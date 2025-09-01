<?php
/**
 * Template Name: Archives (Year Grouped)
 * Description: Lists all published posts grouped by year.
 */

get_header(); ?>

<div class="header-unstyled">
    <strong><em>Random thoughts by <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html( get_bloginfo('name') ); ?></a>. See other <a href="<?php echo esc_url(home_url('/blog')); ?>">blog posts</a> here.</em></strong>
    </div>

<div class="archives-page">
    <h1 class="page-title"><?php _e('Archives', 'rselbach'); ?></h1>

    <div class="archives-list">
        <?php
        $query = new WP_Query([
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'no_found_rows'  => true,
            'fields'         => 'ids',
        ]);

        $years = [];
        foreach ( $query->posts as $post_id ) {
            $year = get_the_date('Y', $post_id);
            $years[ $year ][] = $post_id;
        }
        wp_reset_postdata();
        ?>

        <?php foreach ($years as $year => $ids) : ?>
            <div class="archive-year">
                <h2><?php echo esc_html($year); ?></h2>
                <ul class="archive-items">
                    <?php foreach ($ids as $id) : ?>
                        <li class="archive-item">
                            <span class="archive-date"><?php echo esc_html( get_the_date('M d', $id) ); ?></span>
                            <a href="<?php echo esc_url( get_permalink($id) ); ?>" class="archive-title">
                                <?php echo esc_html( get_the_title($id) ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php get_footer(); ?>

