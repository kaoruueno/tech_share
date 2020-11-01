<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions_m.php';
require_once MODEL_PATH . 'db_m.php';
require_once MODEL_PATH . 'user_m.php';
require_once MODEL_PATH . 'article_m.php';
// header('X-FRAME-OPTIONS: DENY');

session_start();

$db = get_db_connect();

$user = get_login_user($db);
if ($user === false) {
  redirect_to(LOGOUT_URL);
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  redirect_to(INDEX_URL);
}
$post_id = get_get('post');
// バリデーション
if (is_valid_post_id_for_article($db, $post_id) === false) {
  set_error('指定されたページは存在しません');
  redirect_to(INDEX_URL);
}
$article = get_article($db, $post_id);
$article = get_article_for_article($article);
if (has_post_session() === true) {
  set_post_warning('記事の投稿が中断されました。右のボタンから投稿作業に戻れます。' . "<br>" . 'ブラウザを閉じると、中断された入力データは破棄されます。');
}
// $token = get_csrf_token();
include_once VIEW_PATH . 'article_v.php';
?>