<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/design.php'; ?>
  <title>記事の内容</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'message.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'article_main.css'; ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <main>
    <div class="ctr">
      <?php include VIEW_PATH . 'templates/messages.php'; ?>
      <article>
<?php if ($article['title_image'] !== '') { ?>          
        <img src="<?php print $article['title_image']; ?>">
<?php } ?>
<?php if (is_own_post($db, $user, $article['post_id']) === true || is_admin($user) === true) { ?>
        <form class="delete_button_area" method="post" action="post_delete.php">
          <input type="hidden" name="post_id" value="<?php print $article['post_id']; ?>">
          <input type="hidden" name="token" value="<?php print $token; ?>">
          <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#post_delete<?php print $key = ''; ?>_modal"><i class="far fa-trash-alt"></i> 投稿削除</button>
          <?php include DIALOG_PATH . 'post_delete_modal.php'; ?>
        </form>
<?php } ?>
        <h3><?php print $article['title']; ?></h3>
        <div class="post_details">
          <div>ジャンル:<?php print PERMITTED_LANGUAGE_TYPES[$article['language_type']]; ?></div>
          <div>投稿日時:
            <div><?php print $article['created']; ?></div>
          </div>
        </div>
<?php if (is_own_user($user, $article['user_id']) === true) { ?>
        <a href="my_profile.php" class="btn btn-outline-dark" role="button">投稿者: <?php print $article['user_name']; ?></a>
<?php } else { ?>
        <a href="another_profile.php?user=<?php print $article['user_id']; ?>" class="btn btn-outline-success" role="button">投稿者: <?php print $article['user_name']; ?></a>
<?php } ?>
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
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#following_user_delete<?php print $key = ''; ?>_modal"><i class="fas fa-heart following"></i> フォロー中</button>
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
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#favorite_post_delete<?php print $key = ''; ?>_modal"><i class="fas fa-thumbs-up favorite_post"></i> お気に入り解除</button>
            <?php include DIALOG_PATH . 'favorite_post_delete_modal.php'; ?>
          </form>
  <?php } ?>
        </div>
<?php } ?>
        <div class="article_body"><?php print $article['body']; ?></div>
      </article>
    </div>
  </main>
  <?php include VIEW_PATH . 'templates/menubar.php'; ?>
  <?php include DIALOG_PATH . 'logout_modal.php'; ?>
</body>
</html>