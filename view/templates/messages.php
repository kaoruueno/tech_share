<?php foreach(get_errors() as $error){ ?>
  <p class="alert alert-danger alert-dismissible fade show">
    <span><?php print $error; ?></span>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </p>
<?php } ?>
<?php foreach(get_messages() as $message){ ?>
  <p class="alert alert-success alert-dismissible fade show">
    <span><?php print $message; ?></span>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </p>
<?php } ?>
<?php foreach(get_login_warnings() as $warning){ ?>
  <p class="alert alert-warning alert-dismissible fade show login_warning">
    <span><?php print $warning; ?></span>
    <span>
      <a href="login.php" class="btn btn-danger">ログイン</a>
      <a href="signup.php" class="btn btn-danger">新規登録</a>
    </span>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </p>
<?php } ?>
<?php foreach(get_post_warnings() as $warning){ ?>
  <p class="alert alert-warning alert-dismissible fade show post_warning">
    <span><?php print $warning; ?></span>
    <span>
      <a href="post_pre.php" class="btn btn-danger">投稿作業の続きへ</a>
    </span>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </p>
<?php } ?>