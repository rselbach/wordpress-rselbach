<?php
/**
 * The main template file
 */

get_header(); ?>

<?php if (!is_front_page() && !is_home()) : ?>
    <div class="header-unstyled">
        <strong><em>Random thoughts by <a href="<?php echo esc_url(home_url('/')); ?>">Roberto Selbach</a>. See other <a href="<?php echo esc_url(home_url('/blog')); ?>">blog posts</a> here.</em></strong>
    </div>
<?php endif; ?>

<div class="list-page">
    <?php if (is_home() && !is_front_page()) : ?>
        <!-- For the blog section, hide the title -->
    <?php elseif (is_archive()) : ?>
        <h1 class="page-title">
            <?php
            if (is_category()) {
                single_cat_title();
            } elseif (is_tag()) {
                single_tag_title();
            } elseif (is_author()) {
                the_author();
            } elseif (is_year()) {
                echo get_the_date('Y');
            } elseif (is_month()) {
                echo get_the_date('F Y');
            } elseif (is_day()) {
                echo get_the_date('F j, Y');
            } else {
                _e('Archives', 'rselbach');
            }
            ?>
        </h1>
    <?php endif; ?>
    
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
                        <?php
                        $tags = get_the_tags();
                        if ($tags) : ?>
                            <span class="post-tags">
                                <i class="fas fa-tags"></i>
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="post-content markdown-body">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endwhile; ?>
            
            <?php
            // Pagination
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('Previous', 'rselbach'),
                'next_text' => __('Next', 'rselbach'),
                'class' => 'pagination',
            ));
            ?>
        <?php else : ?>
            <p><?php _e('No posts found.', 'rselbach'); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>