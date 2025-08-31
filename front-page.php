<?php
/**
 * The front page template file
 */

get_header(); ?>

<div class="home">
    <div class="home-content">
        <div class="avatar-container">
            <?php 
            $avatar_url = get_theme_mod('rselbach_avatar_image', get_template_directory_uri() . '/images/avatar.jpg');
            ?>
            <img src="<?php echo esc_url($avatar_url); ?>" alt="Profile Avatar" class="avatar-image">
        </div>
        <div class="content-text">
            <?php 
            // Display the page content if this is a static front page
            if (have_posts()) : 
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>
        
        <div class="social-links">
            <ul>
                <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><i class="fas fa-blog"></i> My blog</a></li>
                <?php if ($mastodon = get_theme_mod('rselbach_mastodon_url')) : ?>
                    <li><a href="<?php echo esc_url($mastodon); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-mastodon"></i> Mastodon</a></li>
                <?php endif; ?>
                <?php if ($bluesky = get_theme_mod('rselbach_bluesky_url')) : ?>
                    <li><a href="<?php echo esc_url($bluesky); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-bluesky"></i> Bluesky</a></li>
                <?php endif; ?>
                <?php if ($twitter = get_theme_mod('rselbach_twitter_url')) : ?>
                    <li><a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-x-twitter"></i> Twitter</a></li>
                <?php endif; ?>
                <?php if ($linkedin = get_theme_mod('rselbach_linkedin_url')) : ?>
                    <li><a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
                <?php endif; ?>
                <?php if ($github = get_theme_mod('rselbach_github_url')) : ?>
                    <li><a href="<?php echo esc_url($github); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-github"></i> GitHub</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<?php get_footer(); ?>