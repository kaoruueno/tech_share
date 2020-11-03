<?php
function get_user($db, $user_id, $is_another_user = false) {
  $params = [
    $user_id
  ];
  $sql = 'SELECT user_id, user_name';
  if ($is_another_user === false) {
    $sql .= ', password, user_type';
  }
  $sql .= '
          FROM users_t
          WHERE user_id = ?
          LIMIT 1';

          
  return fetch_query($db, $sql, $params);
}

function get_users($db, $display_order = 0) {
  $params = [];
  $sql = 'SELECT user_id, user_name
          FROM users_t';
  if ($display_order === 0) {
    $sql .= ' ORDER BY user_id DESC';
  } else {
    $sql .= ' ORDER BY user_id';
  }
  return fetch_all_query($db, $sql, $params);
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

function login_as($db, $user_name, $password) {
  $password = get_password_for_guest($user_name, $password);
  $user = get_user_by_name($db, $user_name);
  // ログイン情報の照合(入力PWとハッシュ化PWの照合)
  if($user === false || password_verify($password, $user['password']) === false){
    return false;
  }
  set_session('user_id', $user['user_id']);
  return $user;
}

function get_password_for_guest($user_name, $password) {
  if ($user_name === GUEST_USER['user_name']) {
    $password = GUEST_USER['password'];
  }
  return $password;
}

function get_login_user($db){
  $user_id = get_session('user_id');
  if ($user_id === '') {
    return '';
  }
  return get_user($db, $user_id);
}



function register_user($db, $user_name, $password, $password_confirmation, $language_types) {
  if (is_valid_user($user_name, $password, $password_confirmation, $language_types) === false) {
    return false;
  }
  // パスワードのハッシュ化
  $password = password_hash($password, PASSWORD_DEFAULT);
  if ($language_types !== '') {
    return signup_transaction($db, $user_name, $password, $language_types);
  }
  return insert_user($db, $user_name, $password);
}

function is_admin($user) {
  if (isset($user['user_type']) === false) {
    return false;
  }
  return $user['user_type'] === USER_TYPE_ADMIN;
}

function is_valid_user($user_name, $password, $password_confirmation, $language_types) {
  // 短絡評価を避けるため一旦代入。
  $is_valid_user_name = is_valid_user_name($user_name);
  $is_valid_password = is_valid_password($password, $password_confirmation);
  $is_valid_password_confirmation = is_valid_password_confirmation($is_valid_password, $password, $password_confirmation);
  $is_valid_language_types = is_valid_language_types($language_types);
  return $is_valid_user_name && $is_valid_password && $is_valid_password_confirmation && $is_valid_language_types;
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

function is_valid_language_types($language_types) {
  if ($language_types === false) {
    return false;
  }
  if (is_array($language_types) === true) {
    foreach ($language_types as $key => $value) {
      if (is_language_type($value) === false) {
        return false;
      }
    }
    if (is_unique_value_array($language_types) === false) {
      return false;
    }
  }
  return true;
}

function signup_transaction($db, $user_name, $password, $language_types) {
  $is_false = [];
  $db->beginTransaction();
  $is_false[] = insert_user($db, $user_name, $password);
  $user_id = $db->lastInsertId('user_id');
  foreach ($language_types as $value) {
    $is_false[] = insert_favorite_language($db, $user_id, $value);
  }
  if (has_false($is_false) === false) {
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

function insert_favorite_language($db, $user_id, $language_type) {
  $params = [
    $user_id,
    $language_type
  ];
  $sql = 'INSERT INTO favorite_languages(user_id, language_type)
          VALUES (?, ?)';

  return execute_query($db, $sql, $params);
}

function is_own_post($db, $user, $post_id) {
  if (is_array($user) === false) {
    return false;
  }
  if (is_array(get_own_post($db, $post_id, $user['user_id'])) === false) {
    return false;
  }
  return true;
}
function get_own_post($db, $post_id, $user_id){
  $params = [
    $post_id,
    $user_id
  ];
  $sql = 'SELECT post_id
          FROM posts
          WHERE post_id = ?
          AND user_id = ?
          LIMIT 1';

  return fetch_query($db, $sql, $params);
}

function is_favorite_post($db, $user, $post_id) {
  if (is_array($user) === false) {
    return false;
  }
  if (is_array(get_favorite_post($db, $user['user_id'], $post_id)) === false) {
    return false;
  }
  return true;
}
function get_favorite_post($db, $user_id, $post_id){
  $params = [
    $user_id,
    $post_id
  ];
  $sql = 'SELECT post_id
          FROM favorite_posts
          WHERE user_id = ?
          AND post_id = ?
          LIMIT 1';

  return fetch_query($db, $sql, $params);
}

function is_register_post($db, $post_id) {
  if (is_array(get_register_post($db, $post_id)) === false) {
    return false;
  }
  return true;
}
function get_register_post($db, $post_id) {
  $params = [
    $post_id
  ];
  $sql = 'SELECT post_id
          FROM posts
          WHERE post_id = ?
          LIMIT 1';

  return fetch_query($db, $sql, $params);
}

function is_valid_post_id_for_favorite_post_register($db, $user, $post_id) {
  if ($post_id === false || $post_id === '') {
    return false;
  }
  if (is_positive_int($post_id) === false) {
    return false;
  }
  if (is_register_post($db, $post_id) === false) {
    return false;
  }
  if (is_own_post($db, $user, $post_id) === true) {
    return false;
  }
  if (is_favorite_post($db, $user, $post_id) === true) {
    return false;
  }
  return true;
}

function register_favorite_post($db, $user, $post_id) {
  $params = [
    $user['user_id'],
    $post_id
  ];
  $sql = 'INSERT INTO favorite_posts(user_id, post_id)
          VALUES (?, ?)';

  return execute_query($db, $sql, $params);
}

function is_valid_post_id_for_favorite_post_delete($db, $user, $post_id) {
  if ($post_id === false || $post_id === '') {
    return false;
  }
  if (is_positive_int($post_id) === false) {
    return false;
  }
  if (is_register_post($db, $post_id) === false) {
    return false;
  }
  if (is_favorite_post($db, $user, $post_id) === false) {
    return false;
  }
  return true;
}

function delete_favorite_post($db, $user, $post_id) {
  $params = [
    $user['user_id'],
    $post_id
  ];
  $sql = 'DELETE FROM favorite_posts
          WHERE user_id = ?
          AND post_id = ?';

  return execute_query($db, $sql, $params);
}

function is_following_user($db, $user, $follower_id) {
  if (is_array($user) === false) {
    return false;
  }
  if (is_array(get_following_user($db, $user['user_id'], $follower_id)) === false) {
    return false;
  }
  return true;
}
function get_following_user($db, $user_id, $follower_id){
  $params = [
    $user_id,
    $follower_id
  ];
  $sql = 'SELECT follower_id
          FROM following_users
          WHERE user_id = ?
          AND follower_id = ?
          LIMIT 1';

  return fetch_query($db, $sql, $params);
}

function is_own_user($user, $target_user_id) {
  if (is_array($user) === false) {
    return false;
  }
  if ($user['user_id'] !== (int)$target_user_id) {
    return false;
  }
  return true;
}

function is_register_user($db, $user_id) {
  if (is_array(get_register_user($db, $user_id)) === false) {
    return false;
  }
  return true;
}
function get_register_user($db, $user_id) {
  $params = [
    $user_id
  ];
  $sql = 'SELECT user_id
          FROM users_t
          WHERE user_id = ?
          LIMIT 1';

  return fetch_query($db, $sql, $params);
}

function is_valid_follower_id_for_following_user_register($db, $user, $follower_id) {
  if ($follower_id === false || $follower_id === '') {
    return false;
  }
  if (is_positive_int($follower_id) === false) {
    return false;
  }
  if (is_register_user($db, $follower_id) === false) {
    return false;
  }
  if (is_own_user($user, $follower_id) === true) {
    return false;
  }
  if (is_following_user($db, $user, $follower_id) === true) {
    return false;
  }
  return true;
}

function register_following_user($db, $user, $follower_id) {
  $params = [
    $user['user_id'],
    $follower_id
  ];
  $sql = 'INSERT INTO following_users(user_id, follower_id)
          VALUES (?, ?)';

  return execute_query($db, $sql, $params);
}

function is_valid_follower_id_for_following_user_delete($db, $user, $follower_id) {
  if ($follower_id === false || $follower_id === '') {
    return false;
  }
  if (is_positive_int($follower_id) === false) {
    return false;
  }
  if (is_register_user($db, $follower_id) === false) {
    return false;
  }
  if (is_following_user($db, $user, $follower_id) === false) {
    return false;
  }
  return true;
}

function delete_following_user($db, $user, $follower_id) {
  $params = [
    $user['user_id'],
    $follower_id
  ];
  $sql = 'DELETE FROM following_users
          WHERE user_id = ?
          AND follower_id = ?';

  return execute_query($db, $sql, $params);
}
?>