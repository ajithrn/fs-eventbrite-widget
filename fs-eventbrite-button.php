<?php
/**
 * Plugin Name: FluxStack Eventbrite Widget
 * Plugin URI: https://ajithrn.com/
 * Description: A WordPress plugin to easily integrate customizable Eventbrite buttons and widgets with shortcode support.
 * Version: 2.0.0
 * Author: Ajith R N
 * Author URI: https://ajithrn.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: fs-eventbrite-widget
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * Network: false
 * 
 * @package FSEventbriteWidget
 * @author Ajith R N
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('FS_EVENTBRITE_BUTTON_VERSION', '2.0.0');
define('FS_EVENTBRITE_BUTTON_TEXT_DOMAIN', 'fs-eventbrite-widget');

// Load block registration class
require_once plugin_dir_path(__FILE__) . 'includes/class-fs-eventbrite-block.php';

/**
 * Main Eventbrite Button Widget Plugin Class
 * 
 * @since 1.0.0
 */
class FSEventbriteWidgetPlugin {
    
    /**
     * Plugin instance
     * 
     * @var FSEventbriteWidgetPlugin
     * @since 1.0.0
     */
    private static $instance = null;
    
    /**
     * Get plugin instance (Singleton pattern)
     * 
     * @return FSEventbriteWidgetPlugin
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
     * Flag to track if shortcode is used on current page
     * 
     * @var bool
     * @since 1.0.0
     */
    private $shortcode_used = false;
    
    /**
     * Initialize WordPress hooks
     * 
     * @since 1.0.0
     */
    private function init_hooks() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
        add_action('wp_footer', array($this, 'enqueue_scripts'));
        add_shortcode('fs_eventbrite_widget', array($this, 'eventbrite_widget_shortcode'));
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
     * Register scripts and styles
     * 
     * @since 1.0.0
     */
    public function register_scripts() {
        // Register the external Eventbrite widgets script
        wp_register_script(
            'fs-eventbrite-widgets',
            'https://www.eventbrite.com/static/widgets/eb_widgets.js',
            array(),
            null,
            true
        );
        
        // Register widget styles
        wp_register_style(
            'fs-eventbrite-widget',
            plugins_url('assets/css/fs-eventbrite-widget.css', __FILE__),
            array(),
            FS_EVENTBRITE_BUTTON_VERSION,
            'all'
        );
    }
    
