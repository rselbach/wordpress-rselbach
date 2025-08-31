<?php
/**
 * The template for displaying archive pages by year
 */

get_header(); ?>

<div class="header-unstyled">
    <strong><em>Random thoughts by <a href="<?php echo esc_url(home_url('/')); ?>">Roberto Selbach</a>. See other <a href="<?php echo esc_url(home_url('/blog')); ?>">blog posts</a> here.</em></strong>
</div>

<div class="archives-page">
    <h1 class="page-title"><?php _e('Archives', 'rselbach'); ?></h1>
    
    <div class="archives-list">
        <?php
        // Get all posts grouped by year
        $years = array();
        $posts = get_posts(array(
            'numberposts' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_type' => 'post',
            'post_status' => 'publish',
        ));
        
        foreach ($posts as $post) {
            $year = get_the_date('Y', $post);
            if (!isset($years[$year])) {
                $years[$year] = array();
            }
            $years[$year][] = $post;
        }
        ?>
        
        <?php foreach ($years as $year => $year_posts) : ?>
            <div class="archive-year">
                <h2><?php echo esc_html($year); ?></h2>
                <ul class="archive-items">
                    <?php foreach ($year_posts as $post) : setup_postdata($post); ?>
                        <li class="archive-item">
                            <span class="archive-date"><?php echo get_the_date('M d', $post); ?></span>
                            <a href="<?php echo get_permalink($post); ?>" class="archive-title">
                                <?php echo get_the_title($post); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>

<?php get_footer(); ?>