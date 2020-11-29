<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions_m.php';
require_once MODEL_PATH . 'db_m.php';
require_once MODEL_PATH . 'user_m.php';
require_once MODEL_PATH . 'post_m.php';
header('X-FRAME-OPTIONS: DENY');

session_start();

$db = get_db_connect();

$user = get_login_user($db);
if ($user === false) {
  redirect_to(LOGOUT_URL);
}
if ($user === '') {
  if (has_valid_previous_url() === true) {
    redirect_to(PREVIOUS_URL);
  }
  redirect_to(POST_URL);
}

delete_post_data_session();
if (has_valid_previous_url() === true) {
  redirect_to(PREVIOUS_URL);
}
redirect_to(POST_URL);
?>