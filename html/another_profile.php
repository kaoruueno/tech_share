<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions_m.php';
require_once MODEL_PATH . 'db_m.php';
require_once MODEL_PATH . 'user_m.php';
require_once MODEL_PATH . 'article_m.php';
require_once MODEL_PATH . 'profile_m.php';
// header('X-FRAME-OPTIONS: DENY');

session_start();

$db = get_db_connect();

$user = get_login_user($db);
if ($user === false) {
  redirect_to(LOGOUT_URL);
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  if (PREVIOUS_URL !== null) {
    redirect_to(PREVIOUS_URL);
  }
  redirect_to(INDEX_URL);
}
$another_user_id = get_get('user');
$followings = get_get('followings');
$followers = get_get('followers');
$own_posts = get_get('own_posts');
$favorite_posts = get_get('favorite_posts');
$favorite_languages = get_get('favorite_languages');

if (is_valid_another_user_id($db, $user, $another_user_id) === false) {
  if (PREVIOUS_URL !== null) {
    redirect_to(PREVIOUS_URL);
  }
  redirect_to(INDEX_URL);
}

$another_user = get_accessed_another_user($db, $another_user_id);

// GETリクエストの種類を判別し、番号で取得する
$get_link = get_valid_get_profile_data($followings, $followers, $own_posts, $favorite_posts, $favorite_languages);


// GETリクエストに対するプロフィール関係のボタンのデザインを取得する
$button = get_profile_link_button($get_link);

// GETリクエストに対するレスポンス内容を取得
$response_link = get_result_requested_profile_link($db, $another_user, $get_link);


// フォロー中のcountとフォロワーのcountをDBから取得する
$follow_count = get_count_followings_and_followers($db, $another_user);

if (has_post_session() === true) {
  set_post_warning('記事の投稿が中断されました。ブラウザを閉じると、中断されたデータは破棄されます。');
}
// $token = get_csrf_token();
include_once VIEW_PATH . 'another_profile_v.php';
?>






<!-- if (set_new_accessed_another_user_session($get_another_user_id, $another_user_session) === false) {
  if (PREVIOUS_URL !== null) {
    redirect_to(PREVIOUS_URL);
  }
  redirect_to(INDEX_URL);
}



  // ある

  // ない 
  // get_get('user')の値でユーザー情報を取得
    // ある
    // get_get('user')の値をセッションに格納
  
    // ない
    // falseで前のページにリダイレクト


$followings = get_get('followings');
$followers = get_get('followers');
$own_posts = get_get('own_posts');
$favorite_posts = get_get('favorite_posts');
$favorite_languages = get_get('favorite_languages');

// GETリクエストの種類を判別し、番号で取得する
$get_link = get_valid_get_profile_data($followings, $followers, $own_posts, $favorite_posts, $favorite_languages);
// GETリクエストに対するプロフィール関係のボタンのデザインを取得する
$button = get_my_profile_link_button($get_link);
// GETリクエストに対するレスポンス内容を取得
$response_link = get_result_requested_my_profile_link($db, $user, $get_link);

// フォロー中のcountとフォロワーのcountをDBから取得する
$follow_count = get_count_followings_and_followers($db, $user);

if (has_post_session() === true) {
  set_post_warning('記事の投稿が中断されました。ブラウザを閉じると、中断されたデータは破棄されます。');
}
// $token = get_csrf_token();
include_once VIEW_PATH . 'another_profile_v.php'; -->