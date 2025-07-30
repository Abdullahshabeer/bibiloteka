<?php
/**
 **  Template Name:  child sidebar
 */
get_header();
?>
<?php
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
            <div class="row sub-page-row">
                <div class="col-xl-8">
                    <?php
					the_content()
					?>
                 </div>
                <div class="col-xl-4">
					<div class="sidebar gray-bg">
						<div class="web-heading">
							<h2><?php _e('Menu' , 'bibiloteka') ?></h2>
						</div>
						<div class="sidebar-menu">
                            <ul>
                                <?php
                                // Check if the current page has a parent
                                $parent_id = wp_get_post_parent_id(get_the_ID());
                                $active_class = '';
                                // print_r($parent_id);
                                if ($parent_id) {
                                    // Get the current page's ID
                                    $current_page_id = get_the_ID();
                            
                                    // Get the child pages of the same parent
                                    $sibling_pages_query = new WP_Query(array(
                                        'post_type' => 'page',
                                        'post_parent' => $parent_id,
                                        'posts_per_page' => -1, // Show all sibling pages
                                        'orderby' => 'menu_order', // Order by menu order
                                        'order' => 'ASC', // Ascending order
                                    ));
                            
                                    while ($sibling_pages_query->have_posts()) {
                                        $sibling_pages_query->the_post();
                                        $active_class = ($current_page_id == get_the_ID()) ? 'current-menu-item' : ''; // Check if it's the current page
                                ?>
                                        <li class="<?php echo $active_class; ?>">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </li>
                                <?php
                                    }
                                    wp_reset_postdata(); // Reset post data to the main query
                                } else {
                                    // If there is no parent page, display the current page's title with a link
                                ?>
                                    <li>
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </li>
                                <?php
                                }
                                ?>
                                
                            </ul>
                        </div>
					</div>
				</div>
            </div>
        </div>
    </main>
      <?php
        }
    }
?>

<?php
get_footer()
?>