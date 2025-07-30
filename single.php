<?php
/**
 * Single Kalendarz-Wydarzen Template
 */
get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();

        // ACF Fields
        $acf_date     = get_field('date');
        $acf_time     = get_field('time');
        $acf_price    = get_field('price');
        $acf_location = get_field('location');
        $acf_more_info = get_field('more_info_link');

        // Formatted values
        $event_date_display = $acf_date ? date_i18n('j F Y (l)', strtotime($acf_date)) : '';
        $event_time_display = $acf_time ? date_i18n('H:i', strtotime($acf_time)) : '';

        // Terms
        $dla_kogo_terms = get_the_terms(get_the_ID(), 'dla_kogo');
        $kategorie_terms = get_the_terms(get_the_ID(), 'wydarzen_categories');
?>
<section class="top-banner-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="banner-content">
                    <?php custom_breadcrumbs(); ?>
                    <h1><?php the_title(); ?></h1>
                </div>
            </div>
            <?php if (has_post_thumbnail()): ?>
                <div class="col-xl-4">
                    <div class="banner-img">
                        <?php the_post_thumbnail(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<main class="main-wrap">
    <div class="container">
        <div class="row sub-page-row">
            <div class="col-xl-8">
                <?php the_content(); ?>
            </div>
            <div class="col-xl-4">
                <div class="sidebar gray-bg">
                    <div class="sidebar-collapse-sec">
                        <div class="collapse-title">
                            <h2 data-bs-toggle="collapse" data-bs-target="#more-info" aria-expanded="true">Informacje o wydarzeniu</h2>
                        </div>
                        <div class="collapse show" id="more-info">
                            <div class="article-info-sec">

                                <?php if ($dla_kogo_terms): ?>
                                    <div class="article-info-row">
                                        <div class="icon"><img src="<?php echo get_template_directory_uri(); ?>/images/user-tag.svg" alt="icon"></div>
                                        <div class="content">
                                            <span>Dla Kogo</span>
                                            <p><?php echo esc_html(join(', ', wp_list_pluck($dla_kogo_terms, 'name'))); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($kategorie_terms): ?>
                                    <div class="article-info-row">
                                        <div class="icon"><img src="<?php echo get_template_directory_uri(); ?>/images/archive-tick.svg" alt="icon"></div>
                                        <div class="content">
                                            <span>Kategoria</span>
                                            <div class="category-sec">
                                                <?php foreach ($kategorie_terms as $term):
                                                    $color = get_field('color_select', 'wydarzen_categories_' . $term->term_id) ?: '#1A8D92'; ?>
                                                    <span class="cat-color" style="background-color: <?php echo esc_attr($color); ?>;"></span>
                                                    <p><?php echo esc_html($term->name); ?></p>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($acf_price): ?>
                                    <div class="article-info-row">
                                        <div class="icon"><img src="<?php echo get_template_directory_uri(); ?>/images/ticket-star.svg" alt="icon"></div>
                                        <div class="content">
                                            <span>Cena</span>
                                            <p><?php echo esc_html($acf_price); ?></p>
                                            <?php if ($acf_more_info): ?>
                                                <a href="<?php echo esc_url($acf_more_info); ?>" target="_blank">Więcej informacji <img src="<?php echo get_template_directory_uri(); ?>/images/right-arrow.svg" alt=""></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($event_date_display): ?>
                                    <div class="article-info-row">
                                        <div class="icon"><img src="<?php echo get_template_directory_uri(); ?>/images/calendar-fill.svg" alt="icon"></div>
                                        <div class="content">
                                            <span>Data</span>
                                            <p><?php echo esc_html($event_date_display); ?></p>
                                            <a href="<?php echo esc_url(get_post_type_archive_link('kalendarz-wydarzen')); ?>">Więcej wydarzeń <img src="<?php echo get_template_directory_uri(); ?>/images/right-arrow.svg" alt=""></a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($event_time_display): ?>
                                    <div class="article-info-row">
                                        <div class="icon"><img src="<?php echo get_template_directory_uri(); ?>/images/clock-fill.svg" alt="icon"></div>
                                        <div class="content">
                                            <span>Godzina</span>
                                            <p><?php echo esc_html($event_time_display); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($acf_location): ?>
                                    <div class="article-info-row">
                                        <div class="icon"><img src="<?php echo get_template_directory_uri(); ?>/images/location.svg" alt="icon"></div>
                                        <div class="content">
                                            <span>Miejsce</span>
                                            <p><?php echo esc_html($acf_location); ?></p>
                                            <a href="#">Jak do nas dotrzeć <img src="<?php echo get_template_directory_uri(); ?>/images/right-arrow.svg" alt=""></a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Events -->
        <div class="featured-articles-sec">
            <h2>Polecane wydarzenia</h2>
            <div class="articles-wrap">
                <div class="carousel-block">
                    <div class="owl-carousel owl-theme articles-carousel">
                        <?php
                        $featured_query = new WP_Query([
                            'post_type' => 'kalendarz-wydarzen',
                            'posts_per_page' => 6,
                            'post__not_in' => [get_the_ID()]
                        ]);
                        while ($featured_query->have_posts()): $featured_query->the_post();
                            $f_date = get_field('date');
                            $f_time = get_field('time');
                            $f_display_date = $f_date ? date_i18n('j F Y', strtotime($f_date)) : '';
                            $f_display_time = $f_time ? date_i18n('H:i', strtotime($f_time)) : '';
                            $f_terms = get_the_terms(get_the_ID(), 'wydarzen_categories');
                            $f_term = $f_terms ? $f_terms[0] : null;
                            $f_color = $f_term ? get_field('color_select', 'wydarzen_categories_' . $f_term->term_id) : '#1A8D92';
                        ?>
                        <div class="item">
                            <div class="article-card">
                                <a href="<?php the_permalink(); ?>" class="article-card-inner d-flex flex-column">
                                    <div class="featured-image double-image" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>');">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </div>
                                    <div class="article-card-content d-flex flex-column">
                                        <div class="article-meta d-flex align-items-center">
                                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/calendar.svg" alt="icon"><?php echo esc_html($f_display_date); ?></span>
                                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/clock.svg" alt="icon"><?php echo esc_html($f_display_time); ?></span>
                                        </div>
                                        <?php if ($f_term): ?>
                                            <div class="category-sec">
                                                <span class="cat-color" style="background-color: <?php echo esc_attr($f_color); ?>;"></span>
                                                <p><?php echo esc_html($f_term->name); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <div class="article-title">
                                            <h3><?php the_title(); ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
                <div class="read-more-btn d-flex">
                    <a href="<?php echo esc_url(get_post_type_archive_link('kalendarz-wydarzen')); ?>" class="btn btn-primary">Wszystkie wydarzenia</a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
    }
}
get_footer();
?>
