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
  redirect_to(INDEX_URL);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $post_id = get_post('post_id');
  $token = get_post('token');

  if (is_valid_csrf_token($token) === false) {
    redirect_to(LOGOUT_URL);
  }

  if (is_valid_post_id_for_post_delete($db, $user, $post_id) === false) {
    if (has_valid_previous_url() === true) {
      redirect_to(PREVIOUS_URL);
    }
    redirect_to(INDEX_URL);
  }
  
  if (delete_post_transaction($db, $post_id) === false) {
    set_error('指定した投稿記事の削除に失敗しました。再度お試し下さい。');
    if (has_valid_previous_url() === true) {
      redirect_to(PREVIOUS_URL);
    }
    redirect_to(INDEX_URL);
  }
  set_message('指定した投稿記事を削除しました');
}
if (has_valid_previous_url() === true && is_previous_page(ARTICLE_URL) === false) {
  redirect_to(PREVIOUS_URL);
}
redirect_to(INDEX_URL);
?>