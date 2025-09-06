<?php
/**
 * Rselbach theme functions and definitions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Sets up theme defaults and registers support for various WordPress features
 */
function rselbach_setup() {
    // Make theme available for translation
    load_theme_textdomain('rselbach', get_template_directory() . '/languages');
    
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');
    
    // Let WordPress manage the document title
    add_theme_support('title-tag');
    
    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');
    
    // This theme uses wp_nav_menu() in one location
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'rselbach'),
    ));
    
    // Switch default core markup for search form, comment form, and comments to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');
    
    // Add support for Block Styles
    add_theme_support('wp-block-styles');
    
    // Add support for full and wide align images
    add_theme_support('align-wide');
    
    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');
    
    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'rselbach_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet
 */
function rselbach_content_width() {
    $GLOBALS['content_width'] = apply_filters('rselbach_content_width', 860);
}
add_action('after_setup_theme', 'rselbach_content_width', 0);

/**
 * Enqueue scripts and styles
 */
function rselbach_scripts() {
    // Enqueue theme stylesheet (cache-busted by file mtime)
    $style_path = get_stylesheet_directory() . '/style.css';
    $style_ver  = file_exists($style_path) ? filemtime($style_path) : null;
    // Self-hosted icons CSS (optional)
    $icons_css = get_template_directory() . '/assets/icons/icons.css';
    $deps = array();
    if (file_exists($icons_css)) {
        wp_enqueue_style(
            'rselbach-icons',
            get_template_directory_uri() . '/assets/icons/icons.css',
            array(),
            filemtime($icons_css)
        );
        $deps[] = 'rselbach-icons';
    }

    wp_enqueue_style('rselbach-style', get_stylesheet_uri(), $deps, $style_ver);
    
    // Add custom CSS for accent and decoration colors
    $accent_color = get_theme_mod('rselbach_accent_color', '#ff7675');
    $decoration_color = get_theme_mod('rselbach_decoration_color', '#ff7675');
    
    $custom_css = "
        :root {
            --color-accent: {$accent_color};
            --color-decoration: {$decoration_color};
        }
    ";

    // Optionally re-enable image shadows if toggled in Customizer
    if (get_theme_mod('rselbach_enable_image_shadow', false)) {
        $custom_css .= "
            .post-content img,
            .markdown-body img,
            .wp-block-image img,
            .avatar-image {
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }
        ";
    }
    
    wp_add_inline_style('rselbach-style', $custom_css);
    
    // Add Google Analytics if configured (with async loading)
    if ($ga_id = get_theme_mod('rselbach_google_analytics')) {
        wp_enqueue_script('google-analytics', 'https://www.googletagmanager.com/gtag/js?id=' . $ga_id, array(), null, true);
        wp_script_add_data('google-analytics', 'async', true);
        
        $ga_script = "
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{$ga_id}');
        ";
        
        wp_add_inline_script('google-analytics', $ga_script);
    }
}
add_action('wp_enqueue_scripts', 'rselbach_scripts');

/**
 * Render an inline SVG icon from the theme sprite.
 *
 * @param string $name  ID of the symbol in assets/icons/icons.svg
 * @param string $class Extra CSS classes
 * @return string SVG markup or empty string if sprite missing
 */
function rselbach_icon($name, $class = '') {
    $sprite = get_template_directory() . '/assets/icons/icons.svg';
    if (!file_exists($sprite)) {
        return '';
    }
    $classes = trim('icon icon-' . preg_replace('/[^a-z0-9\-]/i', '', $name) . ' ' . $class);
    $href    = get_template_directory_uri() . '/assets/icons/icons.svg#' . rawurlencode($name);
    return '<svg class="' . esc_attr($classes) . '" aria-hidden="true" focusable="false"><use href="' . esc_url($href) . '"></use></svg>';
}

/**
 * Custom navigation walker class
 */
class Rselbach_Nav_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-link';
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        $attributes .= $class_names;
        
        $item_output = $args->before ?? '';
        $item_output .= '<a'. $attributes .'>';
        $item_output .= ($args->link_before ?? '') . apply_filters('the_title', $item->title, $item->ID) . ($args->link_after ?? '');
        $item_output .= '</a>';
        $item_output .= $args->after ?? '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * Default menu fallback
 */
function rselbach_default_menu() {
    ?>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link">Home</a>
    <a href="<?php echo esc_url(home_url('/blog')); ?>" class="nav-link">Blog</a>
    <?php
}

/**
 * Customize register
 */
