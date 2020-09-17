<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions_m.php';
require_once MODEL_PATH . 'db_m.php';
require_once MODEL_PATH . 'user_m.php';
// header('X-FRAME-OPTIONS: DENY');

session_start();


$db = get_db_connect();

$user = get_login_user($db);
if ($user === false) {
  redirect_to(LOGOUT_URL);
}
if (has_post_session() === true) {
  set_post_warning('記事の投稿が中断されました。ブラウザを閉じると、中断されたデータは破棄されます。');
}
// 記事をDBから取得する処理



// $token = get_csrf_token();
include_once VIEW_PATH . 'index_v.php';
?>