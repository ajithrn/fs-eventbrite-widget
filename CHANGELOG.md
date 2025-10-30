# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2025-10-30

### Added
- **Gutenberg Block Support** - Complete block editor integration with visual controls
- **Block Variations** - Two pre-configured variations:
  - Modal Button Widget (default)
  - Embedded Widget
- **Enhanced Styling Controls** - Comprehensive button customization options:
  - Typography controls (font size, weight, color)
  - Background controls (solid colors and gradients)
  - Border controls (width, style, color, radius)
  - Spacing controls (padding with individual side control)
  - Hover effects (colors, transforms, transition duration)
- **Visual Block Editor** - Live button preview in the editor
- **Block Toolbar** - Quick alignment controls
- **Inspector Controls** - Organized panels for all settings:
  - Event Settings
  - Button Text & Typography
  - Background
  - Border
  - Spacing
  - Hover Effects
  - Container Settings
  - Advanced
- **Reset to Defaults** - Quick button to restore default styling
- **Gradient Support** - Built-in gradient picker with preset gradients
- **Alignment Support** - Left, center, right alignment options
- **WordPress Coding Standards** - Full compliance with WordPress PHP and JavaScript standards

### Changed
- Updated plugin version to 2.0.0
- Enhanced plugin architecture with separate block registration class
- Improved code organization with dedicated `includes/` directory
- Updated build process with webpack configuration

### Technical Details
- Dynamic block rendering via PHP `render_callback`
- Reuses existing shortcode logic for consistency
- Block and shortcode share the same HTML output
- Backward compatible - existing shortcodes continue to work
- Modern React-based block editor interface
- SCSS for styling with separate editor and frontend styles
- Proper asset enqueueing and dependency management

## [1.2.0] - 2025-10-30

### Added - Accessibility Improvements ♿

#### Critical Accessibility Features
- **Semantic HTML**: Replaced anchor tags with proper `<button>` elements for modal triggers
- **ARIA Attributes**: Comprehensive ARIA labels and roles for screen reader support
  - `aria-label` with descriptive text for all interactive elements
  - `aria-haspopup="dialog"` for modal buttons
  - `role="region"` for widget containers
  - `role="alert"` and `aria-live="assertive"` for error messages
  - `aria-busy` states for loading indicators
- **Keyboard Navigation**: Full keyboard support with Enter and Space key handlers
- **Focus Management**: 
  - Visible focus indicators (3px blue outline with shadow)
  - Focus return to trigger button after modal closes
  - `:focus-visible` support for better UX
- **Accessibility Stylesheet**: New `assets/css/fs-eventbrite-accessibility.css` with:
  - WCAG AA compliant color contrast (4.54:1 ratio)
  - Visible focus indicators
  - High contrast mode support
  - Reduced motion preferences
  - Responsive touch targets (44x44px minimum on mobile)
  - Loading state animations
  - Print styles

#### Enhanced User Experience
- Loading states with `aria-busy` attributes
- Screen reader announcements for dynamic content
- Better error message accessibility
- Mobile-friendly touch targets
- Support for Windows High Contrast Mode
- Respect for `prefers-reduced-motion` user preference

### Changed
- Modal trigger buttons now use semantic `<button>` elements instead of `<a>` tags
- Error messages now include proper ARIA alert roles
- Widget containers now have descriptive ARIA labels
- Improved JavaScript for better keyboard event handling
- Enhanced focus management in modal interactions

## [1.1.0] - 2025-01-30

### Changed
- Refactored script loading to use WordPress enqueuing system
- Updated shortcode name from `[fs_eventbrite]` to `[fs_eventbrite_widget]`
- Implemented flag-based script detection for better performance
- Scripts now only load when shortcode is actually used on the page
- Added `fs-eventbrite-widgets` script handle with proper WordPress registration

### Improved
- Better performance - scripts load only when needed
- Works in all contexts (posts, pages, widgets, blocks)
- Follows WordPress coding standards for script enqueuing
- Easier debugging with proper script queue management
- Cache-friendly external script loading

### Fixed
- Modal button href changed from event URL to `#` to prevent navigation
- Script loading now works in widgets and custom post types

## [1.0.0] - 2025-01-30

### Added
- Initial release
- Basic shortcode functionality
- Modal widget support (button opens popup checkout)
- Embedded/inline widget support
- Customizable button text, classes, and inline styles
- Customizable container classes and styles
- Multiple widget support on same page
- WordPress coding standards compliance
- Security improvements and proper sanitization
- Translation-ready with `fs-eventbrite-Widget` text domain

### Features
- Modal checkout widget with customizable button
- Inline/embedded widget with configurable height
- Support for unlimited events on same page
- Responsive design
- No settings page required - all configuration via shortcode
- Compatible with WordPress 5.0+
- Compatible with PHP 7.4+

### Security
- Proper input sanitization and validation
- Event ID validation (10-19 digits)
- XSS protection with proper escaping
- ABSPATH check to prevent direct access
