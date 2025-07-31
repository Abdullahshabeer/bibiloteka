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
                <form id="normal-filter-form" method="GET" action="<?php echo site_url('/kalendarz-imprez'); ?>">
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
                <div class="owl-carousel owl-theme events-carousel-home">
                    <?php
                       
                        $query = new WP_Query($atts);

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
function homepage_new_section_shortcodef($atts) {
    $atts = shortcode_atts(
        array(
            'post_type' => array('projektyinwestycyjne', 'projekty_leader'),
            'posts_per_page' => 3,
        ),
        $atts
    );

    ob_start();
?>
    <div class="filter-sec d-flex align-items-center">
        <div class="filter-btn d-flex">
            <button type="button" class="btn btn-secondary filter-button" data-postype='projektyinwestycyjne'><?php _e('Projekty inwestycyjne ', 'bibiloteka') ?></button>
            <button type="button" class="btn btn-primary filter-button"   data-postype='projekty_leader'><?php _e('Projekty leader', 'bibiloteka') ?> </button>
        </div>
    </div>
    <!-- Posts Display Section -->
    <div id="post-list" class="carousel-block">
    <div class="loderdiv" style="display: none;"><span class="loader"></span></div>
        <div class="owl-carousel owl-theme article-carousel">
            <?php echo fetch_posts($atts['post_type'], $atts['posts_per_page']); ?>
        </div>
    </div>
    <?php

    return ob_get_clean();
}
add_shortcode('homepage-new-shortcodef', 'homepage_new_section_shortcode');


/**
 * 
 * API endpoint for get_post_shortcode
 */
