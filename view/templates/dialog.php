<!-- お気に入り記事解除用 -->
<div class="modal" id="favorite_post_delete_modal" tabindex="-1" role="dialog" aria-labelledby="favorite_post_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="favorite_post_delete_modal_label">お気に入り解除の確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">指定した記事をお気に入りから解除しますか？</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">いいえ</button>
        <button type="submit" class="btn btn-danger">お気に入り解除</button>
      </div>
    </div>
  </div>
</div>
<!-- フォロー解除用 -->
<div class="modal" id="following_user_delete_modal" tabindex="-1" role="dialog" aria-labelledby="following_user_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="following_user_delete_modal_label">フォロー解除の確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">フォローを解除しますか？</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">いいえ</button>
        <button type="submit" class="btn btn-danger">フォロー解除</button>
      </div>
    </div>
  </div>
</div>
<!-- 投稿記事削除用 -->
<div class="modal" id="post_delete_modal" tabindex="-1" role="dialog" aria-labelledby="post_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="post_delete_modal_label">投稿記事削除の確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">投稿記事を削除しますか？</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">いいえ</button>
        <button type="submit" class="btn btn-danger">投稿記事削除</button>
      </div>
    </div>
  </div>
</div>
<!-- ログアウト用 -->
<div class="modal" id="logout_modal" tabindex="-1" role="dialog" aria-labelledby="logout_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logout_modal_label">ログアウト実行の確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">ログアウトしますか？</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">いいえ</button>
        <a class="btn btn-danger" href="<?php print LOGOUT_URL; ?>" role="button">ログアウト</a>
      </div>
    </div>
  </div>
</div>
<!-- 興味があるジャンルの変更用 -->
<div class="modal" id="favorite_languages_change_modal" tabindex="-1" role="dialog" aria-labelledby="favorite_languages_change_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="favorite_languages_change_modal_label">興味があるジャンル変更の確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">興味があるジャンルを変更しますか？</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">いいえ</button>
        <button type="submit" class="btn btn-success">変更する</button>
      </div>
    </div>
  </div>
</div>
<!-- 投稿プレビュー用 -->
<div class="modal" id="post_pre_modal" tabindex="-1" role="dialog" aria-labelledby="post_pre_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="post_pre_modal_label">投稿プレビュー(投稿する内容の確認)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">こちらの内容で投稿プレビューしますか？</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">いいえ</button>
        <button type="submit" class="btn btn-warning">プレビュー</button>
      </div>
    </div>
  </div>
</div>
<!-- 投稿用 -->
<div class="modal" id="post_modal" tabindex="-1" role="dialog" aria-labelledby="post_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="post_modal_label">投稿の確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">こちらの内容で投稿を確定しますか？</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">いいえ</button>
        <button type="submit" class="btn btn-warning">投稿する</button>
      </div>
    </div>
  </div>
</div>
<!-- 新規登録用 -->
<div class="modal" id="signup_modal" tabindex="-1" role="dialog" aria-labelledby="signup_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signup_modal_label">ユーザー登録の確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">こちらの内容でユーザー登録を確定しますか？</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">いいえ</button>
        <button type="submit" class="btn btn-success">登録する</button>
      </div>
    </div>
  </div>
</div>
<!-- 投稿プレビュー(仮保存)データのセッション削除用 -->
<div class="modal" id="post_session_delete_modal" tabindex="-1" role="dialog" aria-labelledby="post_session_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="post_session_delete_modal_label">入力した投稿内容の削除の確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">入力した投稿内容を削除しますか？</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">いいえ</button>
        <a class="btn btn-danger" href="post_session_delete.php" role="button">削除する</a>
      </div>
    </div>
  </div>
</div>