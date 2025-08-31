<?php
/**
 * The template for displaying all pages
 */

get_header(); ?>

<?php if (!is_front_page()) : ?>
    <div class="header-unstyled">
        <strong><em>Random thoughts by <a href="<?php echo esc_url(home_url('/')); ?>">Roberto Selbach</a>. See other <a href="<?php echo esc_url(home_url('/blog')); ?>">blog posts</a> here.</em></strong>
    </div>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
    <article class="post">
        <?php if (!is_front_page()) : ?>
            <div class="post-header">
                <h1 class="post-title"><?php the_title(); ?></h1>
            </div>
            <hr>
        <?php endif; ?>
        <div class="post-content markdown-body">
            <?php the_content(); ?>
        </div>
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>