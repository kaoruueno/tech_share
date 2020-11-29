<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/design.php'; ?>
  <title>投稿プレビューページ</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'message.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'post.css'; ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <main>
    <div class="ctr">
      <h2>投稿プレビュー</h2>
      <div class="alert alert-warning alert-dismissible fade show">
        <strong>注意!</strong> - まだ投稿は完了していません。下の「投稿ボタン」を押すと投稿が完了します。
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
      <?php include VIEW_PATH . 'templates/messages.php'; ?>
      <section>
        <div class="post_pre">
          <?php print $pre_title_img_file; ?>
          <?php print $pre_title; ?>
          <?php print $pre_body; ?>
        </div>
        <form method="post" action="post_register.php">
          <div class="form-group">
            <label>記事のジャンル:
              <select name="language_type">
<?php if ($language_type === '') { ?>
                <option value="">選択してください</option>
<?php } ?>
  <?php foreach (PERMITTED_LANGUAGE_TYPES as $key => $value) { ?>
    <?php if ($language_type !== '' && (int)$language_type === $key) { ?>
      <?php $selected = ' selected'; ?>
    <?php } else { ?>
      <?php $selected = ''; ?>
    <?php } ?>
                <option value="<?php print $key; ?>"<?php print $selected; ?>><?php print $value; ?></option>
  <?php } ?>
              </select>
            </label>
          </div>
          <input type="hidden" name="token" value="<?php print $token; ?>">
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#post_session_delete_modal">投稿キャンセル</button>
          <?php include DIALOG_PATH . 'post_session_delete_modal.php'; ?>
          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#post_modal">投稿する</button>
          <?php include DIALOG_PATH . 'post_modal.php'; ?>
        </form>
      </section>
    </div>
  </main>
  <?php include VIEW_PATH . 'templates/menubar.php'; ?>
  <?php include DIALOG_PATH . 'logout_modal.php'; ?>
</body>
</html>