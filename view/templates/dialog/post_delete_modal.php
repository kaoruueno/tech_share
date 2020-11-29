<!-- 投稿記事削除用 -->
<div class="modal" id="post_delete<?php print $key; ?>_modal" tabindex="-1" role="dialog" aria-labelledby="post_delete<?php print $key; ?>_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="post_delete<?php print $key; ?>_modal_label">投稿記事削除の確認</h5>
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