# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a custom WordPress theme called "Rselbach" that replicates the design and functionality of a Hugo theme. It features a GitHub-inspired design with customizable colors, social links, and Google Analytics integration.

## Theme Structure

The theme follows standard WordPress template hierarchy:
- `functions.php`: Theme setup, customizer settings, navigation walker, and hooks
- `style.css`: Main stylesheet with CSS custom properties for theming
- `front-page.php`: Homepage template with avatar and social links grid
- `index.php`: Main blog listing template
- `single.php`: Individual post template
- `page.php`: Page template
- `archive.php`: Archive pages with year grouping
- `header.php` / `footer.php`: Site-wide header and footer

## Development Commands

Since this is a WordPress theme, there are no build or compilation steps. Development workflow:

1. **Local Development**: Place theme in `wp-content/themes/` directory of a WordPress installation
2. **Testing**: Activate theme through WordPress admin (Appearance > Themes)
3. **CSS Changes**: Edit `style.css` directly - changes are immediate
4. **PHP Changes**: Edit template files directly - refresh browser to see changes

## Key Customization Points

### Theme Customizer Settings (functions.php:151-272)
- Accent and decoration colors (CSS custom properties)
- Avatar image upload
- Google Analytics integration
- Social links (Mastodon, Bluesky, Twitter, LinkedIn, GitHub)

### Navigation System
- Custom navigation walker (`Rselbach_Nav_Walker`) for styled menu items
- Primary menu location registered
- Fallback menu function for default navigation

### Template Customizations
- Homepage shows header with avatar only on front page
- Archive pages group posts by year
- Custom excerpt length (55 words) and formatting
- Font Awesome icons for social links
- PT Sans font family throughout

## WordPress Integration

- Theme supports: post thumbnails, HTML5 markup, title tag, RSS feeds, custom logo
- Custom image size: `rselbach-featured` (860x480)
- Text domain: `rselbach` for translations
- No required plugins, compatible with Classic Editor and SEO plugins