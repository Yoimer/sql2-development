<?php
require_once('../../private/initialize.php');

unset($_SESSION['username']);

//unset($_SESSION['admin_id']); //I tested this and clean completly the session :) ;) hehe

// or you could use
// $_SESSION['username'] = NULL;

redirect_to(url_for('/staff/login.php'));

?>
