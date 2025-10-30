# FluxStack Eventbrite Widget

[![WordPress](https://img.shields.io/badge/wordpress-%3E%3D5.0-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/php-%3E%3D7.4-blue.svg)](https://php.net/)
[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)

A simple, lightweight WordPress plugin to easily integrate customizable Eventbrite widgets and buttons into your WordPress site.

## Description

**FluxStack Eventbrite Widget** allows you to embed Eventbrite event widgets on your WordPress site with complete control over styling and presentation. Whether you want a simple button that opens a modal checkout or an embedded widget directly on your page, this plugin provides both a Gutenberg block and shortcode solution.

### Key Features

- **Gutenberg Block** - Visual block editor with live preview and comprehensive styling controls
- **Block Variations** - Pre-configured Modal Button and Embedded Widget variations
- **Easy Shortcode Integration** - Simple `[fs_eventbrite_widget]` shortcode for classic editor
- **Modal & Embedded Widgets** - Choose between popup modal or inline embedded widgets  
- **Advanced Styling Controls** - Complete control over typography, colors, borders, spacing, and hover effects
- **Gradient Support** - Built-in gradient picker with preset options
- **Responsive Design** - Works on all device sizes
- **Clean Code** - Lightweight, follows WordPress coding standards
- **No Settings Required** - Works out of the box, configure via block or shortcode
- **Multiple Events** - Support unlimited Eventbrite events on the same page
- **Accessibility Compliant** - WCAG 2.1 Level AA standards

## Download & Installation

### Latest Release

Download the latest version from the [GitHub Releases](https://github.com/ajithrn/fs-eventbrite-widget/releases) page.

### Installation Methods

**Method 1: Via WordPress Admin (Recommended)**
1. Download the ZIP file from [Releases](https://github.com/ajithrn/fs-eventbrite-widget/releases)
2. Go to **Plugins > Add New** in WordPress admin
3. Click **Upload Plugin** and select the ZIP file
4. Click **Install Now** and then **Activate**

**Method 2: Manual Installation**
1. Download and extract the ZIP file
2. Upload the `fs-eventbrite-widget` folder to `/wp-content/plugins/`
3. Activate the plugin through the **Plugins** menu

**Method 3: Via WP-CLI**
```bash
wp plugin install https://github.com/ajithrn/fs-eventbrite-widget/releases/download/v2.1.0/fs-eventbrite-widget.zip --activate
```

## Usage

### Using the Gutenberg Block (Recommended)

1. **Add the Block**
   - In the block editor, click the `+` button
   - Search for "Eventbrite Widget"
   - Choose a variation:
     - **Modal Button Widget** - Shows a customizable button that opens a modal
     - **Embedded Widget** - Embeds the checkout directly on the page

2. **Configure Event Settings**
   - Enter your Eventbrite Event ID
   - Choose widget type (Modal or Embedded)

3. **Customize Button Appearance** (Modal only)
   - **Text & Typography**: Button text, font size, weight, and color
   - **Background**: Solid color or gradient
   - **Border**: Width, style, color, and radius
   - **Spacing**: Individual padding controls for each side
   - **Hover Effects**: Hover colors, transforms, and transition duration

4. **Container Settings**
   - Width (%, px, vw)
   - Height (for embedded widgets)
   - Custom CSS classes and styles

5. **Advanced Options**
   - Additional button CSS classes
   - Custom inline styles

### Block Features

- **Live Preview** - See your button design in real-time
- **Event ID Validation** - Instant feedback on valid event IDs
- **Color Pickers** - Visual color selection with alpha support
- **Gradient Picker** - Choose from presets or create custom gradients
- **Unit Controls** - Flexible units (px, em, rem, %, vw)
- **Reset to Defaults** - Quick button to restore default styling
- **Alignment Toolbar** - Left, center, right alignment
- **Organized Panels** - Collapsible sections for easy navigation

### Using Shortcodes (Classic Editor)

Add this shortcode to any post, page, or widget area:

```
[fs_eventbrite_widget event_id="1917376307149"]
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
| `button_class` | CSS classes for the button | `fs-eventbrite-button` | `button_class="btn btn-primary"` |
| `button_style` | Inline CSS styles for the button | - | `button_style="background: #ff6600;"` |
| `width` | Widget container width | `100%` | `width="500px"` |
| `height` | Height for embedded widgets (pixels) | `550` | `height="600"` |
| `container_class` | CSS classes for wrapper container | - | `container_class="my-widget"` |
| `container_style` | Inline CSS for wrapper container | - | `container_style="margin: 20px;"` |

## Examples

### Modal Widget (Default)
```
[fs_eventbrite_widget event_id="1917376307149"]
```

### Custom Button Text
```
[fs_eventbrite_widget event_id="1917376307149" button_text="Register Now"]
```

### Styled Button with CSS Classes
```
[fs_eventbrite_widget event_id="1917376307149" button_class="btn btn-large btn-primary" button_text="Book Your Spot"]
```

### Inline Button Styling
```
[fs_eventbrite_widget event_id="1917376307149" button_style="background: linear-gradient(45deg, #667eea, #764ba2); border: none; color: white; padding: 15px 30px; border-radius: 25px; font-weight: bold; text-decoration: none;"]
```

### Embedded Widget (No Modal)
```
[fs_eventbrite_widget event_id="1917376307149" modal="false" height="600"]
```

### Multiple Events on Same Page
```
[fs_eventbrite_widget event_id="1917376307149" button_text="Workshop 1"]
[fs_eventbrite_widget event_id="9876543210123" button_text="Workshop 2"]
```

### Full Customization Example
```
[fs_eventbrite_widget 
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
       class="fs-eventbrite-button eventbrite-widget-modal-trigger-1917376307149" 
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
.fs-eventbrite-button {
    display: inline-block;
    padding: 12px 24px;
    background-color: #ff6600;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.fs-eventbrite-button:hover {
    background-color: #e55a00;
    color: white;
    text-decoration: none;
}
```

### Container Styling
```css
.fs-eventbrite-widget-wrapper {
    margin: 20px 0;
}

.eventbrite-widget-wrapper.text-center {
    text-align: center;
}
```

## Accessibility

**This plugin meets WCAG 2.1 Level AA accessibility standards.** ♿

### Keyboard Shortcuts

- **Tab:** Navigate to button
- **Enter/Space:** Activate button
- **Escape:** Close modal (in Eventbrite widget)

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
[fs_eventbrite_widget event_id="1111111111111"]
[fs_eventbrite_widget event_id="2222222222222"]
```

### The widget isn't loading. What should I check?

1. Verify your event ID is correct and the event is published
2. Check browser console for JavaScript errors  
3. Ensure your event is set to "Public" in Eventbrite
4. Test with a simple shortcode first: `[fs_eventbrite_widget event_id="YOUR_ID"]`

### Can I style the button with my theme's CSS?

Absolutely! Use the `button_class` parameter to add your theme's button classes:
```
[fs_eventbrite_widget event_id="1917376307149" button_class="btn btn-primary btn-lg"]
```

### Does this work with caching plugins?

Yes, the plugin is compatible with most caching plugins. The Eventbrite widget JavaScript loads dynamically and shouldn't be cached.

### Can I translate the plugin?

Yes, the plugin is translation-ready. The text domain is `fs-eventbrite-widget`. Default translatable strings:
- Button text: "Get Tickets" 
- Error message: "Error: event_id parameter is required..."

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for detailed version history and release notes.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

### Quick Start for Contributors

1. Clone the repository
2. Install dependencies: `npm install`
3. Start development build: `npm start`
4. Make your changes following WordPress coding standards
5. Build for production: `npm run build`
6. Test thoroughly
7. Submit pull request

For detailed instructions, see [DEVELOPER.md](DEVELOPER.md).

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
- **Plugin URI**: [https://ajithrn.com/](https://ajithrn.com/)
- **Eventbrite**: [https://www.eventbrite.com](https://www.eventbrite.com)

---

**Made with ❤️ for the WordPress community**
