<?php
/**
 * Template for Search Results
 */
get_header();

global $wp_query;

// Get search query
$search_query = get_search_query();
?>

<section class="top-banner-sec">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-6">
                <div class="banner-img">
                    <?php
                    // Optional ACF banner image (if you want a custom image for search)
                    $search_banner = get_field('banner_image', 'option');
                    if ($search_banner) :
                        echo '<img src="' . esc_url($search_banner['url']) . '" alt="' . esc_attr($search_banner['alt']) . '">';
                    else : ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/page-banner-25.jpg" alt="">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="banner-content">
                    <?php if (function_exists('custom_breadcrumbs')) custom_breadcrumbs(); ?>
                    <h1>Wyniki wyszukiwania “<?php echo esc_html($search_query); ?>”</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<main class="main-wrap">
    <div class="container">
        <!-- Search Form -->
        <div class="advance-search-bar gray-bg radius-40">
            <h2>Szukaj w kalendarzu</h2>
            <div class="web-form">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="form-inner">
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="form-group">
                                    <input type="search" class="form-control" name="s"
                                           placeholder="Wpisz szukaną frazę"
                                           value="<?php echo esc_attr($search_query); ?>" aria-label="Search">
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="row">
                                    <!-- Example date filters (optional, can be removed) -->
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <select class="form-select" name="date_from">
                                                <option value="">Data publikacji od</option>
                                                <!-- Add your date range options here -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group">
                                            <select class="form-select" name="date_to">
                                                <option value="">Data publikacji do</option>
                                                <!-- Add your date range options here -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-sec">
                           <button type="button" class="btn btn-secondary reset-btn">
								<img src="<?php echo get_template_directory_uri(); ?>/images/refresh.svg" alt="icon">
								<span>Resetuj wyniki</span>
							</button>
                            <button type="submit" class="btn btn-primary">Szukaj</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div style="height:80px" aria-hidden="true" class="wp-block-spacer"></div>

        <!-- Search Results -->
        <div class="articles-wrap">
            <div class="row">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="article-card">
                                <a href="<?php the_permalink(); ?>" class="article-card-inner d-flex flex-column">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="featured-image">
                                            <?php the_post_thumbnail('medium', ['alt' => get_the_title()]); ?>
                                        </div>
                                    <?php endif; ?>
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
                <?php else : ?>
                    <div class="col-12">
                        <p><?php esc_html_e('Brak wyników dla wyszukiwanego zapytania.', 'bibiloteka'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div style="height:80px" aria-hidden="true" class="wp-block-spacer"></div>

        <!-- Pagination -->
        <div class="pagination-wrap">
            <div class="pagination-inner" role="navigation">
                <?php
                echo paginate_links([
                    'total'        => $wp_query->max_num_pages,
                    'current'      => max(1, get_query_var('paged')),
                    'prev_text'    => '<img src="' . get_template_directory_uri() . '/images/right-arrow.svg" alt="icon">',
                    'next_text'    => '<img src="' . get_template_directory_uri() . '/images/right-arrow.svg" alt="icon">',
                ]);
                ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
