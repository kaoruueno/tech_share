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
if ($user === '') {
  if (PREVIOUS_URL !== null) {
    redirect_to(PREVIOUS_URL);
  }
  redirect_to(INDEX_URL);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $post_id = get_post('post_id');
  if (is_valid_post_id_for_favorite_post_delete($db, $user, $post_id) === false) {
    redirect_to(PREVIOUS_URL);
  }
  if (delete_favorite_post($db, $user, $post_id) === false) {
    set_error('指定した記事のお気に入りからの解除に失敗しました。再度お試し下さい。');
    redirect_to(PREVIOUS_URL);
  }
  set_message('指定した記事をお気に入りから解除しました');
}
redirect_to(PREVIOUS_URL);
?>