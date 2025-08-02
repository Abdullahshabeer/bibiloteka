<?php
/*
Template Name: Kalendarz - Wszystkie Wydarzenia (Flat)
*/
get_header();

// Filters
$paged       = get_query_var('paged') ?: 1;
$search      = $_GET['search'] ?? '';
$date_from   = $_GET['date_from'] ?? '';
$date_to     = $_GET['date_to'] ?? '';
$category_id = $_GET['category'] ?? '';

// Get all categories (for filter dropdown)
$all_categories = get_terms(['taxonomy' => 'wydarzen_categories', 'hide_empty' => false]);

// Query args
$today = date('Y-m-d');

// Base query args
$args = [
    'post_type'      => 'kalendarz-wydarzen',
    'posts_per_page' => 12,
    'paged'          => $paged,
    's'              => sanitize_text_field($search),
    'meta_query'     => [], // initialize empty
];

// Optional category filter
if (!empty($category_id)) {
    $args['tax_query'][] = [
        'taxonomy' => 'wydarzen_categories',
        'field'    => 'term_id',
        'terms'    => $category_id,
    ];
}

// Date range filter
if ($date_from || $date_to) {
    $args['meta_query'][] = [
        'key'     => 'date',
        'compare' => 'BETWEEN',
        'type'    => 'DATE',
        'value'   => [
            $date_from ?: '1900-01-01',
            $date_to   ?: '2100-01-01',
        ]
    ];
}

// Add filter to only show past events
$args['meta_query'][] = [
    'key'     => 'date',
    'value'   => $today,
    'compare' => '<',
    'type'    => 'DATE',
];

$query = new WP_Query($args);


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
        <!-- Filter Form -->
        <div class="advance-search-bar gray-bg radius-40">
            <h2><?php _e('Szukaj w kalendarzu', 'bibiloteka'); ?></h2>
            <div class="web-form">
                <form method="get" action="">
                    <div class="form-inner">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="row">
                                    <div class="col-xl-7 col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="search" class="form-control" value="<?= esc_attr($search); ?>" placeholder="<?php _e('Wpisz szukaną frazę', 'bibiloteka'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xl-5 col-lg-6">
                                        <div class="form-group">
                                            <input type="date" name="date_from" class="form-control" value="<?= esc_attr($date_from); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6">
                                        <div class="form-group">
                                            <input type="date" name="date_to" class="form-control" value="<?= esc_attr($date_to); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-6">
                                        <div class="form-group">
                                            <select name="category" class="form-select" >
                                                <option value=""><?php _e('Wybierz kategorię', 'bibiloteka'); ?></option>
                                                <?php foreach ($all_categories as $cat): ?>
                                                    <option value="<?= $cat->term_id; ?>" <?= selected($category_id, $cat->term_id, false); ?>>
                                                        <?= esc_html($cat->name); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-sec">
                            <button type="button" class="btn btn-secondary reset-btn" onclick="window.location.href='<?= esc_url(get_permalink()); ?>';">
                                <img src="<?= get_template_directory_uri(); ?>/images/refresh.svg" alt="icon">
                                <span><?php _e('Resetuj wyniki', 'bibiloteka'); ?></span>
                            </button>
                            <button type="submit" class="btn btn-primary"><?php _e('Szukaj', 'bibiloteka'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div style="height:80px" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- Posts List -->
        <div class="articles-wrap">
            <div class="row">
                <?php if ($query->have_posts()): ?>
                    <?php while ($query->have_posts()): $query->the_post(); 
                        $event_date = get_field('date');
                        $event_time = get_field('time'); ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="article-card">
                                <a href="<?php the_permalink(); ?>" class="article-card-inner d-flex flex-column">
                                    <div class="featured-image double-image" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>);">
                                        <?php the_post_thumbnail('full'); ?>
                                    </div>
                                    <div class="article-card-content d-flex flex-column">
                                        <div class="meta-type d-flex align-items-center">
                                            <div class="article-meta d-flex align-items-center">
                                                <?php if ($event_date): ?>
                                                <span><img src="<?= get_template_directory_uri(); ?>/images/calendar.svg" alt="icon"> <?= date_i18n('j F Y', strtotime($event_date)); ?></span>
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
                                        </div>
                                        <div class="article-title">
                                            <h3><?php the_title(); ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p><?php _e('Brak wydarzeń do wyświetlenia.', 'bibiloteka'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div style="height:80px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- Pagination -->
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
        </div>
    </div>
</main>

<?php
wp_reset_postdata();
 endwhile; endif; 

get_footer();
?>
