<?php

function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function u($string="") {
  return urlencode($string);
}

function raw_u($string="") {
  return rawurlencode($string);
}

function h($string="") {
  return htmlspecialchars($string);
}

function error_404() {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
}

function error_500() {
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}

function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class=\"errors\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul>";
    foreach($errors as $error) {
      $output .= "<li>" . h($error) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

function get_and_clear_session_message() {
  if(isset($_SESSION['message']) && $_SESSION['message'] != '') {
    $msg = $_SESSION['message'];
    unset($_SESSION['message']);
    return $msg;
  }
}

function display_session_message() {
  $msg = get_and_clear_session_message();
  if(!is_blank($msg)) {

    // position first -
    $first_hyphen = strpos($msg, '-');

     // position second -
    $second_hyphen = strpos($msg, '-', strpos($msg, '-') + 1);

    // first part of the string
    $first_part_msg = substr($msg, 0, ($first_hyphen + 1));

    // second part of the string
    $second_part_msg = substr($msg, $second_hyphen, -1);

    // red bolded string
    $red_bolded_msg = substr($msg, ($first_hyphen + 1) , (($second_hyphen - $first_hyphen) - 1));

    $output = '';
    $output .= "<div id=\"message\">";
    $output .= "<p>" . $first_part_msg . "<b><span style=\"color:red;\">" . $red_bolded_msg . "</span></b>" . $second_part_msg . "</p>";
    $output .= "</div>";
    return $output;
  }
}

?>
