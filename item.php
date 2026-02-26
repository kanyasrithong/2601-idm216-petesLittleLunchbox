<?php
  session_start();
  require_once "db.php";
  include "functions/items.php";
  include "functions/variants.php";
  include "functions/bs_variants.php";

  $variants = [];
  $bs_variants = [];
  
  if (isset($_GET['item'])) {
    $item_name = urldecode($_GET['item']);
    $item = getItemByName($item_name);
  }

  // get meat variants for Egg & Cheese
  if ($item['id'] === 1) {
    $bs_variants = getBSVariants();
  }

  if($item['category_id'] === 1 || $item['category_id'] === 2 || $item['category_id'] === 4) {
    $variants = getVariantsByCategory($item['category_id']);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $item_name ?> - Pete's Little Lunchbox</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body class="body-center">
  <a class="back-button" href="menu.php">Back</a>
  <img src="assets/images/<?= $item['img_url'] ?>" alt="">
  <h1><?= $item['item_name'] ?></h1>
  <p><?= $item['description'] ?></p>
  <p>$<?= $item['base_price'] ?></p>
  <form method="post" action="functions/helpers/add_to_bag.php?item_id=<?= $item['id'] ?>">
    <?php if (!empty($variants)) : ?>
    <fieldset>
      <?php
      // check whether variant is Bread or Size
        $first_key = array_key_first($variants);
        $first_variant = $variants[$first_key];

        if ($first_variant['category_id'] === '4') {
          $variant_type = 'size';
        } else {
          $variant_type = 'bread';
        }
       ?>
      <span>*<?= ucfirst($variant_type) ?></span>
      <span>[select one]</span>
      <?php foreach ($variants as $variant) : ?>
        <label>
          <input type="radio" name="variants[<?= $variant_type ?>]" value="<?= $variant['id'] ?>" required>
          <h3><?= $variant['variant_name'] ?></h3>
        </label>
      <?php endforeach ?>
    <?php endif ?>
    </fieldset>

    <?php if (!empty($bs_variants)) : ?>
      <fieldset>
      <span>*Meat</span>
      <span>[select one]</span>
      <?php foreach ($bs_variants as $bs_variant) : ?>
        <label>
          <input type="radio" name="variants[meat]" value="<?= $bs_variant['id'] ?>" required>
          <h3><?= $bs_variant['bs_name'] ?></h3>
        </label>
      <?php endforeach ?>
    </fieldset>
    <?php endif ?>
    <input type="submit" value="Add to Bag">
  </form>
  <?php 
    var_dump($item['category_id']);
    var_dump($first_variant['category_id']);
  ?>
</body>
</html>