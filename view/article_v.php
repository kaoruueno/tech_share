<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/responsive.php'; ?>
  <?php include VIEW_PATH . 'templates/icon.php'; ?>
  <title>記事の内容</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'logined.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'article.css'; ?>">
  <style>
  /* * {
  outline: solid 1px;
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
      <?php include VIEW_PATH . 'templates/messages.php'; ?>
      <article>
        <section>
<?php if ($article['title_image'] !== '') { ?>          
          <div><img src="<?php print $article['title_image']; ?>"></div>
<?php } ?>
          <h3><?php print $article['title']; ?></h3>
          <div>ジャンル:<?php print PERMITTED_LANGUAGE_TYPES[$article['language_type']]; ?></div>
          <div class="post_user">
            <div class="follow_user">
              <div>投稿者:<?php print $article['user_name']; ?></div>
<?php if (is_own_post($db, $user, $article['post_id']) === false) { ?>
  <?php if (is_following_user($db, $user, $article['user_id']) === false) { ?>       
              <form method="post" action="following_user_register.php">
                <input type="hidden" name="follower_id" value="<?php print $article['user_id']; ?>">
                <button type="submit" class="btn btn-warning"><i class="fas fa-heart"></i> フォローする</button>
              </form>
  <?php } else { ?>
              <form method="post" action="following_user_delete.php">
                <input type="hidden" name="follower_id" value="<?php print $article['user_id']; ?>">
                <button type="submit" class="btn btn-light"><i class="fas fa-heart following"></i> フォロー中</button>
              </form>
  <?php } ?>
<?php } ?>
            </div>
            <div class="favorite_post">
<?php if (is_own_post($db, $user, $article['post_id']) === false) { ?>
  <?php if (is_favorite_post($db, $user, $article['post_id']) === false) { ?>
              <form method="post" action="favorite_post_register.php">
                <input type="hidden" name="post_id" value="<?php print $article['post_id']; ?>">
                <button type="submit" class="btn btn-warning"><i class="fas fa-thumbs-up"></i> お気に入り</button>
              </form>
  <?php } else { ?>
              <form method="post" action="favorite_post_delete.php">
                <input type="hidden" name="post_id" value="<?php print $article['post_id']; ?>">
                <button type="submit" class="btn btn-light"><i class="fas fa-thumbs-up favorite_post"></i> お気に入り解除</button>
              </form>
  <?php } ?> 
<?php } ?>
            </div>
          </div>
          <div class="article_body"><?php print $article['body']; ?></div>
        </section>
      </article>
    </div>
  </main>
  <?php include VIEW_PATH . 'templates/menubar.php'; ?>
</body>
</html>