<?php
function get_valid_get_profile_data($followings, $followers, $own_posts, $favorite_posts, $favorite_languages) {
  $count = [];
  if (is_valid_profile_data($followings) === true) {
    $count[] = PROFILE_LINK['followings'];
  }
  if (is_valid_profile_data($followers) === true) {
    $count[] = PROFILE_LINK['followers'];
  }
  if (is_valid_profile_data($own_posts) === true) {
    $count[] = PROFILE_LINK['own_posts'];
  }
  if (is_valid_profile_data($favorite_posts) === true) {
    $count[] = PROFILE_LINK['favorite_posts'];
  }
  if (is_valid_profile_data($favorite_languages) === true) {
    $count[] = PROFILE_LINK['favorite_languages'];
  }

  if (is_valid_count_get_profile_data($count) === true) {
    return $count[0];
  }
  return PROFILE_LINK['no_request'];
}
function is_valid_profile_data($profile_data) {
  // 「1」に指定したGETリクエストのURL変数を、バリデーション
  if ($profile_data === '1') {
    return true;
  }
  return false;
}
function is_valid_count_get_profile_data($count) {
  if (count($count) === 1) {
    return true;
  }
  return false;
}

function get_count_followings_and_followers($db, $user) {
  $count['followings'] = get_count_followings($db, $user);
  $count['followers'] = get_count_followers($db, $user);
  return $count;
}

function get_count_followings($db, $user) {
  $params = [
    $user['user_id']
  ];
  $sql = 'SELECT COUNT(follower_id)
          FROM following_users
          WHERE user_id = ?
          LIMIT 1';
  $result = fetch_query($db, $sql, $params);
  // if ($result === false) {
  //   return false;
  // }
  return $result['COUNT(follower_id)'];
}

function get_count_followers($db, $user) {
  $params = [
    $user['user_id']
  ];
  $sql = 'SELECT COUNT(user_id)
          FROM following_users
          WHERE follower_id = ?
          LIMIT 1';
  $result = fetch_query($db, $sql, $params);
  // if ($result === false) {
  //   return false;
  // }
  return $result['COUNT(user_id)'];
}

function get_result_requested_profile_link($db, $user, $get_link) {
  if ($get_link === PROFILE_LINK['no_request']) {
    return '';
  } else if ($get_link === PROFILE_LINK['followings']) {
    return get_followings($db, $user);
  } else if ($get_link === PROFILE_LINK['followers']) {
    return get_followers($db, $user);
  } else if ($get_link === PROFILE_LINK['own_posts']) {
    return get_own_posts($db, $user);
  } else if ($get_link === PROFILE_LINK['favorite_posts']) {
    return get_favorite_posts($db, $user);
  } else if ($get_link === PROFILE_LINK['favorite_languages']) {
    return get_favorite_languages_checked($db, $user);
  }
}

function get_followings($db, $user) {
  $params = [
    $user['user_id']
  ];
  $sql = 'SELECT users_t.user_id, user_name
          FROM users_t
            INNER JOIN following_users
            ON users_t.user_id = following_users.follower_id
          WHERE following_users.user_id = ?';
  return fetch_all_query($db, $sql, $params);
}

function get_followers($db, $user) {
  $params = [
    $user['user_id']
  ];
  $sql = 'SELECT users_t.user_id, user_name
          FROM users_t
            INNER JOIN following_users
            ON users_t.user_id = following_users.user_id
          WHERE following_users.follower_id = ?';
  return fetch_all_query($db, $sql, $params);
}

function get_own_posts($db, $user) {
  $own_posts = get_articles($db, $user['user_id']);
  return convert_shortened_articles($own_posts);
}

function get_favorite_posts($db, $user) {
  $post_ids = get_favorite_post_ids($db, $user);
  $favorite_posts = [];
  foreach ($post_ids as $value) {
    $favorite_posts[] = get_article($db, $value['post_id']);
  }
  return convert_shortened_articles($favorite_posts);
}
function get_favorite_post_ids($db, $user) {
  $params = [
    $user['user_id']
  ];
  $sql = 'SELECT post_id
          FROM favorite_posts
          WHERE user_id = ?';
  return fetch_all_query($db, $sql, $params);
}

