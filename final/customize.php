<?php
  session_start();
  require_once "../db.php";
  include "functions/items.php";
  include "functions/variants.php";
  include "functions/bs_variants.php";

  $variants = [];
  $bs_variants = [];
  
  if (isset($_GET['item'])) {
    $item_name = urldecode($_GET['item']);
    $item = getItemByName($item_name);
  }

  // get meat variants for Egg & Cheese
  if ($item['id'] === 1) {
    $bs_variants = getBSVariants();
  }

  if($item['category_id'] === 1 || $item['category_id'] === 2 || $item['category_id'] === 4) {
    $variants = getVariantsByCategory($item['category_id']);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Customize — Egg & Cheese</title>

  <!-- shared -->
  <link rel="stylesheet" href="css/style.css" />
  <!-- page specific -->
  <link rel="stylesheet" href="css/customize.css" />
</head>

<body class="customize">
  <main class="customize-page">
    <!-- TOP BAR -->
    <header class="topbar">
      <a class="icon-btn" href="menu.php" aria-label="Back to menu">‹</a>

      <a class="bag-btn" href="bag.php" aria-label="Go to bag">
        <img 
          src="../assets/images/icons/Bag.svg" 
          alt="Bag" 
          class="bag-icon"
        />
      </a>
    </header>

    <!-- IMAGE + TEXT GROUP -->
    <section class="item-hero">
      <div class="hero-img-frame">
        <img class="hero-img" src="../assets/images/<?= $item['img_url'] ?>" alt="<?= $item['item_name'] ?>" />
      </div>

      <div class="item-text">
        <h1 class="item-title"><?= $item['item_name'] ?></h1>
        <p class="item-desc"><?= $item['description'] ?></p>
        <p class="item-price">$<?= $item['base_price'] ?></p>
      </div>

      <hr class="divider" />
    </section>
    <!-- FORM + FIELDS -->
    <form id="customizeForm" class="options" method="post" action="functions/helpers/add_to_bag.php?item_id=<?= $item['id'] ?>">
      <?php if (!empty($variants)) : ?>
        <details class="acc" open>
          <?php
          // check whether variant is Bread or Size
            $first_key = array_key_first($variants);
            $first_variant = $variants[$first_key];

            $first_variant['category_id'] === '4' ?
            $variant_type = 'size' :
            $variant_type = 'bread';
          ?>
            <summary class="acc-header">
              <span class="acc-title">* <?= ucfirst($variant_type) ?> <span class="acc-sub">[select one]</span></span>
              <span class="acc-caret" aria-hidden="true">
                <img src="../assets/images/icons/Down.svg" alt="Expand">
              </span>
            </summary>
            
            <div class="acc-panel">
              <?php foreach ($variants as $variant) : ?>
                <label class="opt">
                  <input class="opt-input" type="radio" name="variants[<?= $variant_type ?>]" value="<?= $variant['id'] ?>" required>
                  <span class="opt-img">
                    <img src="../assets/images/<?= $variant['img_url'] ?>" alt="<?= $variant['variant_name'] ?>">
                  </span>
                  <div class="opt-details">
                    <span class="opt-text"><?= $variant['variant_name'] ?></span>
                    <span class="opt-price">+$<?= $variant['add_price'] ?></span>
                  </div>
                </label>
              <?php endforeach ?>
            </div>
          <?php endif ?>
        </details>

      <?php if (!empty($bs_variants)) : ?>
            <!-- Meat -->
        <details class="acc">
          <summary class="acc-header">
            <span class="acc-title">* Meat <span class="acc-sub">[select one]</span></span>
            <span class="acc-caret" aria-hidden="true">
              <img src="../assets/images/icons/Down.svg" alt="Expand">
            </span>
          </summary>

          <div class="acc-panel">
            <?php foreach ($bs_variants as $bs_variant) : ?>
                <label class="opt">
                  <input class="opt-input" type="radio" name="variants[meat]" value="<?= $bs_variant['id'] ?>" required>
                  <span class="opt-img">
                    <img src="../assets/images/<?= $bs_variant['img_url'] ?>" alt="<?= $bs_variant['bs_name'] ?>">
                  </span>
                  <div class="opt-details">
                    <span class="opt-text"><?= $bs_variant['bs_name'] ?></span>
                    <span class="opt-price">+$<?= number_format($bs_variant['add_price'], 2) ?></span>
                  </div>
                </label>
            <?php endforeach ?>
          </div>
        </details>

      <hr class="divider" />

      <!-- TEXTAREA -->
      <section class="notes">
          <textarea class="textarea-box" type="text" placeholder="Please let the kitchen know of any dietary restrictions…"></textarea>
      </section>
      <?php endif ?>

      <!-- QUANTITY BAR -->
      <section class="qty">
        <div class="qty-bar">
          <p class="qty-label">Quantity</p>

          <div class="qty-controls item">
            <button class="qty-btn minus" type="button" aria-label="Decrease quantity">
              <img src="../assets/images/icons/Minus.svg" alt="Subtract">
            </button>
            <p class="qty-value" id="qtyNum">1</p>
            <input class="qty-input" type="hidden" name="quantity" value="1">
            <button class="qty-btn plus" type="button" aria-label="Increase quantity">
              <img src="../assets/images/icons/Plus.svg" alt="Add">
            </button>
          </div>
        </div>
      </section>

      <!-- ADD TO BAG -->
      <section class="cta">
        <input class="add-to-bag" id="addToBagBtn" type="submit" value="Add to Bag"/>
      </section>
    </form>
  </main>

  <script type="module">
    // const btn = document.getElementById("addToBagBtn");
    // btn.addEventListener("click", () => {
    //   document.body.classList.add("page-exit");
    //   setTimeout(() => {
    //     window.location.href = "menu.php";
    //   }, 520);
    // });
  </script>
  <script src="functions/js/quantity-counter.js"></script>
</body>
</html>