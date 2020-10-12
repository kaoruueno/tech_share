<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions_m.php';
require_once MODEL_PATH . 'user_m.php';
require_once MODEL_PATH . 'db_m.php';
// header('X-FRAME-OPTIONS: DENY');

session_start();

if (is_logined() === true) {
  redirect_to(INDEX_URL);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  if (PREVIOUS_URL !== null) {
    redirect_to(PREVIOUS_URL);
  }
  redirect_to(SIGNUP_URL);
}
// $token = get_post('token');
$user_name = get_post('user_name');
$password = get_post('password');
$password_confirmation = get_post('password_confirmation');
$language_types = get_post_checkbox('language_types');
// if (is_valid_csrf_token($token) === false) {
//   redirect_to(SIGNUP_URL);
// }
$db = get_db_connect();

if (register_user($db, $user_name, $password, $password_confirmation, $language_types) === false) {
  set_error('ユーザー登録に失敗しました。');
  redirect_to(SIGNUP_URL);
}

set_message('ユーザー登録が完了しました。');
login_as($db, $user_name, $password);
redirect_to(INDEX_URL);
?>