function get_favorite_languages_checked($db, $user) {
  $params = [
    $user['user_id']
  ];
  $sql = 'SELECT language_type
          FROM favorite_languages
          WHERE user_id = ?';
  $favorite_languages = fetch_all_query($db, $sql, $params);
  // if ($favorite_languages === false) {
  //   return false;
  // }
  return convert_favorite_languages_checked($favorite_languages);
}
function convert_favorite_languages_checked($favorite_languages) {
  foreach (PERMITTED_LANGUAGE_TYPES as $key => $value) {
    $checked = '';
    foreach ($favorite_languages as $favorite_language) {
      if ($favorite_language['language_type'] === $key) {
        $checked = ' checked';
        break;
      }
    }
    $favorite_language_checked[$key] = $checked;
  }
  return $favorite_language_checked;
}

function change_favorite_languages_transaction($db, $user, $language_types) {
  $change_favorite_languages = get_favorite_languages_to_operate($db, $user, $language_types);
  if ($change_favorite_languages === []) {
    return '';
  }
  $db->beginTransaction();
  foreach ($change_favorite_languages as $key => $value) {
    if ($value === 'delete') {
      delete_favorite_language($db, $user['user_id'], $key);
    }
    if ($value === 'insert') {
      insert_favorite_language($db, $user['user_id'], $key);
    }
  }
  if (has_error() === false) {
    $db->commit();
    return true;
  } else {
    $db->rollback();
    return false; 
  }
}

function get_favorite_languages_to_operate($db, $user, $language_types) {
  $operation_array = [];
  foreach (PERMITTED_LANGUAGE_TYPES as $key => $value) {
    if (is_favorite_language($db, $user, $key) === true && is_permitted_language_types_array($language_types, $key) === false) {
      // 更新する(delete)
      $operation_array[$key] = 'delete';
    } else if (is_favorite_language($db, $user, $key) === false && is_permitted_language_types_array($language_types, $key) === true) {
      // 更新する(insert)
      $operation_array[$key] = 'insert';
    }
  }
  return $operation_array;
}

function is_favorite_language($db, $user, $language_type) {
  if (is_array($user) === false) {
    return false;
  }
  if (is_array(get_favorite_language($db, $user['user_id'], $language_type)) === false) {
    return false;
  }
  return true;
}
function get_favorite_language($db, $user_id, $language_type){
  $params = [
    $user_id,
    $language_type
  ];
  $sql = 'SELECT language_type
          FROM favorite_languages
          WHERE user_id = ?
          AND language_type = ?
          LIMIT 1';
  return fetch_query($db, $sql, $params);
}

// $language_typesの配列の要素にPERMITTED_LANGUAGE_TYPESのkey(値)があるかないか？
function is_permitted_language_types_array($language_types, $permitted_value) {
  if (is_array($language_types) === false) {
    return false;
  }
  // in_arrayの第3引数にtrueを指定せず、型比較しない(==比較)
  if (in_array($permitted_value, $language_types) === true) {
    return true;
  }
  return false;
}

function delete_favorite_language($db, $user_id, $language_type) {
  $params = [
    $user_id,
    $language_type
  ];
  $sql = 'DELETE FROM favorite_languages
          WHERE user_id = ?
          AND language_type = ?';

  return execute_query($db, $sql, $params);
}

function get_profile_link_button($get_link) {
  $button = [];
  foreach (PROFILE_LINK as $key => $value) {
    if ($value === PROFILE_LINK['no_request']) {
      continue;
    }
    $class = 'btn';
    $disabled = '';
  
    if ($value !== $get_link) {
      $class .= ' btn-outline-';
    } else {
      $class .= ' btn-';
    }

    if ($value === PROFILE_LINK['followings'] || $value === PROFILE_LINK['followers']) {
      $class .= 'dark';
    } else {
      $class .= 'success';
    }
    
    if ($value === $get_link && $get_link !== PROFILE_LINK['no_request']) {
      $class .= ' disabled';
      $disabled = ' tabindex="-1" aria-disabled="true"';
    }
    $button[$key]['class'] = $class;
    $button[$key]['disabled'] = $disabled;
  }
  return $button;
}

// 

function is_valid_another_user_id($db, $user, $another_user_id) {
  if ($another_user_id === false || $another_user_id === '') {
    return false;
  }
  if (is_positive_int($another_user_id) === false) {
    return false;
  }
  if (is_register_user($db, $another_user_id) === false) {
    return false;
  }
  if (is_own_user($user, $another_user_id) === true) {
    return false;
  }
  return true;
}

function get_accessed_another_user($db, $another_user_id, $is_another_user = true) {
  return get_user($db, $another_user_id, $is_another_user);
}
?>