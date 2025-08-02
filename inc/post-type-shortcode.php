<?php
function custom_catalogue_search_shortcode() {
	ob_start();
	?>
	<div class="search-form-wrap">
		<form class="search-form" role="search" method="get" action="https://omnis-dbp.primo.exlibrisgroup.com/discovery/search">
			<input type="hidden" name="tab" value="LibraryCatalog">
			<input type="hidden" name="search_scope" value="MyInstitution">
			<input type="hidden" name="vid" value="48OMNIS_WBP:48OMNIS_WBP">
			<input type="hidden" name="offset" value="0">
			
			<input class="form-control" type="search" name="query" placeholder="Wpisz szukaną frazę" aria-label="Search"
			       oninput="this.setAttribute('value', 'any,contains,' + this.value);"
			       value="">
			
			<button class="btn-search" type="submit">Szukaj</button>
		</form>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('custom_catalogue_search', 'custom_catalogue_search_shortcode');

function custom_catalogue_search_handler($request) {
    $params = $request->get_params();
    $content = do_shortcode("[custom_catalogue_search]");
    

    return rest_ensure_response(array('content' => $content));
}
   add_action('rest_api_init', function () {
    register_rest_route('blocks-preview-shortvode/v1', '/custom_catalogue_search_handler-type', array(
        'methods' => 'POST',
        'callback' => 'custom_catalogue_search_handler',
    ));
});

function homepage_new_section_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'post_type' => 'kalendarz-wydarzen',
            'posts_per_page' => 2,
        ),
        $atts
    );

    ob_start();
?>
        <div class="event-search-bar gray-bg radius-40">
            <div class="web-form">
                <form id="" method="GET" action="<?php echo site_url('/kalendarz-imprez'); ?>">
                    <div class="form-inner">
                        <div class="fields-sec">
                            <div class="w-large">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search" placeholder="<?php _e('Wpisz szukaną frazę', 'bibiloteka') ?>">
                                </div>
                            </div>
                            <div class="w-small">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="data_od" value="" placeholder="Data od" aria-label="Data od" onfocus="this.type='date'" onblur="this.type='text'">
                                </div>
                            </div>
                            <div class="w-small">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="data_do" value="" placeholder="Data do" aria-label="Data do" onfocus="this.type='date'" onblur="this.type='text'">
                                </div>
                            </div>
                            <div class="w-medium">
                                <div class="form-group">
                                <select class="form-select" name="category">
                                        <option value=""><?php _e('Kategoria', 'bibiloteka') ?></option>
                                        <?php $categories = get_terms(['taxonomy' => 'wydarzen_categories']); ?>
                                         
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?php echo esc_attr($cat->term_id); ?>">
                                                <?php echo esc_html($cat->name); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="w-medium">
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
                        <div class="button-sec">
                            <button type="submit" class="btn btn-primary"><?php _e('Szukaj', 'bibiloteka') ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="home-event-sec">
            <div class="calender-sec">
                <div id="calendar"></div>
                <button id="reset-calendar" class="btn btn-secondary reset-btn">
                    <span><img src="<?php echo get_template_directory_uri(); ?>/images/refresh.svg" alt="icon"></span>
                    <?php _e('Resetuj wyniki', 'bibiloteka') ?>
                </button>
            </div>
            <div class="carousel-block">
                <div id="ajax-events" class="owl-carousel owl-theme events-carousel-home">
                    <?php
                       
                        $query = new WP_Query($atts);

                        if ($query->have_posts()) : ?>
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
                    <div class="item">
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
                    endif; 
                    
                    ?>
                </div>
            </div>
        </div>
   
    <?php
    // Event dates array for JS
    $event_dates = [];
    $events_query = new WP_Query([
        'post_type'      => 'kalendarz-wydarzen',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ]);

    if ($events_query->have_posts()) {
        foreach ($events_query->posts as $post_id) {
            $acf_date = get_field('date', $post_id);
            if (!empty($acf_date)) {
                $formatted_date = date('Y-m-d', strtotime($acf_date));
                $event_dates[] = $formatted_date;
            }
        }
    }
    wp_reset_postdata();

    // Inject JS
    ?>
    <script>
        const events = <?php echo wp_json_encode($event_dates); ?>;
        console.log("Events from PHP (ACF date):", events);
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('homepage-new-shortcode', 'homepage_new_section_shortcode');


/**
 * 
 * API endpoint for get_post_shortcode
 */
