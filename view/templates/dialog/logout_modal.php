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