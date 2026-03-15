<?php
  session_start();
  require_once "../db.php";
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pete’s Little Lunchbox</title>

  <!-- Karla font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- ORDER CONFIRMATION BANNER (hidden by default, JS will show it) -->
    <a id="orderBanner" class="order-banner" href="confirmation.html?replay=true" style="display:none;">
        <span class="order-banner-text">View your latest order confirmation</span>
        <span class="order-banner-arrow">
          <img src="../assets/images/icons/Forward.svg" alt="Forward">
        </span>
    </a>
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
      <?php $category_items = getItemsByCategory($category['id']); ?>
      <!-- BREAKFAST -->
      <section class="section" id="<?= $category['category_name'] ?>">
        <h2 class="section-title"><?= strtoupper($category['category_name']) ?></h2>

        <div class="card-row">
          <?php foreach ($category_items as $category_item) : ?>
            <a class="card-link" href="customize.php?item=<?= urlencode($category_item['item_name']) ?>">
              <article class="card">
                <div class="card-img-wrap">
                  <img class="card-img" src="../assets/images/<?= $category_item['img_url'] ?>" alt="<?= $category_item['item_name'] ?>">
                </div>

                <div class="card-bottom">
                  <p class="card-name"><?= $category_item['item_name'] ?></p>
              
                  <div class="card-action">
                    <p class="card-price">$<?= $category_item['base_price'] ?></p>
                  </div>
                </div>
              </article>
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

  <script type="module" src="functions/js/main.js"></script>
  <script type="module">
    import { mountHomeBadge } from "functions/js/ui.js";
    import { getLastOrder } from "functions/js/app.js";
  
    mountHomeBadge();
  
    const banner = document.getElementById("orderBanner");
    const lastOrder = getLastOrder();
  
    if (banner && lastOrder) {
      banner.style.display = "flex";
    }
  </script>
</body>
</html>