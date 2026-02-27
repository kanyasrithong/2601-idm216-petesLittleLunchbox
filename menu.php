<?php
  session_start();
  require_once "db.php";
  include "functions/categories.php";
  include "functions/items.php";

  // initialize this after order is confirmed (check confirmation.php)
  if (isset($_GET['clear']) && $_GET['clear'] === 'true') {
    $_SESSION['bag'] = [];
    header('Location: menu.php');
    exit;
  }

  if (!isset($_SESSION['bag'])) {
    $_SESSION['bag'] = [];
  }

  $bag_count = count($_SESSION['bag']);
  $categories = getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - Pete's Little Lunchbox</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body class="body-center">
  <a href="bag.php">Bag<?php if (!empty($_SESSION['bag'])) echo ' (' . $bag_count . ') '?></a>
  <?php foreach ($categories as $category) : ?> 
    <?php $category_items = getItemsByCategory($category['id']); ?>
    <section>
    <h1><?= $category['category_name'] ?></h1>
    <div class="card-grid">
      <?php foreach ($category_items as $category_item) : ?>
      <a href="item.php?item=<?= urlencode($category_item['item_name']) ?>">
        <article style="padding: 16px; border: 1px solid black;">
          <img src="assets/images/<?= $category_item['img_url'] ?>" alt="<?= $category_item['item_name'] ?>">
          <h3><?= $category_item['item_name'] ?></h3>
          <p>$<?= $category_item['base_price'] ?></p>
        </article>
      </a>
      <?php endforeach ?>
    </div>
    </section>
  <?php endforeach ?>
</body>
</html>
