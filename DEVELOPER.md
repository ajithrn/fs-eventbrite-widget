# Developer Documentation

This document provides technical information for developers who want to contribute to or extend the FluxStack Eventbrite Widget plugin.

## Table of Contents

- [Development Setup](#development-setup)
- [Project Structure](#project-structure)
- [Building the Block](#building-the-block)
- [Development Workflow](#development-workflow)
- [Coding Standards](#coding-standards)
- [Testing](#testing)
- [Contributing](#contributing)
- [Architecture](#architecture)

## Development Setup

### Prerequisites

- Node.js 14+ and npm
- PHP 7.4+
- WordPress 5.0+
- Composer (optional, for development tools)

### Initial Setup

1. Clone the repository:
```bash
git clone https://github.com/ajithrn/fs-eventbrite-widget.git
cd fs-eventbrite-widget
```

2. Install Node dependencies:
```bash
npm install
```

3. Install development tools (optional):
```bash
composer install
```

## Project Structure

```
fs-eventbrite-widget/
├── assets/                      # Frontend assets
│   └── css/
│       └── fs-eventbrite-widget.css
├── blocks/                      # Gutenberg blocks
│   └── eventbrite-widget/
│       ├── block.json          # Block configuration
│       ├── src/                # Source files
│       │   ├── index.js        # Block registration
│       │   ├── edit.js         # Editor component
│       │   ├── save.js         # Save component
│       │   ├── editor.scss     # Editor styles
│       │   └── style.scss      # Frontend styles
│       └── build/              # Compiled files (generated)
│           ├── index.js
│           ├── index.css
│           └── style-index.css
├── includes/                    # PHP classes
│   └── class-fs-eventbrite-block.php
├── languages/                   # Translation files
├── fs-eventbrite-button.php    # Main plugin file
├── package.json                # Node dependencies
├── webpack.config.js           # Webpack configuration
├── README.md                   # GitHub readme
├── readme.txt                  # WordPress.org readme
├── CHANGELOG.md                # Version history
├── LICENSE                     # GPL v2 license
└── DEVELOPER.md                # This file
```

## Building the Block

The Gutenberg block uses React and requires compilation from source files.

### Development Build

For development with watch mode (auto-rebuild on changes):

```bash
npm start
```

This will:
- Watch for changes in `blocks/eventbrite-widget/src/`
- Automatically rebuild when files change
- Generate source maps for debugging
- Output to `blocks/eventbrite-widget/build/`

### Production Build

For production-ready, minified builds:

```bash
npm run build
```

This will:
- Compile and minify JavaScript
- Process and minify CSS
- Remove source maps
- Optimize for production
- Output to `blocks/eventbrite-widget/build/`

### Build Output

The build process generates:
- `build/index.js` - Block editor JavaScript
- `build/index.css` - Block editor styles
- `build/style-index.css` - Frontend styles

**Important:** The `build/` directory must be included in the plugin distribution but should be gitignored during development (rebuild before release).

## Development Workflow

### 1. Local WordPress Environment

#### Using wp-env (Recommended)

The plugin includes a `.wp-env.json` configuration:

```bash
# Start WordPress environment
npx wp-env start

# Stop environment
npx wp-env stop

# Clean environment
npx wp-env clean
```

Access your site at: `http://localhost:8888`

#### Using Local by Flywheel or XAMPP

1. Copy plugin to `wp-content/plugins/fs-eventbrite-widget/`
2. Activate the plugin
3. Run `npm start` for development

### 2. Making Changes

#### PHP Changes

1. Edit PHP files in root or `includes/`
2. Follow WordPress Coding Standards
3. Test immediately (no build required)

#### Block Changes

1. Edit files in `blocks/eventbrite-widget/src/`
2. Changes auto-rebuild if `npm start` is running
3. Refresh browser to see changes

#### Style Changes

1. Edit `.scss` files in `blocks/eventbrite-widget/src/`
2. Changes auto-rebuild if `npm start` is running
3. Refresh browser to see changes

### 3. Testing Changes

```bash
# Run PHP CodeSniffer
npm run lint:php

# Run ESLint for JavaScript
npm run lint:js

# Run both linters
npm run lint

# Format code
npm run format
```

## Coding Standards

### PHP Standards

Follow [WordPress PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/):

```php
// Good
if ( $condition ) {
    do_something();
}

// Bad
if($condition){
    do_something();
}
```

Key points:
- Use tabs for indentation
- Space after control structures
- Yoda conditions for comparisons
- Proper DocBlocks for all functions/classes

### JavaScript Standards

Follow [WordPress JavaScript Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/):

```javascript
// Good
const myFunction = () => {
    return 'value';
};

// Bad
const myFunction=()=>{return 'value';}
```

Key points:
- Use ES6+ features
- Consistent spacing
- Meaningful variable names
- JSDoc comments for functions

### React/JSX Standards

```jsx
// Good
const MyComponent = ( { attribute } ) => {
    return (
        <div className="my-class">
            { attribute }
        </div>
    );
};

// Bad
const MyComponent = ({attribute}) => {
    return <div className="my-class">{attribute}</div>
};
```

## Testing

### Manual Testing Checklist

#### Block Editor
- [ ] Block appears in inserter
- [ ] Block variations work correctly
- [ ] Live preview updates in real-time
- [ ] All styling controls function
- [ ] Block saves and loads correctly
- [ ] Block works in different contexts (posts, pages, widgets)

#### Frontend
- [ ] Modal widget opens correctly
- [ ] Embedded widget displays correctly
- [ ] Multiple widgets work on same page
- [ ] Responsive design works on mobile
- [ ] Accessibility features work (keyboard, screen readers)

#### Shortcode
- [ ] Basic shortcode works
- [ ] All parameters function correctly
- [ ] Multiple shortcodes work on same page
- [ ] Shortcode works in widgets

#### Compatibility
- [ ] Works with popular themes
- [ ] Works with popular plugins
- [ ] Works with caching plugins
- [ ] Works in multisite

### Automated Testing

```bash
# PHP Compatibility Check
composer require --dev phpcompatibility/php-compatibility
phpcs --standard=PHPCompatibility --runtime-set testVersion 7.4- .

# WordPress Coding Standards
composer require --dev wp-coding-standards/wpcs
phpcs --standard=WordPress .

# JavaScript Linting
npm run lint:js

# Build Test
npm run build
```

## Architecture

### Plugin Architecture

```
┌─────────────────────────────────────┐
│   fs-eventbrite-button.php          │
│   (Main Plugin File)                │
│   - Plugin initialization           │
│   - Shortcode registration          │
│   - Script/style registration       │
└──────────────┬──────────────────────┘
               │
               ├─────────────────────────────────┐
               │                                 │
┌──────────────▼──────────────────┐   ┌─────────▼──────────────┐
│  FSEventbriteWidgetPlugin       │   │  FS_Eventbrite_Block   │
│  (Main Class)                   │   │  (Block Handler)       │
│  - Shortcode handler            │   │  - Block registration  │
│  - Widget HTML generation       │   │  - Render callback     │
│  - Input sanitization           │   │  - Attribute handling  │
└─────────────────────────────────┘   └────────────────────────┘
```

### Block Architecture

```
┌─────────────────────────────────────┐
│   block.json                        │
│   (Block Configuration)             │
│   - Attributes definition           │
│   - Supports configuration          │
└──────────────┬──────────────────────┘
               │
               ├─────────────────────────────────┐
               │                                 │
┌──────────────▼──────────────────┐   ┌─────────▼──────────────┐
│  edit.js                        │   │  save.js               │
│  (Editor Component)             │   │  (Save Component)      │
│  - Visual controls              │   │  - Returns null        │
│  - Live preview                 │   │  (Dynamic rendering)   │
│  - Inspector panels             │   │                        │
└─────────────────────────────────┘   └────────────────────────┘
               │
               │
┌──────────────▼──────────────────┐
│  class-fs-eventbrite-block.php  │
│  (Render Callback)              │
│  - Converts attributes          │
│  - Calls shortcode handler      │
│  - Returns HTML                 │
└─────────────────────────────────┘
```

### Data Flow

1. **User adds block** → Block registered via `block.json`
2. **User configures** → React component updates attributes
3. **User saves post** → Attributes stored in post content
4. **Frontend render** → PHP render callback called
5. **Render callback** → Converts to shortcode format
6. **Shortcode handler** → Generates HTML output
7. **Output** → Eventbrite widget displayed

## Contributing

### Contribution Workflow

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/my-new-feature
   ```
3. **Make your changes**
   - Follow coding standards
   - Add tests if applicable
   - Update documentation
4. **Commit your changes**
   ```bash
   git commit -m "feat: Add new feature"
   ```
5. **Push to your fork**
   ```bash
   git push origin feature/my-new-feature
   ```
6. **Create a Pull Request**

### Commit Message Format

Follow [Conventional Commits](https://www.conventionalcommits.org/):

```
feat: Add new feature
fix: Fix bug in widget rendering
docs: Update developer documentation
style: Format code according to standards
refactor: Refactor block component
test: Add tests for shortcode handler
chore: Update dependencies
```

### Pull Request Guidelines

- Provide clear description of changes
- Reference related issues
- Include screenshots for UI changes
- Ensure all tests pass
- Update documentation as needed

## Build Scripts Reference

### Available npm Scripts

```json
{
  "start": "wp-scripts start",           // Development build with watch
  "build": "wp-scripts build",           // Production build
  "lint:js": "wp-scripts lint-js",       // Lint JavaScript
  "lint:php": "phpcs",                   // Lint PHP (requires phpcs)
  "format": "wp-scripts format",         // Format code
  "packages-update": "wp-scripts packages-update"  // Update @wordpress packages
}
```

### Webpack Configuration

The plugin uses `@wordpress/scripts` which provides a pre-configured webpack setup. Custom configuration can be added via `webpack.config.js`:

```javascript
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
    ...defaultConfig,
    // Custom configuration here
};
```

## Debugging

### Enable WordPress Debug Mode

Add to `wp-config.php`:

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SCRIPT_DEBUG', true );
```

### Browser DevTools

- Use React DevTools for block debugging
- Check Console for JavaScript errors
- Use Network tab to verify script loading

### PHP Debugging

```php
// Add to plugin code
error_log( print_r( $variable, true ) );

// View logs
tail -f wp-content/debug.log
```

## Release Process

1. **Update version numbers**
   - `fs-eventbrite-button.php` (plugin header and constant)
   - `readme.txt` (stable tag)
   - `block.json` (version)
   - `package.json` (version)

2. **Update changelog**
   - `CHANGELOG.md`
   - `readme.txt` (changelog section)

3. **Build production assets**
   ```bash
   npm run build
   ```

4. **Test thoroughly**
   - Fresh WordPress install
   - Multiple PHP versions
   - Multiple WordPress versions

5. **Create release**
   ```bash
   git tag -a v2.1.0 -m "Release version 2.1.0"
   git push origin v2.1.0
   ```

6. **Create distribution ZIP**
   ```bash
   zip -r fs-eventbrite-widget.zip . \
     -x "*.git*" "*node_modules*" "*.DS_Store" \
     "*package*.json" "*webpack.config.js" \
     "*.wordpress-org*" "*DEVELOPER.md"
   ```

## Resources

### WordPress Development
- [Plugin Handbook](https://developer.wordpress.org/plugins/)
- [Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [Coding Standards](https://developer.wordpress.org/coding-standards/)

### Tools
- [@wordpress/scripts](https://www.npmjs.com/package/@wordpress/scripts)
- [wp-env](https://www.npmjs.com/package/@wordpress/env)
- [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

### Community
- [WordPress Slack](https://make.wordpress.org/chat/)
- [WordPress Stack Exchange](https://wordpress.stackexchange.com/)
- [GitHub Issues](https://github.com/ajithrn/fs-eventbrite-widget/issues)

## Support

For development questions or issues:
- Open an issue on GitHub
- Check existing documentation
- Review WordPress developer resources

---

**Happy Coding!** 🚀
