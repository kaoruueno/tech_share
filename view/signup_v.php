<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/responsive.php'; ?>
  <title>新規登録ページ</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'login_signup.css'; ?>">
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
  /*section {*/
  /*  background-color: lightgray;*/
  /*}*/
  </style>
</head>
<body>
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <main>
    <article class="container">
      <h2>新規登録ページ</h2>
      <?php include VIEW_PATH . 'templates/messages.php'; ?>
      <section>
        <h5>Tech Share に登録</h5>
        <form method="post" action="signup_process.php" class="login_form">
          <div class="form-group">
            <label>ユーザー名:<input type="text" class="form-control" name="user_name" placeholder="6~20文字の半角英数字"></label>
          </div>
          <div class="form-group">
            <label>パスワード:<input type="password" class="form-control" name="password" placeholder="6~100文字の半角英数字"></label>
          </div>
          <div class="form-group">
            <label>パスワード(確認用):<input type="password" class="form-control" name="password_confirmation" placeholder="6~100文字の半角英数字"></label>
          </div>
          <div class="form-group">
            興味があるジャンル[任意]:
            <input type="hidden" name="language_types" value="">
            <div class="form-check">
              <label><input type="checkbox" class="form-check-input" name="language_types[]" value="1">HTML/CSS</label>
            </div>
            <div class="form-check">
              <label><input type="checkbox" class="form-check-input" name="language_types[]" value="2">JavaScript</label>
            </div>
            <div class="form-check">
              <label><input type="checkbox" class="form-check-input" name="language_types[]" value="3">PHP</label>
            </div>
            <div class="form-check">
              <label><input type="checkbox" class="form-check-input" name="language_types[]" value="4">MySQL</label>
            </div>
            <div class="form-check">
              <label><input type="checkbox" class="form-check-input" name="language_types[]" value="0">その他</label>
            </div>
          </div>
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#signup_modal">登録する</button>
          <?php include VIEW_PATH . 'templates/dialog.php'; ?>
        </form>
        <a href="login.php">ログインページはこちら(登録済みの方)</a>
      </section>
    </article>
  </main>
</body>
</html>