    /**
     * Enqueue scripts and styles if shortcode is used
     * 
     * @since 1.0.0
     */
    public function enqueue_scripts() {
        // Only enqueue if shortcode was used on this page
        if ($this->shortcode_used) {
            wp_enqueue_script('fs-eventbrite-widgets');
            wp_enqueue_style('fs-eventbrite-widget');
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
        // Set flag that shortcode is being used
        $this->shortcode_used = true;
        
        // Parse shortcode attributes
        $atts = shortcode_atts(
            array(
                'event_id' => '',
                'modal' => 'true',
                'width' => '100%',
                'height' => '550',
                'button_text' => 'Get Tickets',
                'button_class' => 'fs-eventbrite-button',
                'button_style' => '',
                'container_class' => '',
                'container_style' => ''
            ),
            $atts,
            'fs_eventbrite_widget'
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
        
        $html = '<div class="fs-eventbrite-widget-wrapper ' . esc_attr($options['container_class']) . '" style="' . esc_attr($container_style) . '" role="region" aria-label="' . esc_attr__('Eventbrite ticket widget', FS_EVENTBRITE_BUTTON_TEXT_DOMAIN) . '">';
        
        if ($options['modal']) {
            // Modal widget with customizable button
            $button_style = !empty($options['button_style']) ? $options['button_style'] : '';
            
            // Accessibility: Use button element instead of anchor, add ARIA attributes
            $html .= '<button type="button" ';
            $html .= 'class="' . esc_attr($options['button_class']) . ' eventbrite-widget-modal-trigger-' . esc_attr($event_id) . '" ';
            $html .= 'id="eventbrite-widget-modal-trigger-' . esc_attr($event_id) . '" ';
            $html .= 'aria-label="' . esc_attr(sprintf(__('%s - Opens ticket purchase dialog', FS_EVENTBRITE_BUTTON_TEXT_DOMAIN), $options['button_text'])) . '" ';
            $html .= 'aria-haspopup="dialog"';
            if (!empty($button_style)) {
                $html .= ' style="' . esc_attr($button_style) . '"';
            }
            $html .= '>';
            $html .= '<span aria-hidden="true">' . esc_html($options['button_text']) . '</span>';
            $html .= '</button>';
            
            // Widget initialization script with accessibility enhancements
            $html .= '<script type="text/javascript">';
            $html .= '(function() {';
            $html .= 'var triggerId = "eventbrite-widget-modal-trigger-' . esc_js($event_id) . '";';
            $html .= 'var triggerElement = document.getElementById(triggerId);';
            $html .= 'var widgetInitialized = false;';
            $html .= 'function initEventbriteWidget() {';
            $html .= 'if (typeof window.EBWidgets !== "undefined" && !widgetInitialized) {';
            $html .= 'widgetInitialized = true;';
            $html .= 'if (triggerElement) {';
            $html .= 'triggerElement.setAttribute("aria-busy", "false");';
            $html .= '}';
            $html .= 'window.EBWidgets.createWidget({';
            $html .= 'widgetType: "checkout",';
            $html .= 'eventId: "' . esc_js($event_id) . '",';
            $html .= 'modal: true,';
            $html .= 'modalTriggerElementId: triggerId,';
            $html .= 'onOrderComplete: function() { ';
            $html .= 'console.log("Eventbrite order complete!");';
            $html .= 'if (triggerElement) triggerElement.focus();';
            $html .= '}';
            $html .= '});';
            $html .= '} else if (!widgetInitialized) {';
            $html .= 'setTimeout(initEventbriteWidget, 100);';
            $html .= '}';
            $html .= '}';
            $html .= 'if (triggerElement) {';
            $html .= 'triggerElement.setAttribute("aria-busy", "true");';
            $html .= 'triggerElement.addEventListener("keydown", function(e) {';
            $html .= 'if (e.key === "Enter" || e.key === " ") {';
            $html .= 'e.preventDefault();';
            $html .= 'triggerElement.click();';
            $html .= '}';
            $html .= '});';
            $html .= '}';
            $html .= 'initEventbriteWidget();';
            $html .= '})();';
            $html .= '</script>';
            
        } else {
            // Embedded widget with accessibility attributes
            $html .= '<div class="eventbrite-widget-container-' . esc_attr($event_id) . '" ';
            $html .= 'id="eventbrite-widget-container-' . esc_attr($event_id) . '" ';
            $html .= 'role="region" ';
            $html .= 'aria-label="' . esc_attr__('Eventbrite ticket purchase form', FS_EVENTBRITE_BUTTON_TEXT_DOMAIN) . '" ';
            $html .= 'aria-busy="true" ';
            $html .= 'style="height: ' . esc_attr($options['height']) . 'px;"></div>';
            
            // Widget initialization script with accessibility enhancements
            $html .= '<script type="text/javascript">';
            $html .= '(function() {';
            $html .= 'var containerId = "eventbrite-widget-container-' . esc_js($event_id) . '";';
            $html .= 'var containerElement = document.getElementById(containerId);';
            $html .= 'var widgetInitialized = false;';
            $html .= 'function initEventbriteWidget() {';
            $html .= 'if (typeof window.EBWidgets !== "undefined" && !widgetInitialized) {';
            $html .= 'widgetInitialized = true;';
            $html .= 'window.EBWidgets.createWidget({';
            $html .= 'widgetType: "checkout",';
            $html .= 'eventId: "' . esc_js($event_id) . '",';
            $html .= 'iframeContainerId: containerId,';
            $html .= 'iframeContainerHeight: ' . intval($options['height']) . ',';
            $html .= 'onOrderComplete: function() { console.log("Eventbrite order complete!"); }';
            $html .= '});';
            $html .= 'if (containerElement) {';
            $html .= 'containerElement.setAttribute("aria-busy", "false");';
            $html .= '}';
            $html .= '} else if (!widgetInitialized) {';
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
        return '<div class="eventbrite-widget-error" role="alert" aria-live="assertive" style="background-color: #f8d7da; color: #721c24; padding: 12px; border: 1px solid #f1aeb5; border-radius: 4px; margin: 10px 0;">' . esc_html($message) . '</div>';
    }
}

// Initialize the plugin
FSEventbriteWidgetPlugin::get_instance();
