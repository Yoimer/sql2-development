<?php require_once('../private/initialize.php'); ?>

<?php

    $value = isset($_GET['value']) ? $_GET['value'] : 'DEFAULT VALUE';
    update_status($value);

    // read actual status from database
    $alexa_set = actual_status();
    while($alexa = mysqli_fetch_assoc($alexa_set)) {
        echo $alexa['status'];
    }

?>
