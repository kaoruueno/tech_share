<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/responsive.php'; ?>
  <?php include VIEW_PATH . 'templates/icon.php'; ?>
  <title>マイページ</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'logined.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'account.css'; ?>">
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
      <div>ユーザー名:<span><?php print $user['user_name']; ?></span></div>
      <div class="follow">
<!-- <a>のそれぞれのリンクのレスポンスを受けたときにクラス名（btn-outline-dark）の箇所を変える関数を作る -->
        <a href="?followings=1" class="<?php print $button['followings']['class']; ?>"<?php print $button['followings']['disabled']; ?> role="button">フォロー <?php print $follow_count['followings']; ?></a>
        <a href="?followers=1" class="<?php print $button['followers']['class']; ?>"<?php print $button['followers']['disabled']; ?> role="button">フォロワー <?php print $follow_count['followers']; ?></a>
      </div>
      <div class="profile_bar">
        <a href="?own_posts=1" class="<?php print $button['own_posts']['class']; ?>"<?php print $button['own_posts']['disabled']; ?> role="button"><?php print $user['user_name']; ?>さんの投稿記事</a>
        <a href="?favorite_posts=1" class="<?php print $button['favorite_posts']['class']; ?>"<?php print $button['favorite_posts']['disabled']; ?> role="button">お気に入り記事</a>
        <a href="?favorite_languages=1" class="<?php print $button['favorite_languages']['class']; ?>"<?php print $button['favorite_languages']['disabled']; ?> role="button">興味があるジャンル</a>
<!-- <a>のそれぞれのリンクのレスポンスを受けたときにクラス名（btn-outline-dark）の箇所を変える関数を作る -->
      </div>


      <!-- <a href="?own_posts=1" class="btn btn-primary disabled" tabindex="-1" role="button" aria-disabled="true">Disabled</a> -->
      <!-- aria-disabled="true" -->

<!-- フォローをクリックした場合 -->
<?php if ($get_link === MY_PROFILE_LINK['followings']) { ?>
      <article class="follow_list">
        <h4>フォロー リスト</h4>
  <?php if ($response_link !== []) { ?>
        <table>
    <?php foreach ($response_link as $following) { ?>
          <tr>
            <td>
              <a href="others_profile.php?user=<?php print $following['user_id']; ?>"><?php print $following['user_name']; ?></a>                  
            </td>
            <td>
              <form method="post" action="following_user_delete.php">
                <input type="hidden" name="follower_id" value="<?php print $following['user_id']; ?>">
                <button type="submit" class="btn btn-light"><i class="fas fa-heart following"></i> フォロー中</button>
              </form>
            </td>
          </tr>
    <?php } ?>
        </table>
  <?php } else { ?>
        <p>フォロー中のユーザーはいません</p>
  <?php } ?>
      </article>
      
<!-- フォロワーをクリックした場合 -->
<?php } else if ($get_link === MY_PROFILE_LINK['followers']) { ?>
      <article class="follow_list">
        <h4>フォロワー リスト</h4>
  <?php if ($response_link !== []) { ?>
            <table>
    <?php foreach ($response_link as $follower) { ?>
              <tr>
                <td>
                  <a href="others_profile.php?user=<?php print $follower['user_id']; ?>"><?php print $follower['user_name']; ?></a>                  
                </td>
                <td>
      <?php if (is_following_user($db, $user, $follower['user_id']) === false) { ?>      
                  <form method="post" action="following_user_register.php">
                    <input type="hidden" name="follower_id" value="<?php print $follower['user_id']; ?>">
                    <button type="submit" class="btn btn-warning"><i class="fas fa-heart"></i> フォローする</button>
                  </form>
      <?php } else { ?>
                  <form method="post" action="following_user_delete.php">
                    <input type="hidden" name="follower_id" value="<?php print $follower['user_id']; ?>">
                    <button type="submit" class="btn btn-light"><i class="fas fa-heart following"></i> フォロー中</button>
                  </form>
      <?php } ?>
                </td>
              </tr>
    <?php } ?>
            </table>
  <?php } else { ?>
            <p>フォロー中のユーザーはいません</p>
  <?php } ?>
          </article>

<!-- 自分の投稿記事をクリックした場合 -->
<?php } else if ($get_link === MY_PROFILE_LINK['own_posts']) { ?>
          <article class="post">
  <?php if ($response_link !== []) { ?>
    <?php foreach ($response_link as $own_post) { ?>
            <section>
              <div>
                <a class="link_whole_parent" href="article.php?post=<?php print $own_post['post_id']; ?>"></a>
                <div><img src="<?php print $own_post['title_image']; ?>"></div>
                <h4><?php print $own_post['title']; ?></h4>
                <div><?php print $own_post['body']; ?></div>
                <div>ジャンル:<?php print PERMITTED_LANGUAGE_TYPES[$own_post['language_type']]; ?></div>
              </div>
            </section>
    <?php } ?>
  <?php } else { ?>
            <p><?php print $user['user_name']; ?>さんの投稿記事はありません</p>
  <?php } ?>
          </article>

<!-- お気に入り記事をクリックした場合 -->
<?php } else if ($get_link === MY_PROFILE_LINK['favorite_posts']) { ?>
          <article class="post">
  <?php if ($response_link !== []) { ?>
    <?php foreach ($response_link as $favorite_post) { ?>
            <section>
              <div>
                <a class="link_whole_parent" href="article.php?post=<?php print $favorite_post['post_id']; ?>"></a>
                <div><img src="<?php print $favorite_post['title_image']; ?>"></div>
                <h4><?php print $favorite_post['title']; ?></h4>
                <div><?php print $favorite_post['body']; ?></div>
                <div>ジャンル:<?php print PERMITTED_LANGUAGE_TYPES[$favorite_post['language_type']]; ?></div>
                <div>投稿者:<?php print $favorite_post['user_name']; ?></div>
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
                  <form method="post" action="favorite_post_delete.php">
                    <input type="hidden" name="post_id" value="<?php print $favorite_post['post_id']; ?>">
                    <button type="submit" class="btn btn-light"><i class="fas fa-thumbs-up favorite_post"></i> お気に入り解除</button>
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
<?php } else if ($get_link === MY_PROFILE_LINK['favorite_languages']) { ?>
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
                <div><input type="submit" class="btn btn-success" value="更新"></div>
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