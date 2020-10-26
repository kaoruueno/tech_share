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
    <!-- <nav class="languagebar">
      <a href="#" class="btn btn-outline-success" role="button">全て</a>
      <a href="#" class="btn btn-outline-success" role="button">HTML/CSS</a>
      <a href="#" class="btn btn-outline-success" role="button">JavaScript</a>
      <a href="#" class="btn btn-outline-success" role="button">PHP</a>
      <a href="#" class="btn btn-outline-success" role="button">MySQL</a>
      <a href="#" class="btn btn-outline-success" role="button">その他</a>
    </nav> -->
    <div class="container">
      <!-- <div class="display_side"> -->
      <h2>記事一覧</h2>
        <!-- <form method="post" class="form-inline">
          <input type="search" class="form-control" name="search">
          <input type="submit" class="btn btn-success" value="記事検索">
        </form>
      </div> -->
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