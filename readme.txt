=== FluxStack Eventbrite Widget ===
Contributors: ajithrn
Tags: eventbrite, tickets, events, registration, checkout, widget, gutenberg, block
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 2.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Easily integrate customizable Eventbrite widgets and buttons into your WordPress site with Gutenberg block and shortcode support.

== Description ==

**FluxStack Eventbrite Widget** allows you to embed Eventbrite event widgets on your WordPress site with complete control over styling and presentation. Whether you want a simple button that opens a modal checkout or an embedded widget directly on your page, this plugin provides both a Gutenberg block and shortcode solution.

= Key Features =

* **Gutenberg Block** - Visual block editor with live preview and comprehensive styling controls
* **Block Variations** - Pre-configured Modal Button and Embedded Widget variations
* **Easy Shortcode Integration** - Simple `[fs_eventbrite_widget]` shortcode for classic editor
* **Modal & Embedded Widgets** - Choose between popup modal or inline embedded widgets
* **Advanced Styling Controls** - Complete control over typography, colors, borders, spacing, and hover effects
* **Gradient Support** - Built-in gradient picker with preset options
* **Responsive Design** - Works on all device sizes
* **Clean Code** - Lightweight, follows WordPress coding standards
* **No Settings Required** - Works out of the box, configure via block or shortcode
* **Multiple Events** - Support unlimited Eventbrite events on the same page
* **Accessibility Compliant** - WCAG 2.1 Level AA standards

= How It Works =

1. Get your Eventbrite event ID from your event URL
2. Add the Eventbrite Widget block or use the shortcode
3. Customize the appearance to match your site
4. Publish and start selling tickets!

= Gutenberg Block =

The plugin includes a powerful Gutenberg block with:

* Live preview in the editor
* Event ID validation
* Visual color pickers with alpha support
* Gradient background options
* Typography controls (size, weight, color)
* Border controls (width, style, color, radius)
* Individual padding controls
* Hover effects and transitions
* Alignment options
* Custom CSS classes

= Shortcode Usage =

Basic usage:
`[fs_eventbrite_widget event_id="1917376307149"]`

With custom button text:
`[fs_eventbrite_widget event_id="1917376307149" button_text="Register Now"]`

Embedded widget:
`[fs_eventbrite_widget event_id="1917376307149" modal="false" height="600"]`

= Finding Your Event ID =

Your Eventbrite event ID is in your event URL:
`https://www.eventbrite.com/e/your-event-name-1917376307149`

The number `1917376307149` is your event ID.

= Accessibility =

This plugin meets WCAG 2.1 Level AA accessibility standards with:

* Proper ARIA labels and roles
* Keyboard navigation support (Tab, Enter, Space, Escape)
* Screen reader friendly
* Focus management
* Semantic HTML

= Support =

For support, please visit the [plugin support forum](https://wordpress.org/support/plugin/fs-eventbrite-widget/).

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin panel
2. Go to Plugins > Add New
3. Search for "FluxStack Eventbrite Widget"
4. Click "Install Now" and then "Activate"

= Manual Installation =

1. Download the plugin ZIP file
2. Log in to your WordPress admin panel
3. Go to Plugins > Add New > Upload Plugin
4. Choose the ZIP file and click "Install Now"
5. Activate the plugin

= After Activation =

1. Create or edit a post/page
2. Add the "Eventbrite Widget" block or use the shortcode
3. Enter your Eventbrite event ID
4. Customize the appearance
5. Publish!

== Frequently Asked Questions ==

= How do I find my Eventbrite event ID? =

Your event ID is in your Eventbrite event URL. For example:
`https://www.eventbrite.com/e/my-awesome-event-1917376307149`

The ID is `1917376307149`.

= Can I use multiple events on the same page? =

Yes! Each block or shortcode instance works independently. You can add as many events as you need on the same page.

= The widget isn't loading. What should I check? =

1. Verify your event ID is correct
2. Ensure your event is published and set to "Public" in Eventbrite
3. Check your browser console for JavaScript errors
4. Try disabling other plugins to check for conflicts
5. Clear your cache if using a caching plugin

= Can I customize the button styling? =

Absolutely! The Gutenberg block provides extensive styling controls including:
* Typography (size, weight, color)
* Background colors and gradients
* Borders and border radius
* Padding and spacing
* Hover effects

You can also use custom CSS classes or inline styles.

= Does this work with caching plugins? =

Yes, the plugin is compatible with most caching plugins. The Eventbrite widget JavaScript loads dynamically.

= Is the plugin accessible? =

Yes! The plugin meets WCAG 2.1 Level AA accessibility standards with proper ARIA labels, keyboard navigation, and screen reader support.

= Can I translate the plugin? =

Yes, the plugin is translation-ready. The text domain is `fs-eventbrite-widget`. You can use tools like Loco Translate or Poedit to create translations.

= Does this plugin collect any data? =

No, this plugin does not collect any user data. It simply embeds Eventbrite's official widget on your site.

= What happens when someone completes a purchase? =

The purchase is processed entirely through Eventbrite's secure checkout. The plugin simply provides the interface to access Eventbrite's checkout system.

== Screenshots ==

1. Gutenberg block in the editor with live preview
2. Modal button widget on the frontend
3. Embedded widget on the frontend
4. Block settings panel with styling controls
5. Shortcode usage example

== Changelog ==

= 2.1.0 =
* Security: Fixed critical CSS injection vulnerability
* Security: Improved HTML class sanitization
* Security: Enhanced input validation and escaping
* Fix: Text domain consistency (fs-eventbrite-widget)
* Added: WordPress.org submission documentation
* Added: GPL v2 LICENSE file
* Added: Comprehensive readme.txt for WordPress.org
* Improved: Code security following WordPress.org guidelines
* Improved: Documentation and code comments

= 2.0.0 =
* Added Gutenberg block support with live preview
* Added block variations (Modal Button and Embedded Widget)
* Added comprehensive styling controls in block editor
* Added gradient background support
* Added hover effects and transitions
* Improved accessibility (WCAG 2.1 Level AA)
* Enhanced security with better input sanitization
* Fixed text domain consistency
* Improved code organization and documentation
* Added keyboard navigation support
* Added ARIA labels and roles
* Better error handling and validation

= 1.0.0 =
* Initial release
* Shortcode support for modal and embedded widgets
* Basic styling options
* Multiple events support

== Upgrade Notice ==

= 2.1.0 =
Important security update fixing CSS injection vulnerability. Recommended for all users.

= 2.0.0 =
Major update with Gutenberg block support, enhanced styling controls, improved accessibility, and better security. Fully backward compatible with existing shortcodes.

== Privacy Policy ==

This plugin does not collect, store, or transmit any personal data. All event registration and ticket purchases are processed directly through Eventbrite's secure platform. Please refer to [Eventbrite's Privacy Policy](https://www.eventbrite.com/support/articles/en_US/Troubleshooting/eventbrite-privacy-policy) for information about how Eventbrite handles user data.

== Third-Party Services ==

This plugin integrates with Eventbrite's widget service by loading their official JavaScript library from:
`https://www.eventbrite.com/static/widgets/eb_widgets.js`

By using this plugin, you agree to Eventbrite's [Terms of Service](https://www.eventbrite.com/support/articles/en_US/Troubleshooting/eventbrite-terms-of-service).

== Credits ==

* Developed by [Ajith R N](https://ajithrn.com)
* Eventbrite integration uses [Eventbrite's official widget API](https://www.eventbrite.com/platform/docs/widgets)
