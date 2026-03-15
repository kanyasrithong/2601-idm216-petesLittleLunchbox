<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pete's Little Lunchbox</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://api.fontshare.com/v2/css?f[]=satoshi@500&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/splash.css">
</head>

<body>

  <!-- Logo — starts centered, animates to upper-left -->
  <div class="logo-wrap">
    <img class="logo" src="../assets/images/logo.png" alt="Pete's Little Lunchbox logo">
  </div>

  <!-- Content — fades in after logo settles -->
  <div class="splash-content">
    <h1 class="splash-title">Petes Little Lunchbox</h1>
    <p class="splash-tagline">A <span class="serif">new</span> food truck app for breakfast + lunch.</p>
    <a href="menu.php" class="splash-btn">Order Now</a>
  </div>

  <script>
    document.querySelector('.splash-btn').addEventListener('click', function (e) {
      e.preventDefault();
      const dest = this.getAttribute('href');
      document.body.classList.add('exiting');
      setTimeout(() => { window.location.href = dest; }, 350);
    });
  </script>

</body>
</html>
