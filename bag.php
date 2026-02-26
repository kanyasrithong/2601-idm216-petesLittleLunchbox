<?php
  session_start();
  require_once "db.php";
  include 'functions/items.php';

  if (!isset($_SESSION['bag'])) {
    $_SESSION['bag'] = [];
  }

  if (isset($_GET['remove'])) {
    foreach ($_SESSION['bag'] as $key => $item) {
        if ($item['id'] === $_GET['remove']) {
            unset($_SESSION['bag'][$key]);
            break;
        }
    }
    $_SESSION['bag'] = array_values($_SESSION['bag']);
    header('Location: bag.php');
    exit;
  }

  // used for loading order item helper function
  $current_page = basename($_SERVER['PHP_SELF']);

  $bag = $_SESSION['bag'];
  $subtotal = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bag - Pete's Little Lunchbox</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body class="order-summary">
  <a href="menu.php">Back</a>
  <h1>Bag</h1>
  <section class="bag">
    <?php if (empty($bag)) : ?>
      <h2>Your bag is empty. </h2>
      <p>Add items from the menu to start an order.</p>
    <?php else : ?>
      <?php foreach ($bag as $item) : ?>
        <?php include 'functions/helpers/load_order_item.php' ?>
      <?php endforeach ?>
    <?php endif; ?>
    <div class="order-calculations">
      <h2>Subtotal: $<?= number_format($subtotal, 2) ?></h2>
    </div>
  </section>
  <?php if (!empty($bag)) : ?>
    <a href="payment.php">Proceed to Checkout</a>
  <?php endif ?>
</body>