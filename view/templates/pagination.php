<?php if ($pagination['all_articles_count'] > 0) { ?>
<div class="pagination_area">
  <?php if ($pagination['display_count']['min'] < $pagination['display_count']['max']) { ?>
  <div><?php print $pagination['all_articles_count']; ?>件中 <?php print $pagination['display_count']['min']; ?> - <?php print $pagination['display_count']['max']; ?>件目の記事</div>
  <?php } else {?>
  <div><?php print $pagination['all_articles_count']; ?>件中 <?php print $pagination['display_count']['min']; ?>件目の記事</div>
  <?php } ?>
  <div>
  <?php if ($pagination['current_page'] >= 3) { ?>
    <a href="<?php print $pagination['url_param'] . '1'; ?>">最初へ</a>
  <?php } ?>
  <?php if ($pagination['current_page'] > 1) { ?>
    <a href="<?php print $pagination['url_param'] . ($pagination['current_page'] - 1); ?>">前へ</a>
  <?php } ?>
  <?php $pagination_count = 0; ?>
  <?php for ($i = -2; $i <= 2; $i++) { ?>
    <?php if ($i === 0) { ?>
      <div class="current"><?php print $pagination['current_page']; ?></div>
      <?php $pagination_count++; ?>
    <?php } else if ($pagination['current_page']+$i > 0 && $pagination['current_page']+$i <= $pagination['all_page']) { ?>
      <a href="<?php print $pagination['url_param'] . ($pagination['current_page'] + $i); ?>"><?php print $pagination['current_page'] + $i; ?></a>
      <?php $pagination_count++; ?>
    <?php } ?>
    <?php if ($pagination_count >= 3) { ?>
      <?php break; ?>
    <?php } ?>
  <?php } ?>
  <?php if ($pagination['current_page'] < $pagination['all_page']) { ?>
      <a href="<?php print $pagination['url_param'] . ($pagination['current_page'] + 1); ?>">次へ</a>
  <?php } ?>
  <?php if ($pagination['all_page'] - $pagination['current_page'] >= 2) { ?>
      <a href="<?php print $pagination['url_param'] . $pagination['all_page']; ?>">最後へ</a>
  <?php } ?>
  </div>
</div>
<?php } ?>