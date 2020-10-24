<?php
function dd($var){
  var_dump($var);
  exit();
}

function redirect_to($url){
  header('Location: ' . $url);
  exit;
}

function get_get($name){
  if (isset($_GET[$name]) === false){
    return false;
  }
  if ($_GET[$name] === ''){
    return '';
  }
  return $_GET[$name];
}

function get_post($name){
  if (isset($_POST[$name]) === false){
    return false;
  }
  if ($_POST[$name] === ''){
    return '';
  }
  return $_POST[$name];
}


function get_post_array($name) {
  if (is_array($_POST[$name]) === false) {
    return false;
  }
  foreach ($_POST[$name] as $key => $value) {
    if (isset($value) === false) {
      return false;
    }
    if ($value === '') {
      continue;
    }
    return $_POST[$name];
  }
  return '';
}

function get_file($name){
  if (isset($_FILES[$name]['tmp_name']) === false) {
    return false;
  }
  if ($_FILES[$name]['tmp_name'] === '') {
    return '';
  }  
  return $_FILES[$name];
}

function get_file_array($name){
  if (is_array($_FILES[$name]['tmp_name']) === false) {
    return false;
  }
  foreach ($_FILES[$name]['tmp_name'] as $key => $value) {
    if (isset($value) === false) {
      return false;
    }
    if ($value === '') {
      continue;
    }
    return $_FILES[$name];
  }
  return '';
}

function get_post_checkbox($name) {
  if (isset($_POST[$name]) === false) {
    return false;
  }
  if ($_POST[$name] === ''){
    return '';
  }
  if (is_array($_POST[$name]) === false) {
    return false;
  }
  foreach ($_POST[$name] as $key => $value) {
    if (isset($value) === false) {
      return false;
    }
  }
  return $_POST[$name];
}

function get_session($name){
  if(isset($_SESSION[$name]) === true){
    return $_SESSION[$name];
  }
  return '';
}

function set_session($name, $value){
  $_SESSION[$name] = $value;
}

function delete_session($name) {
  if(isset($_SESSION[$name]) === true){
    unset($_SESSION[$name]);
  }
}

function delete_post_data_session() {
  delete_session('title');
  delete_session('title_img_file');
  delete_session('body');
  delete_session('img_file');
  delete_session('language_type');
}

function set_error($error){
  $_SESSION['__errors'][] = $error;
}

function get_errors(){
  $errors = get_session('__errors');
  if($errors === ''){
    return array();
  }
  set_session('__errors',  array());
  return $errors;
}

function has_error(){
  return isset($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0;
}

function set_message($message){
  $_SESSION['__messages'][] = $message;
}

function get_messages(){
  $messages = get_session('__messages');
  if($messages === ''){
    return array();
  }
  set_session('__messages',  array());
  return $messages;
}

function set_login_warning($warning) {
  $_SESSION['__login_warnings'][] = $warning;
}

function get_login_warnings() {
  $warnings = get_session('__login_warnings');
  if ($warnings === '') {
    return array();
  }
  unset($_SESSION['__login_warnings']);
  return $warnings;
}


function set_post_warning($warning) {
  $_SESSION['__post_warnings'][] = $warning;
}

function get_post_warnings() {
  $warnings = get_session('__post_warnings');
  if ($warnings === '') {
    return array();
  }
  unset($_SESSION['__post_warnings']);
  return $warnings;
}

function has_post_session() {
  $title = get_session('title');
  $body = get_session('body');
  return is_valid_post_data_session($title, $body);
}

function is_valid_post_data_session($title, $body) {
  if ($body === '' || $title === '') {
    delete_post_data_session();
    return false;  
  }
  return true;
}

function is_logined() {
  return get_session('user_id') !== '';
}

function get_random_string($length = 20){
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}

function save_image($img, $img_file){
  if (move_uploaded_file($img['tmp_name'], PRE_TITLE_IMAGE_DIR . $img_file) !== true) {
    set_error('ファイルアップロードに失敗しました');
  }
}

function save_image_array($img, $img_file){
  foreach ($img_file as $key => $value) {
    if (move_uploaded_file($img['tmp_name'][$key], PRE_IMAGE_DIR . $value) !== true) {
      set_error('ファイルアップロードに失敗しました');
    }
  }
}


function is_valid_length($string, $min_length, $max_length = PHP_INT_MAX){
  $length = mb_strlen($string);
  return ($min_length <= $length) && ($length <= $max_length);
}

function is_alphanumeric($string){
  return is_valid_format($string, REGEX_ALPHANUMERIC);
}

function is_positive_int($string){
  return is_valid_format($string, REGEX_POSITIVE_INT);
}

function is_language_type($string){
  return is_valid_format($string, REGEX_LANGUAGE_TYPE);
}

function is_display_order($string) {
  return is_valid_format($string, REGEX_DISPLAY_ORDER);
}

function is_sort_by_newest($string) {
  return is_sort_by_oldest($string) !== true;
}
function is_sort_by_oldest($string) {
  return is_valid_format($string, REGEX_SORT_BY_OLDEST);
}

function is_valid_format($string, $format){
  return preg_match($format, $string) === 1;
}


function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function trim_only_space_str($str) {
  return preg_replace(REGEX_WHITE_SPACE, '', $str);
}

function trim_both_ends_space($str) {
  return preg_replace(REGEX_BOTH_ENDS_WHITE_SPACE, '$1', $str);
}

// タイトル画像用

function get_upload_file_name($title_img) {
  if (is_uploaded_file($title_img['tmp_name']) === false) {
    return false;
  }
  $ext = get_upload_file_ext($title_img);
  if ($ext === false) {
    return false;
  }
  return get_random_string(10) . $ext;
}

function get_upload_file_ext($title_img) {
  $file_type = mime_content_type($title_img['tmp_name']);
  if ($file_type === 'image/png') {
    return '.png';
  } else if ($file_type === 'image/jpeg') {
    return '.jpg';
  } else {
    // （エラー文のファイル形式は後で変更）
    set_error('タイトル画像のファイル形式が異なります。画像ファイルはJPEG、PNGのみ利用可能');
    return false;
  }
}

// 本文用

function get_upload_file_name_array($img, $key) {
  if (is_uploaded_file($img['tmp_name'][$key]) === false) {
    return false;
  }
  $ext = get_upload_file_ext_array($img, $key);
  if ($ext === false) {
    return false;
  }
  return get_random_string(10) . $ext;
}

function get_upload_file_ext_array($img, $key) {
  $file_type = mime_content_type($img['tmp_name'][$key]);
  if ($file_type === 'image/png') {
    return '.png';
  } else if ($file_type === 'image/jpeg') {
    return '.jpg';
  } else {
    // （エラー文のファイル形式は後で変更）
    set_error('記事中の画像用フォームの' . ($key + 1) . '番目のファイル形式が異なります。画像ファイルはJPEG、PNGのみ利用可能');
    return false;
  }
}

function is_unique_value_array($array) {
  $unique_array = [];
  foreach($array as $key => $value) {
    if (in_array($value, $unique_array, true) === true) {
      return false;
    }
    $unique_array[$key] = $value;
  }
  return true;
}

function convert_unique_value_array($array) {
  $unique_array = [];
  foreach($array as $key => $value) {
    if (in_array($value, $unique_array, true) === false) {
      $unique_array[$key] = $value;
    }
  }
  return $unique_array;
}

function is_even($int) {
  if ($int % 2 === 0) {
    return true;
  }
  return false;
}
?>