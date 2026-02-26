<?php
  session_start();
  require_once "db.php";
  include 'functions/items.php';

  if (!isset($_SESSION['bag'])) {
    $_SESSION['bag'] = [];
  }

  $items = $_SESSION['bag'];
  $subtotal = 0;
  $sales_tax_percent = 0.08;
  $sales_tax = 0;
  $total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Pete's Little Lunchbox</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body class="order-summary">
  <a href="bag.php">Back</a>
  <h1>Checkout</h1>
  <h2>Order Summary</h2>
  <section class="payment">
    <?php foreach ($items as $item) : ?>
      <?php include 'functions/helpers/load_order_item.php' ?>
    <?php endforeach ?>
  <div class="order-calculations">
    <h3>Subtotal: $<?= number_format($subtotal, 2) ?></h3>
    <?php
      $sales_tax = $subtotal * $sales_tax_percent;
      $total = $subtotal + $sales_tax;
    ?>
    <h3>Sales Tax: $<?= number_format($sales_tax, 2) ?></h3>
    <h2>Total: $<?= number_format($total, 2) ?></h2>
    </section>
    </div>
  <a href="confirmation.php">Place Order</a>
</body>