function publications_list_custom_post_type_handlerf($request) {
    $params = $request->get_params();
    $content = do_shortcode("[homepage-new-shortcodef post_type='{$params['postType']}' posts_per_page='{$params['postperpage']}' categories='{$params['selectedCategory']}' ]");
    

    return rest_ensure_response(array('content' => $content));
}
   add_action('rest_api_init', function () {
    register_rest_route('blocks-preview-shortvodef/v1', '/homepage-new-post-shortcode-typef', array(
        'methods' => 'POST',
        'callback' => 'publications_list_custom_post_type_handlerf',
    ));
});
function fetch_posts($post_type = array('projektyinwestycyjne', 'projekty_leader'), $posts_per_page = 3, $category_id = 0) {
    $args = array(
        'post_type' => array('projektyinwestycyjne', 'projekty_leader'),
        'posts_per_page' => $posts_per_page,
    );
    $custom_query = new WP_Query($args);
    ob_start();

    if ($custom_query->have_posts()) :
        while ($custom_query->have_posts()) : $custom_query->the_post();

        $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
            
        // Get the alt text for the thumbnail image
        $thumbnail_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
        
        // Fallback to post title if alt text is not set
        $alt_text = $thumbnail_alt ? $thumbnail_alt : '';
        $categories = get_the_category(get_the_ID());
            
        $post_type = get_post_type();  
				$custom_color 	= ''; 
				$class 			= '';
                if ($post_type == 'projektyinwestycyjne') {  
                    $custom_value 	= '#7E115E';
					$class 			= "projekty-inwestycyjne";
                } elseif ($post_type == 'projekty_leader') {  
                    $custom_value 	= '#004A48';  
					$class 			= "projekty-leader";
                }  
            ?>
             <div class="item">
                <div class="article-card <?php echo $class; ?>">
                    <a href="<?php the_permalink(); ?>" class="d-flex flex-column-reverse">
                        <div class="article-featured-img">
                            <?php the_post_thumbnail('full', array('alt' => esc_attr($alt_text),'aria-hidden' => 'true')); ?>
                        </div>
                        <div class="article-content">
                            <div class="article-top">
                                <div class="title-icon">
                                    <h3  style="color:<?php echo esc_attr($custom_value); ?>;"><?php the_title(); ?></h3>
                                    <div class="icon">
                                        <svg width="24" height="29" viewBox="0 0 24 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.78003 23.4658L8.31636 28.1002C8.2727 28.2388 8.14436 28.3332 7.9987 28.3332H1.9987C1.8927 28.3332 1.7927 28.2825 1.7297 28.1968C1.6667 28.1112 1.6487 28.0008 1.68103 27.8995L4.0457 20.4115C4.12603 20.5988 4.19936 20.8088 4.2717 21.0165C4.5167 21.7212 4.79436 22.5195 5.49703 22.9262C6.19003 23.3272 7.01437 23.1708 7.7407 23.0338C8.1997 22.9468 8.67403 22.8575 8.97836 22.9388C9.2107 23.0005 9.49437 23.2228 9.78003 23.4658ZM19.9517 20.4112C19.8714 20.5985 19.7977 20.8088 19.7254 21.0168C19.4804 21.7212 19.2027 22.5198 18.5004 22.9262C17.8074 23.3272 16.983 23.1715 16.2567 23.0338C15.797 22.9468 15.3227 22.8582 15.019 22.9385C14.7867 23.0008 14.503 23.2228 14.2174 23.4658L15.6807 28.1002C15.7247 28.2388 15.853 28.3332 15.9987 28.3332H21.9987C22.1047 28.3332 22.2047 28.2825 22.2677 28.1968C22.3307 28.1112 22.3487 28.0008 22.3164 27.8995L19.9517 20.4112ZM18.9987 11.6665C18.9987 15.5262 15.8584 18.6665 11.9987 18.6665C8.13903 18.6665 4.9987 15.5262 4.9987 11.6665C4.9987 7.80685 8.13903 4.66651 11.9987 4.66651C15.8584 4.66651 18.9987 7.80685 18.9987 11.6665ZM16.3147 10.2832C16.275 10.1648 16.1724 10.0785 16.049 10.0595L13.4607 9.66385L12.3004 7.19151C12.2454 7.07485 12.128 6.99985 11.9987 6.99985C11.8694 6.99985 11.752 7.07485 11.697 7.19151L10.5367 9.66385L7.94836 10.0595C7.82503 10.0785 7.72236 10.1645 7.6827 10.2832C7.64303 10.4018 7.67303 10.5322 7.76003 10.6218L9.63303 12.5415L9.00703 15.2585C8.97803 15.3848 9.02503 15.5165 9.12703 15.5965C9.22903 15.6762 9.3687 15.6895 9.4837 15.6302L11.9987 14.3412L14.5134 15.6295C14.561 15.6545 14.6137 15.6665 14.6654 15.6665C14.7384 15.6665 14.8107 15.6428 14.87 15.5962C14.9724 15.5165 15.019 15.3845 14.99 15.2582L14.364 12.5412L16.237 10.6215C16.3247 10.5322 16.3544 10.4015 16.3147 10.2832ZM21.9824 14.3435C21.8227 14.9402 21.941 15.5665 22.0557 16.1725C22.15 16.6708 22.257 17.2362 22.104 17.5005C21.9457 17.7738 21.396 17.9655 20.9107 18.1338C20.334 18.3345 19.737 18.5418 19.3064 18.9725C18.8744 19.4048 18.667 20.0015 18.4664 20.5785C18.2974 21.0638 18.1064 21.6132 17.8334 21.7715C17.8 21.7905 17.7004 21.8482 17.4414 21.8482C17.1664 21.8482 16.8304 21.7848 16.5054 21.7232C16.1327 21.6525 15.711 21.5728 15.3057 21.5728C15.0764 21.5728 14.8707 21.5978 14.678 21.6488C14.099 21.8042 13.6277 22.2115 13.1717 22.6058C12.758 22.9638 12.331 23.3332 11.9987 23.3332C11.6657 23.3332 11.2387 22.9638 10.8254 22.6058C10.3694 22.2115 9.8977 21.8038 9.32136 21.6502C9.12803 21.5985 8.92103 21.5735 8.6897 21.5735C8.2857 21.5735 7.86403 21.6532 7.49203 21.7238C7.16536 21.7855 6.82936 21.8488 6.5547 21.8488C6.2967 21.8488 6.1967 21.7908 6.16403 21.7722C5.89036 21.6135 5.6987 21.0638 5.53036 20.5785C5.3297 20.0018 5.12236 19.4048 4.6917 18.9742C4.25936 18.5422 3.6627 18.3348 3.0857 18.1342C2.60036 17.9652 2.05103 17.7742 1.8927 17.5012C1.74003 17.2368 1.8467 16.6722 1.94103 16.1735C2.05603 15.5642 2.1737 14.9395 2.0147 14.3438C1.86036 13.7675 1.4527 13.2958 1.0587 12.8402C0.701365 12.4258 0.332031 11.9988 0.332031 11.6665C0.332031 11.3335 0.701365 10.9065 1.05936 10.4932C1.4537 10.0372 1.86136 9.56551 2.01503 8.98918C2.1747 8.39251 2.05636 7.76618 1.9417 7.16018C1.84736 6.66185 1.74036 6.09651 1.89336 5.83218C2.0517 5.55885 2.60136 5.36718 3.0867 5.19885C3.66336 4.99818 4.26036 4.79085 4.69103 4.36018C5.12303 3.92785 5.33036 3.33118 5.53103 2.75418C5.70003 2.26885 5.89103 1.71951 6.16403 1.56118C6.19736 1.54218 6.29736 1.48418 6.55637 1.48418C6.83203 1.48418 7.16736 1.54785 7.4917 1.60951C7.8637 1.67985 8.28436 1.75951 8.6917 1.75951C8.92036 1.75951 9.12436 1.73518 9.31636 1.68451C9.89837 1.52851 10.3697 1.12118 10.8254 0.726847C11.2394 0.369181 11.6664 -0.000152588 11.9987 -0.000152588C12.3317 -0.000152588 12.7587 0.369181 13.172 0.727181C13.628 1.12151 14.0997 1.52918 14.676 1.68285C14.869 1.73418 15.0754 1.75951 15.3067 1.75951C15.709 1.75951 16.1317 1.67985 16.5044 1.60951C16.8307 1.54751 17.1674 1.48418 17.442 1.48418C17.7 1.48418 17.8004 1.54218 17.833 1.56085C18.1067 1.71951 18.2984 2.26918 18.4667 2.75451C18.6674 3.33118 18.8747 3.92818 19.3054 4.35885C19.7377 4.79085 20.3344 4.99818 20.9114 5.19885C21.3967 5.36785 21.946 5.55885 22.1044 5.83185C22.257 6.09618 22.1504 6.66085 22.056 7.15951C21.941 7.76885 21.8234 8.39351 21.9824 8.98918C22.1367 9.56551 22.5444 10.0372 22.9384 10.4928C23.296 10.9072 23.6654 11.3342 23.6654 11.6665C23.6654 11.9995 23.296 12.4265 22.938 12.8398C22.544 13.2958 22.136 13.7675 21.9824 14.3435ZM20.332 11.6665C20.332 7.07151 16.5937 3.33318 11.9987 3.33318C7.4037 3.33318 3.66536 7.07151 3.66536 11.6665C3.66536 16.2615 7.4037 19.9998 11.9987 19.9998C16.5937 19.9998 20.332 16.2615 20.332 11.6665Z" fill="<?php echo esc_attr($custom_value); ?>"/>
                                        </svg>
                                    </div>
                                </div>
                                <?php 
                                $beneficjent = get_field('beneficjent_text_with_icon', get_the_ID());
                                $dofinansowania = get_field('dofinansowania_z_efrrow', get_the_ID());
                                $valueprojects = get_field('value_of_projects:', get_the_ID());
                                ?>
                                <div class="excerpt-sec">
                                    <p><span><?php echo $beneficjent['label']; ?></span><?php echo $beneficjent['title']; ?></p>
                                    <p><span><?php echo $dofinansowania['label']; ?></span><?php echo $valueprojects; ?> zł</p>
                                </div>
                            </div>
                            <div class="web-btn d-flex link-btn">
                                    <span><?php esc_html_e('zobacz szczegóły', 'bibiloteka'); ?></span>
                                <div class="icon">
                                    <img decoding="async" src="<?php echo get_stylesheet_directory_uri(); ?>/images/right.svg" alt="<?php _e('icon', 'bibiloteka') ?>" aria-hidden="true">
                                </div>    
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php
        endwhile;
    else :
        echo '<div class="parentnone">No posts found.</div>';
    endif;

    wp_reset_postdata();
    return ob_get_clean();
}

            


