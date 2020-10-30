<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/responsive.php'; ?>
  <?php include VIEW_PATH . 'templates/icon.php'; ?>
  <title>トップページ</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'logined.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'index.css'; ?>">
  <style>
  /* * {
    outline: solid 1px blue;
  } */
  /*body {*/
  /*  min-width:575px;*/
  /*  background-color: lightgreen;*/
  /*}*/
  /*main {*/
  /*  background-color: pink;*/
  /*}*/
  /*article {*/
  /*  background-color: lightblue;*/
  /*}*/
  /*.container .display_side section {*/
  /*  background-color: lightgray;*/
  /*}*/
  </style>
</head>
<body>
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <main>
    <div class="container">
      <h2>記事一覧</h2>
      <?php include VIEW_PATH . 'templates/messages.php'; ?>
      <form class="search_form">
        <div>
          <label>表示順:
            <select name="display_order">
              <option value="0"<?php print $display_order_selected[0]; ?>><?php print DISPLAY_ORDER[0]; ?></option>
              <option value="1"<?php print $display_order_selected[1]; ?>><?php print DISPLAY_ORDER[1]; ?></option>
            </select>
          </label>
          <label>記事のジャンル:
            <select name="language_type">
              <option value="">全て</option>
<?php foreach (PERMITTED_LANGUAGE_TYPES as $key => $value) { ?>
             <option value="<?php print $key; ?>"<?php print $language_type_selected[$key]; ?>><?php print $value; ?></option>
<?php } ?>
            </select>
          </label>
          <label>キーワード: <input type="text" name="keyword"  value="<?php print $keyword_selected; ?>"></label>
        </div>
        <div>
          <div>検索条件: 
            <span class="badge badge-pill badge-success"><?php print DISPLAY_ORDER[$get_search['display_order']]; ?></span>
          <?php if ($get_search['language_type'] !== '') { ?>
            <span class="badge badge-pill badge-success"><?php print PERMITTED_LANGUAGE_TYPES[$get_search['language_type']]; ?></span>
          <?php } ?>
          <?php foreach ($display_keyword as $value) { ?>
            <span class="badge badge-pill badge-success"><?php print $value; ?></span>
          <?php } ?>
          </div>
          <div class="submit_area">
            <button type="submit" class="btn btn-success">絞り込み検索</button>
        <?php if ($get_search['user_id'] !== '' || $get_search['language_type'] !== '') { ?>
            <a href="index.php" class="btn btn-secondary" role="button">絞り込み解除</a>
        <?php } ?>
          </div>
        </div>
      </form>
      <article class="post">
    <?php if ($articles !== []) { ?>
      <?php foreach ($articles as $key => $value) { ?>
        <section>
          <div>
            <a class="link_whole_parent" href="article.php?post=<?php print $value['post_id']; ?>"></a>
            <div><img src="<?php print $value['title_image']; ?>"></div>
            <h4><?php print $value['title']; ?></h4>
            <div><?php print $value['body']; ?></div>
            <div class="post_details">
              <div>ジャンル: <?php print PERMITTED_LANGUAGE_TYPES[$value['language_type']]; ?></div>
              <div>投稿日時:
                <div><?php print $value['created']; ?></div>
              </div>
            </div>
      <?php if (is_own_user($user, $value['user_id']) === true) { ?>
            <a href="my_profile.php" class="btn btn-outline-dark" role="button">投稿者: <?php print $value['user_name']; ?></a>
      <?php } else { ?>
            <a href="another_profile.php?user=<?php print $value['user_id']; ?>" class="btn btn-outline-success" role="button">投稿者: <?php print $value['user_name']; ?></a>
      <?php } ?>
      <?php if (is_own_user($user, $value['user_id']) === false) { ?>
            <div class="favorite_button_area">
        <?php if (is_following_user($db, $user, $value['user_id']) === false) { ?>
              <form method="post" action="following_user_register.php">
                <input type="hidden" name="follower_id" value="<?php print $value['user_id']; ?>">
                <button type="submit" class="btn btn-warning"><i class="fas fa-heart"></i> フォローする</button>
              </form>
        <?php } else { ?>
              <form method="post" action="following_user_delete.php">
                <input type="hidden" name="follower_id" value="<?php print $value['user_id']; ?>">
                <button type="submit" class="btn btn-light"><i class="fas fa-heart following"></i> フォロー中</button>
              </form>
        <?php } ?>
        <?php if (is_favorite_post($db, $user, $value['post_id']) === false) { ?>
              <form method="post" action="favorite_post_register.php">
                <input type="hidden" name="post_id" value="<?php print $value['post_id']; ?>">
                <button type="submit" class="btn btn-warning"><i class="fas fa-thumbs-up"></i> お気に入り</button>
              </form>
        <?php } else { ?>
              <form method="post" action="favorite_post_delete.php">
                <input type="hidden" name="post_id" value="<?php print $value['post_id']; ?>">
                <button type="submit" class="btn btn-light"><i class="fas fa-thumbs-up favorite_post"></i> お気に入り解除</button>
              </form>
        <?php } ?>
            </div>
      <?php } ?>
          </div>
        </section>
      <?php } ?>
        <?php } else { ?>
          <p>条件に一致する記事はありませんでした。</p>
        <?php } ?>
      </article>
      <?php include VIEW_PATH . 'templates/pagination.php'; ?>
    </div>
  </main>
  <?php include VIEW_PATH . 'templates/menubar.php'; ?>
</body>
</html>