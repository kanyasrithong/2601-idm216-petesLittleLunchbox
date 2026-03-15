<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Phone Number</title>

  <!-- shared -->
  <link rel="stylesheet" href="css/style.css" />
  <!-- page specific -->
  <link rel="stylesheet" href="css/phone.css" />
</head>

<body class="phone">

  <main class="phone-page">

    <!-- back button -->
    <header class="phone-topbar">
      <a class="icon-btn" href="bag.php" aria-label="Back to bag">‹</a>
    </header>

    <!-- title -->
    <section class="phone-hero">
      <h1 class="phone-title">
        Enter your phone number<br />
        to receive order<br />
        notifications
      </h1>
    </section>

    <!-- illustration -->
    <section class="phone-graphic" aria-hidden="true">
      <img
        class="phone-graphic-img"
        src="../assets/images/icons/phone-notification.png"
        alt=""
      />
    </section>

    <!-- form area -->
    <section class="phone-form">
      <input class="phone-input" type="tel" inputmode="numeric" pattern="[0-9]*" placeholder="Enter number here..."
        oninput="this.value = this.value.replace(/[^0-9]/g, '')" />

      <a class="primary-btn" href="payment.php" aria-label="Continue">Continue</a>
    </section>

  </main>
  <script type="module" src="./js/main.js"></script>
</body>
</html>