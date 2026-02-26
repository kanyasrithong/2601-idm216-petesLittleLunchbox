<?php
  if (isset($item['variants'])) {
    $variants = $item['variants'];
  }
    $subtotal += $item['item_total'];
  ?>
  <article class="order-summary-row">
    <div class="item-details">
      <h3><?= $item['item_name'] ?></h3>
      <!-- Load variants if they exist -->
      <?php if (isset($variants)) : ?>
        <?php foreach ($variants as $type => $variant) : ?>
          <?php if ($variant != 'None') : ?>
            <h4>+ <?= $variant ?></h4>
          <?php endif?>
        <?php endforeach ?>
      <?php endif ?>
    </div>
    <div class="bag-details">
      <h3>$<?= number_format($item['item_total'], 2) ?></h3>
      <?php if (isset($current_page) && $current_page === 'bag.php') : ?>
        <a href="bag.php?remove=<?= $item['id']; ?>">Remove</a>
      <?php endif?>
    </div>
  </article>
  