<?php
/**
 * Plugin Name: FluxStack Eventbrite Integration
 * Plugin URI: https://ajithrn.com/plugins/fluxstack-eventbrite-integration
 * Description: A WordPress plugin to easily integrate customizable Eventbrite buttons and widgets with shortcode support.
 * Version: 1.0.0
 * Author: Ajith R N
 * Author URI: https://ajithrn.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: fs-eventbrite-integration
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * Network: false
 * 
 * @package FSEventbriteButton
 * @author Ajith R N
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('FS_EVENTBRITE_BUTTON_VERSION', '1.0.0');
define('FS_EVENTBRITE_BUTTON_TEXT_DOMAIN', 'fs-eventbrite-integration');

/**
 * Main Eventbrite Button Integration Plugin Class
 * 
 * @since 1.0.0
 */
class FSEventbriteButtonPlugin {
    
    /**
     * Plugin instance
     * 
     * @var FSEventbriteButtonPlugin
     * @since 1.0.0
     */
    private static $instance = null;
    
    /**
     * Get plugin instance (Singleton pattern)
     * 
     * @return FSEventbriteButtonPlugin
     * @since 1.0.0
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor - Initialize the plugin
     * 
     * @since 1.0.0
     */
    private function __construct() {
        $this->init_hooks();
    }
    
    /**
     * Initialize WordPress hooks
     * 
     * @since 1.0.0
     */
    private function init_hooks() {
        add_action('init', array($this, 'init'));
        add_action('wp_footer', array($this, 'enqueue_eventbrite_script'));
        add_shortcode('fs_eventbrite', array($this, 'eventbrite_widget_shortcode'));
    }
    
    /**
     * Initialize plugin
     * 
     * @since 1.0.0
     */
    public function init() {
        // Load text domain for translations
        load_plugin_textdomain(
            FS_EVENTBRITE_BUTTON_TEXT_DOMAIN,
            false,
            dirname(plugin_basename(__FILE__)) . '/languages'
        );
    }
    
