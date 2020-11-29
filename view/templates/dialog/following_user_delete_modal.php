<!-- フォロー解除用 -->
<div class="modal" id="following_user_delete<?php print $key; ?>_modal" tabindex="-1" role="dialog" aria-labelledby="following_user_delete<?php print $key; ?>_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="following_user_delete<?php print $key; ?>_modal_label">フォロー解除の確認</h5>
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