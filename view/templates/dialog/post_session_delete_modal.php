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