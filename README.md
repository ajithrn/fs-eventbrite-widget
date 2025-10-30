# FluxStack Eventbrite Integration

[![WordPress](https://img.shields.io/badge/wordpress-%3E%3D5.0-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/php-%3E%3D7.4-blue.svg)](https://php.net/)
[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)

A simple, lightweight WordPress plugin to easily integrate customizable Eventbrite widgets and buttons into your WordPress site using shortcodes.

## Description

**FluxStack Eventbrite Integration** allows you to embed Eventbrite event widgets on your WordPress site with complete control over styling and presentation. Whether you want a simple button that opens a modal checkout or an embedded widget directly on your page, this plugin provides an easy shortcode solution.

### Key Features

- **Easy Shortcode Integration** - Simple `[fs_eventbrite]` shortcode
- **Modal & Embedded Widgets** - Choose between popup modal or inline embedded widgets  
- **Fully Customizable Buttons** - Control button text, CSS classes, and inline styles
- **Responsive Design** - Works on all device sizes
- **Clean Code** - Lightweight, follows WordPress coding standards
- **No Settings Required** - Works out of the box, configure via shortcode parameters
- **Multiple Events** - Support unlimited Eventbrite events on the same page

## Installation

### Via WordPress Admin

1. Download the plugin ZIP file
2. Go to **Plugins > Add New** in your WordPress admin
3. Click **Upload Plugin** and select the ZIP file
4. Click **Install Now** and then **Activate**

### Manual Installation

1. Download and extract the plugin files
2. Upload the `eventbrite-button-integration` folder to `/wp-content/plugins/`
3. Activate the plugin through the **Plugins** menu in WordPress

## Usage

### Basic Usage

Add this shortcode to any post, page, or widget area:

```
[fs_eventbrite event_id="1917376307149"]
```

### Finding Your Event ID

Your Eventbrite event ID is found in your event URL:
```
https://www.eventbrite.com/e/your-event-name-1917376307149
```
The number `1917376307149` is your event ID.

## Shortcode Parameters

| Parameter | Description | Default | Example |
|-----------|-------------|---------|---------|
| `event_id` | **Required** - Your Eventbrite event ID | - | `1917376307149` |
| `modal` | Show as modal popup (true) or embedded (false) | `true` | `modal="false"` |
| `button_text` | Text displayed on the button | `Get Tickets` | `button_text="Register Now"` |
| `button_class` | CSS classes for the button | `eventbrite-button` | `button_class="btn btn-primary"` |
| `button_style` | Inline CSS styles for the button | - | `button_style="background: #ff6600;"` |
| `width` | Widget container width | `100%` | `width="500px"` |
| `height` | Height for embedded widgets (pixels) | `550` | `height="600"` |
| `container_class` | CSS classes for wrapper container | - | `container_class="my-widget"` |
| `container_style` | Inline CSS for wrapper container | - | `container_style="margin: 20px;"` |

## Examples

### Modal Widget (Default)
```
[fs_eventbrite event_id="1917376307149"]
```

### Custom Button Text
```
[fs_eventbrite event_id="1917376307149" button_text="Register Now"]
```

### Styled Button with CSS Classes
```
[fs_eventbrite event_id="1917376307149" button_class="btn btn-large btn-primary" button_text="Book Your Spot"]
```

### Inline Button Styling
```
[fs_eventbrite event_id="1917376307149" button_style="background: linear-gradient(45deg, #667eea, #764ba2); border: none; color: white; padding: 15px 30px; border-radius: 25px; font-weight: bold; text-decoration: none;"]
```

### Embedded Widget (No Modal)
```
[fs_eventbrite event_id="1917376307149" modal="false" height="600"]
```

### Multiple Events on Same Page
```
[fs_eventbrite event_id="1917376307149" button_text="Workshop 1"]
[fs_eventbrite event_id="9876543210123" button_text="Workshop 2"]
```

### Full Customization Example
```
[fs_eventbrite 
    event_id="1917376307149" 
    button_text="Reserve Your Seat" 
    button_class="custom-btn large-btn" 
    button_style="background: #ff6600; color: white; padding: 12px 24px; border-radius: 5px; border: 2px solid #e55a00; font-weight: bold; text-transform: uppercase;" 
    container_class="text-center" 
    container_style="margin: 20px 0;"]
```

## Generated HTML Structure

### Modal Widget
```html
<div class="eventbrite-widget-wrapper">
    <a rel="nofollow" href="#" target="_self" 
       class="eventbrite-button eventbrite-widget-modal-trigger-1917376307149" 
       id="eventbrite-widget-modal-trigger-1917376307149">
        <span>Get Tickets</span>
    </a>
</div>
```

### Embedded Widget  
```html
<div class="eventbrite-widget-wrapper">
    <div class="eventbrite-widget-container-1917376307149" 
         id="eventbrite-widget-container-1917376307149" 
         style="height: 550px;">
    </div>
</div>
```

## CSS Styling

### Default Button Styling
```css
.eventbrite-button {
    display: inline-block;
    padding: 12px 24px;
    background-color: #ff6600;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.eventbrite-button:hover {
    background-color: #e55a00;
    color: white;
    text-decoration: none;
}
```

### Container Styling
```css
.eventbrite-widget-wrapper {
    margin: 20px 0;
}

.eventbrite-widget-wrapper.text-center {
    text-align: center;
}
```

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Valid Eventbrite event ID
- Modern browser with JavaScript enabled

## Frequently Asked Questions

### How do I find my Eventbrite event ID?

Your event ID is in your Eventbrite event URL. For example:
`https://www.eventbrite.com/e/my-awesome-event-1917376307149`
The ID is `1917376307149`.

### Can I use multiple events on the same page?

Yes! Each shortcode instance works independently. Use different event IDs:
```
[fs_eventbrite event_id="1111111111111"]
[fs_eventbrite event_id="2222222222222"]
```

### The widget isn't loading. What should I check?

1. Verify your event ID is correct and the event is published
2. Check browser console for JavaScript errors  
3. Ensure your event is set to "Public" in Eventbrite
4. Test with a simple shortcode first: `[fs_eventbrite event_id="YOUR_ID"]`

### Can I style the button with my theme's CSS?

Absolutely! Use the `button_class` parameter to add your theme's button classes:
```
[fs_eventbrite event_id="1917376307149" button_class="btn btn-primary btn-lg"]
```

### Does this work with caching plugins?

Yes, the plugin is compatible with most caching plugins. The Eventbrite widget JavaScript loads dynamically and shouldn't be cached.

### Can I translate the plugin?

Yes, the plugin is translation-ready. The text domain is `fs-eventbrite-integration`. Default translatable strings:
- Button text: "Get Tickets" 
- Error message: "Error: event_id parameter is required..."

## Changelog

### 1.0.0
- Initial release
- Basic shortcode functionality
- Modal and embedded widget support
- Button customization options
- WordPress coding standards compliance
- Security improvements and sanitization

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

### Development Setup

1. Clone the repository
2. Install dependencies: `composer install` (if using Composer)
3. Follow WordPress coding standards
4. Test with different WordPress versions
5. Submit pull request

## Support

If you encounter any issues or have questions:

1. Check the FAQ section above
2. Review your event ID and settings
3. Test with a minimal shortcode first
4. Open an issue on GitHub with details

## License

This plugin is licensed under the GPL v2 or later.

```
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## Credits

- **Author**: [Ajith R N](https://ajithrn.com)
- **Plugin URI**: [https://ajithrn.com/plugins/fluxstack-eventbrite-integration](https://ajithrn.com/plugins/fluxstack-eventbrite-integration)
- **Eventbrite**: [https://www.eventbrite.com](https://www.eventbrite.com)

---

**Made with ❤️ for the WordPress community**
