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
      <section class="text-center">
        <h5>Tech Share にログイン</h5>
        <form method="post" action="login_process.php" class="login_form">
          <div class="form-group">
            <label>ユーザー名:<input type="text" class="form-control" name="user_name"></label>
          </div>
          <div class="form-group">
            <label>パスワード:<input type="password" class="form-control" name="password"></label>
          </div>
          <div><input type="submit" class="btn btn-success" value="ログイン"></div>
        </form>
        <a href="signup.php">新規登録はこちら</a>
      </section>
    </article>
  </main>
</body>
</html>