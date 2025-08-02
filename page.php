<?php
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();

        // Check if current page is the front page
        if (is_front_page()) {
            // Show only the content for front page
            the_content();
        } else {
            // Show banner section for other pages
            ?>
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
        <div class="row sub-page-row">
            <?php
            $current_page_id = get_the_ID();
            $parent_id = wp_get_post_parent_id($current_page_id);

            // Check for siblings if parent exists, else check for children
            $menu_query_args = array(
                'post_type' => 'page',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC',
            );

            if ($parent_id) {
                $menu_query_args['post_parent'] = $parent_id;
            } else {
                $menu_query_args['post_parent'] = $current_page_id;
            }

            $menu_query = new WP_Query($menu_query_args);
            $has_menu_items = $menu_query->have_posts();
            ?>

            <div class="<?php echo $has_menu_items ? 'col-xl-8' : 'col-xl-12'; ?>">
                <?php the_content(); ?>
            </div>

            <?php if ($has_menu_items): ?>
                <div class="col-xl-4">
                    <div class="sidebar gray-bg">
                        <div class="web-heading">
                            <h2><?php _e('Menu', 'bibiloteka'); ?></h2>
                        </div>
                        <div class="sidebar-menu">
                            <ul>
                                <?php
                                while ($menu_query->have_posts()) {
                                    $menu_query->the_post();
                                    $active_class = ($current_page_id == get_the_ID()) ? 'current-menu-item' : '';
                                    ?>
                                    <li class="<?php echo $active_class; ?>">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </li>
                                    <?php
                                }
                                wp_reset_postdata();
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>


            <?php
           
        }

    endwhile;
endif;

get_footer();
?>
