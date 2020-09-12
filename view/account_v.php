<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/responsive.php'; ?>
  <title>マイページ</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'logined.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'account.css'; ?>">
  <style>
  /** {*/
  /*  outline: solid 1px;*/
  /*}*/
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
    <article class="container">
      <h2>プロフィール</h2>
      <div class="display_side">
        <section></section>
        <section>
          <form method="post" class="login_form">
            <div class="form-group">
              興味があるジャンル:
              <div class="form-check">
                <label><input type="checkbox" class="form-check-input" name="language_type">HTML/CSS</label>
              </div>
              <div class="form-check">
                <label><input type="checkbox" class="form-check-input" name="language_type">JavaScript</label>
              </div>
              <div class="form-check">
                <label><input type="checkbox" class="form-check-input" name="language_type">PHP</label>
              </div>
              <div class="form-check">
                <label><input type="checkbox" class="form-check-input" name="language_type">MySQL</label>
              </div>
              <div class="form-check">
                <label><input type="checkbox" class="form-check-input" name="language_type">その他</label>
              </div>
            </div>
            <input type="submit" class="btn btn-success" value="更新">
          </form>
        </section>
      </div>
      <div class="display_side">
        <!-- foreach文で投稿データを表示 -->
        <!-- if文 DBから取得した記事のキーが奇数なら、<section class="ml-auto">(右寄せ) -->
        <section>
          <div>画像</div>
          <h4>タイトル:○○○○○○○○○○</h4>
          <p>本文:○○○○○○○○○○</p>
          <div class="row">
            <div class="col text-left">投稿者名:○○○</div>
            <div class="col text-right">お気に入り👍</div>
          </div>
        </section>
        <section class="ml-auto">
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
        </section>
        <!-- foreach文で投稿データを表示 -->
        <!-- if文 DBから取得した記事のキーが奇数なら、<section class="ml-auto">(右寄せ) -->
      </div>
      <!-- if文 ページネーション(order_view.phpを見ながら変更) -->
      <section class="display_count">○○○件中 ○ - ○件目の記事</section>
      <section class="pagination">
        <div>最初へ 前へ 1 2 3 4 5 次へ 最後へ</div>
      </section>
      <!-- if文 ページネーション(order_view.phpを見ながら) -->
    </article>
  </main>
  <?php include VIEW_PATH . 'templates/menubar.php'; ?>
</body>
</html>