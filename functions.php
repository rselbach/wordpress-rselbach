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
    // Enqueue theme stylesheet
    wp_enqueue_style('rselbach-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Add custom CSS for accent and decoration colors
    $accent_color = get_theme_mod('rselbach_accent_color', '#ff7675');
    $decoration_color = get_theme_mod('rselbach_decoration_color', '#ff7675');
    
    $custom_css = "
        :root {
            --color-accent: {$accent_color};
            --color-decoration: {$decoration_color};
        }
    ";
    
    wp_add_inline_style('rselbach-style', $custom_css);
    
    // Add Google Analytics if configured
    if ($ga_id = get_theme_mod('rselbach_google_analytics')) {
        wp_enqueue_script('google-analytics', 'https://www.googletagmanager.com/gtag/js?id=' . $ga_id, array(), null, false);
        
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
        'default'           => 'https://cosocial.ca/@rselbach',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('rselbach_mastodon_url', array(
        'label'   => __('Mastodon URL', 'rselbach'),
        'section' => 'rselbach_social_links',
        'type'    => 'url',
    ));
    
    // Bluesky URL
    $wp_customize->add_setting('rselbach_bluesky_url', array(
        'default'           => 'https://bsky.app/profile/rselbach.com',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('rselbach_bluesky_url', array(
        'label'   => __('Bluesky URL', 'rselbach'),
        'section' => 'rselbach_social_links',
        'type'    => 'url',
    ));
    
    // Twitter URL
    $wp_customize->add_setting('rselbach_twitter_url', array(
        'default'           => 'https://x.com/robselbach',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('rselbach_twitter_url', array(
        'label'   => __('Twitter/X URL', 'rselbach'),
        'section' => 'rselbach_social_links',
        'type'    => 'url',
    ));
    
    // LinkedIn URL
    $wp_customize->add_setting('rselbach_linkedin_url', array(
        'default'           => 'https://www.linkedin.com/in/rselbach',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('rselbach_linkedin_url', array(
        'label'   => __('LinkedIn URL', 'rselbach'),
        'section' => 'rselbach_social_links',
        'type'    => 'url',
    ));
    
    // GitHub URL
    $wp_customize->add_setting('rselbach_github_url', array(
        'default'           => 'https://github.com/rselbach/',
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
 * Filter the title for the home page
 */
function rselbach_wp_title($title, $sep) {
    if (is_feed()) {
        return $title;
    }
    
    global $page, $paged;
    
    // Add the blog name
    $title .= get_bloginfo('name', 'display');
    
    // Add the blog description for the home/front page
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) {
        $title .= " $sep $site_description";
    }
    
    // Add a page number if necessary
    if (($paged >= 2 || $page >= 2) && !is_404()) {
        $title .= " $sep " . sprintf(__('Page %s', 'rselbach'), max($paged, $page));
    }
    
    return $title;
}
add_filter('wp_title', 'rselbach_wp_title', 10, 2);

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