<?php
/**
 * Eventbrite Widget Block Registration
 *
 * @package FSEventbriteWidget
 * @since 2.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class FS_Eventbrite_Block
 *
 * Handles Gutenberg block registration and rendering
 *
 * @since 2.0.0
 */
class FS_Eventbrite_Block {

	/**
	 * Plugin instance
	 *
	 * @var FS_Eventbrite_Block
	 * @since 2.0.0
	 */
	private static $instance = null;

	/**
	 * Get plugin instance (Singleton pattern)
	 *
	 * @return FS_Eventbrite_Block
	 * @since 2.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 *
	 * @since 2.0.0
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'register_block' ) );
		add_filter( 'block_categories_all', array( $this, 'register_block_category' ), 10, 2 );
	}

	/**
	 * Register custom block category
	 *
	 * @param array                   $categories Array of block categories.
	 * @param WP_Block_Editor_Context $editor_context Block editor context.
	 * @return array Modified array of block categories.
	 * @since 2.0.0
	 */
	public function register_block_category( $categories, $editor_context ) {
		// Check if our category already exists
		foreach ( $categories as $category ) {
			if ( 'fluxstack' === $category['slug'] ) {
				return $categories;
			}
		}

		// Add our custom category at the beginning
		return array_merge(
			array(
				array(
					'slug'  => 'fluxstack',
					'title' => __( 'Fluxstack', 'fs-eventbrite-widget' ),
					'icon'  => null,
				),
			),
			$categories
		);
	}

	/**
	 * Register the Eventbrite Widget block
	 *
	 * @since 2.0.0
	 */
	public function register_block() {
		// Register the block
		register_block_type(
			dirname( __DIR__ ) . '/blocks/eventbrite-widget/block.json',
			array(
				'render_callback' => array( $this, 'render_block' ),
			)
		);
	}

	/**
	 * Render the block on the frontend
	 *
	 * @param array    $attributes Block attributes.
	 * @param string   $content    Block content.
	 * @param WP_Block $block      Block instance.
	 * @return string Block HTML output.
	 * @since 2.0.0
	 */
	public function render_block( $attributes, $content, $block ) {
		// Get the main plugin instance
		$plugin = FSEventbriteWidgetPlugin::get_instance();

		// Convert block attributes to shortcode format
		$shortcode_atts = $this->convert_attributes_to_shortcode( $attributes );

		// Validate event_id
		if ( empty( $shortcode_atts['event_id'] ) ) {
			return '<div class="eventbrite-widget-error" role="alert" aria-live="assertive" style="background-color: #f8d7da; color: #721c24; padding: 12px; border: 1px solid #f1aeb5; border-radius: 4px; margin: 10px 0;">' . esc_html__( 'Error: Event ID is required for the Eventbrite Widget block.', 'fs-eventbrite-widget' ) . '</div>';
		}

		// Build button styles from block attributes
		$button_style = $this->build_button_styles( $attributes );
		if ( ! empty( $button_style ) ) {
			$shortcode_atts['button_style'] = $button_style;
		}

		// Add custom button classes if provided
		if ( ! empty( $attributes['buttonClass'] ) ) {
			$shortcode_atts['button_class'] = sanitize_text_field( $attributes['buttonClass'] );
		}

		// Add alignment class to container
		$alignment_class = '';
		if ( ! empty( $attributes['alignment'] ) && 'left' !== $attributes['alignment'] ) {
			$alignment_class = 'has-text-align-' . sanitize_html_class( $attributes['alignment'] );
		}
		if ( ! empty( $alignment_class ) ) {
			$shortcode_atts['container_class'] = trim( $shortcode_atts['container_class'] . ' ' . $alignment_class );
		}

		// Add block wrapper classes
		$wrapper_attributes = get_block_wrapper_attributes(
			array(
				'class' => 'wp-block-fluxstack-eventbrite-widget',
			)
		);

		// Use the existing shortcode rendering logic
		$widget_html = $plugin->eventbrite_widget_shortcode( $shortcode_atts );

		// Wrap in block wrapper
		return sprintf(
			'<div %s>%s</div>',
			$wrapper_attributes,
			$widget_html
		);
	}

