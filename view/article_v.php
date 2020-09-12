<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/responsive.php'; ?>
  <?php include VIEW_PATH . 'templates/icon.php'; ?>
  <title>記事のタイトル</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'logined.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'article.css'; ?>">
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
    <article class="container">
      <h2>投稿ページ</h2>
      <section>
        <form method="post" action="post_insert.php">
          <div class="form-inline">
            <label>記事のジャンル:
                  <select name = "language_type">
                    <option value = "">選択してください</option>
                    <option value = "1">HTML/CSS</option>
                    <option value = "2">JavaScript</option>
                    <option value = "3">PHP</option>
                    <option value = "4">MySQL</option>
                    <option value = "0">その他</option>
                  </select>
            </label>
          </div>
          <!-- textareaの高さを調整する -->
          <div class="form-group" id="textarea">
            <textarea class="form-control" name="#"></textarea>
          </div>
          <!-- textareaの高さを調整する -->
          <div class="display_button">
            <a href="post.php" class="btn btn-secondary" role="button">リセット</a>
            <input type="submit" class="btn btn-success" value="投稿">
          </div>
        </form>
      </section>
      
      <p>My Icons <i class="fas fa-heart heart"></i></p>
      <p>An icon along with some text: <i class="fas fa-thumbs-up good"></i></p>
      
    </article>
  </main>
  <?php include VIEW_PATH . 'templates/menubar.php'; ?>
</body>
</html>