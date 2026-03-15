<?php
  // loads each order item as a component
  $variants = $item['variants'] ?? [];
  ?>
  <article class="bag-item" data-id="<?= $item['id'] ?>">
    <div class="bag-item-row">
      <img class="bag-item-img" src="../../../assets/images/<?= $item['img_url'] ?>" alt="<?= $item['item_name'] ?>" />
      <div class="bag-item-content">
        <div class="bag-item-topline">
          <div class="bag-item-text">
            <p class="bag-item-name"><?= $item['item_name'] ?></p>
            <?php if (!empty($variants)) : ?>
              <?php foreach ($variants as $variant) : ?>
                <div class="item-row variant">
                  <?php if ($variant['variant_name'] != 'None') : ?>
                    <p class="bag-item-addon">
                      + <?= $variant['variant_name'] ?>
                    </p>
                  <?php endif?>
                </div>
              <?php endforeach ?>
            <?php endif ?>
          </div>
          <?php 
            $variant_total = 0;

            foreach ($variants as $variant) {
              $variant_total += $variant['add_price'];
            }

            $item_total = $item['item_quantity'] * ($item['item_total'] + $variant_total);
            $subtotal += $item_total;
          ?>
          <div class="bag-item-right">
            <p class="bag-item-price">$<?= number_format($item_total, 2) ?></p>
            <a class="trash-btn" href="bag.php?remove=<?= $item['id']; ?>" aria-label="Remove item">🗑</a>
          </div>
        </div>
        <div class="bag-item-bottomline">
            <a class="edit-btn" href="${item.editHref || "customize.html"}">EDIT ✎</a>

            <div class="qty-controls cart" data-id="<?= $item['id'] ?>">
              <button class="qty-btn minus" type="button" aria-label="Decrease quantity">
                <img src="../assets/images/icons/Minus.svg" alt="Subtract">
              </button>
              <p class="qty-value"><?= $item['item_quantity'] ?></p>
              <button class="qty-btn plus" type="button" aria-label="Increase quantity">
                <img src="../assets/images/icons/Plus.svg" alt="Add">
              </button>
            </div>
          </div>
      </div>
    </div>
  </article>
  