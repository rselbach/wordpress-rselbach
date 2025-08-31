# Rselbach WordPress Theme

A GitHub-inspired WordPress theme that matches the Hugo rselbach theme exactly.

## Features

- Clean, GitHub-inspired design
- Responsive layout
- Custom homepage with avatar and social links
- Archives page with year grouping
- Tag support
- Custom colors (accent and decoration)
- Google Analytics integration
- Font Awesome icons
- PT Sans font

## Installation

1. Upload the `rselbach` folder to your WordPress installation's `wp-content/themes/` directory
2. Activate the theme through the WordPress admin panel (Appearance > Themes)
3. Configure the theme through the WordPress Customizer

## Configuration

### Theme Customizer Settings

Navigate to **Appearance > Customize** to configure:

#### Theme Settings
- **Accent Color**: Primary theme accent color (default: #ff7675)
- **Decoration Color**: Secondary decoration color (default: #ff7675)
- **Avatar Image**: Upload your profile avatar image
- **Google Analytics ID**: Enter your GA measurement ID (e.g., G-XXXXXXXXXX)

#### Social Links
- Mastodon URL
- Bluesky URL
- Twitter/X URL
- LinkedIn URL
- GitHub URL

### Menu Setup

1. Go to **Appearance > Menus**
2. Create a new menu
3. Add your pages (Home, Blog, etc.)
4. Assign it to the "Primary Menu" location

### Homepage Setup

1. Create a new page for your homepage content
2. Go to **Settings > Reading**
3. Set "Your homepage displays" to "A static page"
4. Select your homepage from the dropdown

### Blog Page Setup

1. Create a new page titled "Blog"
2. Leave the content empty
3. Go to **Settings > Reading**
4. Set the "Posts page" to your Blog page

## Required Plugins

None required, but these are recommended:
- Classic Editor (if you prefer the classic WordPress editor)
- Yoast SEO or similar for SEO optimization

## Theme Structure

```
rselbach/
├── style.css           # Main theme stylesheet
├── functions.php       # Theme functions and setup
├── index.php          # Main template file
├── front-page.php     # Homepage template
├── single.php         # Single post template
├── page.php           # Page template
├── archive.php        # Archive template
├── search.php         # Search results template
├── 404.php            # 404 error page
├── header.php         # Header template
├── footer.php         # Footer template
├── searchform.php     # Search form template
├── screenshot.png     # Theme screenshot
├── images/           # Theme images
│   └── avatar.jpg    # Default avatar
└── README.md         # This file

```

## Matching Hugo Theme

This WordPress theme replicates all the features of the original Hugo theme:
- Same CSS styles and layout
- Identical header behavior (shows on homepage only)
- Same post metadata display
- Matching archive page layout
- Identical social links grid
- Same typography and colors

## License

GPL v2 or later

## Support

For issues or questions, please contact the theme author.