<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions_m.php';
require_once MODEL_PATH . 'db_m.php';
require_once MODEL_PATH . 'user_m.php';
require_once MODEL_PATH . 'profile_m.php';
// header('X-FRAME-OPTIONS: DENY');

session_start();

$db = get_db_connect();

$user = get_login_user($db);
if ($user === false) {
  redirect_to(LOGOUT_URL);
}
if ($user === '') {
  if (PREVIOUS_URL !== null) {
    redirect_to(PREVIOUS_URL);
  }
  redirect_to(INDEX_URL);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $language_types = get_post_checkbox('language_types');
  // if (is_valid_csrf_token($token) === false) {
  //   redirect_to(SIGNUP_URL);
  // }
  if (is_valid_language_types($language_types) === false) {
    redirect_to(PREVIOUS_URL);
  }

  if (change_favorite_languages_transaction($db, $user, $language_types) === '') {
    set_error('興味があるジャンルの変更はありませんでした');
    redirect_to(PREVIOUS_URL);
  } else if (change_favorite_languages_transaction($db, $user, $language_types) === false) {
    set_error('興味があるジャンルの更新に失敗しました。再度お試し下さい。');
    redirect_to(PREVIOUS_URL);
  }
  set_message('興味があるジャンルを更新しました');
}
// $token = get_csrf_token();
redirect_to(PREVIOUS_URL);
?>