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
<body class="body-center">
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
          <td><?= $category['id'] ?></td>
          <td><?= $category['category_name'] ?></td>
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
          <td><?= $item['id'] ?></td>
          <td><?= $item['category_id'] ?></td>
          <td><?= $item['item_name'] ?></td>
          <td><img src="assets/images/<?= $item['img_url'] ?>" alt=""></td>
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
          <td><?= $variant['id'] ?></td>
          <td><?= $variant['item_id'] ?></td>
          <td><?= $variant['variant_name'] ?></td>
          <td><?= $variant['price'] ?></td>
          <td><img src="assets/images/<?= $variant['img_url'] ?>" alt=""></td>
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
          <td><?= $bs_variant['id'] ?></td>
          <td><?= $bs_variant['item_id'] ?></td>
          <td><?= $bs_variant['variant_id'] ?></td>
          <td><?= $bs_variant['bs_name'] ?></td>
          <td><img src="assets/images/<?= $bs_variant['img_url'] ?>" alt=""></td>
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
          <td><?= $order['id'] ?></td>
          <td><?= $order['item_id'] ?></td>
          <td><?= $order['variant_id'] ?></td>
          <td><?= $order['bs_id'] ?></td>
          <td><?= $order['quantity'] ?></td>
          <td><?= $order['unit_price'] ?></td>
          <td><?= $order['subtotal'] ?></td>
          <td><?= $order['special_requests'] ?></td>
          <td><?= $order['tip'] ?></td>
        </tr>
    <?php endwhile ?>
  </table>
  </main>
</body>
</html>