    /**
     * Enqueue Eventbrite script if shortcode is used
     * 
     * @since 1.0.0
     */
    public function enqueue_eventbrite_script() {
        global $post;
        
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'fs_eventbrite')) {
            echo '<script src="https://www.eventbrite.com/static/widgets/eb_widgets.js"></script>' . "\n";
        }
    }
    
    /**
     * Eventbrite Widget Shortcode Handler
     * 
     * @param array $atts Shortcode attributes
     * @param string $content Shortcode content
     * @return string HTML output
     * @since 1.0.0
     */
    public function eventbrite_widget_shortcode($atts, $content = '') {
        // Parse shortcode attributes
        $atts = shortcode_atts(
            array(
                'event_id' => '',
                'modal' => 'true',
                'width' => '100%',
                'height' => '550',
                'button_text' => 'Get Tickets',
                'button_class' => 'eventbrite-button',
                'button_style' => '',
                'container_class' => '',
                'container_style' => ''
            ),
            $atts,
            'fs_eventbrite'
        );
        
        // Validate event_id
        $event_id = $this->sanitize_event_id($atts['event_id']);
        if (empty($event_id)) {
            return $this->get_error_message(__('Error: event_id parameter is required and must be a valid Eventbrite event ID.', FS_EVENTBRITE_BUTTON_TEXT_DOMAIN));
        }
        
        // Sanitize attributes
        $modal = filter_var($atts['modal'], FILTER_VALIDATE_BOOLEAN);
        $width = sanitize_text_field($atts['width']);
        $height = sanitize_text_field($atts['height']);
        $button_text = sanitize_text_field($atts['button_text']);
        $button_class = sanitize_text_field($atts['button_class']);
        $button_style = wp_strip_all_tags($atts['button_style']);
        $container_class = sanitize_text_field($atts['container_class']);
        $container_style = wp_strip_all_tags($atts['container_style']);
        
        // Build widget HTML
        $html = $this->build_widget_html($event_id, array(
            'modal' => $modal,
            'width' => $width,
            'height' => $height,
            'button_text' => $button_text,
            'button_class' => $button_class,
            'button_style' => $button_style,
            'container_class' => $container_class,
            'container_style' => $container_style
        ));
        
        return $html;
    }
    
    /**
     * Sanitize and validate Eventbrite event ID
     * 
     * @param string $event_id Raw event ID
     * @return string Sanitized event ID or empty string if invalid
     * @since 1.0.0
     */
    private function sanitize_event_id($event_id) {
        // Remove any non-numeric characters
        $event_id = preg_replace('/[^0-9]/', '', $event_id);
        
        // Validate length (Eventbrite event IDs are typically 10-19 digits)
        if (strlen($event_id) >= 10 && strlen($event_id) <= 19) {
            return $event_id;
        }
        
        return '';
    }
    
    /**
     * Build the widget HTML
     * 
     * @param string $event_id Sanitized event ID
     * @param array $options Widget options
     * @return string HTML output
     * @since 1.0.0
     */
    private function build_widget_html($event_id, $options) {
        $container_style = !empty($options['container_style']) ? $options['container_style'] . ';' : '';
        $container_style .= 'width: ' . $options['width'] . ';';
        
        $html = '<div class="eventbrite-widget-wrapper ' . esc_attr($options['container_class']) . '" style="' . esc_attr($container_style) . '">';
        
        if ($options['modal']) {
            // Modal widget with customizable button
            $button_style = !empty($options['button_style']) ? $options['button_style'] : '';
            
            $html .= '<a rel="nofollow" href="#" target="_self" ';
            $html .= 'class="' . esc_attr($options['button_class']) . ' eventbrite-widget-modal-trigger-' . esc_attr($event_id) . '" ';
            $html .= 'id="eventbrite-widget-modal-trigger-' . esc_attr($event_id) . '"';
            if (!empty($button_style)) {
                $html .= ' style="' . esc_attr($button_style) . '"';
            }
            $html .= '>';
            $html .= '<span>' . esc_html($options['button_text']) . '</span>';
            $html .= '</a>';
            
            // Widget initialization script
            $html .= '<script type="text/javascript">';
            $html .= '(function() {';
            $html .= 'function initEventbriteWidget() {';
            $html .= 'if (typeof window.EBWidgets !== "undefined") {';
            $html .= 'window.EBWidgets.createWidget({';
            $html .= 'widgetType: "checkout",';
            $html .= 'eventId: "' . esc_js($event_id) . '",';
            $html .= 'modal: true,';
            $html .= 'modalTriggerElementId: "eventbrite-widget-modal-trigger-' . esc_js($event_id) . '",';
            $html .= 'onOrderComplete: function() { console.log("Eventbrite order complete!"); }';
            $html .= '});';
            $html .= '} else {';
            $html .= 'setTimeout(initEventbriteWidget, 100);';
            $html .= '}';
            $html .= '}';
            $html .= 'initEventbriteWidget();';
            $html .= '})();';
            $html .= '</script>';
            
        } else {
            // Embedded widget
            $html .= '<div class="eventbrite-widget-container-' . esc_attr($event_id) . '" ';
            $html .= 'id="eventbrite-widget-container-' . esc_attr($event_id) . '" ';
            $html .= 'style="height: ' . esc_attr($options['height']) . 'px;"></div>';
            
            // Widget initialization script
            $html .= '<script type="text/javascript">';
            $html .= '(function() {';
            $html .= 'function initEventbriteWidget() {';
            $html .= 'if (typeof window.EBWidgets !== "undefined") {';
            $html .= 'window.EBWidgets.createWidget({';
            $html .= 'widgetType: "checkout",';
            $html .= 'eventId: "' . esc_js($event_id) . '",';
            $html .= 'iframeContainerId: "eventbrite-widget-container-' . esc_js($event_id) . '",';
            $html .= 'iframeContainerHeight: ' . intval($options['height']) . ',';
            $html .= 'onOrderComplete: function() { console.log("Eventbrite order complete!"); }';
            $html .= '});';
            $html .= '} else {';
            $html .= 'setTimeout(initEventbriteWidget, 100);';
            $html .= '}';
            $html .= '}';
            $html .= 'initEventbriteWidget();';
            $html .= '})();';
            $html .= '</script>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Get error message HTML
     * 
     * @param string $message Error message
     * @return string HTML error message
     * @since 1.0.0
     */
    private function get_error_message($message) {
        return '<div class="eventbrite-widget-error" style="background-color: #f8d7da; color: #721c24; padding: 12px; border: 1px solid #f1aeb5; border-radius: 4px; margin: 10px 0;">' . esc_html($message) . '</div>';
    }
}

// Initialize the plugin
FSEventbriteButtonPlugin::get_instance();
