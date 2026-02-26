<?php
  require_once "db.php";
  include "functions/categories.php";
  include "functions/items.php";
  include "functions/variants.php";
  include "functions/bs_variants.php";
  include "functions/orders.php";

  $categories = getCategories();
  $items = getItems();
  $variants = getVariants();
  $bs_variants = getBSVariants();
  $order = getOrders();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pete's Little Lunchbox</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body class="body-center">
  <main>
    <h1>Categories</h1>
  <table>
    <tr>
      <th>id</th>
      <th>category_name</th>
    </tr>
    <?php foreach ($categories as $category) : ?>
        <tr>
          <td><?= $category['id'] ?></td>
          <td><?= $category['category_name'] ?></td>
        </tr>
    <?php endforeach ?>
  </table>
  <h1>Menu Items</h1>
  <table>
    <tr>
      <th>id</th>
      <th>category_id</th>
      <th>item_name</th>
      <th>base_price</th>
      <th>description</th>
      <th>img_url</th>
    </tr>
    <?php foreach ($items as $item) : ?>
        <tr>
          <td><?= $item['id'] ?></td>
          <td><?= $item['category_id'] ?></td>
          <td><?= $item['item_name'] ?></td>
          <td><?= $item['base_price'] ?></td>
          <td><?= $item['description'] ?></td>
          <td><img src="assets/images/<?= $item['img_url'] ?>" alt=""></td>
        </tr>
    <?php endforeach ?>
  </table>
  <h1>Item Variants</h1>
  <table>
    <tr>
      <th>id</th>
      <th>category_id</th>
      <th>variant_name</th>
      <th>add_price</th>
      <th>img_url</th>
    </tr>
    <?php foreach ($variants as $variant) : ?>
        <tr>
          <td><?= $variant['id'] ?></td>
          <td><?= $variant['category_id'] ?></td>
          <td><?= $variant['variant_name'] ?></td>
          <td><?= $variant['add_price'] ?></td>
          <td><img src="assets/images/<?= $variant['img_url'] ?>" alt=""></td>
        </tr>
    <?php endforeach ?>
  </table>
  <h1>Breakfast Sandwich Variants</h1>
  <table>
    <tr>
      <th>id</th>
      <th>bs_name</th>
      <th>add_price</th>
      <th>img_url</th>
    </tr>
    <?php
      foreach ($bs_variants as $bs_variant) : ?>
        <tr>
          <td><?= $bs_variant['id'] ?></td>
          <td><?= $bs_variant['bs_name'] ?></td>
          <td><?= $bs_variant['add_price'] ?></td>
          <td><img src="assets/images/<?= $bs_variant['img_url'] ?>" alt=""></td>
        </tr>
    <?php endforeach ?>
  </table>
  <h1>Order Items Store</h1>
  <table>
    <tr>
      <th>id</th>
      <th>items</th>
      <th>variant_id</th>
      <th>bs_id</th>
      <th>quantity</th>
      <th>unit_price</th>
    </tr>
    <?php
      foreach ($order as $order_item) : ?>
        <tr>
          <td><?= $order_item['id'] ?></td>
          <td><?= $order_item['item_id'] ?></td>
          <td><?= $order_item['variant_id'] ?></td>
          <td><?= $order_item['bs_id'] ?></td>
          <td><?= $order_item['quantity'] ?></td>
          <td><?= $order_item['unit_price'] ?></td>
        </tr>
    <?php endforeach ?>
  </table>
  </main>
</body>
</html>