function publications_list_custom_post_type_handler($request) {
    $params = $request->get_params();
    $content = do_shortcode("[homepage-new-shortcode post_type='{$params['postType']}' posts_per_page='{$params['postperpage']}' categories='{$params['selectedCategory']}' ]");
    

    return rest_ensure_response(array('content' => $content));
}
   add_action('rest_api_init', function () {
    register_rest_route('blocks-preview-shortvode/v1', '/homepage-new-post-shortcode-type', array(
        'methods' => 'POST',
        'callback' => 'publications_list_custom_post_type_handler',
    ));
});
function homepage_new_posts_section_shortcode($atts) {
    $atts = shortcode_atts(array(
        'post_type' => 'post',
        'posts_per_page' => 4,
    ), $atts);

    $query = new WP_Query(array(
        'post_type'      => $atts['post_type'],
        'posts_per_page' => $atts['posts_per_page'],
        'post_status'    => 'publish',
    ));

    ob_start();

    if ($query->have_posts()) {
        echo '<div class="announcements-b-wrap d-flex flex-row">';

        $count = 0;

        while ($query->have_posts()) {
            $query->the_post();
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: 'https://via.placeholder.com/600x400';
            $date = get_the_date('j F Y');
            $title = get_the_title();
            $permalink = get_permalink();

            if ($count === 0) {
                // First post (large card)
                ?>
                <div class="card-large">
                    <div class="article-card">
                        <a href="<?php echo esc_url($permalink); ?>" class="article-card-inner d-flex flex-column">
                            <div class="featured-image">
                                <img src="<?php echo esc_url($image_url); ?>" alt="">
                            </div>
                            <div class="article-card-content d-flex flex-column">
                                <div class="article-meta d-flex align-items-center">
                                    <span><?php echo esc_html($date); ?></span>
                                </div>
                                <div class="article-title">
                                    <h3><?php echo esc_html($title); ?></h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="card-mini d-flex flex-column">
                <?php
            } else {
                // Remaining posts (mini cards)
                ?>
                <div class="article-card horizontal-layout">
                    <a href="<?php echo esc_url($permalink); ?>" class="article-card-inner d-flex flex-column">
                        <div class="featured-image">
                            <img src="<?php echo esc_url($image_url); ?>" alt="">
                        </div>
                        <div class="article-card-content d-flex flex-column">
                            <div class="article-meta d-flex align-items-center">
                                <span><?php echo esc_html($date); ?></span>
                            </div>
                            <div class="article-title">
                                <h3><?php echo esc_html($title); ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }

            $count++;
        }

        // Close the mini card wrap if at least one mini card was rendered
        if ($count > 1) {
            echo '</div>'; // close .card-mini
        }

        echo '</div>'; // close .announcements-b-wrap
        wp_reset_postdata();
    } else {
        echo '<p>Brak dostępnych postów.</p>';
    }

    return ob_get_clean();
}
add_shortcode('homepage-new-posts-shortcode', 'homepage_new_posts_section_shortcode');
function publications_list_custom_news_post_type($request) {
    $params = $request->get_params();
    $content = do_shortcode("[homepage-new-posts-shortcode post_type='{$params['postType']}' posts_per_page='{$params['postperpage']}' categories='{$params['selectedCategory']}' ]");
    

    return rest_ensure_response(array('content' => $content));
}
   add_action('rest_api_init', function () {
    register_rest_route('blocks-preview-shortvodef/v1', '/homepage-new-post-type-shortcode-type', array(
        'methods' => 'POST',
        'callback' => 'publications_list_custom_news_post_type',
    ));
});


/**
 * 
 * API endpoint for get_post_shortcode
 */
function teaser_new_posts_section_shortcode($atts) {
    $atts = shortcode_atts(array(
        'post_type'      => 'post',
        'posts_per_page' => 3,
    ), $atts);

    $query = new WP_Query(array(
        'post_type'      => $atts['post_type'],
        'posts_per_page' => $atts['posts_per_page'],
        'post_status'    => 'publish',
    ));

    ob_start();

    if ($query->have_posts()) : ?>
        <div class="carousel-block">
            <div class="owl-carousel owl-theme events-carousel">
                <?php while ($query->have_posts()) : $query->the_post(); 
                    // Get ACF date and time fields
                    $event_date_raw = get_field('date');
                    $event_time_raw = get_field('time');

                    $event_date_display = $event_date_raw 
                        ? date_i18n('j F Y', strtotime($event_date_raw)) 
                        : '';

                    $event_time_display = $event_time_raw 
                        ? date_i18n('H:i', strtotime($event_time_raw)) 
                        : '';
                    ?>
                    <div class="item">
                        <div class="article-card">
                            <a href="<?php the_permalink(); ?>" class="article-card-inner d-flex flex-column">
                                <?php
                                $post_type = get_post_type(get_the_ID());
                               if ($post_type === 'kalendarz-wydarzen') : ?>
                                    <div class="featured-image double-image" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>);">
                                        <?php the_post_thumbnail(); ?>
                                    </div>
                                <?php else : ?>
                                    <div class="featured-image">
                                        <?php the_post_thumbnail(); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="article-card-content d-flex flex-column">
                                    <?php if ($event_date_display): ?>
                                        <div class="article-meta d-flex align-items-center">
                                            <span>
                                                <img src="<?php echo get_template_directory_uri(); ?>/images/calendar.svg" alt="icon">
                                                <?php echo esc_html($event_date_display); ?>
                                            </span>
                                            <?php if ($event_time_display): ?>
                                                <span>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/clock.svg" alt="icon">
                                                    <?php echo esc_html($event_time_display); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="article-meta d-flex align-items-center">
                                            <span><?php echo get_the_date('j F Y'); ?></span>
                                        </div>
                                    <?php endif; ?>
                                   <?php
                                        $post_type = get_post_type(get_the_ID());

                                        if ($post_type === 'kalendarz-wydarzen') :
                                            $wydarzen_terms = get_the_terms(get_the_ID(), 'wydarzen_categories');

                                            if (!empty($wydarzen_terms) && !is_wp_error($wydarzen_terms)) : ?>
                                                <div class="category-sec">
                                                    <?php foreach ($wydarzen_terms as $term) :
                                                        $term_color = get_field('color_select', 'wydarzen_categories_' . $term->term_id);
                                                        $term_color = $term_color ?: '#1A8D92';
                                                    ?>
                                                        <span class="cat-color" style="background-color: <?php echo esc_attr($term_color); ?>;"></span>
                                                        <p><?php echo esc_html($term->name); ?></p>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif;
                                        endif;
                                        ?>
                                    <div class="article-title">
                                        <h3><?php the_title(); ?></h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif;

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('teaser-new-posts-shortcode', 'teaser_new_posts_section_shortcode');




