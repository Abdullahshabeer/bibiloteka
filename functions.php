<?php
include_once 'inc/post-type-shortcode.php';
include_once 'inc/coustom-post-types.php';
include_once 'inc/admin-ajax.php';
add_theme_support( 'title-tag' );
if (!function_exists('bibiloteka_theme_setup')) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     
     *
     * @return void
     */
    function bibiloteka_theme_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Twenty Twenty-One, use a find and replace
         * to change 'bibiloteka' to the name of your theme in all the template files.
         */
        load_theme_textdomain('bibiloteka', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * This theme does not use a hard-coded <title> tag in the document head,
         * WordPress will provide it for us.
         */
        add_theme_support('title-tag');

        /**
         * Add post-formats support.
         */
        add_theme_support(
            'post-formats',
            array(
                'link',
                'aside',
                'gallery',
                'image',
                'quote',
                'status',
                'video',
                'audio',
                'chat',
            )
        );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1568, 9999);

        register_nav_menus(
            array(
                'primary' => esc_html__('header menu', 'bibiloteka'),
                'footer-bottom-menu' => esc_html__('footer bottom menu', 'bibiloteka'),
                'footermenu' => esc_html__('footer menu', 'bibiloteka'),
                'languagechange' => esc_html__('language changer', 'bibiloteka'),
                
                //  'primary' => esc_html__('header menu', 'bibiloteka'),
                // 'footermenuF' => esc_html__('footer menu Biblioteka', 'bibiloteka'),
                // 'footermenuS' => esc_html__('footer menu Czytelników', 'bibiloteka'),
                // 'footermenuT' => esc_html__('footer menu Ważne linki', 'bibiloteka'),
                // 'languagechange' => esc_html__('language changer', 'bibiloteka'), 
            )
        );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
                'navigation-widgets',
            )
        );

        /*
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            array(
                'flex-width' => true,
                'flex-height' => true,
                'unlink-homepage-logo' => true,
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Add support for Block Styles.
        add_theme_support('wp-block-styles');

        // Add support for full and wide align images.
        add_theme_support('align-wide');
        add_filter('wpcf7_autop_or_not', '__return_false');
        // Add support for editor styles.
        add_theme_support('editor-styles');
        add_post_type_support('page', 'excerpt');
        // Add support for responsive embedded content.
        add_theme_support('responsive-embeds');

        // Add support for custom line height controls.
        add_theme_support('custom-line-height');

        // Add support for experimental link color control.
        add_theme_support('experimental-link-color');

        // Add support for experimental cover block spacing.
        add_theme_support('custom-spacing');

        // Add support for custom units.
        // This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
        add_theme_support('custom-units');

        // Remove feed icon link from legacy RSS widget.
        add_filter('rss_widget_feed_link', '__return_empty_string');
        add_post_type_support('post', 'page-attributes');
    }
}
add_action('after_setup_theme', 'bibiloteka_theme_setup');

// function cc_mime_types($mimes) {
//     $mimes['svg'] = 'image/svg+xml';
//     return $mimes;
//   }
function my_wp_page_menu_args( $args ) {
    $args['menu_class'] = 'd-flex align-items-center nav-menu';
    return $args;
}
add_filter( 'wp_page_menu_args', 'my_wp_page_menu_args' );

function custom_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'custom_mime_types');

// Sanitize SVG before uploading
function sanitize_svg($svg) {
    $svg = simplexml_load_string($svg);
    return $svg->asXML();
}



function bibiloteka_enqueue_scripts() {

    // Core dependencies
    wp_enqueue_script('jquery');
    wp_enqueue_media();
    wp_enqueue_script('wp-tinymce');

    // Styles
    wp_enqueue_style('owl-carousel-css', get_stylesheet_directory_uri() . '/library/owl-carousel/assets/owl.carousel.min.css');
    wp_enqueue_style('bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('flatpickr-css', get_stylesheet_directory_uri() . '/library/flatpickr/css/flatpickr.min.css');
    wp_enqueue_style('admin-css', get_stylesheet_directory_uri() . '/css/admin.css', [], '1.0', 'all'); 
    wp_enqueue_style('main-css', get_stylesheet_directory_uri() . '/style.css', [], '1.0', 'all');

    // JS libraries
    wp_enqueue_script('bootstrap-script', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', ['jquery'], '1.0', true);
    wp_enqueue_script('owl-carousel-script', get_stylesheet_directory_uri() . '/library/owl-carousel/owl.carousel.min.js', ['jquery'], '1.0', true);
    wp_enqueue_script('validate-js', get_stylesheet_directory_uri() . '/library/jquery-validate/jquery.validate.min.js', ['jquery'], '1.0', true);
    
    // Flatpickr
    wp_enqueue_script('flatpickrjs', get_stylesheet_directory_uri() . '/library/flatpickr/js/flatpickr.js', [], '4.6.13', true);
    wp_enqueue_script('flatpickrpljs', get_stylesheet_directory_uri() . '/library/flatpickr/js/pl.js', ['flatpickrjs'], '4.6.13', true);
    
    // Custom scripts
   

    // Localize for AJAX and Calendar Data
  

    wp_enqueue_script('custom-script');

    // Admin JS (optional)
    wp_enqueue_script('admin-script', get_stylesheet_directory_uri() . '/js/theam-admin.js', ['jquery'], '1.0', true);
     wp_localize_script('admin-script', 'calendarData', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'events'  => [] // default, replaced in template
    ]);
     wp_register_script('custom-script', get_stylesheet_directory_uri() . '/js/scripts.js', ['jquery', 'flatpickrjs'], '1.0', true);
        wp_localize_script('custom-script', 'calendarData', [
        'ajaxurl'   => admin_url('admin-ajax.php'),
        'theme_url' => get_template_directory_uri()
    ]);
    }
add_action('wp_enqueue_scripts', 'bibiloteka_enqueue_scripts');


add_action('wp_enqueue_scripts', 'bibiloteka_enqueue_scripts');
function bibiloteka_admin_enqueue()
{
    $current_screen = get_current_screen();
    wp_enqueue_media();
    // Check if we are on the Gutenberg editor screen
    if ($current_screen && 'post' === $current_screen->base && post_type_supports($current_screen->post_type, 'editor')) {
    wp_enqueue_script('jquery');
    
     wp_enqueue_style('owl-carousel-css', get_stylesheet_directory_uri() . '/library/owl-carousel/assets/owl.carousel.min.css');
    wp_enqueue_style('bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array(), '1.0', 'all');
    wp_enqueue_style('flatpickr-css', get_stylesheet_directory_uri() . '/library/flatpickr/css/flatpickr.min.css');
    wp_enqueue_style('admin-css', get_stylesheet_directory_uri() . '/css/admin.css', array(), '1.0', 'all'); 
    wp_enqueue_style('main-css', get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('admin-css', get_stylesheet_directory_uri() . '/css/admin.css', array(), '1.0', 'all');
   wp_enqueue_script('bootstrap-script', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', '1.0', true);
    wp_enqueue_script('owl-carousel-script', get_stylesheet_directory_uri() . '/library/owl-carousel/owl.carousel.min.js');
    wp_enqueue_script('validate-js', get_stylesheet_directory_uri() . '/library/jquery-validate/jquery.validate.min.js',);
    wp_enqueue_script('flatpickrjs', get_stylesheet_directory_uri() . '/library/flatpickr/js/flatpickr.js', '', true);
    
    wp_enqueue_script('flatpickrpljs', get_stylesheet_directory_uri() . '/library/flatpickr/js/pl.js', '', true);
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/scripts.js',);
    
    }
    wp_enqueue_script('wp-tinymce');
    wp_enqueue_script('admin-script', get_stylesheet_directory_uri() . '/js/theam-admin.js',);
}
add_action('admin_enqueue_scripts', 'bibiloteka_admin_enqueue');
function bibiloteka_customize_register( $wp_customize ) {
     // Top Header Section
     $wp_customize->add_section(
        'top_min_header_section',
        array(
            'title'         => __('UE Logo Bar ', 'bibiloteka'),
            'priority'      => 30,
        )
    );
    $wp_customize->add_setting( 'header_logo', array(
        'default'   => '',
        'transport' => 'refresh',
    ) );

    // Add Header Logo Control (Image Upload)
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'header_logo_control',
        array(
            'label'    => __( 'Upload Header single UE Logo', 'bibiloteka' ),
            'section'  => 'top_min_header_section',
            'settings' => 'header_logo',
        )
    ) );
    $wp_customize->add_setting( 'header_mobile_logo', array(
        'default'   => '',
        'transport' => 'refresh',
    ) );

    // Add Header Logo Control (Image Upload)
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'header_mobile_logo_control',
        array(
            'label'    => __( 'Upload mobile Header single UE Logo', 'bibiloteka' ),
            'section'  => 'top_min_header_section',
            'settings' => 'header_mobile_logo',
        )
    ) );
    $wp_customize->add_setting( 'header_logo_link', array(
    'default'   => '#',
    'transport' => 'refresh',
    ) );

    // Add Logo Link Control
    $wp_customize->add_control( 'header_logo_link_control', array(
        'label'    => __( 'Header single UE Logo Link URL', 'bibiloteka' ),
        'section'  => 'top_min_header_section',
        'settings' => 'header_logo_link',
        'type'     => 'url',
    ) );
    // Define settings and controls for the top header section
    $settings_and_controls = array(
        'first_logo'            => __(' footer UE first logo ', 'bibiloteka'),
        // 'polish_first_logo'     => __('Polish logo', 'bibiloteka'),
        'first_link_control'    => __('Custom link', 'bibiloteka'),
        'second_logo'           => __(' footer UE second logo', 'bibiloteka'),
        // 'polish_second_logo'    => __('Polish logo', 'bibiloteka'),
        'second_link_control'   => __('Custom link', 'bibiloteka'),
        'Third_logo'            => __(' footer UE Third logo ', 'bibiloteka'),
        // 'polish_Third_logo'     => __('Polish logo', 'bibiloteka'),
        'Third_link_control'    => __('Custom link', 'bibiloteka'),
        'Four_logo'             => __(' footer Four logo', 'bibiloteka'),
        // 'polish_Four_logo'      => __('Polish logo', 'bibiloteka'),
        'Four_link_control'     => __('Custom link', 'bibiloteka')
    );

    foreach ($settings_and_controls as $setting_name => $control_label) {
        $sanitize_callback = (strpos($setting_name, '_logo') !== false) ? 'esc_url_raw' : 'esc_attr';

        $wp_customize->add_setting(
            $setting_name,
            array(
                'default' => '',
                'sanitize_callback' => $sanitize_callback,
            )
        );

        if (strpos($setting_name, '_logo') !== false) {
            $wp_customize->add_control(
                new WP_Customize_Image_Control(
                    $wp_customize,
                    $setting_name,
                    array(
                        'label'         =>      __($control_label, 'bibiloteka'),
                        'section'       =>      'top_min_header_section',
                        'settings'      =>      $setting_name,
                    )
                )
            );
        } else {
            $wp_customize->add_control(
                $setting_name,
                array(
                    'label'             => $control_label,
                    'section'           => 'top_min_header_section',
                    'type'              => (strpos($setting_name, '_logo') !== false) ? 'image' : 'text',
                    'settings'          => $setting_name,
                    'input_attrs'       => array(
                        'placeholder'   => __('Enter link', 'bibiloteka'),
                    ),
                )
            );
        }
    }

  $wp_customize->add_section( 'social_media_section', array(
        'title'       => __( 'Social Media', 'bibiloteka' ),
        'priority'    => 30,
        'description' => __( 'Add up to 4 social media custom logos and links.', 'bibiloteka' ),
    ) );

    // ===== LOGO 1 =====
    $wp_customize->add_setting( 'social_logo_1', array(
        'default'   => '',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'social_logo_1_control',
        array(
            'label'    => __( 'Upload Social Media Logo 1', 'bibiloteka' ),
            'section'  => 'social_media_section',
            'settings' => 'social_logo_1',
        )
    ) );

    $wp_customize->add_setting( 'social_logo_link_1', array(
        'default'   => '#',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'social_logo_link_1_control', array(
        'label'    => __( 'Social Media Logo 1 Link', 'bibiloteka' ),
        'section'  => 'social_media_section',
        'settings' => 'social_logo_link_1',
        'type'     => 'url',
    ) );

    // ===== LOGO 2 =====
    $wp_customize->add_setting( 'social_logo_2', array(
        'default'   => '',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'social_logo_2_control',
        array(
            'label'    => __( 'Upload Social Media Logo 2', 'bibiloteka' ),
            'section'  => 'social_media_section',
            'settings' => 'social_logo_2',
        )
    ) );

    $wp_customize->add_setting( 'social_logo_link_2', array(
        'default'   => '#',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'social_logo_link_2_control', array(
        'label'    => __( 'Social Media Logo 2 Link', 'bibiloteka' ),
        'section'  => 'social_media_section',
        'settings' => 'social_logo_link_2',
        'type'     => 'url',
    ) );

    // ===== LOGO 3 =====
    $wp_customize->add_setting( 'social_logo_3', array(
        'default'   => '',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'social_logo_3_control',
        array(
            'label'    => __( 'Upload Social Media Logo 3', 'bibiloteka' ),
            'section'  => 'social_media_section',
            'settings' => 'social_logo_3',
        )
    ) );

    $wp_customize->add_setting( 'social_logo_link_3', array(
        'default'   => '#',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'social_logo_link_3_control', array(
        'label'    => __( 'Social Media Logo 3 Link', 'bibiloteka' ),
        'section'  => 'social_media_section',
        'settings' => 'social_logo_link_3',
        'type'     => 'url',
    ) );

    // ===== LOGO 4 =====
    $wp_customize->add_setting( 'social_logo_4', array(
        'default'   => '',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'social_logo_4_control',
        array(
            'label'    => __( 'Upload Social Media Logo 4', 'bibiloteka' ),
            'section'  => 'social_media_section',
            'settings' => 'social_logo_4',
        )
    ) );

    $wp_customize->add_setting( 'social_logo_link_4', array(
        'default'   => '#',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'social_logo_link_4_control', array(
        'label'    => __( 'Social Media Logo 4 Link', 'bibiloteka' ),
        'section'  => 'social_media_section',
        'settings' => 'social_logo_link_4',
        'type'     => 'url',
    ) );



}
add_action( 'customize_register', 'bibiloteka_customize_register' );

function theme_footer_widgets_init()
{
     register_sidebar(
        array(
            'name' => __('social media', 'bibiloteka'),
            'id' => 'social-sidebar',
            'description' => __('Widgets added here will appear in the social media.', 'bibiloteka'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
     register_sidebar(
        array(
            'name' => __(' Footer gallery', 'bibiloteka'),
            'id' => 'footer-gallery',
            'description' => __('Widgets added here will appear in the footer.', 'bibiloteka'),
        )
    );
    register_sidebar(
        array(
            'name' => __(' Footer content', 'bibiloteka'),
            'id' => 'footer-sidebar',
            'description' => __('Widgets added here will appear in the footer.', 'bibiloteka'),
            'before_widget' => '<div id="%1$s" class=" image widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );

     register_sidebar(
        array(
            'name' => __(' Footer menu', 'bibiloteka'),
            'id' => 'footer-menu-first',
            'description' => __('Widgets added here will appear in the footer.', 'bibiloteka'),
            'before_widget' => '<div class="col-xl-3 col-lg-6"><div class="footer-col"><div class="widget footer-menu">',
            'after_widget' => '</div></div></div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
   
}

add_action('widgets_init', 'theme_footer_widgets_init');

function custom_search_filter($query) {
    if (!is_admin() && $query->is_search && $query->is_main_query()) {
        // Check if category is set and filter by it
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $query->set('cat', sanitize_text_field($_GET['category']));
        }

        // Initialize date_query if it is not already set
        $date_query = array();

        // Check if date_from is set and filter by it
        if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
            $date_query[] = array(
                'after' => sanitize_text_field($_GET['date_from']),
                'inclusive' => true,
            );
        }

        // Check if date_to is set and filter by it
        if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
            $date_query[] = array(
                'before' => sanitize_text_field($_GET['date_to']),
                'inclusive' => true,
            );
        }

        // Set the date_query if there are date filters
        if (!empty($date_query)) {
            $query->set('date_query', $date_query);
        }

        // Set the number of results per page
        if (isset($_GET['results_per_page']) && !empty($_GET['results_per_page'])) {
            $query->set('posts_per_page', intval($_GET['results_per_page']));
        }
    }
}

add_action('pre_get_posts', 'custom_search_filter');

function custom_breadcrumbs() {
    global $post;
    echo '<div class="breadcrumbs-sec"><ul>';
    echo '<li><a href="' . get_home_url() . '"><span class="visually-hidden">Home</span>Strona główna</a></li>';
    if (is_single()) {
       
        $referer_url = wp_get_referer();
        $referer_parts = parse_url($referer_url);
       
       
          
        function get_title_from_url($url) {
            $response = wp_remote_get($url);
        
            if (is_wp_error($response) || wp_remote_retrieve_response_code($response) != 200) {
                // Error handling here
                return 'Error in fetching URL';
            }
        
            $html = wp_remote_retrieve_body($response);
            $dom = new DOMDocument();
        
            // Load the HTML and suppress warnings/errors
            @$dom->loadHTML($html);
        
            // Extract the title
            $titles = $dom->getElementsByTagName('title');
            if ($titles->length > 0) {
                $fullTitle = $titles[0]->nodeValue;
                // Remove site title and trim the result
                $specificTitle = str_replace('| Punkt dla Przyrody', '', $fullTitle);
                return trim($specificTitle);
            }
        
            return 'Title not found';
        }
        
           
            if (isset($referer_parts['path'])) {
                $path_parts = explode('/', $referer_parts['path']);
                $parent_page_title = '';
                
                // Check if there is a parent page title in the URL
              $parent_page_title_second_last ='';
                if (count($path_parts) > 3) {
                    $parent_page_title_second_last = $path_parts[count($path_parts) - 3];
                  
                    $third_last_url = home_url('/' . $parent_page_title_second_last . '/');
                    $page_title = get_title_from_url($third_last_url);
                }
                 
                   if (count($path_parts) > 2) {
                    $parent_page_title_last = $path_parts[count($path_parts) - 2]; 
                  
                    $parent_page_title_last_url = home_url('/' . $parent_page_title_second_last . '/' . $parent_page_title_last . '/');
                    $page_titlee = get_title_from_url($parent_page_title_last_url);
                }
               
                if(!empty( $parent_page_title_second_last)) {
                    echo '<li><a href="'.$third_last_url.'">' . ucfirst($page_title) . '</a></li>';
                }
                
                if (!empty($parent_page_title_last)) {
                    echo '<li><a href="' . esc_url($referer_url) . '">' . ucfirst($page_titlee) . '</a></li>';
                }
            }
            // print_r( $referer_url);
            echo '<li>' . get_the_title() . '</li>';
        }  
    
           
    
    
    
    elseif (is_category()) {
        $category = get_queried_object();

        echo $category->name;
    }
    elseif (is_tag()) {
        $tag = get_queried_object();
        echo '<li>Tag: ' . $tag->name . '</li>';
    }
    elseif (is_post_type_archive()) {
        echo post_type_archive_title();
    }
    elseif (is_page()) {
        $ancestors = get_post_ancestors($post);
        if ($ancestors) {
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                echo '<li><a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
            }
        }
        echo '<li><span>'.get_the_title() .'</span></li>';
    }
    elseif (is_search()) {
        echo '<li>Search Results for "' . get_search_query() . '" </li>';
    }
    elseif (is_404()) {
        echo '<li>404 Not Found</li>';
    }
    echo '</ul></div>';
}


