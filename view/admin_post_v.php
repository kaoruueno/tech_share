<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/design.php'; ?>
  <title>投稿管理ページ</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'message.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'articles_list.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'profile.css'; ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <main>
    <div class="ctr">
      <h2>投稿管理ページ</h2>
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
          <label>ユーザー名:
            <select name="user">
              <option value="">全て</option>
<?php foreach ($all_users as $key => $all_user) { ?>
              <option value="<?php print $all_user['user_id']; ?>"<?php print $user_selected[$key]; ?>><?php print $all_user['user_name']; ?></option>
<?php } ?>
            </select>
          </label>
        </div>
        <div>
          <div>検索条件: 
            <span class="badge badge-pill badge-success"><?php print DISPLAY_ORDER[$get_search['display_order']]; ?></span>
<?php if ($get_search['language_type'] !== '') { ?>
            <span class="badge badge-pill badge-success"><?php print PERMITTED_LANGUAGE_TYPES[$get_search['language_type']]; ?></span>
<?php } ?>
<?php if ($get_search['user_id'] !== '') { ?>
            <span class="badge badge-pill badge-success"><?php print $get_search['user_name']; ?></span>
<?php } ?>
          </div>
          <div class="submit_area">
<?php if ($get_search['user_id'] !== '' || $get_search['language_type'] !== '') { ?>
            <a href="admin_post.php" class="btn btn-secondary" role="button">絞り込み解除</a>
<?php } ?>
            <button type="submit" class="btn btn-success">絞り込み検索</button>
          </div>
        </div>
      </form>
      <article class="post">
<?php if ($articles !== [] && $articles !== false) { ?>
  <?php foreach ($articles as $key => $article) { ?>
        <section>
          <div>
            <a class="link_whole_parent" href="article.php?post=<?php print $article['post_id']; ?>"></a>
            <div><img src="<?php print $article['title_image']; ?>"></div>
            <form class="delete_button_area" method="post" action="post_delete.php">
              <input type="hidden" name="post_id" value="<?php print $article['post_id']; ?>">
              <input type="hidden" name="token" value="<?php print $token; ?>">
              <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#post_delete<?php print $key; ?>_modal"><i class="far fa-trash-alt"></i> 投稿削除</button>
              <?php include DIALOG_PATH . 'post_delete_modal.php'; ?>
            </form>
            <h4><?php print $article['title']; ?></h4>
            <div><?php print $article['body']; ?></div>
            <div class="post_details">
              <div>ジャンル: <?php print PERMITTED_LANGUAGE_TYPES[$article['language_type']]; ?></div>
              <div>投稿日時:
                <div><?php print $article['created']; ?></div>
              </div>
            </div>
            <div>投稿者:<?php print $article['user_name']; ?></div>
    <?php if (is_own_user($user, $article['user_id']) === false) { ?>
            <div class="favorite_button_area">
      <?php if (is_following_user($db, $user, $article['user_id']) === false) { ?>
              <form method="post" action="following_user_register.php">
                <input type="hidden" name="follower_id" value="<?php print $article['user_id']; ?>">
                <input type="hidden" name="token" value="<?php print $token; ?>">
                <button type="submit" class="btn btn-warning"><i class="fas fa-heart"></i> フォローする</button>
              </form>
      <?php } else { ?>
              <form method="post" action="following_user_delete.php">
                <input type="hidden" name="follower_id" value="<?php print $article['user_id']; ?>">
                <input type="hidden" name="token" value="<?php print $token; ?>">
                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#following_user_delete<?php print $key; ?>_modal"><i class="fas fa-heart following"></i> フォロー中</button>
                <?php include DIALOG_PATH . 'following_user_delete_modal.php'; ?>
              </form>
      <?php } ?>
      <?php if (is_favorite_post($db, $user, $article['post_id']) === false) { ?>
              <form method="post" action="favorite_post_register.php">
                <input type="hidden" name="post_id" value="<?php print $article['post_id']; ?>">
                <input type="hidden" name="token" value="<?php print $token; ?>">
                <button type="submit" class="btn btn-warning"><i class="fas fa-thumbs-up"></i> お気に入り追加</button>
              </form>
      <?php } else { ?>
              <form method="post" action="favorite_post_delete.php">
                <input type="hidden" name="post_id" value="<?php print $article['post_id']; ?>">
                <input type="hidden" name="token" value="<?php print $token; ?>">
                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#favorite_post_delete<?php print $key; ?>_modal"><i class="fas fa-thumbs-up favorite_post"></i> お気に入り解除</button>
                <?php include DIALOG_PATH . 'favorite_post_delete_modal.php'; ?>
              </form>
      <?php } ?>                  
            </div>
    <?php } ?>
          </div>
        </section>
  <?php } ?>
<?php } else { ?>
        <p>検索条件に一致する記事はありません</p>
<?php } ?>
      </article>
    </div>
  </main>
  <?php include VIEW_PATH . 'templates/menubar.php'; ?>
  <?php include DIALOG_PATH . 'logout_modal.php'; ?>
</body>
</html>