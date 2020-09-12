<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions_m.php';
require_once MODEL_PATH . 'post_m.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  delete_post_data_session();
  redirect_to(INDEX_URL);
}

$title = get_session('title');
$tmb_img_file = get_session('tmb_img_file');
$body = get_session('body');
$img_file = get_session('img_file');
if (is_valid_post_data_session_post($title, $body) === false) {
  delete_post_data_session();
  redirect_to(POST_URL);
}


move_tmb_img_valid_dir_post($tmb_img_file);
move_img_valid_dir_post($img_file);
delete_post_data_session();
if (has_error() === true) {
  set_error('投稿に失敗しました。再度お試し下さい。');
  redirect_to(POST_URL);
}

// DBに$bodyを登録



// 成功した場合
redirect_to(INDEX_URL);



// if ($file !== '') {
//   foreach ($file as $key => $value) {
//     $random_file_name = get_random_string() . $value['ext'];
//     // $_SESSION['body']の　[画像ファイル名.拡張子]　の箇所を　[ランダム文字.拡張子]　にする
//     $body = preg_replace(REGEX_PRE_IMAGE, '['. $random_file_name . ']', $body, 1);
//     // pre_imagesフォルダにあるプレビューで表示した画像を、imagesフォルダにランダム文字に変更して移動する
//     rename(PRE_IMAGE_PATH . $value, IMAGE_PATH . $random_file_name);
//   }
// }

// $bodyに$_SESSION['body']を代入し、unset($_SESSION['body']);unset($_SESSION['img']);でセッション削除





// 記事を表示するページで処理
// bodyをエスケープ

// bodyの　[画像ファイル名.拡張子]　の箇所を下の形の変換する
// '<div><img src="'. IMAGE_PATH . 画像ファイル名.拡張子 . '"></div>'  

// white-space: pre;のdivにbodyを出力

// post_insert.phpの処理




?>