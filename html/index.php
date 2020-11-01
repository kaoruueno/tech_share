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

$display_order = get_get('display_order');
$language_type = get_get('language_type');
$keyword = get_get('keyword');

$get_page = get_get('page');


// 検索条件をバリデーションしつつ正しい値に変更
$get_search = get_valid_search_criteria_for_index($db, $display_order, $language_type, $keyword);

// ページネーション関係
$pagination = get_pagination_data_for_index($db, $get_page, $get_search['display_order'], $get_search['language_type'], $get_search['keyword_array'], $get_search['keyword_str']);

// 検索条件に当てはまる記事を取得
$articles = get_limited_searched_articles($db, $get_search['display_order'], $get_search['language_type'], $get_search['keyword_array'], $pagination['current_page']);

// 検索中の値を検索フォームに表示するためのselected
$display_order_selected = get_display_order_selected($get_search['display_order']);
$language_type_selected = get_language_type_selected($get_search['language_type']);
$keyword_selected = h($get_search['keyword_str']);
$display_keyword = entity_array(convert_display_search_keyword_array($get_search['keyword_str']));

// ページネーション

if (has_post_session() === true) {
  set_post_warning('記事の投稿が中断されました。右のボタンから投稿作業に戻れます。' . "<br>" . 'ブラウザを閉じると、中断された入力データは破棄されます。');
}
// $token = get_csrf_token();
include_once VIEW_PATH . 'index_v.php';
?>