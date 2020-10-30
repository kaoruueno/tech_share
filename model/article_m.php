<?php
function get_articles($db, $display_order = 0, $language_type = '', $user_id = '', $keyword_array = [], $skip_count = '') {
  $params = [];
  $sql = 'SELECT
            post_id, 
            posts.user_id,
            users_t.user_name,
            title,
            title_image,
            body,
            language_type,
            posts.created
          FROM posts
            INNER JOIN users_t
              ON posts.user_id = users_t.user_id
          WHERE 1';
  if ($user_id !== '') {
    $params[] = $user_id;
    $sql .= ' AND posts.user_id = ?';
  }
  if ($language_type !== '') {
    $params[] = $language_type;
    $sql .= ' AND language_type = ?';
  }
  foreach ($keyword_array as $key => $value) {
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
  if ($skip_count !== '') {
    $params[] = $skip_count;
    $sql .= ' LIMIT ?, 8';
  }
  return fetch_all_query($db, $sql, $params);
}

function get_article($db, $post_id = '', $language_type = '', $keyword_array = [], $is_articles_count = false) {
  $params = [];
  $sql = 'SELECT';
  if ($is_articles_count !== true) {
    $sql .= ' post_id, 
              posts.user_id,
              users_t.user_name,
              title,
              title_image,
              body,
              language_type,
              posts.created';
  } else {
    $sql .= ' COUNT(*)';
  }
  $sql .= ' FROM posts
              INNER JOIN users_t
                ON posts.user_id = users_t.user_id
            WHERE 1';
  if ($post_id !== '') {
    $params[] = $post_id;
    $sql .= ' AND post_id = ?';
  }            
  if ($language_type !== '') {
    $params[] = $language_type;
    $sql .= ' AND language_type = ?';
  }
  foreach ($keyword_array as $key => $value) {
    // プレースホルダ「?」の数だけ$paramsにバインドする値を代入する
    $params[] = $value;
    $params[] = $value;
    $params[] = $value;
    $sql .= ' AND (users_t.user_name LIKE ?
              OR title LIKE ?
              OR body LIKE ?)';
  }
  $sql .= ' LIMIT 1';
  // $sql = '
  //   SELECT
  //     post_id, 
  //     posts.user_id,
  //     users_t.user_name,
  //     title,
  //     title_image,
  //     body,
  //     language_type,
  //     posts.created
  //   FROM
  //     posts
  //     INNER JOIN
  //       users_t
  //     ON
  //       posts.user_id = users_t.user_id
  //   WHERE
  //     post_id = ?
  //   LIMIT 1
  // ';
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
function get_searched_articles($db, $display_order, $language_type, $user_id = '', $keyword_array = [], $skip_count = '') {
  $articles = get_articles($db, $display_order, $language_type, $user_id, $keyword_array, $skip_count);
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
  $search_criteria['display_order'] = get_valid_display_order($display_order);
  $search_criteria['language_type'] = get_valid_language_type($language_type);
  
  if (is_register_user($db, $user_id) === false) {
    $user_id = '';
  } else {
    $search_user = get_user($db, $user_id, true);
    $search_criteria['user_name'] = $search_user['user_name'];
  }
  $search_criteria['user_id'] = $user_id;
  return $search_criteria;
}

function get_valid_display_order($display_order) {
  if (is_sort_by_newest($display_order) === false) {
    return 1;
  }
  return 0;
}

function get_valid_language_type($language_type) {
  if (is_language_type($language_type) === false) {
    $language_type = '';
  }
  return $language_type;
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
  $search_criteria['display_order'] = get_valid_display_order($display_order);
  $search_criteria['language_type'] = get_valid_language_type($language_type);
  $search_criteria['keyword_str'] = convert_valid_search_keyword_str($keyword);
  $search_criteria['keyword_array'] = convert_valid_search_keyword_array($search_criteria['keyword_str']);
  return $search_criteria;
}

function convert_valid_search_keyword_str($keyword) {
  if ($keyword_str === false) {
    $keyword_str = '';
  }
  $keyword = convert_all_space_into_half_width_space($keyword);
  $keyword = trim($keyword);
  $keyword = trim_duplicate_spaces($keyword);
  return convert_unique_str_separated_by_space($keyword);
}

function convert_valid_search_keyword_array($keyword_str) {
  $keyword_array = convert_display_search_keyword_array($keyword_str);
  foreach ($keyword_array as $key => $value) {
    // LIKE演算子中で特別な意味を持つ文字を「\」でエスケープ(特殊文字:「_」「%」、エスケープ文字:「\」)
    $value = '%' . addcslashes($value, '\_%') . '%';
    $keyword_array[$key] = $value;
  }
  return $keyword_array;
}

function convert_display_search_keyword_array($keyword_str) {
  if ($keyword_str === '') {
    return [];
  }
  return explode(" ", $keyword_str);
}

// ページネーション
function get_pagination_data_for_index($db, $get_page, $display_order, $language_type, $keyword_array, $keyword_str) {
  $pagination = [];
  $pagination['all_articles_count'] = get_searched_articles_count($db, $language_type, $keyword_array);
  $pagination['all_page'] = get_all_page($pagination['all_articles_count'], 6);
  $pagination['current_page'] = get_valid_current_page($get_page, $pagination['all_page']);
  $pagination['display_count'] = get_display_count($pagination['current_page'], $pagination['all_page'], $pagination['all_articles_count']);
  $pagination['url_param'] = get_valid_url_param_for_index($display_order, $language_type, $keyword_str);
  return $pagination;
}

function get_searched_articles_count($db, $language_type, $keyword_array) {
  $articles_count = get_article($db, $post_id = '', $language_type, $keyword_array, $is_articles_count = true);
  return $articles_count['COUNT(*)'];
}

function get_valid_url_param_for_index($valid_display_order, $valid_language_type, $valid_keyword) {
  $param = '?';
  if ($valid_display_order === 1) {
    $param .= 'display_order=1&';
  }
  if ($valid_language_type !== '') {
    $param .= 'language_type=' . $valid_language_type . '&';
  }
  if ($valid_keyword !== '') {
    $param .= 'keyword=' . rawurlencode($valid_keyword) . '&';
  }
  $param .= 'page=';
  return $param;
}

function get_limited_searched_articles($db, $display_order, $language_type, $keyword_array, $current_page, $count = 6) {
  $skip_count = ($current_page-1) * $count;
  return get_searched_articles($db, $display_order, $language_type, $user_id = '', $keyword_array, $skip_count);
}
?>