<?php
  session_start();
  require_once "db.php";
  include 'functions/items.php';

  if (!isset($_SESSION['bag'])) {
    $_SESSION['bag'] = [];
  }

  $items = $_SESSION['bag'];
  $subtotal = 0;
  $variant_total = 0;
  $sales_tax_percent = 0.08;
  $sales_tax = 0;
  $total = 0;
  $order_number = rand(1, 100);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmation - Pete's Little Lunchbox</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body class="order-summary">
  <div class="order-number">
    <h2>Your Order Number is</h2>
    <h1><?= $order_number ?></h1>
  </div>
  <section>
    <h2>Order Summary</h2>
    <?php foreach ($items as $item) : ?>
      <?php include 'functions/helpers/load_order_item.php' ?>
    <?php endforeach ?>
    <div class="order-calculations">
      <?php if ($variant_total != 0) $subtotal += $variant_total; ?>
      <h3>Subtotal: $<?= number_format($subtotal, 2) ?></h3>
      <?php
        $sales_tax = $subtotal * $sales_tax_percent;
        $total = $subtotal + $sales_tax;
      ?>
      <h3>Sales Tax: $<?= number_format($sales_tax, 2) ?></h3>
      <h2>Total: $<?= number_format($total, 2) ?></h2>
    </div>
  </section> 
  <a href="menu.php?clear=true">Start New Order</a>
</body>

<!--TODO: store $_SESSION['cart'] contents after this page (or future order ready page with animation) is initialized -->