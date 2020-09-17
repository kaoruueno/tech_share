<?php
function get_user($db, $user_id){
  $params = [
    $user_id
  ];
  $sql = "
    SELECT
      user_id, 
      user_name,
      password,
      user_type
    FROM
      users_t
    WHERE
      user_id = ?
    LIMIT 1
  ";

  return fetch_query($db, $sql, $params);
}

function get_user_by_name($db, $user_name){
  $params = [
    $user_name
  ];
  $sql = "
    SELECT
      user_id, 
      user_name,
      password,
      user_type
    FROM
      users_t
    WHERE
      user_name = ?
    LIMIT 1
  ";

  return fetch_query($db, $sql, $params);
}

function login_as($db, $user_name, $password){
  $user = get_user_by_name($db, $user_name);
  // ログイン情報の照合(入力PWとハッシュ化PWの照合も実装)
  if($user === false || password_verify($password, $user['password']) === false){
    return false;
  }
  set_session('user_id', $user['user_id']);
  return $user;
}

function get_login_user($db){
  $user_id = get_session('user_id');
  if ($user_id === '') {
    return '';
  }
  return get_user($db, $user_id);
}



function register_user($db, $user_name, $password, $password_confirmation, $language_type) {
  if (is_valid_user($user_name, $password, $password_confirmation, $language_type) === false) {
    return false;
  }
  // パスワードのハッシュ化
  $password = password_hash($password, PASSWORD_DEFAULT);
  if ($language_type !== '') {
    return signup_transaction($db, $user_name, $password, $language_type);
  }
  return insert_user($db, $user_name, $password);
}

function is_admin($user){
  return $user['type'] === USER_TYPE_ADMIN;
}

function is_valid_user($user_name, $password, $password_confirmation, $language_type) {
  // 短絡評価を避けるため一旦代入。
  $is_valid_user_name = is_valid_user_name($user_name);
  $is_valid_password = is_valid_password($password, $password_confirmation);
  $is_valid_password_confirmation = is_valid_password_confirmation($is_valid_password, $password, $password_confirmation);
  $is_valid_language_type = is_valid_language_type($language_type);
  return $is_valid_user_name && $is_valid_password && $is_valid_password_confirmation && $is_valid_language_type;
}

function is_valid_user_name($user_name) {
  $is_valid = true;
  if ($user_name === false) {
    return false;
  }
  if (is_valid_length($user_name, USER_NAME_LENGTH_MIN, USER_NAME_LENGTH_MAX) === false) {
    set_error('ユーザー名は'. USER_NAME_LENGTH_MIN . '文字以上、' . USER_NAME_LENGTH_MAX . '文字以内にして下さい。');
    $is_valid = false;
  }
  if (is_alphanumeric($user_name) === false) {
    set_error('ユーザー名は半角英数字で入力して下さい。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_password($password, $password_confirmation){
  $is_valid = true;
  if ($password === false) {
    return false;
  }
  if (is_valid_length($password, USER_PASSWORD_LENGTH_MIN, USER_PASSWORD_LENGTH_MAX) === false) {
    set_error('パスワードは'. USER_PASSWORD_LENGTH_MIN . '文字以上、' . USER_PASSWORD_LENGTH_MAX . '文字以内にして下さい。');
    $is_valid = false;
  }
  if (is_alphanumeric($password) === false) {
    set_error('パスワードは半角英数字で入力して下さい。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_password_confirmation($is_valid_password, $password, $password_confirmation) {
  $is_valid = true;
  if ($is_valid_password === false || $password_confirmation === false) {
    return false;
  }
  if ($password !== $password_confirmation) {
    set_error('パスワードがパスワード(確認用)と一致しません。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_language_type($language_type) {
  if ($language_type === false) {
    return false;
  }
  if (is_array($language_type) === true) {
    foreach ($language_type as $key => $value) {
      if (is_language_type($value) === false) {
        return false;
      }
    }
  }
  return true;
}

function signup_transaction($db, $user_name, $password, $language_type) {
  $db->beginTransaction();
  insert_user($db, $user_name, $password);
  $user_id = $db->lastInsertId('user_id');
  foreach ($language_type as $value) {
    insert_favorite_languages($db, $user_id, $value);
  }
  if (has_error() === false) {
    $db->commit();
    return true;
  } else {
    $db->rollback();
    return false; 
  }
}

function insert_user($db, $user_name, $password){
  $params = [
    $user_name,
    $password
  ];
  $sql = 'INSERT INTO users_t(user_name, password)
          VALUES (?, ?)';

  return execute_query($db, $sql, $params);
}

function insert_favorite_languages($db, $user_id, $language_type){
  $params = [
    $user_id,
    $language_type
  ];
  $sql = 'INSERT INTO favorite_languages(user_id, language_type)
          VALUES (?, ?)';

  return execute_query($db, $sql, $params);
}
?>