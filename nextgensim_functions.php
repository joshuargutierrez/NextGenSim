<?php

defined( 'ABSPATH' ) or die( '::NO INDIRECT ACCESS ALLOWED::' );

/**
 * Verify logged in user can manage options
 */
function nextgensim_verify_credentials()
{
    if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    } // end if
} // end function function site2crm_verify_credentials

//add stylesheet
function nextgensim_add_stylesheet_to_admin() 
{
    wp_enqueue_style( 'prefix-style', plugins_url('assets/styles.css', __FILE__) );

} // nextgensim_add_stylesheet_to_admin

//Add custom css for admin sections
add_action( 'admin_enqueue_scripts', 'nextgensim_add_stylesheet_to_admin' );
