<h1>NextGenSim Shortcode</h1>
<!-- get all characters-->
<?php
    $years = get_posts([
        'post_type' => 'year',
        'post_status' => 'publish',
        'numberposts' => -1,
        'order'    => 'ASC',
    ]);
?>
<hr>
<hr>
<h2>Choose a Year to Generate Shortcode</h2>
<form method="POST" action="#">
    <label for="years-dropdown">Current Years: </label>
    <select id="years-dropdown" name="years-dropdown">
        <option value="" selected>Choose a Year</option>
    <?php

        foreach($years as $year){
            $current_year = get_post_meta($year->ID, 'year', true);
            echo "<option value='$current_year' >$current_year</option>";
        } // end foreach
    ?>
    </select>
    <button type="submit" id="choose-year-submit"> Display Shortcode </button>
</form>
<hr width="100%" size="12px">

<?php

    // If a year has been chosen for shortcode
    if (isset ($_POST['years-dropdown']) && $_POST['years-dropdown'] != ""  && $_POST['years-dropdown'] != "Choose a Year")
    {
        $year = $_POST['years-dropdown'];
        echo "<br><hr><h2>Paste the shortcode below into a page block to display $year NextGenSim:</h2><hr> [nextgensim-application year=$year]<br>";
    } // end if

    
?>



