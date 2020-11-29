<header>
  <a href="index.php"><i class="fas fa-file-code"></i> Tech Share</a>
<?php if (isset($user['user_name']) === true) { ?>
  <a href="my_profile.php">
    <i class="fas fa-user-check"></i>
    <div>ログイン中</div>
  </a>
<?php } ?>
</header>