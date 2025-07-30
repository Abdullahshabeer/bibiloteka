<?php
/**
 * Category Archive Template with Date Filter
 */

get_header();

// Get current category object
$category = get_queried_object();
$banner_image = get_field('banner_image', 'category_' . $category->term_id);

// Capture search and date filters from URL parameters
$search_query = isset($_GET['ca']) ? sanitize_text_field($_GET['ca']) : '';
$date_from    = isset($_GET['date_from']) ? sanitize_text_field($_GET['date_from']) : '';
$date_to      = isset($_GET['date_to']) ? sanitize_text_field($_GET['date_to']) : '';

// Prepare date query array
$date_query = [];

if (!empty($date_from)) {
    $date_query[] = [
        'after'     => $date_from,
        'inclusive' => true,
    ];
}

if (!empty($date_to)) {
    $date_query[] = [
        'before'    => $date_to,
        'inclusive' => true,
    ];
}

// Prepare arguments for WP_Query
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$args = [
    'post_type'      => 'post',
    'posts_per_page' => 6,
    'paged'          => $paged,
    's'              => $search_query,
    'cat'            => $category->term_id,
];

// Add date query if dates are set
if (!empty($date_query)) {
    $args['date_query'] = $date_query;
}

// Execute custom query
$query = new WP_Query($args);
?>

<section class="top-banner-sec">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-6">
                <?php if ($banner_image): ?>
                    <div class="banner-img">
                        <img src="<?php echo esc_url($banner_image['url']); ?>" alt="<?php echo esc_attr($banner_image['alt']); ?>">
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <div class="banner-content">
                    <?php if (function_exists('custom_breadcrumbs')) custom_breadcrumbs(); ?>
                    <h1><?php echo esc_html($category->name); ?></h1>
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
                <form method="get" action="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                    <div class="form-inner">
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="ca" value="<?php echo esc_attr($search_query); ?>" placeholder="<?php _e('Wpisz szukaną frazę', 'bibiloteka'); ?>">
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <select class="form-select" name="date_from">
                                                <option value=""><?php _e('Data publikacji od', 'bibiloteka'); ?></option>
                                                <option value="2025-01-01" <?php selected($date_from, '2025-01-01'); ?>>Styczeń 2025</option>
                                                <option value="2025-06-01" <?php selected($date_from, '2025-06-01'); ?>>Czerwiec 2025</option>
                                                <!-- Add more months or years dynamically -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <select class="form-select" name="date_to">
                                                <option value=""><?php _e('Data publikacji do', 'bibiloteka'); ?></option>
                                                <option value="2025-06-30" <?php selected($date_to, '2025-06-30'); ?>>Czerwiec 2025</option>
                                                <option value="2025-12-31" <?php selected($date_to, '2025-12-31'); ?>>Grudzień 2025</option>
                                                <!-- Add more months or years dynamically -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="button-sec">
                           <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="btn btn-secondary reset-btn">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/refresh.svg" alt="icon">
                                <span><?php _e('Resetuj wyniki', 'bibiloteka'); ?></span>
                            </a>
                            <button type="submit" class="btn btn-primary"><?php _e('Szukaj', 'bibiloteka'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div style="height:80px" aria-hidden="true" class="wp-block-spacer"></div>

        <!-- Posts Listing -->
        <div class="articles-wrap">
            <div class="row">
                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="article-card">
                                <a href="<?php the_permalink(); ?>" class="article-card-inner d-flex flex-column">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="featured-image">
                                            <?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="article-card-content d-flex flex-column">
                                        <div class="article-meta d-flex align-items-center">
                                            <span><?php echo get_the_date('d.m.Y'); ?></span>
                                        </div>
                                        <div class="article-title">
                                            <h3><?php the_title(); ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="col-12">
                        <p><?php _e('Brak postów spełniających kryteria wyszukiwania.', 'bibiloteka'); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div style="height:80px" aria-hidden="true" class="wp-block-spacer"></div>

            <!-- Pagination -->
            <div class="pagination-wrap">
                <div class="pagination-inner" role="navigation">
                    <?php
                    echo paginate_links([
                        'total'        => $query->max_num_pages,
                        'current'      => max(1, get_query_var('paged')),
                        'format'       => '?paged=%#%',
                        'prev_text'    => '<img src="' . get_template_directory_uri() . '/images/right-arrow.svg" alt="Prev">',
                        'next_text'    => '<img src="' . get_template_directory_uri() . '/images/right-arrow.svg" alt="Next">',
                        'end_size'     => 2,
                        'mid_size'     => 1,
                    ]);
                    ?>
                </div>
                <div class="web-btn d-flex">
                    <a href="#" class="btn btn-primary"><?php _e('Archiwum aktualności', 'bibiloteka'); ?></a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
wp_reset_postdata();
get_footer();
?>
