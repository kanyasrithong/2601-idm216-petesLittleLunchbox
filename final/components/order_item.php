<?php
  // loads each bag item as a component
  $variants = $item['variants'] ?? [];
  ?>

  <article class="confirm-card">
    <img class="confirm-card-img" src="../assets/images/<?= $item['img_url'] ?>" alt="<?= $item['item_name'] ?>" />

    <div class="confirm-card-body">
      <div class="confirm-card-top">
        <div class="confirm-card-text">
          <p class="confirm-card-name"><?= $item['item_name'] ?></p>
          <?php if (!empty($variants)) : ?>
            <div class="confirm-card-addons">
              <?php foreach ($variants as $variant) : ?>
                <?php if ($variant['variant_name'] != 'None') : ?>
                  <p class="confirm-card-addon">
                    + <?= $variant['variant_name'] ?>
                  </p>
                <?php endif?>
              <?php endforeach ?>
            </div>
          <?php endif ?>
        </div>
        <?php 
          $variant_total = 0;

          foreach ($variants as $variant) {
            $variant_total += $variant['add_price'];
          }

          $item_total = $item['item_quantity'] * ($item['item_total'] + $variant_total);
        ?>
        <p class="confirm-card-price">$<?= number_format($item_total, 2) ?></p>
      </div>

      <p class="confirm-card-qty">Qty: <?= $item['item_quantity'] ?></p>
    </div>
  </article>
