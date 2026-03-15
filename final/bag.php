<?php
  session_start();
  require_once "../db.php";

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
  $variant_total = 0;
  $subtotal = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bag</title>

  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/bag.css" />
</head>

<body class="bag">

  <main class="bag-page">

    <!-- PICKUP HEADER -->
    <section class="pickup">
      <h1 class="pickup-title">
        Pickup from <span class="brand">Pete’s</span>
      </h1>
      <p class="pickup-address">11 N 33rd St, Philadelphia, PA 19104</p>
    </section>

    <!-- ASAP + SCHEDULE -->
    <section class="pickup-options">
      <!-- ASAP (clickable) -->
      <button id="pickupAsap" class="pickup-box pickup-choice is-selected" type="button">
        <p class="pickup-box-text">ASAP (ready in ~12 min)</p>
      </button>
    
      <!-- Schedule (real dropdown) -->
      <div class="pickup-box pickup-select-wrap" id="pickupScheduledWrap">
        <select id="pickupTimeSelect" class="pickup-select" aria-label="Schedule Pickup Time">
          <option value="" selected disabled>Schedule Pickup Time</option>
          <option value="10:30 AM">10:30 AM</option>
          <option value="10:45 AM">10:45 AM</option>
          <option value="11:00 AM">11:00 AM</option>
          <option value="11:15 AM">11:15 AM</option>
          <option value="11:30 AM">11:30 AM</option>
        </select>
    
        <span class="pickup-select-icon" aria-hidden="true">
          <img src="../assets/images/icons/Down.svg" alt="Expand">
        </span>
      </div>
    </section>

    <?php if (empty($bag)) : ?>
      <!-- EMPTY STATE -->
      <section id="bagEmpty" class="bag-empty" style="display:none;">
        <h2 class="bag-empty-title">Your bag is empty</h2>
        <p class="bag-empty-sub">Add items from the menu to start an order.</p>
        <a class="primary-btn" href="index.php">Go to Menu</a>
      </section>
    <?php else : ?>
      <!-- ITEMS LIST (JS will fill) -->
      <section id="bagList" class="bag-list">
        <?php foreach ($bag as $item) : ?>
          <?php include 'functions/helpers/load_bag_item.php' ?>
        <?php endforeach ?>
      </section>
    <?php endif; ?>

    <!-- ADD A SIDE (horizontal scroll - static cards) -->
    <section class="add-side">
        <h2 class="add-side-title">WANT TO ADD A SIDE?</h2>
    
        <div class="add-side-row">
        <article class="card">
            <div class="card-img-wrap">
            <img class="card-img" src="../assets/images/menu/sides/chip.webp" alt="Potato Chips">
            </div>
            <div class="card-bottom">
            <p class="card-name">Potato Chips</p>
            <div class="card-action">
                <p class="card-price">$0.75</p>
                <button class="add-btn" type="button" disabled>+</button>
            </div>
            </div>
        </article>
    
        <article class="card">
            <div class="card-img-wrap">
            <img class="card-img" src="../assets/images/menu/sides/muffin.webp" alt="Muffin">
            </div>
            <div class="card-bottom">
            <p class="card-name">Muffin</p>
            <div class="card-action">
                <p class="card-price">$1.75</p>
                <button class="add-btn" type="button" disabled>+</button>
            </div>
            </div>
        </article>
    
        <article class="card">
            <div class="card-img-wrap">
            <img class="card-img" src="../assets/images/menu/sides/hashbrown.webp" alt="Hashbrown">
            </div>
            <div class="card-bottom">
            <p class="card-name">Hashbrown</p>
            <div class="card-action">
                <p class="card-price">$1.25</p>
                <button class="add-btn" type="button" disabled>+</button>
            </div>
            </div>
        </article>
    
        <article class="card">
            <div class="card-img-wrap">
            <img class="card-img" src="../assets/images/menu/sides/bagel.webp" alt="Bagel">
            </div>
            <div class="card-bottom">
            <p class="card-name">Bagel</p>
            <div class="card-action">
                <p class="card-price">$2.00</p>
                <button class="add-btn" type="button" disabled>+</button>
            </div>
            </div>
        </article>
        </div>
    </section>

    <!-- TOTAL + CHECKOUT -->
    <section class="bag-footer">
      <div class="bag-total-row">
        <span class="bag-total-label">Total</span>
        <span class="bag-total-value" id="bagTotal">$<?= number_format($subtotal, 2) ?></span>
      </div>

      <a class="primary-btn" id="bagCheckout" href="phone.php">Proceed to Checkout</a>
    </section>

  </main>

  <!-- bottom nav (bag active) -->
  <nav class="bottom-nav">
    <a href="menu.php" class="nav-item">
      <img src="../assets/images/icons/Home.svg" alt="Order" class="nav-icon">
      <span>Order</span>
    </a>

    <a href="bag.php" class="nav-item active">
      <img src="../assets/images/icons/Bag.svg" alt="Bag" class="nav-icon">
      <span>Bag</span>
    </a>

    <a href="account.php" class="nav-item">
      <img src="../assets/images/icons/Account.svg" alt="Account" class="nav-icon">
      <span>Account</span>
    </a>
  </nav>

  <script src="functions/js/quantity-counter.js"></script>
</body>
</html>