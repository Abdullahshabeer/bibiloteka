<?php
// AJAX Handler for Events
function load_events_ajax() {
  $paged         = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
$search        = sanitize_text_field($_POST['search'] ?? '');
$category      = intval($_POST['category'] ?? 0);
$dla_kogo      = intval($_POST['dla_kogo'] ?? 0);
$date_from     = sanitize_text_field($_POST['date_from'] ?? '');
$date_to       = sanitize_text_field($_POST['date_to'] ?? '');
$calendar_date = sanitize_text_field($_POST['calendar_date'] ?? '');

$args = [
    'post_type'      => 'kalendarz-wydarzen',
    'posts_per_page' => 11,
    'paged'          => $paged,
    's'              => $search,
];

// Taxonomy query
$tax_query = [];

if ($category) {
    $tax_query[] = [
        'taxonomy' => 'wydarzen_categories',
        'field'    => 'term_id',
        'terms'    => $category,
    ];
}

if ($dla_kogo) {
    $tax_query[] = [
        'taxonomy' => 'dla_kogo',
        'field'    => 'term_id',
        'terms'    => $dla_kogo,
    ];
}

if (!empty($tax_query)) {
    $args['tax_query'] = $tax_query;
    $args['tax_query']['relation'] = 'AND';
}

// Meta query for date filters
$meta_query = [];

if (!empty($calendar_date)) {
    $meta_query[] = [
        'key'     => 'date', // ACF field key
        'value'   => $calendar_date,
        'compare' => '=',
        'type'    => 'DATE',
    ];
}

if (!empty($date_from)) {
    $meta_query[] = [
        'key'     => 'date', // ACF field key
        'value'   => $date_from,
        'compare' => '>=',
        'type'    => 'DATE',
    ];
}

if (!empty($date_to)) {
    $meta_query[] = [
        'key'     => 'date', // ACF field key
        'value'   => $date_to,
        'compare' => '<=',
        'type'    => 'DATE',
    ];
}

if (!empty($meta_query)) {
    $args['meta_query'] = $meta_query;
    $args['meta_query']['relation'] = 'AND';
}

$query = new WP_Query($args);


    ob_start();
     if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post(); 
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
            wp_reset_postdata();
        else:
            echo '<p>Brak wydarzeń do wyświetlenia.</p>';
        endif;

    $html = ob_get_clean();

    wp_send_json([
        'html'      => $html,
        'max_pages' => $query->max_num_pages,
    ]);
}
add_action('wp_ajax_load_events', 'load_events_ajax');
add_action('wp_ajax_nopriv_load_events', 'load_events_ajax');



?>