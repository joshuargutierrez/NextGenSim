<h1>NextGenSim</h1>
<!-- get all characters-->
<?php
    $characters = get_posts([
        'post_type' => 'character',
        'post_status' => 'publish',
        'numberposts' => -1,
        'order'    => 'ASC',
    ]);
    $years = [];
?>
<hr>
<hr>
<h2>Choose a Year to Generate Page Shortcode</h2>
<form method="POST" action="#">
    <label for="years-dropdown">Current Years: </label>
    <select id="years-dropdown" name="years-dropdown">
        <option value="" selected>Choose a Year</option>
    <?php
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options WHERE option_id = 1", OBJECT );
        
        // foreach($characters as $character){
        //     $year = get_post_meta($character->ID, 'year', true);
        //     echo "<option value='$year' >$year</option>";
        // } // end foreach
    ?>
    </select>
    <button type="submit" id="choose-year-submit"> Create Shortcode </button>
</form>

<?php

    // If a year has been chosen
    if (isset ($_POST['years-dropdown']) && $_POST['years-dropdown'] != ""  && $_POST['years-dropdown'] != "Choose a Year")
    {
        $year = $_POST['years-dropdown'];
        echo "<br><hr><h2>Paste the shortcode below into a page block to display $year NextGenSim:</h2> [nextgensim-application year=$year]<br><hr>";
    } // end if

