<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header(); ?>

<div class="header-unstyled">
    <strong><em>Random thoughts by <a href="<?php echo esc_url(home_url('/')); ?>">Roberto Selbach</a>. See other <a href="<?php echo esc_url(home_url('/blog')); ?>">blog posts</a> here.</em></strong>
</div>

<article class="post">
    <div class="post-header">
        <h1 class="post-title"><?php _e('404 - Page Not Found', 'rselbach'); ?></h1>
    </div>
    <hr>
    <div class="post-content markdown-body">
        <p><?php _e('Sorry, the page you are looking for could not be found.', 'rselbach'); ?></p>
        <p><?php _e('You can try searching for what you are looking for or go back to the', 'rselbach'); ?> <a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('homepage', 'rselbach'); ?></a>.</p>
        
        <?php get_search_form(); ?>
    </div>
</article>

<?php get_footer(); ?>