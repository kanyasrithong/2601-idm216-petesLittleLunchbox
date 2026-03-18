<?php
  // reset variants for each item to prevent bleed
  $variants = $item['variants'] ?? [];
?>
<div class="summary-item">
  <div class="summary-row">
    <p class="summary-bold">x<?= $item['item_quantity'] ?> <?= $item['item_name'] ?></p>
    <p class="summary-bold">$<?= number_format($item['item_total'] * $item['item_quantity'], 2) ?></p>
  </div>
  <?php if (!empty($variants)) : ?>
    <?php foreach ($variants as $variant) : ?>
      <div class="summary-row">
        <?php if ($variant['variant_name'] != 'None') : ?>
          <p class="summary-bold">+<?= $variant['variant_name'] ?></p>
          <!-- Create $variant_price if more than 0 -->
          <?php if ($variant['add_price'] != 0 ) : ?>
            <?php $variant_price = $variant['add_price'] * $item['item_quantity'] ?>
            <p class="summary-bold">$<?= number_format($variant_price, 2) ?></p>
          <?php endif ?>
        <?php endif ?>
      </div>
    <?php endforeach ?>
  <?php endif?>
</div>
