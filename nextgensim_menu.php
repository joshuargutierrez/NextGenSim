<?php
defined( 'ABSPATH' ) or die( '::NO INDIRECT ACCESS ALLOWED::' );

if ( is_admin()){

add_action( 'admin_menu', 'negtgensim_plugin_menu', 9);

} // end if is_admin

function negtgensim_plugin_menu() 
{
    add_menu_page( 'NextGenSim', 'NextGenSim', 'manage_options', 'nextgensim-settings', 'nextgensim_display_main_page', ' 	dashicons-id', 21);
    add_submenu_page('nextgensim-settings', 'Add Year', 'Add Year', 'manage_options', 'nextgensim-add-year', 'nextgensim_display_add_year_page');     
    add_submenu_page('nextgensim-settings', 'Add/Edit Character', 'Add/Edit Character', 'manage_options', 'nextgensim-add-character', 'nextgensim_display_add_character_page');     
    # add_submenu_page('nextgensim-settings', 'View Characters', 'View Characters', 'manage_options', 'nextgensim-view-all', 'nextgensim_display_view_all_page');
    add_submenu_page('nextgensim-settings', 'Get Shortcode', 'Get Shortcode', 'manage_options', 'nextgensim-get-shortcode', 'nextgensim_display_add_shortcode_page');
      
       



}

function nextgensim_display_main_page()
{
    nextgensim_verify_credentials();
    echo '<div class="wrap"></br>';
    include('main_page.php');
    echo '</div>';
}

function nextgensim_display_add_character_page()
{
    nextgensim_verify_credentials();
    echo '<div class="wrap"></br>';
    include('new_character.php');
    echo '</div>';
}

function nextgensim_display_view_all_page()
{
    nextgensim_verify_credentials();
    echo '<div class="wrap"></br>';
    include('view_all.php');
    echo '</div>';
}

function nextgensim_display_add_year_page()
{
    nextgensim_verify_credentials();
    echo '<div class="wrap"></br>';
    include('add_year.php');
    echo '</div>';
}

function nextgensim_display_add_shortcode_page()
{
    nextgensim_verify_credentials();
    echo '<div class="wrap"></br>';
    include('shortcode.php');
    echo '</div>';
}
