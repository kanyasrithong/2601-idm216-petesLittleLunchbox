<?php
  session_start();
  require_once "../db.php";
  include "functions/categories.php";
  include "functions/items.php";

  // initialize this after order is confirmed
  if (isset($_GET['replay']) && $_GET['replay'] === 'false') {
    $_SESSION['order'] = [];
    header('Location: menu.php');
    exit;
  } elseif (isset($_GET['replay']) && $_GET['replay'] === 'true') {
    $_SESSION['order'] = $_SESSION['bag'];
    $_SESSION['bag'] = [];
  }

  if (!isset($_SESSION['bag'])) {
    $_SESSION['bag'] = [];
  }

  $categories = getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pete’s Little Lunchbox</title>

  <!-- Karla font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- ORDER CONFIRMATION BANNER -->
  <?php if (isset($_GET['replay']) && $_GET['replay'] === 'true') : ?>
    <a id="orderBanner" class="order-banner" href="confirmation.php?replay=true" style="display:none;">
      <span class="order-banner-text">View your latest order confirmation</span>
      <span class="order-banner-arrow">
        <img src="../assets/images/icons/Forward.svg" alt="Forward">
      </span>
    </a>
  <?php endif?>

  <!-- BAG COUNT -->
  <?php $bag_count = count($_SESSION['bag']) ?>
  <input id="bagCount" type="hidden" value="<?= intval($bag_count) ?>">

  <!-- HEADER -->
  <header class="top">
    <h1 class="welcome">
      Welcome to <span class="brand">Pete’s</span>
    </h1>

    <p class="hours">
      We’re open from 6:00 am - 3:00 pm today.
    </p>

    <!-- CATEGORY SCROLL -->
    <nav class="chips">
        <a class="chip active" href="#">All</a>
        <a class="chip" href="#Breakfast Sandwiches">Breakfast Sandwiches</a>
        <a class="chip" href="#Lunch Sandwiches">Lunch Sandwiches</a>
        <a class="chip" href="#Sides">Sides</a>
        <a class="chip" href="#Drinks">Drinks</a>
      </nav>
  </header>

  <!-- MAIN CONTENT -->
  <main class="page">
    <?php foreach ($categories as $category) : ?> 
      <?php $category_items = getItemsByCategory($category['id']) ?>

      <section class="section" id="<?= $category['category_name'] ?>">
        <h2 class="section-title"><?= strtoupper($category['category_name']) ?></h2>

        <div class="card-row">
          <?php foreach ($category_items as $item) : ?>

            <a class="card-link" href="customize.php?item=<?= urlencode($item['item_name']) ?>">
              <?php include 'components/card.php' ?>
            </a>
            
          <?php endforeach ?>
        </div>
      </section>
    <?php endforeach ?>
  </main>

  <nav class="bottom-nav">
    <a href="menu.php" class="nav-item active">
      <img src="../assets/images/icons/Home.svg" alt="Order" class="nav-icon">
      <span>Order</span>
    </a>
  
    <a href="bag.php" class="nav-item">
        <span class="nav-icon-wrap">
          <img src="../assets/images/icons/Bag.svg" alt="Bag" class="nav-icon">
          <span class="nav-badge is-hidden" id="bagBadge" aria-label="Bag items"></span>
        </span>
        <span>Bag</span>
    </a>
  
    <a href="account.php" class="nav-item">
      <img src="../assets/images/icons/Account.svg" alt="Account" class="nav-icon">
      <span>Account</span>
    </a>
  </nav>

  <script type="module" src="../final/functions/js/main.js"></script>
  <script type="module">
    import { mountHomeBadge } from "../final/functions/js/ui.js";

    mountHomeBadge();
  </script>
</body>
</html>