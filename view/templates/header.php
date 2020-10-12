<header>
  <nav class="navbar navbar-light bg-light">
    <!-- リンク先を定数、タイトルのデザインを修正 -->
    <a class="navbar-brand" href="index.php">Tech Share</a>
    <!-- login,signupはこれだけ -->

    <!-- if (login後)なら -->
<?php if (isset($user['user_name']) === true) { ?>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">ようこそ <?php print h($user['user_name']); ?>さん</li>
    </ul>
<?php } ?>
    <!-- if (login後)なら -->
  </nav>
</header>