	/**
	 * Convert block attributes to shortcode format
	 *
	 * @param array $attributes Block attributes.
	 * @return array Shortcode attributes.
	 * @since 2.0.0
	 */
	private function convert_attributes_to_shortcode( $attributes ) {
		$shortcode_atts = array(
			'event_id'        => isset( $attributes['eventId'] ) ? $attributes['eventId'] : '',
			'modal'           => isset( $attributes['widgetType'] ) && 'modal' === $attributes['widgetType'] ? 'true' : 'false',
			'button_text'     => isset( $attributes['buttonText'] ) ? $attributes['buttonText'] : 'Get Tickets',
			'width'           => isset( $attributes['width'] ) ? $attributes['width'] : '100%',
			'height'          => isset( $attributes['height'] ) ? $attributes['height'] : '550',
			'button_class'    => 'fs-eventbrite-button',
			'button_style'    => isset( $attributes['buttonStyle'] ) ? $attributes['buttonStyle'] : '',
			'container_class' => isset( $attributes['containerClass'] ) ? $attributes['containerClass'] : '',
			'container_style' => isset( $attributes['containerStyle'] ) ? $attributes['containerStyle'] : '',
		);

		return $shortcode_atts;
	}

	/**
	 * Build button inline styles from block attributes
	 *
	 * @param array $attributes Block attributes.
	 * @return string CSS inline styles.
	 * @since 2.0.0
	 */
	private function build_button_styles( $attributes ) {
		$styles = array();

		// Only build styles for modal type
		if ( isset( $attributes['widgetType'] ) && 'embedded' === $attributes['widgetType'] ) {
			return '';
		}

		// Font size
		if ( ! empty( $attributes['fontSize'] ) ) {
			$styles[] = 'font-size: ' . esc_attr( $attributes['fontSize'] );
		}

		// Font weight
		if ( ! empty( $attributes['fontWeight'] ) ) {
			$styles[] = 'font-weight: ' . esc_attr( $attributes['fontWeight'] );
		}

		// Text color
		if ( ! empty( $attributes['textColor'] ) ) {
			$styles[] = 'color: ' . esc_attr( $attributes['textColor'] );
		}

		// Background (gradient or solid)
		if ( ! empty( $attributes['useGradient'] ) && ! empty( $attributes['backgroundGradient'] ) ) {
			$styles[] = 'background: ' . esc_attr( $attributes['backgroundGradient'] );
		} elseif ( ! empty( $attributes['backgroundColor'] ) ) {
			$styles[] = 'background-color: ' . esc_attr( $attributes['backgroundColor'] );
		}

		// Border
		if ( ! empty( $attributes['borderWidth'] ) ) {
			$border_style = ! empty( $attributes['borderStyle'] ) ? $attributes['borderStyle'] : 'solid';
			$border_color = ! empty( $attributes['borderColor'] ) ? $attributes['borderColor'] : 'transparent';
			$styles[]     = sprintf(
				'border: %s %s %s',
				esc_attr( $attributes['borderWidth'] ),
				esc_attr( $border_style ),
				esc_attr( $border_color )
			);
		}

		// Border radius
		if ( ! empty( $attributes['borderRadius'] ) ) {
			$styles[] = 'border-radius: ' . esc_attr( $attributes['borderRadius'] );
		}

		// Padding
		$padding_parts = array();
		if ( ! empty( $attributes['paddingTop'] ) ) {
			$padding_parts[] = esc_attr( $attributes['paddingTop'] );
		}
		if ( ! empty( $attributes['paddingRight'] ) ) {
			$padding_parts[] = esc_attr( $attributes['paddingRight'] );
		}
		if ( ! empty( $attributes['paddingBottom'] ) ) {
			$padding_parts[] = esc_attr( $attributes['paddingBottom'] );
		}
		if ( ! empty( $attributes['paddingLeft'] ) ) {
			$padding_parts[] = esc_attr( $attributes['paddingLeft'] );
		}
		if ( count( $padding_parts ) === 4 ) {
			$styles[] = 'padding: ' . implode( ' ', $padding_parts );
		}

		// Transition
		if ( ! empty( $attributes['transitionDuration'] ) ) {
			$styles[] = 'transition: all ' . esc_attr( $attributes['transitionDuration'] );
		}

		// Add custom button styles if provided
		if ( ! empty( $attributes['buttonStyle'] ) ) {
			$styles[] = wp_strip_all_tags( $attributes['buttonStyle'] );
		}

		return implode( '; ', $styles );
	}
}

// Initialize the block
FS_Eventbrite_Block::get_instance();