function rselbach_customize_register($wp_customize) {
    // Add section for theme settings
    $wp_customize->add_section('rselbach_theme_settings', array(
        'title'    => __('Theme Settings', 'rselbach'),
        'priority' => 30,
    ));
    
    // Accent color setting
    $wp_customize->add_setting('rselbach_accent_color', array(
        'default'           => '#ff7675',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'rselbach_accent_color', array(
        'label'    => __('Accent Color', 'rselbach'),
        'section'  => 'rselbach_theme_settings',
        'settings' => 'rselbach_accent_color',
    )));
    
    // Decoration color setting
    $wp_customize->add_setting('rselbach_decoration_color', array(
        'default'           => '#ff7675',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'rselbach_decoration_color', array(
        'label'    => __('Decoration Color', 'rselbach'),
        'section'  => 'rselbach_theme_settings',
        'settings' => 'rselbach_decoration_color',
    )));
    
    // Avatar image setting
    $wp_customize->add_setting('rselbach_avatar_image', array(
        'default'           => get_template_directory_uri() . '/images/avatar.jpg',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'rselbach_avatar_image', array(
        'label'    => __('Avatar Image', 'rselbach'),
        'section'  => 'rselbach_theme_settings',
        'settings' => 'rselbach_avatar_image',
    )));

    // Image shadow toggle
    $wp_customize->add_setting('rselbach_enable_image_shadow', array(
        'default'           => false,
        'sanitize_callback' => 'rselbach_sanitize_checkbox',
    ));

    $wp_customize->add_control('rselbach_enable_image_shadow', array(
        'label'   => __('Enable Image Box Shadows', 'rselbach'),
        'section' => 'rselbach_theme_settings',
        'type'    => 'checkbox',
    ));
    
    // Google Analytics setting
    $wp_customize->add_setting('rselbach_google_analytics', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('rselbach_google_analytics', array(
        'label'       => __('Google Analytics ID', 'rselbach'),
        'description' => __('Enter your Google Analytics measurement ID (e.g., G-XXXXXXXXXX)', 'rselbach'),
        'section'     => 'rselbach_theme_settings',
        'type'        => 'text',
    ));
    
    // Social Links Section
    $wp_customize->add_section('rselbach_social_links', array(
        'title'    => __('Social Links', 'rselbach'),
        'priority' => 35,
    ));
    
    // Mastodon URL
    $wp_customize->add_setting('rselbach_mastodon_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('rselbach_mastodon_url', array(
        'label'   => __('Mastodon URL', 'rselbach'),
        'section' => 'rselbach_social_links',
        'type'    => 'url',
    ));
    
    // Bluesky URL
    $wp_customize->add_setting('rselbach_bluesky_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('rselbach_bluesky_url', array(
        'label'   => __('Bluesky URL', 'rselbach'),
        'section' => 'rselbach_social_links',
        'type'    => 'url',
    ));
    
    // Twitter URL
    $wp_customize->add_setting('rselbach_twitter_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('rselbach_twitter_url', array(
        'label'   => __('Twitter/X URL', 'rselbach'),
        'section' => 'rselbach_social_links',
        'type'    => 'url',
    ));
    
    // LinkedIn URL
    $wp_customize->add_setting('rselbach_linkedin_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('rselbach_linkedin_url', array(
        'label'   => __('LinkedIn URL', 'rselbach'),
        'section' => 'rselbach_social_links',
        'type'    => 'url',
    ));
    
    // GitHub URL
    $wp_customize->add_setting('rselbach_github_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('rselbach_github_url', array(
        'label'   => __('GitHub URL', 'rselbach'),
        'section' => 'rselbach_social_links',
        'type'    => 'url',
    ));
}
add_action('customize_register', 'rselbach_customize_register');

/**
 * Sanitize checkbox values from the Customizer
 */
function rselbach_sanitize_checkbox($checked) {
    return isset($checked) && (int) (bool) $checked;
}

/**
 * Custom excerpt length
 */
function rselbach_excerpt_length($length) {
    return 55;
}
add_filter('excerpt_length', 'rselbach_excerpt_length', 999);

/**
 * Custom excerpt more
 */
function rselbach_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'rselbach_excerpt_more');

/**
 * Add custom image sizes
 */
function rselbach_add_image_sizes() {
    add_image_size('rselbach-featured', 860, 480, true);
}
add_action('after_setup_theme', 'rselbach_add_image_sizes');

/**
 * Register block styles
 */
function rselbach_register_block_styles() {
    if (function_exists('register_block_style')) {
        register_block_style(
            'core/image',
            array(
                'name'  => 'shadow',
                'label' => __('Shadow', 'rselbach'),
            )
        );
    }
}
add_action('init', 'rselbach_register_block_styles');

// Title is handled by core via add_theme_support('title-tag') in rselbach_setup().

/**
 * Add body classes
 */
function rselbach_body_classes($classes) {
    // Adds a class of no-sidebar when there is no sidebar present
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }
    
    // Adds a class for the homepage
    if (is_front_page() && is_home()) {
        $classes[] = 'home-page';
    }
    
    return $classes;
}
add_filter('body_class', 'rselbach_body_classes');

// Core provides image lazy-loading; no custom filters needed.

// Let server/CDN handle static asset caching; avoid PHP cache headers.

/**
 * Optimize jQuery loading
 */
function rselbach_optimize_jquery() {
    if (is_admin()) {
        return;
    }

    // Disable jQuery Migrate only if explicitly opted in
    if (apply_filters('rselbach_disable_jquery_migrate', false)) {
        wp_deregister_script('jquery-migrate');
    }

    // Move jQuery to the footer only if opted in
    if (apply_filters('rselbach_move_jquery_to_footer', false)) {
        wp_scripts()->add_data('jquery', 'group', 1);
        wp_scripts()->add_data('jquery-core', 'group', 1);
    }
}
add_action('wp_enqueue_scripts', 'rselbach_optimize_jquery');

/**
 * Remove unnecessary meta tags and links from head
 */
function rselbach_clean_head() {
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove WordPress version
    remove_action('wp_head', 'wp_generator');
    
    // Remove wlwmanifest link
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove REST API links
    remove_action('wp_head', 'rest_output_link_wp_head');
    
    // Remove oEmbed links
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('init', 'rselbach_clean_head');

/**
 * Disable emojis
 */
function rselbach_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    
    // Remove from TinyMCE
    add_filter('tiny_mce_plugins', 'rselbach_disable_emojis_tinymce');
}
add_action('init', 'rselbach_disable_emojis');

/**
 * Filter function to remove emoji plugin from TinyMCE
 */
function rselbach_disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }
    return array();
}
