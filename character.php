<?php

defined( 'ABSPATH' ) or die( '::NO INDIRECT ACCESS ALLOWED::' );

/**
 * character.php creates a custom post type (CPT) called a character, 
 * so new characters can be added to the WordPress (WP) database
 * 
 */

/** 
 * Character update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function codex_character_updated_messages( $messages ) 
{
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['character'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Character updated.'),
		2  => __( 'Field updated.' ),
		3  => __( 'Field deleted.'),
		4  => __( 'Character updated.' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Character restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Character published.'),
		7  => __( 'Character saved.'),
		8  => __( 'Character submitted.'),
		9  => sprintf(
			__( 'Character scheduled for: <strong>%1$s</strong>.'),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i'), strtotime( $post->post_date ) )
		), // end 9  => sprintf(
		10 => __( 'Character draft updated.')
	); // end $messages['character'] = array

	if ( $post_type_object->publicly_queryable && 'character' === $post_type ) {
		$permalink = get_permalink( $post->ID );
		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View Character') );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;
		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview Character') );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;

	} // end if

	return $messages;
    
} // end function codex_character_updated_messages

/**
 * Register a Character post type.
 *
 */
function nextgensim_cpt_init() 
{

    $labels = array(
        'name'               => _x( 'Characters', 'post type general name'),
        'singular_name'      => _x( 'Character', 'post type singular name'),
        'menu_name'          => _x( 'Characters', 'nextgensim-settings'),
        'name_admin_bar'     => _x( 'Character', 'nextgensim-settings'),
        'add_new'            => null,
        'add_new_item'       => null,
        'new_item'           => null,
        'edit_item'          => __('Edit Character'),
        'view_item'          => __( 'View Character'),
        'all_items'          => __( 'View Characters'),
        'search_items'       => __( 'Search Characters'),
        'parent_item_colon'  => __( 'Parent Characters:'),
        'not_found'          => __( 'No Characters found.'),
        'not_found_in_trash' => __( 'No Characters found in Trash.')

	); // end $labels = array

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Character'),
		'public'             => false,
		'exclude_from_search'=> true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => false, /** 'nextgensim-settings',  false when in production */
		'query_var'          => true,
		'show_in_nav_menus'  => false,
		'rewrite'            => array( 'slug' => 'character' ),
        'capability_type' => 'post',
		'capabilities' => array(
			'create_posts'       => true, 
			'edit_posts'         => true,
        ),
		'map_meta_cap' => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-rest-api',
        'supports'           => array( 'my_feature', array( 'field' => 'value' ) )
	); // end $args = array

	register_post_type( 'character', $args );
    
} // end function nextgensim_cpt_init() {

/**
 * get permalinks to work when the plugin is activated
 */
function nextgensim_rewrite_flush() 
{
    nextgensim_cpt_init();

    flush_rewrite_rules();

} // end function nextgensim_rewrite_flush

/**
 * Determines which columns can be displayed for CPT 'character'
 * @return type null
 */
function nextgensim_edit_character_columns() 
{
	return array(
		'cb'           => '&lt;input type="checkbox" />',
		'title'		   => 'title',
        'date'         => __( 'Last Edited' ),
        'year'         => __('year'),
		'number'       => __('number'),
		'character-title' => __( 'character-title' ),
        'profile'      => __( 'Profile' ),
        'goal'         => __( 'Goal' ),
        'insider-info' => __( 'Insider Info' ),
        'district'     => __( 'District' ),
        'coalition'    => __( 'Coalition' ),
        'password'     => __( 'Password' ),
	); // end return

} // end function nextgensim_edit_character_columns

/**
 * Determine how a character columns will be displayed
 * @global type $post 'character'
 * @param type $column Which column is being managed
 * @param type $post_id the id of the post being displayed
 */ 
function nextgensim_manage_character_columns( $column, $post_id ) 
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

		case 'number' :
			$number = get_post_meta( $post_id, 'number', true );
						if ( empty( $number ) ){echo __( '' );}
						else{echo __( $number ) ;}
						break;

		case 'character-title' :
			$title = get_post_meta( $post_id, 'character-title', true );
                        if ( empty( $title ) ){echo __( '' );}
                        else{echo __( $title ) ;}
                        break;
		
        case 'profile' :
			$profile = get_post_meta( $post_id, 'profile', true );
                        if ( empty( $profile ) ){echo __( '' );}
                        else{echo __( substr($profile, 0, 32) ) ;}
                        break;     

        case 'goal' :
			$goal = get_post_meta( $post_id, 'goal', true );
                        if ( empty( $goal ) ){echo __( '' );}
                        else{echo __( substr($goal, 0, 32)  ) ;}
                        break;   

        case 'insider-info' :
			$insider_info = get_post_meta( $post_id, 'insider-info', true );
                        if ( empty( $insider_info ) ){echo __( '' );}
                        else{echo __( substr($insider_info, 0, 32)  ) ;}
                        break; 

        case 'region' :
            $region = get_post_meta( $post_id, 'region', true );
                        if ( empty( $region ) ){echo __( '' );}
                        else{echo __( $region ) ;}
                        break; 

        case 'password' :
			$password = get_post_meta( $post_id, 'password', true );
                        if ( empty( $password ) ){echo __( '' );}
                        else{echo __( $password ) ;}
                        break; 
        

        case 'district' :
			$district = get_post_meta( $post_id, 'district', true );
                        if ( empty( $district ) ){echo __( '' );}
                        else{echo __( $district ) ;}
                        break;

        case 'coalition' :
			$coalition = get_post_meta( $post_id, 'coalition', true );
                        if ( empty( $coalition ) ){echo __( '' );}
                        else{echo __( $coalition ) ;}
                        break; 

		default :break;

	} // end switch

} // end function nextgensim_manage_character_columns

//Initialize Custom Post Type (CPT) 'character'
add_action( 'init', 'nextgensim_cpt_init' );

//Ensure CPT gets added to the DB on hook activation
register_activation_hook( __FILE__, 'nextgensim_rewrite_flush' );

//registers how CPT 'lead' is displayed
add_filter( 'post_updated_messages', 'codex_character_updated_messages' );

//determine which columns will be displayed when viewing CPT 'character' 
add_filter( 'manage_edit-character_columns', 'nextgensim_edit_character_columns' ) ;

//Sets columns for viewing CPT 'lead'
add_action( 'manage_character_posts_custom_column', 'nextgensim_manage_character_columns', 10, 2 );


