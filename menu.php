<?php
  require_once "db.php";
  include "functions/items.php";
  $subtotal = 0;
  $sales_tax_percent = 0.8;
  $sales_tax = 0;
  $total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pete's Little Lunchbox - Menu</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body class="body-center">
  <h1>Menu Items</h1>
  <form action="menu.php" method="post">
    <table>
      <tr>
        <th></th>
        <th>id</th>
        <th>category_id</th>
        <th>item_name</th>
        <th>base_price</th>
        <th>description</th>
        <th>img_url</th>
      </tr>
      <?php
        while ($item = $items_result->fetch_assoc()) : ?>
          <tr>
            <td><input type="checkbox" name="order_items[]" value="<?= $item['id'] ?>"></td>
            <td><?= $item['id'] ?></td>
            <td><?= $item['category_id'] ?></td>
            <td><?= $item['item_name'] ?></td>
            <td><?= $item['base_price'] ?></td>
            <td><?= $item['description'] ?></td>
            <td><img src="assets/images/<?= $item['img_url'] ?>" alt=""></td>
          </tr>
      <?php endwhile ?>
    </table>
    <input type="submit" value="Submit">
    <a href="menu.php">Reset</a>
  </form>
  <?php
    if (isset($_POST['order_items'])) : ?>
      <?php $order_ids = $_POST['order_items']; ?>
      <div class="order-summary">
        <h1>Order Summary</h1>
        <?php foreach ($order_ids as $order_id) : ?>
          <?php
            include "functions/process_order.php";
            $subtotal += $processed_item['base_price'];
          ?>
          <div class="order-summary-row">
            <h3><?= htmlspecialchars($processed_item['item_name']) ?></h3>
            <h3>$<?= number_format($processed_item['base_price'], 2) ?></h3>
          </div>
        <?php endforeach ?>
        <?php
          $sales_tax = $subtotal - ($subtotal * $sales_tax_percent);
          $total = $subtotal + $sales_tax;
        ?>
          <div class="order-summary-row">
            <h2>Sales Tax</h2>
            <h2>$<?= number_format($sales_tax, 2) ?></h2>
          </div>
          <div class="order-summary-row">
            <h2>Total</h2>
            <h2>$<?= number_format($total, 2) ?></h2>
          </div>
      </div?>
    <?php endif?>
</body>
</html>