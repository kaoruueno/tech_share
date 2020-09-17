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
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <section>
      <div class="post_pre">
<?php print $pre_title; ?>
<?php print $pre_tmb_img_file; ?>
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
              <option value="<?php print $key ?>"<?php print $selected ?>><?php print $value ?></option>
  <?php } ?>
            </select>
          </label>
        </div>
        <div class="display_button">
          <a href="post.php" class="btn btn-secondary" role="button">リセット</a>
          <input type="submit" class="btn btn-success" value="投稿">
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