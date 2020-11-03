<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions_m.php';
require_once MODEL_PATH . 'db_m.php';
require_once MODEL_PATH . 'user_m.php';
header('X-FRAME-OPTIONS: DENY');

session_start();

if (is_logined() === true) {
  redirect_to(INDEX_URL);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  if (PREVIOUS_URL !== null) {
    redirect_to(PREVIOUS_URL);
  }
  redirect_to(LOGIN_URL);
}

$user_name = get_post('user_name');
$password = get_post('password');

$token = get_post('token');

if (is_valid_csrf_token($token) === false) {
  redirect_to(LOGOUT_URL);
}

$db = get_db_connect();

$user = login_as($db, $user_name, $password);
if ($user === false) {
  set_error('ログインに失敗しました。');
  redirect_to(LOGIN_URL);
}

set_message('ログインしました。');
// if ($user['user_type'] === USER_TYPE_ADMIN) {
//   redirect_to(ADMIN_URL);
// }
redirect_to(INDEX_URL);
?>