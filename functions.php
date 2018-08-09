<?php

define('DISALLOW_FILE_EDIT', true);

if ( ! class_exists( 'Timber' ) ) {
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
    } );
    return;
}

Timber::$dirname = array('templates', 'views');

require_once("acf.php");



class StarterSite extends TimberSite {

    function __construct() {
        add_filter( 'timber_context', array( $this, 'add_to_context' ) );
        add_theme_support( 'menus' );
        parent::__construct();
    }

    function add_to_context( $context ) {

        return $context;
    }
}
new StarterSite();


if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Samti orders',
        'menu_title'	=> 'Samti orders',
        'menu_slug' 	=> 'samti-orders',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'DPD instellingen',
        'menu_title'	=> 'DPD instellingen',
        'parent_slug'	=> 'samti-orders',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Webshops',
        'menu_title'	=> 'Webshops',
        'parent_slug'	=> 'samti-orders',
    ));

}

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array (
        'key' => 'group_5b28f1c18a17b',
        'title' => 'dpd',
        'fields' => array (
            array (
                'key' => 'field_5b28f1d0dfab9',
                'label' => 'DPD auth string',
                'name' => 'dpd_auth_string',
                'type' => 'textarea',
                'instructions' => 'The string required to connect with DPD http://localhost/samtiwp/getdpdauthkey',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'DPD auth string',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-dpd-instellingen',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));

endif;




function custom_post_type() {

$labels = array(
    'name'                => _x( 'Retouren', 'Post Type General Name', 'twentythirteen' ),
    'singular_name'       => _x( 'Retour', 'Post Type Singular Name', 'twentythirteen' ),
    'menu_name'           => __( 'Retour', 'twentythirteen' ),
    'parent_item_colon'   => __( 'Parent Retour', 'twentythirteen' ),
    'all_items'           => __( 'Alle Retouren', 'twentythirteen' ),
    'view_item'           => __( 'View Retour', 'twentythirteen' ),
    'add_new_item'        => __( 'Add New Retour', 'twentythirteen' ),
    'add_new'             => __( 'Add New', 'twentythirteen' ),
    'edit_item'           => __( 'Edit Retour', 'twentythirteen' ),
    'update_item'         => __( 'Update Retour', 'twentythirteen' ),
    'search_items'        => __( 'Search Retour', 'twentythirteen' ),
    'not_found'           => __( 'Not Found', 'twentythirteen' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
);

// Set other options for Custom Post Type

$args = array(
    'label'               => __( 'retouren', 'twentythirteen' ),
    'description'         => __( 'Alle retouren', 'twentythirteen' ),
    'labels'              => $labels,
    // Features this CPT supports in Post Editor
    'supports'            => array( 'title', 'thumbnail', 'custom-fields', ),
    // You can associate this CPT with a taxonomy or custom taxonomy.
    'taxonomies'          => array( 'genres' ),
    /* A hierarchical CPT is like Pages and can have
    * Parent and child items. A non-hierarchical CPT
    * is like Posts.
    */
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capability_type'     => 'page',
);

// Registering your Custom Post Type
register_post_type( 'retouren', $args );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/

add_action( 'init', 'custom_post_type', 0 );


