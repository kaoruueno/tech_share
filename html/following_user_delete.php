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
if ($user === '') {
  if (PREVIOUS_URL !== null) {
    redirect_to(PREVIOUS_URL);
  }
  redirect_to(INDEX_URL);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $follower_id = get_post('follower_id');
  if (is_valid_follower_id_for_following_user_delete($db, $user, $follower_id) === false) {
    redirect_to(PREVIOUS_URL);
  }
  $follower = get_user($db, $follower_id);
  if (delete_following_user($db, $user, $follower_id) === false) {
    set_error($follower['user_name'] . 'さんへのフォローの解除に失敗しました。再度お試し下さい。');
    redirect_to(PREVIOUS_URL);
  }
  set_message($follower['user_name'] . 'さんへのフォローを解除しました');
}
redirect_to(PREVIOUS_URL);
?>