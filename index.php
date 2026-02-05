<?php
  require_once "db.php";
  include "functions/categories.php";
  include "functions/items.php";
  include "functions/variants.php";
  include "functions/bs_variants.php";
  include "functions/order.php";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pete's Little Lunchbox</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
  <main>
    <h1>Categories</h1>
  <table>
    <tr>
      <th>id</th>
      <th>category_name</th>
    </tr>
    <?php
      while ($category = $categories_result->fetch_assoc()) : ?>
        <tr>
          <th><?= $category['id'] ?></th>
          <th><?= $category['category_name'] ?></th>
        </tr>
    <?php endwhile ?>
  </table>
  <h1>Menu Items</h1>
  <table>
    <tr>
      <th>id</th>
      <th>category_id</th>
      <th>item_name</th>
      <th>img_url</th>
    </tr>
    <?php
      while ($item = $items_result->fetch_assoc()) : ?>
        <tr>
          <th><?= $item['id'] ?></th>
          <th><?= $item['category_id'] ?></th>
          <th><?= $item['item_name'] ?></th>
          <th><img src="assets/images/<?= $item['img_url'] ?>" alt=""></th>
        </tr>
    <?php endwhile ?>
  </table>
  <h1>Item Variants</h1>
  <table>
    <tr>
      <th>id</th>
      <th>item_id</th>
      <th>variant_name</th>
      <th>price</th>
      <th>img_url</th>
    </tr>
    <?php
      while ($variant = $variants_result->fetch_assoc()) : ?>
        <tr>
          <th><?= $variant['id'] ?></th>
          <th><?= $variant['item_id'] ?></th>
          <th><?= $variant['variant_name'] ?></th>
          <th><?= $variant['price'] ?></th>
          <th><img src="assets/images/<?= $variant['img_url'] ?>" alt=""></th>
        </tr>
    <?php endwhile ?>
  </table>
  <h1>Breakfast Sandwich Variants</h1>
  <table>
    <tr>
      <th>id</th>
      <th>item_id</th>
      <th>variant_id</th>
      <th>bs_name</th>
      <th>img_url</th>
    </tr>
    <?php
      while ($bs_variant = $bs_result->fetch_assoc()) : ?>
        <tr>
          <th><?= $bs_variant['id'] ?></th>
          <th><?= $bs_variant['item_id'] ?></th>
          <th><?= $bs_variant['variant_id'] ?></th>
          <th><?= $bs_variant['bs_name'] ?></th>
          <th><img src="assets/images/<?= $bs_variant['img_url'] ?>" alt=""></th>
        </tr>
    <?php endwhile ?>
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
      <th>subtotal</th>
      <th>special_requests</th>
      <th>tip</th>
    </tr>
    <?php
      while ($order = $order_result->fetch_assoc()) : ?>
        <tr>
          <th><?= $order['id'] ?></th>
          <th><?= $order['item_id'] ?></th>
          <th><?= $order['variant_id'] ?></th>
          <th><?= $order['bs_id'] ?></th>
          <th><?= $order['quantity'] ?></th>
          <th><?= $order['unit_price'] ?></th>
          <th><?= $order['subtotal'] ?></th>
          <th><?= $order['special_requests'] ?></th>
          <th><?= $order['tip'] ?></th>
        </tr>
    <?php endwhile ?>
  </table>
  </main>
</body>
</html>