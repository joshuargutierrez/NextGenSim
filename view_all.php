<?php 
defined( 'ABSPATH' ) or die( '::NO INDIRECT ACCESS ALLOWED::' );

echo '<div class=""wrap>';
echo '<h1>View All Characters</h1>';
echo '<hr width="70%" align="left">';
$posts = get_posts([
    'post_type' => 'character',
    'post_status' => 'publish',
    'numberposts' => -1,
    'order'    => 'ASC',
  ]);

foreach($posts as $post)
{
    echo '<hr width="100%">';
    
    echo '<hr width="98%" align="center">';

    $character_id = $post->ID;

    $character_year = get_post_meta($character_id, 'year', true);

    $character_number = get_post_meta($character_id, 'number', true);

    $character_title = get_post_meta($character_id, 'character-title', true);

    echo "<h2 style='margin-bottom:2px;'> ($character_year) #$character_number - $character_title</h2>";

    $character_profile = get_post_meta($character_id, 'profile', true);

    echo "<h2 style='margin:0;'>Profile: </h2><h4 style='margin-top:2px;'>$character_profile</h4>";

    $character_goal = get_post_meta($character_id, 'goal', true);

    echo "<h2 style='margin:0;'>Goal: </h2><h4 style='margin-top:2px;'>$character_goal</h4>";

    $character_insider = get_post_meta($character_id, 'insider-info', true);

    echo "<h2 style='margin:0;'>Insider Info: </h2><h4 style='margin-top:2px;'>$character_insider</h4>";

    $character_password = get_post_meta($character_id, 'password', true);

    echo "<h2 style='margin:0;'>Password: </h2><h4 style='margin-top:2px;'>$character_password</h4>";

    echo '<hr width="98%" align="center">';
    
}

echo '</div>';