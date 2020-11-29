<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/design.php'; ?>
  <title><?php print $user['user_name']; ?>さんのマイページ</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'message.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'articles_list.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'profile.css'; ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <main>
    <div class="ctr">
      <h2>マイプロフィール</h2>
      <?php include VIEW_PATH . 'templates/messages.php'; ?>
      <div>ユーザー名: <span><?php print $user['user_name']; ?></span></div>
      <div class="follow_count">
        <a href="?followings=1" class="<?php print $button['followings']['class']; ?>"<?php print $button['followings']['disabled']; ?> role="button">フォロー <?php print $follow_count['followings']; ?></a>
        <a href="?followers=1" class="<?php print $button['followers']['class']; ?>"<?php print $button['followers']['disabled']; ?> role="button">フォロワー <?php print $follow_count['followers']; ?></a>
      </div>
      <div class="profile_bar">
        <a href="?own_posts=1" class="<?php print $button['own_posts']['class']; ?>"<?php print $button['own_posts']['disabled']; ?> role="button">投稿記事</a>
        <a href="?favorite_posts=1" class="<?php print $button['favorite_posts']['class']; ?>"<?php print $button['favorite_posts']['disabled']; ?> role="button">お気に入り記事</a>
        <a href="?favorite_languages=1" class="<?php print $button['favorite_languages']['class']; ?>"<?php print $button['favorite_languages']['disabled']; ?> role="button">興味があるジャンル</a>
      </div>
