<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/responsive.php'; ?>
  <title>投稿ページ</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'logined.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'post.css'; ?>">
  <!-- 投稿のテスト箇所 -->
  <script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
  <script>
    $(function(){
      $('#add').on('click',function(e){
        e.preventDefault();
        var ta = $('<textarea>');
        ta.attr('name','texts[]');
        ta.attr('class','form-control');
        $('#fm').append(ta);
        var ip= $('<input>');
        ip.attr('type','file');
        ip.attr('name','images[]');
        $('#fm').append(ip);
      });
    });
  </script>
  <!-- 投稿のテスト箇所 -->  
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
    <article class="container">
      <h2>投稿ページ</h2>
      <div class="alert alert-success alert-dismissible fade show">
        <h4>投稿方法</h4>
        <div>・記事に複数の画像を表示したり、文章と画像の表示する順番をカスタマイズする場合「フォーム追加」ボタンを押して下さい。</div>
        <div>・文章と画像は入力・アップロードした順番で記事に表示されます。</div>
        <div>・投稿内容の文章フォームは少なくとも一箇所の入力が必須です。</div>
        <div>・画像ファイルはJPEG、PNGのみ利用可能です。</div>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
      <?php include VIEW_PATH . 'templates/messages.php'; ?>
      <section>
        <form method="post" enctype="multipart/form-data" action="post_pre.php">
          <div class="form-group">
            <label>タイトル画像[任意]:<input type="file" name="title_image" class="form-control-file"></label>
          </div>
          <div class="form-group">
            <label>タイトル[必須]:<input type="text" name="title" class="form-control"></label>
          </div>
          <div id='fm' class="form-group">
            <div>投稿内容 ( 文章[一箇所以上必須]、画像[任意] ):</div>
            <textarea name="texts[]" class="form-control"></textarea>
            <input type="file" name="images[]">
          </div>
          <div class="form-inline">
            <label>記事のジャンル:
              <select name="language_type">
                <option value="">選択して下さい</option>
                <option value="1">HTML/CSS</option>
                <option value="2">JavaScript</option>
                <option value="3">PHP</option>
                <option value="4">MySQL</option>
                <option value="0">その他</option>
              </select>
            </label>
          </div>
          <button id='add' type="button" class="btn btn-secondary">フォーム追加</button>
          <input type="hidden" name="token" value="<?php print $token; ?>">
          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#post_pre_modal">プレビュー</button>
          <?php include VIEW_PATH . 'templates/dialog.php'; ?>
        </form>
      </section>
    </article>
  </main>
  <?php include VIEW_PATH . 'templates/menubar.php'; ?>
  <script type="text/javascript" src="<?php print JS_PATH . 'post.js'; ?>"></script>
</body>
</html>