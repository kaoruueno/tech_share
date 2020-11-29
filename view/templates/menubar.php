<nav>
<?php if (is_index_page() === false) { ?>
  <a href="index.php"><i class="fas fa-home"></i><div>トップ</div></a>
<?php } else { ?>
  <div><i class="fas fa-home"></i><div>トップ</div></div>
<?php } ?>
<?php if (is_logined() === false) { ?>
  <?php if (is_login_page() === false) { ?>
  <a href="login.php"><i class="fas fa-sign-in-alt"></i><div>ログイン</div></a>
  <?php } else { ?>
  <div><i class="fas fa-sign-in-alt"></i><div>ログイン</div></div>
  <?php } ?>
  <?php if (is_signup_page() === false) { ?>
  <a href="signup.php"><i class="fas fa-user-plus"></i><div>新規登録</div></a>
  <?php } else { ?>
  <div><i class="fas fa-user-plus"></i><div>新規登録</div></div>
  <?php } ?>
<?php } ?>
<?php if (is_post_page() === false) { ?>
  <a href="post.php"><i class="fas fa-edit"></i><div>投稿</div></a>
<?php } else { ?>
  <div><i class="fas fa-edit"></i><div>投稿</div></div>
<?php } ?>
<?php if (is_logined() === true) { ?>
  <?php if (is_my_profile_page() === false) { ?>
  <a href="my_profile.php"><i class="fas fa-user"></i><div>マイページ</div></a>
  <?php } else { ?>
  <div><i class="fas fa-user"></i><div>マイページ</div></div>
  <?php } ?>
  <?php if (is_admin($user) === true) { ?>
    <?php if (is_admin_post_page() === false) { ?>
  <a href="admin_post.php"><i class="fas fa-user-cog"></i><div>投稿管理</div></a>
    <?php } else { ?>
  <div><i class="fas fa-user-cog"></i><div>投稿管理</div></div>
    <?php } ?>
  <?php } ?>
  <a data-toggle="modal" data-target="#logout_modal"><i class="fas fa-sign-out-alt"></i><div>ログアウト</div></a>
<?php } ?>
</nav>