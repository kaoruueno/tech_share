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
  redirect_to(POST_URL);
}

// プレビューボタンが押されたときの処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = get_post('title');
  $title_img = get_file('title_image');
	$text = get_post_array('texts');
  $img = get_file_array('images');
  $language_type = get_post('language_type');

  $token = get_post('token');

  if (is_valid_csrf_token($token) === false) {
    redirect_to(LOGOUT_URL);
  }

  // $textのバリデーション 失敗した場合、set_error、redirect_to
  $title_img_file = get_title_img_file_name_post($title_img);
  $img_file = get_img_file_name_post($img);
  // $title	$text $img $title_img $file $language_typeをバリデーションしたものに「false」がなければ、次の処理
  list($title, $text) = validate_post_data_post($title, $title_img, $title_img_file, $text, $img, $img_file, $language_type);

// 	foreach ($text as $key => $value) {
//     if ($value !== '') {
//       $body .= $value . "\n";
//     }
    
// 		if ($img['tmp_name'][$key] === '') {
// 			continue;
//     }
    
// // 関数化完了
// 		if (is_uploaded_file($img['tmp_name'][$key]) === false) {
// 			set_error('アップロード方法が不正です');
// 			redirect_to(POST_URL);
// 		}
// 		$file_type = mime_content_type($img['tmp_name'][$key]);
// 		$ext = '';
// 		if ($file_type === 'image/png') {
// 			$ext = '.png';
// 		} else if ($file_type === 'image/jpeg') {
// 			$ext = '.jpg';
// 		} else {
// 			// （エラー文のファイル形式は後で変更）
// 			set_error('ファイル形式が異なります。画像ファイルはJPEG、PNGのみ利用可能');
// 			redirect_to(POST_URL);
// 		}
//     $file[$key] = ['file_name' => $key . $ext, 'ext' => $ext];
// // 関数化完了

  $body = get_body_post($text, $img_file);
    // $body .= '[' . $file[$key] . ']' . "\n";

// 
// }

  set_post_data_session_post($title_img, $title_img_file, $img, $img_file, $title, $body, $language_type);
  // if (isset($file) === true) {
  //   foreach ($file as $key => $value) {
  //     if (move_uploaded_file($img['tmp_name'][$key], PRE_IMAGE_DIR . $value) !== true) {
  //       set_error('ファイルアップロードに失敗しました');
  //       redirect_to(POST_URL);
  //     }
  //   }
  //   // $body,$imgをセッションに入れる(他のページに遷移したら削除)
  //   $_SESSION['file'] = $file;
  // }
  
  // $_SESSION['title'] = $title;
  // $_SESSION['body'] = $body;

  $pre_title = get_pre_title_post($title);
  $pre_title_img_file = get_pre_title_img_post($title_img_file);
  $pre_body = get_pre_body_post($body);

} else {
  $title = get_session('title');
  $title_img_file = get_session('title_img_file');
  $body = get_session('body');
  $img_file = get_session('img_file');
  $language_type = get_session('language_type');
  if (is_valid_post_data_session($title, $body) === false) {
    redirect_to(POST_URL);
  }
  $pre_title = get_pre_title_post($title);
  $pre_title_img_file = get_pre_title_img_post($title_img_file);
  $pre_body = get_pre_body_post($body);
}
$token = get_csrf_token();
include_once VIEW_PATH . 'post_pre_v.php';
?>