<?php
/* Template Name: Kalendarz imprez */

get_header(); 

if (have_posts()) :
    while (have_posts()) : the_post(); ?>
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
        <!-- Normal Filter -->
        <div class="advance-search-bar gray-bg radius-40">
            <h2><?php _e('Szukaj w kalendarzu', 'bibiloteka') ?></h2>
            <div class="web-form">
                <form id="normal-filter-form">
                    <div class="form-inner">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="row">
                                    <div class="col-xl-7 col-lg-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="search" placeholder="<?php _e('Wpisz szukaną frazę', 'bibiloteka') ?>">
                                        </div>
                                    </div>
                                    <div class="col-xl-5 col-lg-6">
                                        <div class="form-group">
                                            <input type="date" class="form-control" name="date_from">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6">
                                        <div class="form-group">
                                            <input type="date" class="form-control" name="date_to">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6">
                                        <div class="form-group">
                                            <?php
                                            $categories = get_terms(['taxonomy' => 'wydarzen_categories']);
                                            ?>
                                            <select class="form-select" name="category">
                                                <option value=""><?php _e('Kategoria', 'bibiloteka') ?></option>
                                                <?php foreach ($categories as $cat): ?>
                                                    <option value="<?php echo esc_attr($cat->term_id); ?>">
                                                        <?php echo esc_html($cat->name); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div class="form-group">
                                            <?php
                                            $categories = get_terms(['taxonomy' => 'dla_kogo']);
                                            ?>
                                            <select class="form-select" name="dla_kogo">
                                                <option value=""><?php _e('Dla kogo', 'bibiloteka') ?> </option>
                                                <?php foreach ($categories as $cat): ?>
                                                    <option value="<?php echo esc_attr($cat->term_id); ?>">
                                                        <?php echo esc_html($cat->name); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-sec">
                            <button type="reset" class="btn btn-secondary reset-btn" id="reset-normal-filter">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/refresh.svg" alt="icon">
                                <span><?php _e('Resetuj wyniki', 'bibiloteka') ?></span>
                            </button>
                            <button type="submit" class="btn btn-primary"><?php _e('Szukaj', 'bibiloteka') ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div style="height:80px" class="wp-block-spacer"></div>

        <!-- Calendar Filter -->
        <div class="articles-wrap">
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="calender-sec">
                        <div id="calendar"></div>
                        <button id="reset-calendar" class="btn btn-secondary reset-btn">
                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/refresh.svg" alt="icon"></span>
                            <?php _e('Resetuj wyniki', 'bibiloteka') ?>
                        </button>
                    </div>
                </div>
                
                    <?php
                    $args = [
                        'post_type'      => 'kalendarz-wydarzen',
                        'posts_per_page' => 1,
                        'paged'          => (get_query_var('paged')) ? get_query_var('paged') : 1,
                    ];
                    $query = new WP_Query($args);

                    if ($query->have_posts()) : ?>
                        <div class="col-xl-8 col-md-6">
                            <!-- AJAX Loaded Posts -->
                            <div id="ajax-events" class="row">
                       <?php while ($query->have_posts()) : $query->the_post(); 
                            // Get ACF date and time fields
                            $event_date_raw = get_field('date');   // ACF Date field
                            $event_time_raw = get_field('time');   // ACF Time field

                            // Format date and time
                            $event_date_display = $event_date_raw 
                                ? date_i18n('j F Y', strtotime($event_date_raw)) 
                                : '';

                            $event_time_display = $event_time_raw 
                                ? date_i18n('H:i', strtotime($event_time_raw)) 
                                : '';
                            ?>
                            <div class="col-xl-4 col-md-6">
                                <div class="article-card">
                                    <a href="<?php the_permalink(); ?>" class="article-card-inner d-flex flex-column">
                                        <div class="featured-image double-image" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>);">
                                            <?php the_post_thumbnail(); ?>

                                            <?php
                                            // Display dla_kogo taxonomy terms
                                            $dla_kogo_terms = get_the_terms(get_the_ID(), 'dla_kogo');
                                            if (!empty($dla_kogo_terms) && !is_wp_error($dla_kogo_terms)) : ?>
                                                <div class="selected-cat">
                                                    <?php foreach ($dla_kogo_terms as $term) : ?>
                                                        <span><?php echo esc_html($term->name); ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="article-card-content d-flex flex-column">
                                            <div class="article-meta d-flex align-items-center">
                                                <?php if ($event_date_display) : ?>
                                                    <span><img src="<?php echo get_template_directory_uri(); ?>/images/calendar.svg" alt="icon"><?php echo esc_html($event_date_display); ?></span>
                                                <?php endif; ?>
                                                <?php if ($event_time_display) : ?>
                                                    <span><img src="<?php echo get_template_directory_uri(); ?>/images/clock.svg" alt="icon"><?php echo esc_html($event_time_display); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <?php
                                            // Display wydarzen_categories taxonomy terms with ACF color
                                            $wydarzen_terms = get_the_terms(get_the_ID(), 'wydarzen_categories');
                                            if (!empty($wydarzen_terms) && !is_wp_error($wydarzen_terms)) : ?>
                                                <div class="category-sec">
                                                    <?php foreach ($wydarzen_terms as $term) :
                                                        $term_color = get_field('color_select', 'wydarzen_categories_' . $term->term_id); // ACF field
                                                        $term_color = $term_color ?: '#1A8D92'; // fallback color
                                                    ?>
                                                        <span class="cat-color" style="background-color: <?php echo esc_attr($term_color); ?>;"></span>
                                                        <p><?php echo esc_html($term->name); ?></p>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>

                                            <div class="article-title">
                                                <h3><?php the_title(); ?></h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                          </div>
                              </div>
                                <div style="height:80px" aria-hidden="true" class="wp-block-spacer"></div>
                                <?php if ($query->max_num_pages > 1): ?>
                                    <div id="ajax-pagination" class="pagination-wrap">
                                        <div  class="pagination-inner" role="navigation">
                                            <?php
                                            $big = 999999999; // Need an unlikely integer
                                            $pages = paginate_links([
                                                'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                                'format'    => '?paged=%#%',
                                                'current'   => max(1, get_query_var('paged')),
                                                'total'     => $query->max_num_pages,
                                                'type'      => 'array',
                                                'prev_text' => '<img src="' . get_template_directory_uri() . '/images/right-arrow.svg" alt="Prev">',
                                                'next_text' => '<img src="' . get_template_directory_uri() . '/images/right-arrow.svg" alt="Next">',
                                            ]);

                                            if (is_array($pages)) {
                                                foreach ($pages as $page) {
                                                    echo $page;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                    <?php
                    else:
                        echo '<p>Brak wydarzeń do wyświetlenia.</p>';
                    endif;
                    ?>
                </div>

            <!-- Pagination -->
           
          

            
        </div>
    </div>
</main>

    <?php
$event_dates = [];
$events_query = new WP_Query([
    'post_type'      => 'kalendarz-wydarzen',
    'posts_per_page' => -1,
    'fields'         => 'ids',
]);

if ($events_query->have_posts()) {
    foreach ($events_query->posts as $post_id) {
        $acf_date = get_field('date', $post_id); // Get ACF date
        if (!empty($acf_date)) {
            // Ensure date is in Y-m-d format
            $formatted_date = date('Y-m-d', strtotime($acf_date));
            $event_dates[] = $formatted_date;
        }
    }
}
wp_reset_postdata();

// Inject real event dates into JS
wp_add_inline_script(
    'admin-script',
    'calendarData.events = ' . wp_json_encode($event_dates) . ';',
    'before'
);
?>
<script>
    const events = <?php echo wp_json_encode($event_dates); ?>;
    console.log("Events from PHP (ACF date):", events);
</script>
<?php endwhile; endif; 

get_footer();
?>
     