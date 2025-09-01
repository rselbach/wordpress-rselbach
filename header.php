<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <!-- DNS prefetch and preconnect for external resources -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Preload critical fonts -->
    <link rel="preload" href="https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700|Abril+Fatface&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700|Abril+Fatface&display=swap"></noscript>
    
    <!-- Font Awesome is enqueued via wp_enqueue_style and may include SRI via style_loader_tag filter. -->
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php echo esc_html__( 'Skip to content', 'rselbach' ); ?></a>
<div class="layout">
    <?php if (is_front_page() || is_home()) : ?>
    <header class="header">
        <div class="container">
            <div class="header-inner">
                <div class="site-brand">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title">
                        <?php bloginfo('name'); ?>
                    </a>
                    <?php 
                    $description = get_bloginfo('description', 'display');
                    if ($description || is_customize_preview()) : ?>
                        <p class="site-description"><?php echo esc_html($description); ?></p>
                    <?php endif; ?>
                </div>
                <div class="header-right">
                    <nav class="nav-menu" aria-label="<?php echo esc_attr__( 'Primary navigation', 'rselbach' ); ?>">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'container' => false,
                            'items_wrap' => '%3$s',
                            'fallback_cb' => 'rselbach_default_menu',
                            'walker' => new Rselbach_Nav_Walker(),
                        ));
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <?php endif; ?>
    <main id="content" class="content">
        <div class="container">
