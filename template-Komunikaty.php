<?php
/*
Template Name: Komunikaty
*/
get_header();

// Filters
$paged       = get_query_var('paged') ?: 1;
$search      = $_GET['search'] ?? '';
$date_from   = $_GET['date_from'] ?? '';
$date_to     = $_GET['date_to'] ?? '';
$category_id = $_GET['category'] ?? '';

// Base query args
$args = [
    'post_type'      => 'post',
    'posts_per_page' => 15,
    'paged'          => $paged,
    's'              => sanitize_text_field($search),
];

// Date range filter using post_date
if ($date_from || $date_to) {
    $args['date_query'][] = [
        'after'     => $date_from ?: '1900-01-01',
        'before'    => $date_to ?: '2100-01-01',
        'inclusive' => true,
    ];
}

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
                        <form>
                            <div class="form-inner">
                                <div class="row">
                                    <div class="col-xl-7">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <input type="text" name="search" class="form-control" value="<?= esc_attr($search); ?>" placeholder="<?php _e('Wpisz szukaną frazę', 'bibiloteka'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="date_from" value="<?= esc_attr($date_from); ?>" placeholder="Data od" aria-label="Data od" onfocus="this.type='date'" onblur="this.type='text'">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="data_do" value="<?= esc_attr($date_to); ?>" placeholder="Data do" aria-label="Data do" onfocus="this.type='date'" onblur="this.type='text'">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="button-sec">
                                    <button type="reset" class="btn btn-secondary reset-btn">
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
                            <?php while ($query->have_posts()): $query->the_post(); ?>
                                <div class="col-xl-4 col-md-6">
                                    <div class="article-card">
                                        <a href="<?php the_permalink(); ?>" class="article-card-inner d-flex flex-column">
                                            <div class="featured-image">
                                                <?php the_post_thumbnail('full'); ?>
                                            </div>
                                            <div class="article-card-content d-flex flex-column">
                                                <div class="article-meta d-flex align-items-center">
                                                    <span><?php echo get_the_date('j F Y'); ?></span>
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
                            <div class="pagination-inner" role="navigation">
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
    endwhile;
endif;

get_footer();
?>
