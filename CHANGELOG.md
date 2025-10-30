# Changelog

All notable changes to FluxStack Eventbrite Widget will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
