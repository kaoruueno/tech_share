<?php
function get_title_img_file_name_post($title_img) {
  if ($title_img === false) {
    return false;
  }
  if ($title_img === '') {
    return '';
  }
  return get_upload_file_name($title_img);
}

function get_img_file_name_post($img) {
  if ($img === false) {
    return false;
  }
  if ($img === '') {
    return '';
  }
  foreach ($img['tmp_name'] as $key => $value) {
    if ($value !== '') {
      $img_file[$key] = get_upload_file_name_array($img, $key);
    }
  }
  if (isset($img_file) === false) {
    return '';
  }
  if (in_array(false, $img_file, true) === true) {
    return false;
  }
  return $img_file;
}

function validate_post_data_post($title, $title_img, $title_img_file, $text, $img, $img_file, $language_type) {
  $title = is_valid_title_post($title);
  $text = is_valid_text_post($text);
  $language_type = is_valid_language_type_post($language_type);  
  if ($title === false || $title_img === false || $title_img_file === false || $text === false || $img === false || $img_file === false || $language_type === false) {
    delete_post_data_session();
    set_error('プレビューに失敗しました');
    redirect_to(POST_URL);
  }
  return [$title, $text];
}

function is_valid_title_post($title) {
  if ($title === false) {
    return false;
  }
  if (trim_only_space_str($title) === '') {
    set_error('タイトルを入力して下さい');
    return false;
    // redirect_to(POST_URL);
  }
  $title = trim_both_ends_space($title);
  if (mb_strlen($title) > 80) {
    set_error('タイトルは80文字以内で入力して下さい');
    return false;
  }
  return $title;
}

function is_valid_text_post($text) {
  if (is_array($text) === true) {
    foreach ($text as $key => $value) {
      $text[$key] = trim_only_space_str($value);
    }
    foreach ($text as $key => $value) {
      if ($value !== '') {
        return $text;
      }
    }
    set_error('本文を入力して下さい');
  }
  if ($text === '') {
    set_error('本文を入力して下さい');
  }
  return false;
}

function is_valid_language_type_post($language_type) {
  if ($language_type === '') {
    return '';
  }
  if ($language_type === false) {
    return false;
  }  
  if (is_language_type($language_type) === false) {
    return false;
  }
  return $language_type;
}

function get_body_post($text, $img_file) {
  $body = '';
  foreach ($text as $key => $value) {
    if ($value !== '') {
      $body .= $value . "\n";
    }
    if (isset($img_file[$key]) === true) {
      $body .= '[' . $img_file[$key] . ']' . "\n";
    }
  }
  return $body;
}

function set_post_data_session_post($title_img, $title_img_file, $img, $img_file, $title, $body, $language_type) {
  if ($title_img_file !== '') {
    save_image_post($title_img, $title_img_file);
  }
  if ($img_file !== '') {
    save_image_array_post($img, $img_file);
  }
  if (has_error() === true) {
    set_error('プレビューに失敗しました');
    redirect_to(POST_URL);
  }
  set_session('title', $title);
  if ($title_img_file !== '') {
    set_session('title_img_file', $title_img_file);
  }
  set_session('body', $body);
  if ($img_file !== '') {
    set_session('img_file', $img_file);
  }
  if ($language_type !== '') {
    set_session('language_type', $language_type);
  }
}

function save_image_post($title_img, $title_img_file){
  if (move_uploaded_file($title_img['tmp_name'], PRE_TITLE_IMAGE_DIR . $title_img_file) !== true) {
    set_error('タイトル画像のファイルアップロードに失敗しました');
  }
}

function save_image_array_post($img, $img_file){
  foreach ($img_file as $key => $value) {
    if (move_uploaded_file($img['tmp_name'][$key], PRE_IMAGE_DIR . $value) !== true) {
      set_error('記事中の画像用フォームの' . ($key + 1) . '番目のファイルアップロードに失敗しました');
    }
  }
}


