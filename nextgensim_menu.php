<?php
defined( 'ABSPATH' ) or die( '::NO INDIRECT ACCESS ALLOWED::' );

if ( is_admin()){

add_action( 'admin_menu', 'negtgensim_plugin_menu', 9);

} // end if is_admin

function negtgensim_plugin_menu() 
{
add_menu_page( 'NextGenSim', 'NextGenSim', 'manage_options', 'nextgensim-settings', 'nextgensim_display_main_page', ' 	dashicons-rest-api', 21);
add_submenu_page('nextgensim-settings', 'Add/Edit Character', 'Add/Edit Character', 'manage_options', 'nextgensim-add-character', 'nextgensim_display_add_character_page');     
add_submenu_page('nextgensim-settings', 'View All', 'View All', 'manage_options', 'nextgensim-view-all', 'nextgensim_display_view_all_page');     

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