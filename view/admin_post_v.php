<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/responsive.php'; ?>
  <title>投稿管理ページ</title>
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'common.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'logined.css'; ?>">
  <link rel="stylesheet" href="<?php print STYLESHEET_PATH . 'admin_post.css'; ?>">
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
      <h2>投稿記事一覧</h2>
      <section>
        <form class="form-inline">
          <!-- phpで検索された値を残しておく(selectedやvalue) -->
          <label>表示順:
                <select name="display_order">
                  <option value="">新着順</option>
                  <option value="1">投稿順</option>
                </select>
          </label>
          <label>記事のジャンル:
                <select name="language_type">
                  <option value="">全て</option>
                  <option value="1">HTML/CSS</option>
                  <option value="2">JavaScript</option>
                  <option value="3">PHP</option>
                  <option value="4">MySQL</option>
                  <option value="0">その他</option>
                </select>
          </label>
          <label><input type="search" class="form-control user_name" placeholder="ユーザー名を入力" value="phpでprint"></label>
          <input type="submit" class="btn btn-success" value="検索">
          <!-- phpで検索された値を残しておく(selectedやvalue) -->
        </form>
        <table border="2px" style="border-collapse: collapse; border-color: gray;">
          <tr>
            <th>投稿番号</th>
            <th>ユーザー名</th>
            <th>ジャンル</th>
            <th>投稿内容</th>
          </tr>
          
          <!-- foreach文で繰り返し表示 -->
          <tr>
            <td>111</td>
            <td>aaaaaa</td>
            <td>MySQL</td>
            <td>
              <input type="submit" class="btn btn-success" value="見る">
              <input type="hidden" class="post_id" value="phpで埋め込む">
            </td>
          </tr>
          <tr>
            <td>112</td>
            <td>bbbbbb</td>
            <td>HTML/CSS</td>
            <td>
              <input type="submit" class="btn btn-success" value="見る">
              <input type="hidden" class="post_id" value="phpで埋め込む">
            </td>
          </tr>
          <!-- foreach文で繰り返し表示 -->
          
        </table>
      </section>
      <!-- if文 ページネーション(order_view.phpを見ながら変更) -->
      <div class="display_count">○○○件中 ○ - ○件目の記事</div>
      <div class="pagination">
        <div>最初へ 前へ 1 2 3 4 5 次へ 最後へ</div>
      </div>
      <!-- if文 ページネーション(order_view.phpを見ながら) -->
    </article>
  </main>
  <?php include VIEW_PATH . 'templates/menubar.php'; ?>
</body>
</html>