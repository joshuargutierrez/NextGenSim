<?php

defined( 'ABSPATH' ) or die( '::NO INDIRECT ACCESS ALLOWED::' );

/**
 * year.php creates a custom post type (CPT) called a year, 
 * so new years can be added to the WordPress (WP) database
 * 
 */

/** 
 * year update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function codex_year_updated_messages( $messages ) 
{
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['year'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'year updated.'),
		2  => __( 'Field updated.' ),
		3  => __( 'Field deleted.'),
		4  => __( 'year updated.' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'year restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'year published.'),
		7  => __( 'year saved.'),
		8  => __( 'year submitted.'),
		9  => sprintf(
			__( 'year scheduled for: <strong>%1$s</strong>.'),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i'), strtotime( $post->post_date ) )
		), // end 9  => sprintf(
		10 => __( 'year draft updated.')
	); // end $messages['year'] = array

	if ( $post_type_object->publicly_queryable && 'year' === $post_type ) {
		$permalink = get_permalink( $post->ID );
		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View year') );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;
		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview year') );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;

	} // end if

	return $messages;
    
} // end function codex_year_updated_messages

/**
 * Register a year post type.
 *
 */
function nextgensim_year_cpt_init() 
{

    $labels = array(
        'name'               => _x( 'years', 'post type general name'),
        'singular_name'      => _x( 'year', 'post type singular name'),
        'menu_name'          => _x( 'years', 'nextgensim-settings'),
        'name_admin_bar'     => _x( 'year', 'nextgensim-settings'),
        'add_new'            => null,
        'add_new_item'       => null,
        'new_item'           => null,
        'edit_item'          => __('Edit year'),
        'view_item'          => __( 'View year'),
        'all_items'          => __( 'View years'),
        'search_items'       => __( 'Search years'),
        'parent_item_colon'  => __( 'Parent years:'),
        'not_found'          => __( 'No years found.'),
        'not_found_in_trash' => __( 'No years found in Trash.')

	); // end $labels = array

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'year'),
		'public'             => false,
		'exclude_from_search'=> true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => 'nextgensim-settings',
		'query_var'          => true,
		'show_in_nav_menus'  => false,
		'rewrite'            => array( 'slug' => 'year' ),
        'capability_type' => 'post',
		'capabilities' => array(
			'create_posts'       => true, 
			'edit_posts'         => true,
        ),
		'map_meta_cap' => true,
		'has_archive'        => true,
		'hierarchical'       => false,
        'supports'           => array( 'my_feature', array( 'field' => 'value' ) )
	); // end $args = array

	register_post_type( 'year', $args );
    
} // end function nextgensim_year_cpt_init() {

/**
 * get permalinks to work when the plugin is activated
 */
function nextgensim_year_rewrite_flush() 
{
    nextgensim_year_cpt_init();

    flush_rewrite_rules();

} // end function nextgensim_year_rewrite_flush

/**
 * Determines which columns can be displayed for CPT 'year'
 * @return type null
 */
function nextgensim_edit_year_columns() 
{
	return array(
		'cb'                   => '&lt;input type="checkbox" />',
		'title'		           => __('Title'),
        'date'                 => __( 'Last Edited' ),
        'year'                 => __('Year'),
		'admin-password'       => __('Admin Password'),
		'secret-password'      => __( 'Secret Password' ),
	); // end return

} // end function nextgensim_edit_year_columns

/**
 * Determine how a year columns will be displayed
 * @global type $post 'year'
 * @param type $column Which column is being managed
 * @param type $post_id the id of the post being displayed
 */ 
function nextgensim_manage_year_columns( $column, $post_id ) 
{
	switch( $column ) {

		case 'title' :
			$title = get_post_meta( $post_id, 'title', true );
                        if ( empty( $title ) ){echo __( '' );}
                        else{echo __( $title ) ;}
                        break;

        case 'date' :
			$date = get_post_meta( $post_id, 'date', true );
                        if ( empty( $date ) ){echo __( '' );}
                        else{echo __( $date ) ;}
                        break;

        case 'year' :
			$year = get_post_meta( $post_id, 'year', true );
                        if ( empty( $year ) ){echo __( '' );}
                        else{echo __( $year ) ;}
                        break;

		case 'admin-password' :
			$password = get_post_meta( $post_id, 'admin-password', true );
						if ( empty( $password ) ){echo __( '' );}
						else{echo __( $password ) ;}
						break;

		case 'secret-password' :
			$secret = get_post_meta( $post_id, 'secret-password', true );
						if ( empty( $secret ) ){echo __( '' );}
						else{echo __( $secret ) ;}
						break;

		default :break;

	} // end switch

} // end function nextgensim_manage_year_columns

add_filter( 'manage_edit-year_sortable_columns', 'set_custom_year_sortable_columns' );

function set_custom_year_sortable_columns( $columns ) {
  $columns['year'] = 'year';

  return $columns;
}

function year_custom_orderby( $query ) {
  if ( ! is_admin() )
    return;

  $orderby = $query->get( 'orderby');

  if ( 'year' == $orderby ) {
    $query->set( 'meta_key', 'year' );
    $query->set( 'orderby', 'meta_value_num' );
  }

}

//Initialize Custom Post Type (CPT) 'year'
add_action( 'init', 'nextgensim_year_cpt_init' );

//Ensure CPT gets added to the DB on hook activation
register_activation_hook( __FILE__, 'nextgensim_year_rewrite_flush' );

//registers how CPT 'year' is displayed
add_filter( 'post_updated_messages', 'codex_year_updated_messages' );

//determine which columns will be displayed when viewing CPT 'year' 
add_filter( 'manage_edit-year_columns', 'nextgensim_edit_year_columns' ) ;

//Sets columns for viewing CPT 'year'
add_action( 'manage_year_posts_custom_column', 'nextgensim_manage_year_columns', 10, 2 );


