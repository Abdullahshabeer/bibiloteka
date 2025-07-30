<?php
/**
 * Template Name: Parent Child
 */
get_header();

// Start the Loop.
if (have_posts()) {
    while (have_posts()) {
        the_post(); ?>
        
        <section class="top-banner-sec">
            <div class="container">
                <div class="row flex-row-reverse">
                    <div class="col-lg-6">
                        <div class="banner-img">
                            <?php the_post_thumbnail('full'); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="banner-content">
                            <?php if (function_exists('custom_breadcrumbs')) custom_breadcrumbs(); ?>
                            <h1><?php the_title(); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <main class="main-wrap">
            <div class="container">
                <div class="podstrony-block">
                    <div class="row">
                        <?php
                        // Get the child pages of the current page
                        $child_pages_query = new WP_Query([
                            'post_type'      => 'page',
                            'post_parent'    => get_the_ID(),
                            'posts_per_page' => -1,
                            'orderby'        => 'menu_order',
                            'order'          => 'ASC',
                        ]);

                        if ($child_pages_query->have_posts()) {
                            while ($child_pages_query->have_posts()) {
                                $child_pages_query->the_post();
                                ?>
                                <div class="col-xl-4 col-lg-6">
                                    <div class="podstrony-card">
                                        <a href="<?php echo esc_url(get_permalink()); ?>" class="podstrony-card-inner d-flex flex-column">
                                            <?php 
                                            $page_icons = get_field('page_icons', get_the_ID());
                                            if (!empty($page_icons) && isset($page_icons['url'])) {
                                                echo '<div class="icon-sec">
                                                        <img src="' . esc_url($page_icons['url']) . '" alt="' . esc_attr($page_icons['alt']) . '" />
                                                    </div>';
                                            }
                                             ?>
                                            <h2><?php echo esc_html(get_the_title()); ?></h2>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            wp_reset_postdata();
                        } else {
                            echo '<h1>' . esc_html(get_the_title()) . '</h1>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main>

    <?php
    }
}

get_footer();
?>
