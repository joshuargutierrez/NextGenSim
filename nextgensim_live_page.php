<?php



function display_live_page($year)
{
  $final_string = "";

  // if the character number has been chosen
  if(isset($_POST["character-number"]) && $_POST["character-number"] > 0 && isset($_POST["password"]))
  {
    $character_number = $_POST["character-number"];

    $password = $_POST["password"];

    $secret_password = "";

    $years = get_posts([
    'post_type' => 'year',
    'post_status' => 'publish',
    'numberposts' => -1,
    'order'    => 'ASC',
    'meta_query' => [
        [
          'key' => 'year',// this key is advance custom field: type post_object
          'value' => $year,
        ], 
      ], 
    ]); // end $years = get_posts

    // colect admin and secret password for current year
    foreach($years as $current_year)
    {
      
        $admin_password = get_post_meta($current_year->ID, 'admin-password', true);

        $secret_password = get_post_meta($current_year->ID, 'secret-password', true);;
            
    } // end foreach

    $characters = get_posts([
      'post_type' => 'character',
      'post_status' => 'publish',
      'numberposts' => -1,
      'order'    => 'ASC',
      'meta_query' => [
        [
          'key' => 'year',
          'value' => $year,
        ], 
        [
          'key' => 'number',
          'value' => $character_number,
        ], 
      ], 
    ]);

    foreach($characters as $character){
          $password = get_post_meta($character->ID, 'password', true);

          $character_number = get_post_meta($character->ID, 'number', true);

          if($character_number == $_POST['character-number'])
          {
            $found_number = true;
           
            if(($password === $_POST['password'] || $_POST['password'] === $admin_password))
            {
              $found_character = true;

              $final_string .= "<h2>Character " . $character_number . " information </h2> <br>";
              $final_string .= "<strong><i>Feel free to share this information with others.</i></strong><br><br><hr><br>";
              $final_string .= "<b>Position</b>: " . get_post_meta($character->ID, 'character-title', true) . "<br>";
              $final_string .= "<br><b>Profile</b>: " . get_post_meta($character->ID, 'profile', true) . "<br>";
              $final_string .= "<br><b>Goal</b>: " . get_post_meta($character->ID, 'goal', true) . "<br>";
              
              $final_string .= "<h2> Insider Information </h2> <br>";

              echo 'SECRET:::' . $secret_password;

              if ($secret_password === $_POST['secret-password']) {
                $final_string .= "<strong><i>This is privileged information that only you have access to. Be careful who you  share it with.</i></strong><br><br><br>";
                $final_string .= get_post_meta($character->ID, 'insider-info', true) . "<br><br>";
              
              } // end if 

              else {
                $final_string .= '<div class="container">';
                $final_string .= '<form action="#" method="post">';

                $final_string .= '<input name="character-number" id="character-number" type="number" value='.$_POST['character-number']. ' type="hidden" style="display:none;" readonly/>';
  
                $final_string .= '<input name="password" id="password" type="password" value='.$_POST['password'].' type="hidden" style="display:none;" readonly/>';

                $final_string .= '<label for="secret-password">Secret Password: </label>';
                $final_string .= '<input id="secret-password" name="secret-password" type="password"/>';

                $final_string .= '<input type="submit" value="Unlock" />';
                $final_string .= '</form>';
                $final_string .= '</div>';

              } // end else

            } // end if
            
          } // end if

      } // end foreach

      if (!$found_number) {

        $final_string .= "<form action='#' method='post'> 
        <h4>Character Not Found</h4> 
        <input type='submit' value='Retry Login Attempt'/>

        </form";

        $final_string .= "";



      } // end if

      else {

        if (!$found_character) {

          $final_string .= "<form action='#' method='post'> 
          <h3>Incorrect Password</h3> 
          <input type='submit' value='Retry Login Attempt'/>
  
          </form";



        } // end if

      } // end else

  } // end if

  else
  {
    $final_string .= '<div class="container">
            <form action="" method="post">
              <label for="character-number">Character Number: </label>
              <input id="character-number" name="character-number" type="number" min="1" max="777" required/>

              <label for="admin-password">Password: </label>
              <input id="password" name="password" type="password" required /><br>

              <!--<input id="secret-password" name="secret-password" type="hidden" /> -->
              
              <input type="submit" value="Submit" />

            </form>
          </div>';
  } // end else

  return $final_string;
  
} // end function display_live_page($year

add_shortcode('nextgensim-application', 'display_live_page');