function get_pre_title_post($title) {
  return '<h5>タイトル:</h5>'."\n".'<h3>' . h($title) . '</h3>'."\n";
}

function get_pre_title_img_post($title_img_file) {
  if ($title_img_file !== '') {
    return '<h5>タイトル画像:</h5>'."\n".'<div><img src="'. PRE_TITLE_IMAGE_PATH . h($title_img_file) . '"></div>'."\n";
  }
  return $pre_title_img_file = '';
}

function get_pre_body_post($body) {
  // プレビューで表示する$bodyをエスケープ
  // $_SESSION['body']の　[画像ファイル名.拡張子]　の箇所を下の形の変換する
  // '<div><img src="'. PRE_IMAGE_PATH . 画像ファイル名.拡張子 . '"></div>'


  // $replacement = '<div><img src="'. PRE_IMAGE_PATH . '$1$2"></div>'."\n";
  return '<h5>投稿内容:</h5>' . "\n" . preg_replace(REGEX_IMAGE, '<div><img src="'. PRE_IMAGE_PATH . '$1$2"></div>', h($body));
}

function is_valid_post_register_data_post($title, $body, $language_type) {
  if (is_valid_post_data_session($title, $body) === false) {
    return false;
  }
  if (is_valid_language_type_post($language_type) === false) {
    delete_post_data_session();
    return false;
  }
  if (is_valid_language_type_post($language_type) === '') {
    set_error('記事のジャンルを選択して下さい');
    return '';
  }
  return true;
}

function move_title_img_valid_dir_post($title_img_file) {
  if ($title_img_file !== '') {
    if (rename(PRE_TITLE_IMAGE_DIR . $title_img_file, TITLE_IMAGE_DIR . $title_img_file) === false) {
      set_error('タイトル画像の保存に失敗しました');
    }
  }
}

function move_img_valid_dir_post($img_file) {
  if ($img_file !== '') {
    $i = 1;
    foreach ($img_file as $key => $value) {
      if (rename(PRE_IMAGE_DIR . $value, IMAGE_DIR . $value) === false) {
        set_error('記事中の' . $i . '番目の画像の保存に失敗しました');
      }
      $i++;
    }
  }
}

function register_post($db, $user_id, $title, $title_img_file, $body, $language_type) {
  $params = [
    $user_id,
    $title,
    $title_img_file,
    $body,
    $language_type
  ];
  $sql = 'INSERT INTO posts(user_id, title, title_image, body, language_type)
          VALUES (?, ?, ?, ?, ?)';

  return execute_query($db, $sql, $params);
}
// // 仮
// function get_post_data_trim_space($key) {
//   $str = '';
//   if (isset($_POST[$key]) === TRUE) {
//     $str = $_POST[$key];
//   }
//   return preg_replace('/^[\s　]*(.*?)[\s　]*$/u', '$1', $str);
// }

// /**
// * POSTデータから「0以上の整数のテキスト」データのバリデーションをする
// */
// function validation_post_positive_int_data_admin($pattern_positive_int, $subject_int, $japanese_int) {
    
//   global $err_msg;
//   if ($subject_int === '') {
//     return false;
//   } else if (preg_match($pattern_positive_int, $subject_int) !== 1){
//       $err_msg[] = $japanese_int . 'は0以上の整数(半角数字)で入力して下さい';
//   } else if (mb_strlen ($subject_int, "UTF-8") > 10){
//       $err_msg[] = $japanese_int . 'は10桁以内で入力して下さい';
//   }
// }
// set_error('ファイル形式が不正です。');
// /**
// * POSTデータから「セレクトボックス」データのバリデーションをする
// */
// function validation_post_select_box_admin($pattern_selection, $subject_selection, $msg) {
  
//   global $err_msg;
//   if ($subject_selection === '') {
//       $err_msg[] = $msg;
//   } else if (preg_match($pattern_selection, $subject_selection) !== 1){
//       $err_msg[] = '処理が不正です';
//   }
// }
?>