/**
 * 
 * API endpoint for get_post_shortcode
 */
function teaser_list_custom_news_post_type($request) {
    $params = $request->get_params();
    $content = do_shortcode("[teaser-new-posts-shortcode post_type='{$params['postType']}' posts_per_page='{$params['postperpage']}' categories='{$params['selectedCategory']}' ]");
    

    return rest_ensure_response(array('content' => $content));
}
   add_action('rest_api_init', function () {
    register_rest_route('blocks-preview-shortvodef/v1', '/teaser-new-post-type-shortcode-type', array(
        'methods' => 'POST',
        'callback' => 'teaser_list_custom_news_post_type',
    ));
});

            













function news_new_posts_section_shortcode($atts) {
    $atts = shortcode_atts(array(
        'post_type' => 'post',
        'posts_per_page' => 4,
    ), $atts);

    $query = new WP_Query(array(
        'post_type'      => $atts['post_type'],
        'posts_per_page' => $atts['posts_per_page'],
        'post_status'    => 'publish',
    ));

    ob_start();

    if ($query->have_posts()) {
        echo '<div class="announcements-b-wrap d-flex flex-row">';

        $count = 0;

        while ($query->have_posts()) {
            $query->the_post();
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: 'https://via.placeholder.com/600x400';
            $date = get_the_date('j F Y');
            $title = get_the_title();
            $permalink = get_permalink();

            if ($count === 0) {
                // First post (large card)
                ?>
                <div class="card-large">
                    <div class="article-card">
                        <a href="<?php echo esc_url($permalink); ?>" class="article-card-inner d-flex flex-column">
                            <div class="featured-image">
                                <img src="<?php echo esc_url($image_url); ?>" alt="">
                            </div>
                            <div class="article-card-content d-flex flex-column">
                                <div class="article-meta d-flex align-items-center">
                                    <span><?php echo esc_html($date); ?></span>
                                </div>
                                <div class="article-title">
                                    <h3><?php echo esc_html($title); ?></h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="card-mini d-flex flex-column">
                <?php
            } else {
                // Remaining posts (mini cards)
                ?>
                <div class="article-card horizontal-layout">
                    <a href="<?php echo esc_url($permalink); ?>" class="article-card-inner d-flex flex-column">
                        <div class="featured-image">
                            <img src="<?php echo esc_url($image_url); ?>" alt="">
                        </div>
                        <div class="article-card-content d-flex flex-column">
                            <div class="article-meta d-flex align-items-center">
                                <span><?php echo esc_html($date); ?></span>
                            </div>
                            <div class="article-title">
                                <h3><?php echo esc_html($title); ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }

            $count++;
        }

        // Close the mini card wrap if at least one mini card was rendered
        if ($count > 1) {
            echo '</div>'; // close .card-mini
        }

        echo '</div>'; // close .announcements-b-wrap
        wp_reset_postdata();
    } else {
        echo '<p>Brak dostępnych postów.</p>';
    }

    return ob_get_clean();
}
add_shortcode('news-new-posts-shortcode', 'news_new_posts_section_shortcode');



/**
 * 
 * API endpoint for get_post_shortcode
 */
function news_list_custom_news_post_type($request) {
    $params = $request->get_params();
    $content = do_shortcode("[news-new-posts-shortcode post_type='{$params['postType']}' posts_per_page='{$params['postperpage']}' categories='{$params['selectedCategory']}' ]");
    

    return rest_ensure_response(array('content' => $content));
}
   add_action('rest_api_init', function () {
    register_rest_route('blocks-preview-shortvodef/v1', '/news-new-post-type-shortcode-type', array(
        'methods' => 'POST',
        'callback' => 'news_list_custom_news_post_type',
    ));
});


