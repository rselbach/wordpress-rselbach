<?php
/**
 * The template for displaying all single posts
 */

get_header(); ?>

<div class="header-unstyled">
    <strong><em>Random thoughts by <a href="<?php echo esc_url(home_url('/')); ?>">Roberto Selbach</a>. See other <a href="<?php echo esc_url(home_url('/blog')); ?>">blog posts</a> here.</em></strong>
</div>

<?php while (have_posts()) : the_post(); ?>
    <article class="post">
        <div class="post-header">
            <h1 class="post-title"><?php the_title(); ?></h1>
            <div class="post-meta">
                <span class="post-date">
                    <?php echo rselbach_icon('calendar'); ?> <?php echo get_the_date('F j, Y'); ?>
                </span>
                <?php
                $tags = get_the_tags();
                if ($tags) : ?>
                    <span class="post-tags">
                        <?php echo rselbach_icon('tags'); ?>
                        <?php foreach ($tags as $tag) : ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag">
                                <?php echo esc_html($tag->name); ?>
                            </a>
                        <?php endforeach; ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        <hr>
        <div class="post-content markdown-body">
            <?php the_content(); ?>
        </div>
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>
