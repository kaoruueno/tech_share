<?php
function get_articles($db, $display_order = 0, $language_type = '', $user_id = '', $keyword = []) {
  $params = [];
  $sql = '
    SELECT
      post_id, 
      posts.user_id,
      users_t.user_name,
      title,
      title_image,
      body,
      language_type,
      posts.created
    FROM
      posts
      INNER JOIN
        users_t
      ON
        posts.user_id = users_t.user_id
      WHERE 1
  ';
  if ($user_id !== '') {
    $params[] = $user_id;
    $sql .= ' AND posts.user_id = ?';
  }
  if ($language_type !== '') {
    $params[] = $language_type;
    $sql .= ' AND language_type = ?';
  }
  foreach ($keyword as $key => $value) {
    // プレースホルダ「?」の数だけ$paramsにバインドする値を代入する
    $params[] = $value;
    $params[] = $value;
    $params[] = $value;
    $sql .= ' AND (users_t.user_name LIKE ?
              OR title LIKE ?
              OR body LIKE ?)';
  }
  if ($display_order === 0) {
    $sql .= ' ORDER BY post_id DESC';
  } else {
    $sql .= ' ORDER BY post_id';
  }
  return fetch_all_query($db, $sql, $params);
}

function get_article($db, $post_id) {
  $params = [$post_id];
  $sql = '
    SELECT
      post_id, 
      posts.user_id,
      users_t.user_name,
      title,
      title_image,
      body,
      language_type,
      posts.created
    FROM
      posts
      INNER JOIN
        users_t
      ON
        posts.user_id = users_t.user_id
    WHERE
      post_id = ?
    LIMIT 1
  ';
  return fetch_query($db, $sql, $params);
}

// function get_items($db, $is_open = false){
//   $sql = '
//     SELECT
//       item_id, 
//       name,
//       stock,
//       price,
//       image,
//       status
//     FROM
//       items
//   ';
//   if($is_open === true){
//     $sql .= '
//       WHERE status = 1
//     ';
//   }

//   return fetch_all_query($db, $sql);
// }

function get_searched_articles($db, $display_order = 0, $language_type = '', $user_id = '', $keyword = []) {
// dd(get_articles($db, $display_order, $language_type, $user_id, $keyword));
  $articles = get_articles($db, $display_order, $language_type, $user_id, $keyword);
  return convert_shortened_articles($articles);
}
  
// function get_open_items($db){
//   return get_items($db, true);
// }

function convert_shortened_articles($articles) {
  foreach ($articles as $key => $value) {
    $value['title_image'] = get_title_img_for_index($value['title_image']);
    $value['body'] = get_body_for_index($value['body']);
    $articles[$key] = $value;
  }
  return $articles;
}

function get_title_img_for_index($title_img) {
  if ($title_img !== '') {
    $title_img = TITLE_IMAGE_PATH . $title_img;
  } else {
    $title_img = LOGO_PATH . NO_IMAGE;
  }
  return $title_img;
}

function get_body_for_index($body) {
  // preg_replaceで、$bodyの[画像.png]の部分を[画像]にする
  $body = preg_replace(REGEX_IMAGE, '[画像]', $body);
  if (mb_strlen($body) > 102) {
    // 記事を100文字以内の文字列に省略する
    $body = mb_substr($body, 0, 100, 'UTF-8') . '…' . "\n";
  }
  return $body;
}

function is_valid_post_id_for_article($db, $post_id) {
  if ($post_id === false || $post_id === '') {
    return false;
  }
  if (is_positive_int($post_id) === false) {
    return false;
  }
  if (is_register_post($db, $post_id) === false) {
    return false;
  }
  return true;
}

function get_article_for_article($article) {
  $article['title_image'] = get_title_img_for_article($article['title_image']);
  $article['body'] = get_body_for_article($article['body']);
  return $article;
}

function get_title_img_for_article($title_img) {
  if ($title_img !== '') {
    return TITLE_IMAGE_PATH . $title_img;
  }
  return '';
}

function get_body_for_article($body) {
  return preg_replace(REGEX_IMAGE, '<div><img src="'. IMAGE_PATH . '$1$2"></div>', $body);
}

function get_valid_search_criteria_for_admin($db, $display_order, $language_type, $user_id) {
  $search_criteria = [];
  if (is_sort_by_newest($display_order) === false) {
    $display_order = 1;
  } else {
    $display_order = 0;
  }
  $search_criteria['display_order'] = $display_order;

  if (is_language_type($language_type) === false) {
    $language_type = '';
  }
  $search_criteria['language_type'] = $language_type;
  
  if (is_register_user($db, $user_id) === false) {
    $user_id = '';
  } else {
    $search_user = get_user($db, $user_id, true);
    $search_criteria['user_name'] = $search_user['user_name'];
  }
  $search_criteria['user_id'] = $user_id;
  return $search_criteria;
}

function get_display_order_selected($display_order) {
  foreach (DISPLAY_ORDER as $key => $value) {
    $selected = '';
    if ($display_order === $key) {
      $selected = ' selected';
    }
    $display_order_selected[$key] = $selected;
  }
 return $display_order_selected; 
}
function get_language_type_selected($language_type) {
  foreach (PERMITTED_LANGUAGE_TYPES as $key => $value) {
    $selected = '';
    if ($language_type !== '' && (int)$language_type === $key) {
      $selected = ' selected';
    }
    $language_type_selected[$key] = $selected;
  }
  return $language_type_selected;
}
function get_user_selected($all_users, $user_id) {
  foreach ($all_users as $key => $value) {
    $selected = '';
    if ($user_id !== '' && (int)$user_id === $value['user_id']) {
      $selected = ' selected';
    }
    $user_selected[$key] = $selected;
  }
  return $user_selected;
}

function get_valid_search_criteria_for_index($db, $display_order, $language_type, $keyword) {
  $search_criteria = [];
  if (is_sort_by_newest($display_order) === false) {
    $display_order = 1;
  } else {
    $display_order = 0;
  }
  $search_criteria['display_order'] = $display_order;

  if (is_language_type($language_type) === false) {
    $language_type = '';
  }
  $search_criteria['language_type'] = $language_type;

  $search_criteria['keyword'] = convert_valid_search_keyword_array($keyword);
  return $search_criteria;
}

function convert_valid_search_keyword_array($keyword) {
  $keyword_array = convert_display_search_keyword_array($keyword);
  foreach ($keyword_array as $key => $value) {
    // LIKE演算子中で特別な意味を持つ文字を「\」でエスケープ(特殊文字:「_」「%」、エスケープ文字:「\」)
    $value = '%' . addcslashes($value, '\_%') . '%';
    $keyword_array[$key] = $value;
  }
  return $keyword_array;
}

function convert_display_search_keyword_array($keyword) {
  $keyword = convert_valid_search_keyword_str($keyword);
  if ($keyword === false || $keyword === '') {
    return [];
  }
  return explode(" ", $keyword);
}

function convert_valid_search_keyword_str($keyword) {
  $keyword = convert_all_space_into_half_width_space($keyword);
  $keyword = trim($keyword);
  return trim_duplicate_spaces($keyword);
}
?>