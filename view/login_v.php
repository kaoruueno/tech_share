<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/responsive.php'; ?>
  <title>ログインページ</title>
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
      <h2>ログインページ</h2>
      <?php include VIEW_PATH . 'templates/messages.php'; ?>
      <section>
        <h5>Tech Share にログイン</h5>
        <form method="post" action="login_process.php" class="login_form">
          <div class="form-group">
            <label>ユーザー名:<input type="text" class="form-control" name="user_name"></label>
          </div>
          <div class="form-group">
            <label>パスワード:<input type="password" class="form-control" name="password"></label>
          </div>
          <input type="hidden" name="token" value="<?php print $token; ?>">
          <div><input type="submit" class="btn btn-success" value="ログイン"></div>
        </form>

        <form method="post" action="login_process.php" class="login_form">
          <input type="hidden" class="form-control" name="user_name" value="guest">
          <input type="hidden" name="token" value="<?php print $token; ?>">
          <!-- <div><input type="submit" class="btn btn-success" value="ゲストとしてログイン"></div> -->
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#guest_login_modal">ゲストとしてログイン</button>
          <?php include VIEW_PATH . 'templates/dialog.php'; ?>
        </form>
        <div class="alert alert-warning alert-dismissible fade show">
          <strong>ゲストログインでの注意!</strong> - フォームへの入力は不要です。<br>サイト内の機能をお試しで使って頂くことを目的にしています。<br>他のゲストログインしたユーザーに、ご自身の投稿が削除されたり、アカウント情報が変更されたりすることがあります。
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <a href="signup.php">新規登録はこちら</a>
      </section>
    </article>
  </main>
</body>
</html>