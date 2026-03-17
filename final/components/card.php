<article class="card">
  <div class="card-img-wrap">
    <img class="card-img" src="../assets/images/<?= $item['img_url'] ?>" alt="<?= $item['item_name'] ?>">
  </div>

  <div class="card-bottom">
    <p class="card-name"><?= $item['item_name'] ?></p>

    <div class="card-action">
      <p class="card-price">$<?= $item['base_price'] ?></p>
      <?php if (isset($current_page) && $current_page === 'bag.php') : ?>
        <button class="add-btn" type="button" disabled>+</button>
      <?php endif ?>
    </div>
  </div>
</article>