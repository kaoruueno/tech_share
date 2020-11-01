<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/responsive.php'; ?>
  <title>投稿プレビューページ</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'logined.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'post.css'; ?>">
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
  /*.container .display_side section {*/
  /*  background-color: lightgray;*/
  /*}*/
  </style>
</head>
<body>
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <main>
  <article class="container">
    <h2>投稿プレビュー</h2>
    <div class="alert alert-warning alert-dismissible fade show">
      <strong>注意!</strong> - まだ投稿は完了していません。下の「投稿ボタン」を押すと投稿は完了します。
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
        <div class="form-inline">
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
        <div class="display_button">
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#post_session_delete_modal">投稿キャンセル</button>
          <?php include VIEW_PATH . 'templates/dialog.php'; ?>
          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#post_modal">投稿する</button>
          <?php include VIEW_PATH . 'templates/dialog.php'; ?>
        </div>
      </form>
    </section>
  </article>
          <!-- textareaの高さを調整する -->
          <!-- <div class="form-group" id="textarea">
            <textarea class="form-control" name="#"></textarea>
          </div> -->
          <!-- textareaの高さを調整する -->
          <!-- <div class="display_button">
            <a href="post.php" class="btn btn-secondary" role="button">リセット</a>
            <input type="submit" class="btn btn-success" value="投稿">
          </div>
        </form>
        <form method='POST' action="post_uproad_img.php" enctype='multipart/form-data' class="form-inline">
          <input type='file' name='img'> -->
          <!--<input type="hidden" name="post_type" value="">-->
          <!-- <input type='submit' class="btn btn-success" value='アップロード'>
        </form>
      </section>
    </article>


        <h3>test</h3>
        <div class="FlexTextarea">
          <div class="FlexTextarea__dummy" aria-hidden="true"></div>
          <textarea class="FlexTextarea__textarea"></textarea>
        </div>
        <p>余白</p> -->
        
  </main>
  <?php include VIEW_PATH . 'templates/menubar.php'; ?>
  <script type="text/javascript" src="<?php print JS_PATH . 'post.js'; ?>"></script>
</body>
</html>