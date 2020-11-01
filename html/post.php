<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions_m.php';
require_once MODEL_PATH . 'db_m.php';
require_once MODEL_PATH . 'user_m.php';

session_start();

$db = get_db_connect();

$user = get_login_user($db);
if ($user === false) {
  redirect_to(LOGOUT_URL);
}
if ($user === '') {
  set_login_warning('記事を投稿するにはログインが必要です');
}

if (has_post_session() === true) {
  set_post_warning('記事の投稿が中断されました。右のボタンから投稿作業に戻れます。' . "<br>" . 'ブラウザを閉じると、中断された入力データは破棄されます。');
}
include_once VIEW_PATH . 'post_v.php';
?>