<?php
  if (isset($item['variants'])) {
    $variants = $item['variants'];
  }
    $subtotal += $item['item_total'];
  ?>
  <article class="order-summary-row">
    <div class="item-details">
      <div class="item-row">
        <h3><?= $item['item_name'] ?></h3>
        <h3>$<?= number_format($item['item_total'], 2) ?></h3>
      </div>

      <!-- Load variants if they exist -->
      <?php if (isset($variants)) : ?>
        <?php foreach ($variants as $type => $variant_details) : ?>
          <div class="item-row">
            <?php if ($variant_details['variant_name'] != 'None') : ?>
              <h4>
                + <?= $variant_details['variant_name'] ?>
              </h4>
            <?php endif?>
            <!-- Create $variant_price if more than 0 -->
            <?php if ($variant_details['add_price'] != 0 ) : ?>
              <?php $variant_price = $variant_details['add_price'] ?>
              <b>+ $<?= number_format($variant_price, 2) ?></b>

              <!-- Add variant price if exists and remove after listing it -->
              <?php
                $variant_total += $variant_price;
                $variant_price = 0; 
              ?>
            <?php endif ?>
          </div>
        <?php endforeach ?>
        <!-- Create remove button if bag.php -->
        <?php if (isset($current_page) && $current_page === 'bag.php') : ?>
          <div class="item-row">
            <a href="bag.php?remove=<?= $item['id']; ?>">Remove</a>
          </div>
        <?php endif?>
      <?php endif ?>
    </div>
  </article>
  