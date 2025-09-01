<?php
/**
 * Archive template respecting the main query
 */

get_header(); ?>

<div class="header-unstyled">
    <strong><em>Random thoughts by <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html( get_bloginfo('name') ); ?></a>. See other <a href="<?php echo esc_url(home_url('/blog')); ?>">blog posts</a> here.</em></strong>
    </div>

<div class="list-page">
    <h1 class="page-title"><?php the_archive_title(); ?></h1>

    <div class="posts-list">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="post-item">
                    <h2 class="post-title" style="font-weight: 400;">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="post-meta">
                        <span class="post-date">
                            <i class="far fa-calendar-alt"></i> <?php echo get_the_date('F j, Y'); ?>
                        </span>
                        <?php if ($tags = get_the_tags()) : ?>
                            <span class="post-tags">
                                <i class="fas fa-tags"></i>
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag"><?php echo esc_html($tag->name); ?></a>
                                <?php endforeach; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="post-content markdown-body">
                        <?php the_excerpt(); ?>
                    </div>
                </div>
            <?php endwhile; ?>

            <?php the_posts_pagination([
                'mid_size'  => 2,
                'prev_text' => __('Previous', 'rselbach'),
                'next_text' => __('Next', 'rselbach'),
            ]); ?>
        <?php else : ?>
            <p><?php _e('No posts found.', 'rselbach'); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
