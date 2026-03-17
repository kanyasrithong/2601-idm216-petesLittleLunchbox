<?php
  session_start();

  // set bag to session bag or order depending on replay
  !empty($_SESSION['bag']) ? $bag = $_SESSION['bag'] : $bag = $_SESSION['order'];

  $total = 0;

  if (!empty($_POST['total'])) {
    $_SESSION['total'] = $_POST['total'];
    $_POST['total'] = '';
  }

  $total = $_SESSION['total'] ?? 0.0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Order Confirmation</title>

  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/confirmation.css" />
</head>

<body class="confirmation-body">

  <main class="confirm-page">

    <!-- header -->
    <section class="confirm-hero">
      <h1 class="confirm-hero-title">Your Order Number is</h1>
      <div class="confirm-hero-number" id="orderNumber">32</div>

      <a 
      class="confirm-address"
      href="https://www.google.com/maps/place/11+N+33rd+St,+Philadelphia,+PA+19104/@39.9556913,-75.1893125,17z/data=!3m1!4b1!4m5!3m4!1s0x89c6c64e270fc00f:0xbdbbb6fc71fdd500!8m2!3d39.9556913!4d-75.1893125?entry=ttu&g_ep=EgoyMDI2MDIxOC4wIKXMDSoASAFQAw%3D%3D"
      target="_blank"
      >
        <span class="confirm-pin">📍</span>
        <span>11 N 33rd St, Philadelphia, PA 19104</span>
        <span class="confirm-ext">↗</span>
      </a>
    </section>

    <!-- pickup status -->
    <section class="pickup-card">
      <div class="pickup-text">
        <p class="pickup-heading">Pickup Status</p>
        <p class="pickup-sub" id="readyByText">Est Ready by: 11:00am</p>
      </div>

      <div class="pickup-progress">
        <div class="progress-row">
          <span class="dot dot-active"></span>
          <span class="line"></span>
          <span class="dot"></span>
          <span class="line"></span>
          <span class="dot"></span>
        </div>

        <div class="progress-labels">
          <span class="progress-label">Received</span>
          <span class="progress-label">Preparing</span>
          <span class="progress-label">Completed</span>
        </div>
      </div>
    </section>

    <h2 class="order-title">Your Order</h2>

    <!-- PHP renders order items -->
    <section id="confirmList" class="confirm-list">
      <?php foreach ($bag as $item) : ?>
        <?php include 'components/order_item.php' ?>
      <?php endforeach ?>
    </section>

    <!-- bottom -->
    <div class="confirm-bottom">
      <section class="total-row">
        <span class="total-label">Total</span>
        <span class="total-value" id="confirmTotal">$<?= number_format($total, 2) ?></span>
      </section>

      <?php if (isset($_GET['replay'])) : ?>
        <a class="primary-btn" href="<?php echo 'menu.php?replay=false' ?>" id="returnHomeBtn">Return Home</a>
      <?php else : ?>
        <a class="primary-btn" href="<?php echo 'menu.php?replay=true' ?>" id="returnHomeBtn">Order Again</a>
      <?php endif ?>
    </div>

  </main>

  <script>
    const isReplay = new URLSearchParams(window.location.search).get("replay") === "true";

    if (isReplay) {
      const dots = document.querySelectorAll(".dot");
      const lines = document.querySelectorAll(".line");

      // Reset all to empty first
      dots.forEach(d => d.classList.remove("dot-active"));

      // Step 1: first dot lights up
      setTimeout(() => {
        dots[0].classList.add("dot-active");
      }, 400);

      // Step 2: first line fills, second dot lights up
      setTimeout(() => {
        lines[0].classList.add("line-active");
      }, 900);
      setTimeout(() => {
        dots[1].classList.add("dot-active");
      }, 1300);

      // Step 3: second line fills, third dot lights up
      setTimeout(() => {
        lines[1].classList.add("line-active");
      }, 1800);
      setTimeout(() => {
        dots[2].classList.add("dot-active");
      }, 2200);
    }
  </script>

</body>
</html>