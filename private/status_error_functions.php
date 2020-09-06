<?php

function require_login()
{
  global $session;
  if(!$session->is_logged_in()){
    redirect_to(url_for('staff/login.php'));
  }else{
    //Do nothing
  }
}

function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    foreach($errors as $error) {
      $output .= "<div class=\"alert alert-danger\" role=\"alert\">";
        $output .= h($error);
      $output .= "</div>";
    }
  }
  return $output;
}

function display_session_message() {
  global $session;
  $msg = $session->message();
  if(isset($msg) && $msg != '') {
    $session->clear_message();
    return '<div class="alert alert-success role="alert"> ' . h($msg) . ' </div>';  
  }
}
function display_session_messageTow() {
  global $session;
  $msg = $session->messageTow();
  if(isset($msg) && $msg != '') {
    $session->clear_message();
    return '<div class="alert alert-success role="alert"> ' . h($msg) . ' </div>';  
  }
}
function display_session_messageInfo() {
  global $session;
  $msg = $session->messageInfo();
  if(isset($msg) && $msg != '') {
    $session->clear_message();
    return '<div class="alert alert-info role="alert"> ' . h($msg) . ' </div>';  
  }
}

?>
