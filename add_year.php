<?php
// If a year has been chosen to add
if (isset ($_POST['add-year']) && $_POST['add-year'] != "")
{
    $character_id;
    
    $duplicate = false;

    $year = get_posts([
        'post_type' => 'year',
        'post_status' => 'publish',
        'numberposts' => -1,
        'order'    => 'ASC',
        'meta_query' => array(
            array(
                'title' => 'year',// this key is advance custom field: type post_object
                'value' => $_POST['add-year'],
        ), 
        ), 
    ]);

    // colect admin and secret password for current year
    foreach($year as $current_year)
    {
        $character_id = $current_year->ID;
        $duplicate = true;
        $current_year = get_post_meta($character_id, 'year', true);
        echo "<h4 style='color:maroon;''>Duplicate found. Cannot add year $current_year</h4>";
        echo '<br><hr>';
    } // end foreach

    if( !$duplicate)
    {
        $character_args = array(
            'post_type'     => 'year',
            'post_status'   => 'publish',
        );

        $character_id = wp_insert_post($character_args ); //get custom id for lead CPT

        add_post_meta($character_id, 'title', "year-" . $_POST['add-year']);

        add_post_meta($character_id, 'year', $_POST['add-year']);

        add_post_meta($character_id, 'admin-password', $_POST['admin-password']);

        add_post_meta($character_id, 'secret-password', $_POST['secret-password']);
    }
} // end if
?>
<div class="wrap">
    <h1>Add a Year</h1><br>
    <hr width="30%" align="left">
    <form method="POST" action="#" id="add-year-form">
        <label for="add-year">Year to Add: </label>
        <input type="number" name="add-year" id="add-year" min="2017" max="2056" required><br>

        <label for="admin-password">Admin Password: </label>
        <input type="text" name="admin-password" id="admin-password" required><br>

        <label for="secret-password">Secret Password: </label>
        <input type="text" name="secret-password" id="secret-password" required><br>

        <hr width="30%" align="left">

        <button type="submit" id="add-year-submit" style="
            margin-left: 120px;
            background-color: lightgray;
            border-radius: 6px;
            color: black;
            padding: 12px;
            padding-right:18px;
            padding-left:18px;
            text-align: center;
            font-size: 14px;
        "> Add New Year </button>
    </form>
</div>