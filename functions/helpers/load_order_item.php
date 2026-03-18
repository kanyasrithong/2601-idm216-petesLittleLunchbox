<?php
  // loads each order item as a component
  $variants = $item['variants'] ?? [];
  $item_total = $item['item_total'] * $item['item_quantity'];
  $subtotal += $item_total;
  ?>
  <article class="order-summary-row" data-id="<?= $item['id'] ?>">
    <div class="item-details">
      <div class="item-row">
        <h3><?= $item['item_name'] ?></h3>
        <h3>$<?= number_format($item_total, 2) ?></h3>
      </div>

      <!-- Load variants if they exist -->
      <?php if (!empty($variants)) : ?>
        <?php foreach ($variants as $type => $variant_details) : ?>
          <div class="item-row variant">
            <?php if ($variant_details['variant_name'] != 'None') : ?>
              <h4 class="variant">
                + <?= $variant_details['variant_name'] ?>
              </h4>
            <?php endif?>
            <!-- Create $variant_price if more than 0 -->
            <?php if ($variant_details['add_price'] != 0 ) : ?>
              <?php $variant_price = $variant_details['add_price'] * $item['item_quantity'] ?>
              <b class="variant-price">+ $<?= number_format($variant_price, 2) ?></b>

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
              <div class="quantity-control cart" data-id="<?= $item['id'] ?>">
                <button type="button" class="quantity-button minus">-</button>
                <input type="number" class="quantity-value" min="1" name="quantity" value="<?=$item['item_quantity'] ?>">
                <button type="button" class="quantity-button plus">+</button>
              </div>
          </div>
        <?php endif?>
      <?php endif ?>
    </div>
  </article>
  