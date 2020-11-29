<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions_m.php';
require_once MODEL_PATH . 'db_m.php';
require_once MODEL_PATH . 'user_m.php';
require_once MODEL_PATH . 'article_m.php';
header('X-FRAME-OPTIONS: DENY');

session_start();

$db = get_db_connect();

$user = get_login_user($db);
if ($user === false) {
  redirect_to(LOGOUT_URL);
}
if ($user === '') {
  if (has_valid_previous_url() === true) {
    set_login_warning('フォローするにはログインが必要です');
    redirect_to(PREVIOUS_URL);
  }
  redirect_to(INDEX_URL);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $follower_id = get_post('follower_id');
  $token = get_post('token');

  if (is_valid_csrf_token($token) === false) {
    redirect_to(LOGOUT_URL);
  }
  
  if (is_valid_follower_id_for_following_user_register($db, $user, $follower_id) === false) {
    if (has_valid_previous_url() === true) {
      redirect_to(PREVIOUS_URL);
    }
    redirect_to(INDEX_URL);
  }
  
  $follower = get_user($db, $follower_id);
  if (register_following_user($db, $user, $follower_id) === false) {
    set_error($follower['user_name'] . 'さんのフォローに失敗しました。再度お試し下さい。');
    if (has_valid_previous_url() === true) {
      redirect_to(PREVIOUS_URL);
    }
    redirect_to(INDEX_URL);
  }
  set_message($follower['user_name'] . 'さんをフォローしました');
}
if (has_valid_previous_url() === true) {
  redirect_to(PREVIOUS_URL);
}
redirect_to(INDEX_URL);
?>