<!-- フォローをクリックした場合 -->
<?php if ($get_link === PROFILE_LINK['followings']) { ?>
      <article class="follow_list">
        <h4>フォロー リスト</h4>
  <?php if ($response_link !== []) { ?>
    <?php foreach ($response_link as $key => $following) { ?>
        <section>
          <a href="another_profile.php?user=<?php print $following['user_id']; ?>"><?php print $following['user_name']; ?></a>
          <form method="post" action="following_user_delete.php">
            <input type="hidden" name="follower_id" value="<?php print $following['user_id']; ?>">
            <input type="hidden" name="token" value="<?php print $token; ?>">
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#following_user_delete<?php print $key; ?>_modal"><i class="fas fa-heart following"></i> フォロー中</button>
            <?php include DIALOG_PATH . 'following_user_delete_modal.php'; ?>
          </form>
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
    <?php foreach ($response_link as $key => $follower) { ?>
        <section>
          <a href="another_profile.php?user=<?php print $follower['user_id']; ?>"><?php print $follower['user_name']; ?></a>
      <?php if (is_following_user($db, $user, $follower['user_id']) === false) { ?>
          <form method="post" action="following_user_register.php">
            <input type="hidden" name="follower_id" value="<?php print $follower['user_id']; ?>">
            <input type="hidden" name="token" value="<?php print $token; ?>">
            <button type="submit" class="btn btn-warning"><i class="fas fa-heart"></i> フォローする</button>
          </form>
      <?php } else { ?>
          <form method="post" action="following_user_delete.php">
            <input type="hidden" name="follower_id" value="<?php print $follower['user_id']; ?>">
            <input type="hidden" name="token" value="<?php print $token; ?>">
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#following_user_delete<?php print $key; ?>_modal"><i class="fas fa-heart following"></i> フォロー中</button>
            <?php include DIALOG_PATH . 'following_user_delete_modal.php'; ?>
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
    <?php foreach ($response_link as $key => $own_post) { ?>
        <section>
          <div>
            <a class="link_whole_parent" href="article.php?post=<?php print $own_post['post_id']; ?>"></a>
            <div><img src="<?php print $own_post['title_image']; ?>"></div>
      <?php if (is_own_post($db, $user, $own_post['post_id']) === true) { ?>
            <form class="delete_button_area" method="post" action="post_delete.php">
              <input type="hidden" name="post_id" value="<?php print $own_post['post_id']; ?>">
              <input type="hidden" name="token" value="<?php print $token; ?>">
              <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#post_delete<?php print $key; ?>_modal"><i class="far fa-trash-alt"></i> 投稿削除</button>
              <?php include DIALOG_PATH . 'post_delete_modal.php'; ?>
            </form>
      <?php } ?>
            <h4><?php print $own_post['title']; ?></h4>
            <div><?php print $own_post['body']; ?></div>
            <div class="post_details">
              <div>ジャンル: <?php print PERMITTED_LANGUAGE_TYPES[$own_post['language_type']]; ?></div>
              <div>投稿日時:
                <div><?php print $own_post['created']; ?></div>
              </div>
            </div>
          </div>
        </section>
    <?php } ?>
  <?php } else { ?>
        <p><?php print $user['user_name']; ?>さんの投稿記事はありません</p>
  <?php } ?>
      </article>
<!-- お気に入り記事をクリックした場合 -->
<?php } else if ($get_link === PROFILE_LINK['favorite_posts']) { ?>
      <article class="post">
  <?php if ($response_link !== []) { ?>
    <?php foreach ($response_link as $key => $favorite_post) { ?>
        <section>
          <div>
            <a class="link_whole_parent" href="article.php?post=<?php print $favorite_post['post_id']; ?>"></a>
            <div><img src="<?php print $favorite_post['title_image']; ?>"></div>
      <?php if (is_admin($user) === true) { ?>
            <form class="delete_button_area" method="post" action="post_delete.php">
              <input type="hidden" name="post_id" value="<?php print $favorite_post['post_id']; ?>">
              <input type="hidden" name="token" value="<?php print $token; ?>">
              <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#post_delete<?php print $key; ?>_modal"><i class="far fa-trash-alt"></i> 投稿削除</button>
              <?php include DIALOG_PATH . 'post_delete_modal.php'; ?>
            </form>
      <?php } ?>
            <h4><?php print $favorite_post['title']; ?></h4>
            <div><?php print $favorite_post['body']; ?></div>
            <div class="post_details">
              <div>ジャンル: <?php print PERMITTED_LANGUAGE_TYPES[$favorite_post['language_type']]; ?></div>
              <div>投稿日時:
                <div><?php print $favorite_post['created']; ?></div>
              </div>
            </div>
            <a href="another_profile.php?user=<?php print $favorite_post['user_id']; ?>" class="btn btn-outline-success" role="button">投稿者: <?php print $favorite_post['user_name']; ?></a>
            <div class="favorite_button_area">
      <?php if (is_following_user($db, $user, $favorite_post['user_id']) === false) { ?>
              <form method="post" action="following_user_register.php">
                <input type="hidden" name="follower_id" value="<?php print $favorite_post['user_id']; ?>">
                <input type="hidden" name="token" value="<?php print $token; ?>">
                <button type="submit" class="btn btn-warning"><i class="fas fa-heart"></i> フォローする</button>
              </form>
      <?php } else { ?>
              <form method="post" action="following_user_delete.php">
                <input type="hidden" name="follower_id" value="<?php print $favorite_post['user_id']; ?>">
                <input type="hidden" name="token" value="<?php print $token; ?>">
                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#following_user_delete<?php print $key; ?>_modal"><i class="fas fa-heart following"></i> フォロー中</button>
                <?php include DIALOG_PATH . 'following_user_delete_modal.php'; ?>
              </form>
      <?php } ?>
              <form method="post" action="favorite_post_delete.php">
                <input type="hidden" name="post_id" value="<?php print $favorite_post['post_id']; ?>">
                <input type="hidden" name="token" value="<?php print $token; ?>">
                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#favorite_post_delete<?php print $key; ?>_modal"><i class="fas fa-thumbs-up favorite_post"></i> お気に入り解除</button>
                <?php include DIALOG_PATH . 'favorite_post_delete_modal.php'; ?>
              </form>
            </div>
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
        <form method="post" action="favorite_languages_change.php">
          <div class="form-group">
            <h4>興味があるジャンル</h4>
            <input type="hidden" name="language_types" value="">
  <?php foreach (PERMITTED_LANGUAGE_TYPES as $key => $value) { ?>
            <div class="form-check">
              <label><input type="checkbox" class="form-check-input" name="language_types[]" value="<?php print $key; ?>"<?php print $response_link[$key]; ?>><?php print $value; ?></label>
            </div>
  <?php } ?>
            <input type="hidden" name="token" value="<?php print $token; ?>">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#favorite_languages_change_modal">変更する</button>
            <?php include DIALOG_PATH . 'favorite_languages_change_modal.php'; ?>
          </div>
        </form>
      </article>
<?php } ?>
    </div>
  </main>
  <?php include VIEW_PATH . 'templates/menubar.php'; ?>
  <?php include DIALOG_PATH . 'logout_modal.php'; ?>
</body>
</html>