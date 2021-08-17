<?php
defined( 'ABSPATH' ) or die( '::NO INDIRECT ACCESS ALLOWED::' );

echo '<div class="wrap"></br>';
echo '<h1 id="add-new-character-form">Add/Edit a Character</h1>';
echo '<hr width="50%" align="left">';
echo '<h3 style="color:maroon; width:50%;">Be careful when creating a new character!
If the year and number match an existing
character, the existing character will be updated with the added fields.</h3></div><hr width="50%" align="left">';

echo '<form method="POST" id="new-character-form" action="">';


if (isset ($_POST['character-year-input']) && isset($_POST['character-number-input']))
{
    $character_id;
        
    $duplicate = false;

    $posts = get_posts([
        'post_type' => 'character',
        'post_status' => 'publish',
        'numberposts' => -1,
        'order'    => 'ASC',
        'meta_query' => array(
            array(
                 'key' => 'number',// this key is advance custom field: type post_object
                 'value' => $_POST['character-number-input'],
            ), 
            array(
                'key' => 'year',// this key is advance custom field: type post_object
                'value' => $_POST['character-year-input'],
           ), 
         ), 
      ]);

    foreach($posts as $post)
    {
        $character_id = $post->ID;
        $duplicate = true;
        echo "<h2>Duplicate/s Found and Updated:</h2><h3 style='color:maroon;'>Character number: " . $_POST['character-number-input'] . "<br> Year: ". $_POST['character-year-input'] . "<br></h3>";
        echo '<hr width="50%" align="left">';
    }
    // if post year and number exist
    if( !$duplicate)
    {
        
        $character_args = array(
            'post_type'     => 'character',
            'post_status'   => 'publish',
            
        );

        $character_id = wp_insert_post($character_args );//get custom id for lead CPT

        add_post_meta($character_id, 'year', $_POST['character-year-input'], true);

        add_post_meta($character_id, 'number', $_POST['character-number-input'], true);
    
        
    } // end if

    add_post_meta($character_id, 'title', 'Character-'.$_POST['character-year-input'].'-'.$_POST['character-1-input'], false);

    if (isset ($_POST['character-title-input']) && $_POST['character-title-input'] !="")
    {
        update_post_meta($character_id, 'character-title', $_POST['character-title-input'], false);
    }

    if (isset ($_POST['character-profile-input']) && $_POST['character-profile-input'] !="")
    {
        update_post_meta($character_id, 'profile', $_POST['character-profile-input'], false);
    }

    if (isset ($_POST['character-goal-input']) && $_POST['character-goal-input'] !="")
    {
        update_post_meta($character_id, 'goal', $_POST['character-goal-input'], false);
    }

    if (isset ($_POST['character-insider-info-input']) && $_POST['character-insider-info-input'] !="")
    {
        update_post_meta($character_id, 'insider-info', $_POST['character-insider-info-input'], false);
    }

    if (isset ($_POST['character-password-input']) && $_POST['character-password-input'] !="")
    {
        update_post_meta($character_id, 'password', $_POST['character-password-input'], false);
    }


}
$form = '
    <label for="character-year-input">NextGenSim Year: <b class="red-star">*</b></label>
    &nbsp;&nbsp;<input type="number" min="2017" max="2056" id="character-year-input" name="character-year-input" required></br>

    <label  for="character-number-input" >Character Number: <b class="red-star">*</b> </label>
    <input type="number" min="1" max="777" id="character-number-input" name="character-number-input" required></br>

    <label for="character-title-input" id="character-title-label" >Character Title:</label>
    <input type="text" id="character-title-input" name="character-title-input"></br>

    <label for="character-profile-input">Character Profile:</label></br>
    <textarea name="character-profile-input" id="character-profile-input" cols="58" rows="7"></textarea></br>

    <label for="character-goal-input">Character Goal(s):</label></br>
    <textarea name="character-goal-input" id="character-goal-input" cols="58" rows="2"></textarea></br>

    <label for="character-insider-info-input">Character Insider Info:</label></br>
    <textarea name="character-insider-info-input" id="character-insider-info-input" cols="58" rows="7"></textarea></br>

    <label for="character-password-input">Character Password:</label>
    <input for="text" name="character-password-input" id="character-password-input"></input><br><br>

    <hr width="50%" align="left">

    <button type="submit" id="add-character-submit"> Add/Edit Character </button>';

echo $form;

echo '<br></form>';
echo '<hr>';
echo '</div>';

/**
 * register settings for new character page
 */
function nextgensim_register_options_settings() { 
    register_setting( 'nextgensim_option_group', '' );  
}

add_action( 'admin_init', 'nextgensim_register_options_settings' );