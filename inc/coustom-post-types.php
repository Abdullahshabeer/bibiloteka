<?php
function Kalendarz_wydarzen() {
    $labels = array(
        'name'                  => _x('Wydarzenia', 'Post Type General Name', 'bibiloteka'),
        'singular_name'         => _x('Wydarzenie', 'Post Type Singular Name', 'bibiloteka'),
        'menu_name'             => __('Wydarzenia', 'bibiloteka'),
        'name_admin_bar'        => __('Wydarzenie', 'bibiloteka'),
        'archives'              => __('Archiwum wydarzeń', 'bibiloteka'),
        'parent_item_colon'     => __('Rodzic wydarzenia:', 'bibiloteka'),
        'all_items'             => __('Wszystkie wydarzenia', 'bibiloteka'),
        'add_new_item'          => __('Dodaj nowe wydarzenie', 'bibiloteka'),
        'add_new'               => __('Dodaj nowe', 'bibiloteka'),
        'new_item'              => __('Nowe wydarzenie', 'bibiloteka'),
        'edit_item'             => __('Edytuj wydarzenie', 'bibiloteka'),
        'update_item'           => __('Aktualizuj wydarzenie', 'bibiloteka'),
        'view_item'             => __('Zobacz wydarzenie', 'bibiloteka'),
        'search_items'          => __('Szukaj wydarzeń', 'bibiloteka'),
        'not_found'             => __('Nie znaleziono', 'bibiloteka'),
        'not_found_in_trash'    => __('Nie znaleziono w koszu', 'bibiloteka'),
        'featured_image'        => __('Obrazek wyróżniający', 'bibiloteka'),
        'set_featured_image'    => __('Ustaw obrazek wyróżniający', 'bibiloteka'),
        'remove_featured_image' => __('Usuń obrazek wyróżniający', 'bibiloteka'),
        'items_list'            => __('Lista wydarzeń', 'bibiloteka'),
        'filter_items_list'     => __('Filtruj listę wydarzeń', 'bibiloteka'),
    );

    $args = array(
        'label'               => __('Wydarzenia', 'bibiloteka'),
        'description'         => __('Wydarzenia realizowane w ramach programu LEADER', 'bibiloteka'),
        'labels'              => $labels,
        'supports'            => array('title', 'author', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'        => true,
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-calendar-alt',
        'rewrite'             => array('slug' => 'kalendarz-wydarzen'),
        'has_archive'         => 'kalendarz-wydarzen',
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type('kalendarz-wydarzen', $args);

    // Taxonomy 1: Kategorie Działań
    $wydarzen_category_labels = array(
        'name'          => _x('Kategorie Działań', 'taxonomy general name', 'bibiloteka'),
        'singular_name' => _x('Kategoria Działania', 'taxonomy singular name', 'bibiloteka'),
        'search_items'  => __('Szukaj Kategorii Działań', 'bibiloteka'),
        'all_items'     => __('Wszystkie Kategorie', 'bibiloteka'),
        'edit_item'     => __('Edytuj Kategorię', 'bibiloteka'),
        'add_new_item'  => __('Dodaj Nową Kategorię', 'bibiloteka'),
        'menu_name'     => __('Kategorie Działań', 'bibiloteka'),
    );

    $wydarzen_category_args = array(
        'hierarchical' => true,
        'labels'       => $wydarzen_category_labels,
        'show_ui'      => true,
        'show_in_rest' => true,
        'rewrite'      => array('slug' => 'wydarzen-category'),
    );
    register_taxonomy('wydarzen_categories', 'kalendarz-wydarzen', $wydarzen_category_args);

    // Taxonomy 2: Dla kogo
    $dla_kogo_labels = array(
        'name'          => _x('Dla kogo', 'taxonomy general name', 'bibiloteka'),
        'singular_name' => _x('Dla kogo', 'taxonomy singular name', 'bibiloteka'),
        'search_items'  => __('Szukaj kategorii', 'bibiloteka'),
        'all_items'     => __('Wszystkie kategorie', 'bibiloteka'),
        'edit_item'     => __('Edytuj kategorię', 'bibiloteka'),
        'add_new_item'  => __('Dodaj nową kategorię', 'bibiloteka'),
        'menu_name'     => __('Dla kogo', 'bibiloteka'),
    );

    $dla_kogo_args = array(
        'hierarchical' => true,
        'labels'       => $dla_kogo_labels,
        'show_ui'      => true,
        'show_in_rest' => true,
        'rewrite'      => array('slug' => 'dla-kogo'),
    );
    register_taxonomy('dla_kogo', 'kalendarz-wydarzen', $dla_kogo_args);
}
add_action('init', 'Kalendarz_wydarzen');


function Konkursy() {
    $labels = array(
        'name'                  => _x('Konkursy', 'Post Type General Name', 'bibiloteka'),
        'singular_name'         => _x('Konkursy', 'Post Type Singular Name', 'bibiloteka'),
        'menu_name'             => __('Konkursy', 'bibiloteka'),
        'name_admin_bar'        => __('Konkursy', 'bibiloteka'),
        'archives'              => __('Archiwum wydarzeń', 'bibiloteka'),
        'parent_item_colon'     => __('Rodzic Konkursy:', 'bibiloteka'),
        'all_items'             => __('Wszystkie Konkursy', 'bibiloteka'),
        'add_new_item'          => __('Dodaj nowe Konkursy', 'bibiloteka'),
        'add_new'               => __('Dodaj nowe', 'bibiloteka'),
        'new_item'              => __('Nowe Konkursy', 'bibiloteka'),
        'edit_item'             => __('Edytuj Konkursy', 'bibiloteka'),
        'update_item'           => __('Aktualizuj Konkursy', 'bibiloteka'),
        'view_item'             => __('Zobacz Konkursy', 'bibiloteka'),
        'search_items'          => __('Szukaj wydarzeń', 'bibiloteka'),
        'not_found'             => __('Nie znaleziono', 'bibiloteka'),
        'not_found_in_trash'    => __('Nie znaleziono w koszu', 'bibiloteka'),
        'featured_image'        => __('Obrazek wyróżniający', 'bibiloteka'),
        'set_featured_image'    => __('Ustaw obrazek wyróżniający', 'bibiloteka'),
        'remove_featured_image' => __('Usuń obrazek wyróżniający', 'bibiloteka'),
        'items_list'            => __('Lista wydarzeń', 'bibiloteka'),
        'filter_items_list'     => __('Filtruj listę wydarzeń', 'bibiloteka'),
    );

    $args = array(
        'label'               => __('Konkursy', 'bibiloteka'),
        'description'         => __('Konkursy realizowane w ramach programu LEADER', 'bibiloteka'),
        'labels'              => $labels,
        'supports'            => array('title', 'author', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'        => true,
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-groups',
        'rewrite'             => array('slug' => 'Konkursy'),
        'has_archive'         => 'Konkursy',
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type('konkursy', $args);

    // Taxonomy 1: Kategorie Działań
    $Konkursy_category_labels = array(
        'name'          => _x('Kategorie Działań', 'taxonomy general name', 'bibiloteka'),
        'singular_name' => _x('Kategoria Działania', 'taxonomy singular name', 'bibiloteka'),
        'search_items'  => __('Szukaj Kategorii Działań', 'bibiloteka'),
        'all_items'     => __('Wszystkie Kategorie', 'bibiloteka'),
        'edit_item'     => __('Edytuj Kategorię', 'bibiloteka'),
        'add_new_item'  => __('Dodaj Nową Kategorię', 'bibiloteka'),
        'menu_name'     => __('Kategorie Działań', 'bibiloteka'),
    );

    $Konkursy_category_args = array(
        'hierarchical' => true,
        'labels'       => $Konkursy_category_labels,
        'show_ui'      => true,
        'show_in_rest' => true,
        'rewrite'      => array('slug' => 'Konkursy-category'),
    );
    register_taxonomy('Konkursy_categories', 'konkursy', $Konkursy_category_args);

}
add_action('init', 'Konkursy');

function Szkolenia() {
    $labels = array(
        'name'                  => _x('Szkolenia', 'Post Type General Name', 'bibiloteka'),
        'singular_name'         => _x('Szkolenia', 'Post Type Singular Name', 'bibiloteka'),
        'menu_name'             => __('Szkolenia', 'bibiloteka'),
        'name_admin_bar'        => __('Szkolenia', 'bibiloteka'),
        'archives'              => __('Archiwum wydarzeń', 'bibiloteka'),
        'parent_item_colon'     => __('Rodzic Szkolenia:', 'bibiloteka'),
        'all_items'             => __('Wszystkie Szkolenia', 'bibiloteka'),
        'add_new_item'          => __('Dodaj nowe Szkolenia', 'bibiloteka'),
        'add_new'               => __('Dodaj nowe', 'bibiloteka'),
        'new_item'              => __('Nowe Szkolenia', 'bibiloteka'),
        'edit_item'             => __('Edytuj Szkolenia', 'bibiloteka'),
        'update_item'           => __('Aktualizuj Szkolenia', 'bibiloteka'),
        'view_item'             => __('Zobacz Szkolenia', 'bibiloteka'),
        'search_items'          => __('Szukaj wydarzeń', 'bibiloteka'),
        'not_found'             => __('Nie znaleziono', 'bibiloteka'),
        'not_found_in_trash'    => __('Nie znaleziono w koszu', 'bibiloteka'),
        'featured_image'        => __('Obrazek wyróżniający', 'bibiloteka'),
        'set_featured_image'    => __('Ustaw obrazek wyróżniający', 'bibiloteka'),
        'remove_featured_image' => __('Usuń obrazek wyróżniający', 'bibiloteka'),
        'items_list'            => __('Lista wydarzeń', 'bibiloteka'),
        'filter_items_list'     => __('Filtruj listę wydarzeń', 'bibiloteka'),
    );

    $args = array(
        'label'               => __('Szkolenia', 'bibiloteka'),
        'description'         => __('Szkolenia realizowane w ramach programu LEADER', 'bibiloteka'),
        'labels'              => $labels,
        'supports'            => array('title', 'author', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'        => true,
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'rewrite'             => array('slug' => 'Szkolenia'),
        'has_archive'         => 'Szkolenia',
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type('szkolenia', $args);

    // Taxonomy 1: Kategorie Działań
    $Szkolenia_category_labels = array(
        'name'          => _x('Kategorie Działań', 'taxonomy general name', 'bibiloteka'),
        'singular_name' => _x('Kategoria Działania', 'taxonomy singular name', 'bibiloteka'),
        'search_items'  => __('Szukaj Kategorii Działań', 'bibiloteka'),
        'all_items'     => __('Wszystkie Kategorie', 'bibiloteka'),
        'edit_item'     => __('Edytuj Kategorię', 'bibiloteka'),
        'add_new_item'  => __('Dodaj Nową Kategorię', 'bibiloteka'),
        'menu_name'     => __('Kategorie Działań', 'bibiloteka'),
    );

    $Szkolenia_category_args = array(
        'hierarchical' => true,
        'labels'       => $Szkolenia_category_labels,
        'show_ui'      => true,
        'show_in_rest' => true,
        'rewrite'      => array('slug' => 'Szkolenia-category'),
    );
    register_taxonomy('Szkolenia_categories', 'szkolenia', $Szkolenia_category_args);

}
add_action('init', 'Szkolenia');
