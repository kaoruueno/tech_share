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
    <nav class="languagebar">
      <a href="#" class="btn btn-outline-success" role="button">全て</a>
      <a href="#" class="btn btn-outline-success" role="button">HTML/CSS</a>
      <a href="#" class="btn btn-outline-success" role="button">JavaScript</a>
      <a href="#" class="btn btn-outline-success" role="button">PHP</a>
      <a href="#" class="btn btn-outline-success" role="button">MySQL</a>
      <a href="#" class="btn btn-outline-success" role="button">その他</a>
    </nav>
    <div class="container">
      <div class="display_side">
        <h2>記事一覧</h2>
        <form method="post" class="form-inline">
          <input type="search" class="form-control" name="search">
          <input type="submit" class="btn btn-success" value="記事検索">
        </form>
      </div>
      <?php include VIEW_PATH . 'templates/messages.php'; ?>
      <article>
<?php foreach ($articles as $key => $value) { ?>
        <section>
          <a href="article.php?post=<?php print $value['post_id']; ?>">
            <div><img src="<?php print $value['title_image']; ?>"></div>
            <h4><?php print $value['title']; ?></h4>
            <div><?php print $value['body']; ?></div>
            <div>ジャンル:<?php print PERMITTED_LANGUAGE_TYPES[$value['language_type']]; ?></div>
            <div>投稿者:<?php print $value['user_name']; ?></div>
          </a>
          <div class="post_user">
            <div class="follow_user">
  <?php if (is_own_post($db, $user, $value['post_id']) === false) { ?>
    <?php if (is_following_user($db, $user, $value['user_id']) === false) { ?>       
              <form method="post" action="following_user_register.php">
                <input type="hidden" name="follower_id" value="<?php print $value['user_id']; ?>">
                <button type="submit" class="btn btn-warning"><i class="fas fa-heart"></i> フォローする</button>
                <a class="link_space" href="article.php?post=<?php print $value['post_id']; ?>"></a>
              </form>
    <?php } else { ?>
              <form method="post" action="following_user_delete.php">
                <input type="hidden" name="follower_id" value="<?php print $value['user_id']; ?>">
                <button type="submit" class="btn btn-light"><i class="fas fa-heart following"></i> フォロー中</button>
                <a class="link_space" href="article.php?post=<?php print $value['post_id']; ?>"></a>
              </form>
    <?php } ?>
  <?php } ?>
            </div>
            <a class="link_space" href="article.php?post=<?php print $value['post_id']; ?>"></a>
            <div class="favorite_post">
  <?php if (is_own_post($db, $user, $value['post_id']) === false) { ?>
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
  <?php } ?>
            </div>
          </div>
        </section>
<?php } ?>
      </article>
        <!-- <section class="ml-auto">
          <div>画像</div>
          <h4>タイトル:○○○○○○○○○○</h4>
          <p>本文:○○○○○○○○○○</p>
          <div class="row">
            <div class="col text-left">投稿者名:○○○</div>
            <div class="col text-right">お気に入り👍</div>
          </div>
        </section>
        <section>
          <div>画像</div>
          <h4>タイトル:○○○○○○○○○○</h4>
          <p>本文:○○○○○○○○○○</p>
          <div class="row">
            <div class="col text-left">投稿者名:○○○</div>
            <div class="col text-right">お気に入り👍</div>
          </div>
        </section> -->
        <!-- foreach文で投稿データを表示 -->
        <!-- if文 DBから取得した記事のキーが奇数なら、<section class="ml-auto">(右寄せ) -->
      <!-- if文 ページネーション(order_view.phpを見ながら変更) -->
      <section class="display_count">○○○件中 ○ - ○件目の記事</section>
      <section class="pagination">
        <div>最初へ 前へ 1 2 3 4 5 次へ 最後へ</div>
      </section>
      <!-- if文 ページネーション(order_view.phpを見ながら) -->
    </div>
  </main>
  <?php include VIEW_PATH . 'templates/menubar.php'; ?>
</body>
</html>