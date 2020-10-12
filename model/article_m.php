<?php
function get_articles($db, $user_id = '') {
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
  ';
  if ($user_id !== '') {
    $params[] = $user_id;
    $sql .= 'WHERE posts.user_id = ?';
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

function get_all_articles($db){
  $articles = get_articles($db);
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
?>