<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions_m.php';
require_once MODEL_PATH . 'db_m.php';
require_once MODEL_PATH . 'user_m.php';
require_once MODEL_PATH . 'post_m.php';

session_start();

$db = get_db_connect();

$user = get_login_user($db);
if ($user === false) {
  redirect_to(LOGOUT_URL);
}
if ($user === '') {
  redirect_to(POST_URL);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  delete_post_data_session();
  redirect_to(INDEX_URL);
}

$title = get_session('title');
$title_img_file = get_session('title_img_file');
$body = get_session('body');
$img_file = get_session('img_file');
$language_type = get_post('language_type');

if (is_valid_post_register_data_post($title, $body, $language_type) === false) {
  redirect_to(POST_URL);
} else if (is_valid_post_register_data_post($title, $body, $language_type) === '') {
  set_error('記事のジャンルを選択して下さい');
  redirect_to(POST_PRE_URL);
}

move_title_img_valid_dir_post($title_img_file);
move_img_valid_dir_post($img_file);
if (has_error() === true) {
  set_error('投稿に失敗しました。再度お試し下さい。');
  redirect_to(POST_URL);
}

// DBに$title, $title_img_file, $body, $language_typeを登録
if (register_post($db, $user['user_id'], $title, $title_img_file, $body, $language_type)=== false) {
  set_error('投稿に失敗しました。再度お試し下さい。');
  redirect_to(POST_URL);
}
set_message('記事の投稿が完了しました。ご利用ありがとうございます。');
delete_post_data_session();
redirect_to(INDEX_URL);
?>