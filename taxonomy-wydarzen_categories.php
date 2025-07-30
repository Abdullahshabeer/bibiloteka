<?php
get_header();

$term = get_queried_object();
$term_id = $term->term_id;
$term_title = $term->name;
$term_description = term_description($term_id, 'wydarzen_categories');
$banner_image = get_field('banner_image', 'wydarzen_categories_' . $term_id);

// Filter inputs
$paged       = get_query_var('paged') ?: 1;
$search      = $_GET['search'] ?? '';
$date_from   = $_GET['date_from'] ?? '';
$date_to     = $_GET['date_to'] ?? '';
$category_id = $_GET['category'] ?? $term_id;

// Query args
$args = [
    'post_type'      => 'kalendarz-wydarzen',
    'posts_per_page' => 9,
    'paged'          => $paged,
    's'              => sanitize_text_field($search),
    'tax_query'      => [[
        'taxonomy' => 'wydarzen_categories',
        'field'    => 'term_id',
        'terms'    => $category_id,
    ]],
];

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

$query = new WP_Query($args);
?>

<section class="top-banner-sec">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-6">
                <?php if ($banner_image): ?>
                    <div class="banner-img">
                        <img src="<?= esc_url($banner_image['url']); ?>" alt="<?= esc_attr($banner_image['alt']); ?>">
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <div class="banner-content">
                    <?php if (function_exists('custom_breadcrumbs')) custom_breadcrumbs(); ?>
                    <h1><?= esc_html($term_title); ?></h1>
                    <?php if ($term_description): ?>
                        <p><?= esc_html($term_description); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<main class="main-wrap">
    <div class="container">
        <div class="advance-search-bar gray-bg radius-40">
            <h2><?php _e('Szukaj w kalendarzu', 'bibiloteka'); ?></h2>
            <div class="web-form">
                <form method="get" action="<?= esc_url(get_term_link($term)); ?>">
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
                                            <?php $all_categories = get_terms(['taxonomy' => 'wydarzen_categories', 'hide_empty' => false]); ?>
                                            <select name="category" class="form-select" onchange="this.form.submit()">
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
                            <button type="button" class="btn btn-secondary reset-btn" onclick="window.location.href='<?= esc_url(get_term_link($term)); ?>';">
                                <img src="<?= get_template_directory_uri(); ?>/images/refresh.svg" alt="icon">
                                <span><?php _e('Resetuj wyniki', 'bibiloteka'); ?></span>
                            </button>
                            <button type="submit" class="btn btn-primary"><?php _e('Szukaj', 'bibiloteka'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="articles-wrap">
            <div class="row">
                <?php if ($query->have_posts()): ?>
                    <?php while ($query->have_posts()): $query->the_post(); 
                        $event_date = get_field('date');
                        $event_time = get_field('time'); ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="article-card">
                                <a href="<?php the_permalink(); ?>" class="article-card-inner d-flex flex-column">
                                    <div class="featured-image"><?php the_post_thumbnail('full'); ?></div>
                                    <div class="article-card-content d-flex flex-column">
                                        <div class="article-meta d-flex align-items-center">
                                            <?php if ($event_date): ?>
                                                <span><img src="<?= get_template_directory_uri(); ?>/images/calendar.svg" alt="icon"> <?= date_i18n('j F Y', strtotime($event_date)); ?></span>
                                            <?php endif; ?>
                                            <?php if ($event_time): ?>
                                                <span><img src="<?= get_template_directory_uri(); ?>/images/clock.svg" alt="icon"> <?= esc_html($event_time); ?></span>
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

            <!-- Pagination -->
            <?php if ($query->max_num_pages > 1): ?>
                <div class="pagination-wrap">
                    <div class="pagination-inner">
                        <?= paginate_links([
                            'total'   => $query->max_num_pages,
                            'current' => $paged,
                            'format'  => '?paged=%#%',
                        ]); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
wp_reset_postdata();
get_footer();
