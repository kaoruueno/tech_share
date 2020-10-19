<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/responsive.php'; ?>
  <?php include VIEW_PATH . 'templates/icon.php'; ?>
  <title><?php print $another_user['user_name']; ?>さんのプロフィール</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'logined.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'profile.css'; ?>">
  <style>
  /* * {
   outline: solid 1px;
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
    <div class="container">
      <h2>プロフィール</h2>
      <?php include VIEW_PATH . 'templates/messages.php'; ?> 
      <div class="follow_another">
        <div>ユーザー名: <span><?php print $another_user['user_name']; ?></span></div>
<?php if (is_following_user($db, $user, $another_user['user_id']) === false) { ?>
        <form method="post" action="following_user_register.php">
          <input type="hidden" name="follower_id" value="<?php print $another_user['user_id']; ?>">
          <button type="submit" class="btn btn-warning"><i class="fas fa-heart"></i> フォローする</button>
        </form>
<?php } else { ?>
        <form method="post" action="following_user_delete.php">
          <input type="hidden" name="follower_id" value="<?php print $another_user['user_id']; ?>">
          <button type="submit" class="btn btn-light"><i class="fas fa-heart following"></i> フォロー中</button>
        </form>
<?php } ?>
      </div>
      <div class="follow_count">
        <a href="?user=<?php print $another_user['user_id']; ?>&followings=1" class="<?php print $button['followings']['class']; ?>"<?php print $button['followings']['disabled']; ?> role="button">フォロー <?php print $follow_count['followings']; ?></a>
        <a href="?user=<?php print $another_user['user_id']; ?>&followers=1" class="<?php print $button['followers']['class']; ?>"<?php print $button['followers']['disabled']; ?> role="button">フォロワー <?php print $follow_count['followers']; ?></a>
      </div>
      <div class="profile_bar">
        <a href="?user=<?php print $another_user['user_id']; ?>&own_posts=1" class="<?php print $button['own_posts']['class']; ?>"<?php print $button['own_posts']['disabled']; ?> role="button"><?php print $another_user['user_name']; ?>さんの投稿記事</a>
        <a href="?user=<?php print $another_user['user_id']; ?>&favorite_posts=1" class="<?php print $button['favorite_posts']['class']; ?>"<?php print $button['favorite_posts']['disabled']; ?> role="button">お気に入り記事</a>
        <a href="?user=<?php print $another_user['user_id']; ?>&favorite_languages=1" class="<?php print $button['favorite_languages']['class']; ?>"<?php print $button['favorite_languages']['disabled']; ?> role="button">興味があるジャンル</a>
      </div>

<!-- フォローをクリックした場合 -->
<?php if ($get_link === PROFILE_LINK['followings']) { ?>
      <article class="follow_list">
        <h4>フォロー リスト</h4>
  <?php if ($response_link !== []) { ?>
    <?php foreach ($response_link as $following) { ?>
        <section>
      <?php if (is_own_user($user, $following['user_id']) === true) { ?>
          <a href="my_profile.php"><?php print $following['user_name']; ?></a>
      <?php } else if (is_following_user($db, $user, $following['user_id']) === false) { ?>
          <a href="another_profile.php?user=<?php print $following['user_id']; ?>"><?php print $following['user_name']; ?></a>
          <form method="post" action="following_user_register.php">
            <input type="hidden" name="follower_id" value="<?php print $following['user_id']; ?>">
            <button type="submit" class="btn btn-warning"><i class="fas fa-heart"></i> フォローする</button>
          </form>
      <?php } else { ?>
          <a href="another_profile.php?user=<?php print $following['user_id']; ?>"><?php print $following['user_name']; ?></a>
          <form method="post" action="following_user_delete.php">
            <input type="hidden" name="follower_id" value="<?php print $following['user_id']; ?>">
            <button type="submit" class="btn btn-light"><i class="fas fa-heart following"></i> フォロー中</button>
          </form>
      <?php } ?>
        </section>
    <?php } ?>
  <?php } else { ?>
        <p>フォロー中のユーザーはいません</p>
  <?php } ?>
      </article>
      
<!-- フォロワーをクリックした場合 -->
<?php } else if ($get_link === PROFILE_LINK['followers']) { ?>
      <article class="follow_list">
        <h4>フォロワー リスト</h4>
  <?php if ($response_link !== []) { ?>
    <?php foreach ($response_link as $follower) { ?>
        <section>
      <?php if (is_own_user($user, $follower['user_id']) === true) { ?>
          <a href="my_profile.php"><?php print $follower['user_name']; ?></a>
      <?php } else if (is_following_user($db, $user, $follower['user_id']) === false) { ?>
          <a href="another_profile.php?user=<?php print $follower['user_id']; ?>"><?php print $follower['user_name']; ?></a>
          <form method="post" action="following_user_register.php">
            <input type="hidden" name="follower_id" value="<?php print $follower['user_id']; ?>">
            <button type="submit" class="btn btn-warning"><i class="fas fa-heart"></i> フォローする</button>
          </form>
      <?php } else { ?>
          <a href="another_profile.php?user=<?php print $follower['user_id']; ?>"><?php print $follower['user_name']; ?></a>
          <form method="post" action="following_user_delete.php">
            <input type="hidden" name="follower_id" value="<?php print $follower['user_id']; ?>">
            <button type="submit" class="btn btn-light"><i class="fas fa-heart following"></i> フォロー中</button>
          </form>
      <?php } ?>
        </section>
    <?php } ?>
  <?php } else { ?>
            <p>フォロー中のユーザーはいません</p>
  <?php } ?>
          </article>

<!-- 自分の投稿記事をクリックした場合 -->
<?php } else if ($get_link === PROFILE_LINK['own_posts']) { ?>
          <article class="post">
  <?php if ($response_link !== []) { ?>
    <?php foreach ($response_link as $own_post) { ?>
            <section>
              <div>
                <a class="link_whole_parent" href="article.php?post=<?php print $own_post['post_id']; ?>"></a>
                <div><img src="<?php print $own_post['title_image']; ?>"></div>
                <h4><?php print $own_post['title']; ?></h4>
                <div><?php print $own_post['body']; ?></div>
                <div>ジャンル: <?php print PERMITTED_LANGUAGE_TYPES[$own_post['language_type']]; ?></div>
                <div>投稿日時:
                  <div><?php print $own_post['created']; ?></div>
                </div>
      <?php if (is_own_user($user, $another_user['user_id']) === false) { ?>
                <div class="favorite_button_area">
        <?php if (is_following_user($db, $user, $another_user['user_id']) === false) { ?>
                  <form method="post" action="following_user_register.php">
                    <input type="hidden" name="follower_id" value="<?php print $another_user['user_id']; ?>">
                    <button type="submit" class="btn btn-warning"><i class="fas fa-heart"></i> フォローする</button>
                  </form>
        <?php } else { ?>
                  <form method="post" action="following_user_delete.php">
                    <input type="hidden" name="follower_id" value="<?php print $another_user['user_id']; ?>">
                    <button type="submit" class="btn btn-light"><i class="fas fa-heart following"></i> フォロー中</button>
                  </form>
        <?php } ?>
        <?php if (is_favorite_post($db, $user, $own_post['post_id']) === false) { ?>
                  <form method="post" action="favorite_post_register.php">
                    <input type="hidden" name="post_id" value="<?php print $own_post['post_id']; ?>">
                    <button type="submit" class="btn btn-warning"><i class="fas fa-thumbs-up"></i> お気に入り</button>
                  </form>
        <?php } else { ?>
                  <form method="post" action="favorite_post_delete.php">
                    <input type="hidden" name="post_id" value="<?php print $own_post['post_id']; ?>">
                    <button type="submit" class="btn btn-light"><i class="fas fa-thumbs-up favorite_post"></i> お気に入り解除</button>
                  </form>
        <?php } ?>
                </div>
      <?php } ?>
              </div>
            </section>
    <?php } ?>
  <?php } else { ?>
            <p><?php print $another_user['user_name']; ?>さんの投稿記事はありません</p>
  <?php } ?>
          </article>

<!-- お気に入り記事をクリックした場合 -->
<?php } else if ($get_link === PROFILE_LINK['favorite_posts']) { ?>
          <article class="post">
  <?php if ($response_link !== []) { ?>
    <?php foreach ($response_link as $favorite_post) { ?>
            <section>
              <div>
                <a class="link_whole_parent" href="article.php?post=<?php print $favorite_post['post_id']; ?>"></a>
                <div><img src="<?php print $favorite_post['title_image']; ?>"></div>
                <h4><?php print $favorite_post['title']; ?></h4>
                <div><?php print $favorite_post['body']; ?></div>
                <div>ジャンル: <?php print PERMITTED_LANGUAGE_TYPES[$favorite_post['language_type']]; ?></div>
                <div class="post_user">
      <?php if (is_own_user($user, $favorite_post['user_id']) === true) { ?>
                  <a href="my_profile.php" class="btn btn-outline-dark" role="button">投稿者: <?php print $favorite_post['user_name']; ?></a>
      <?php } else { ?>
                  <a href="another_profile.php?user=<?php print $favorite_post['user_id']; ?>" class="btn btn-outline-success" role="button">投稿者: <?php print $favorite_post['user_name']; ?></a>
      <?php } ?>
                  <div>投稿日時:
                    <div><?php print $favorite_post['created']; ?></div>
                  </div>
                </div>
      <?php if (is_own_user($user, $favorite_post['user_id']) === false) { ?>
                <div class="favorite_button_area">
        <?php if (is_following_user($db, $user, $favorite_post['user_id']) === false) { ?>
                  <form method="post" action="following_user_register.php">
                    <input type="hidden" name="follower_id" value="<?php print $favorite_post['user_id']; ?>">
                    <button type="submit" class="btn btn-warning"><i class="fas fa-heart"></i> フォローする</button>
                  </form>
        <?php } else { ?>
                  <form method="post" action="following_user_delete.php">
                    <input type="hidden" name="follower_id" value="<?php print $favorite_post['user_id']; ?>">
                    <button type="submit" class="btn btn-light"><i class="fas fa-heart following"></i> フォロー中</button>
                  </form>
        <?php } ?>
        <?php if (is_favorite_post($db, $user, $favorite_post['post_id']) === false) { ?>
                  <form method="post" action="favorite_post_register.php">
                    <input type="hidden" name="post_id" value="<?php print $favorite_post['post_id']; ?>">
                    <button type="submit" class="btn btn-warning"><i class="fas fa-thumbs-up"></i> お気に入り</button>
                  </form>
        <?php } else { ?>
                  <form method="post" action="favorite_post_delete.php">
                    <input type="hidden" name="post_id" value="<?php print $favorite_post['post_id']; ?>">
                    <button type="submit" class="btn btn-light"><i class="fas fa-thumbs-up favorite_post"></i> お気に入り解除</button>
                  </form>
        <?php } ?>
                </div>
      <?php } ?>
              </div>
            </section>
    <?php } ?>
  <?php } else { ?>
            <p>お気に入り記事はありません</p>
  <?php } ?>
          </article>

<!-- 興味があるジャンルをクリックした場合 -->
<?php } else if ($get_link === PROFILE_LINK['favorite_languages']) { ?>
          <article class="favorite_languages">
            <form>
              <div class="form-group">
                <h4>興味があるジャンル</h4>
                <input type="hidden" name="language_types" value="">
  <?php foreach (PERMITTED_LANGUAGE_TYPES as $key => $value) { ?>
                <div class="form-check">
                  <label class="unchangeable_checkbox"><input type="checkbox" class="form-check-input" name="language_types[]" tabindex="-1" value="<?php print $key; ?>"<?php print $response_link[$key]; ?>><?php print $value; ?></label>
                </div>
  <?php } ?>
              </div>
            </form>
          </article>
<?php } ?>

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