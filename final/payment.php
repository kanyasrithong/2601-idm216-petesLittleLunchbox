<?php
  session_start();
  require_once "../db.php";

  $bag = $_SESSION['bag'];
  $items_total = 0;
  $tax_percent = 0.08;
  $tip_percentage = 0;

  // calculate item totals
  foreach ($bag as $item ) {
    $variants = $item['variants'] ?? [];
    $variant_total = 0;

    foreach ($variants as $variant) {
      $variant_total += $variant['add_price'];
    }

    $item_total = $item['item_quantity'] * ($item['item_total'] + $variant_total);
    $items_total += $item_total;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Payment</title>

  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/payment.css" />

  <!-- helper styles just for custom tip input -->
  <style>
    .tip-box.custom .custom-tip-input-wrap{
      display: none;
      width: 100%;
      margin-top: 8px;
    }
    .tip-box.custom.is-selected .custom-tip-input-wrap{
      display: flex;
      justify-content: center;
    }
    .custom-tip-input{
      width: 100%;
      max-width: 120px;
      padding: 8px 10px;
      border-radius: 8px;
      border: 1px solid #B9AC19;
      background: #FBF6E9;
      font-family: Satoshi, system-ui, "Karla", sans-serif;
      font-size: 14px;
      color: #45371F;
      outline: none;
      text-align: center;
    }
  </style>
</head>

<body class="payment">

  <main class="payment-page">

    <!-- back -->
    <header class="payment-topbar">
      <a class="icon-btn" href="phone.php" aria-label="Back">‹</a>
    </header>

    <!-- title -->
    <h1 class="payment-title">Select Payment Method</h1>

    <!-- payment methods -->
    <section class="payment-methods">

      <div class="payment-option" data-payment="card">
        <img class="payment-icon" src="../assets/images/icons/debit.png" alt="Card" />
        <span class="payment-text">Debit/Credit Card</span>
      </div>

      <div class="payment-option" data-payment="applepay">
        <img class="payment-icon" src="../assets/images/icons/applepay.png" alt="Apple Pay" />
        <span class="payment-text">Apple Pay</span>
      </div>

      <div class="payment-option" data-payment="paypal">
        <img class="payment-icon" src="../assets/images/icons/paypal.png" alt="PayPal" />
        <span class="payment-text">PayPal</span>
      </div>

      <div class="payment-option" data-payment="venmo">
        <img class="payment-icon" src="../assets/images/icons/venmo.png" alt="Venmo" />
        <span class="payment-text">Venmo</span>
      </div>

    </section>

    <section class="card-form-wrap is-hidden" id="cardFormWrap" autocomplete="off">
      <div class="card-form-grid">
        <div class="field-group full">
          <label class="field-label" for="cardName">Name on Card</label>
          <input class="field-input" id="cardName" type="text" placeholder="Jane Doe" autocomplete="off" />
        </div>

        <div class="field-group full">
          <label class="field-label" for="cardNumber">Card Number</label>
          <input class="field-input" id="cardNumber" type="number" inputmode="numeric" placeholder="1234 5678 9012 3456" autocomplete="off" />
        </div>

        <div class="field-group">
          <label class="field-label" for="cardExp">Expiration</label>
          <input class="field-input" id="cardExp" type="text" inputmode="numeric" placeholder="MM/YY" autocomplete="off" />
        </div>

        <div class="field-group">
          <label class="field-label" for="cardCvv">CVV</label>
          <input class="field-input" id="cardCvv" type="text" inputmode="numeric" placeholder="123" autocomplete="off" />
        </div>
      </div>

      <p class="card-form-heading">Billing Address</p>

      <div class="card-form-grid">
        <div class="field-group full">
          <label class="field-label" for="billingStreet">Street Address</label>
          <input class="field-input" id="billingStreet" type="text" placeholder="123 Main St" autocomplete="off" />
        </div>

        <div class="field-group full">
          <label class="field-label" for="billingApt">Apt, Suite, etc. (optional)</label>
          <input class="field-input" id="billingApt" type="text" placeholder="Unit 4B" autocomplete="off" />
        </div>

        <div class="field-group">
          <label class="field-label" for="billingCity">City</label>
          <input class="field-input" id="billingCity" type="text" placeholder="Philadelphia" autocomplete="off" />
        </div>

        <div class="field-group">
          <label class="field-label" for="billingState">State</label>
          <input class="field-input" id="billingState" type="text" placeholder="PA" autocomplete="off" />
        </div>

        <div class="field-group full">
          <label class="field-label" for="billingZip">ZIP Code</label>
          <input class="field-input" id="billingZip" type="text" inputmode="numeric" placeholder="19147" autocomplete="off" />
        </div>
      </div>
    </section>

    <!-- olive divider -->
    <div class="divider-olive" aria-hidden="true"></div>

    <!-- tip section -->
    <section class="tip-section">
      <?php
        $tip_10 = $items_total * 0.1;
        $tip_15 = $items_total * 0.15;
        $tip_20 = $items_total * 0.2;
      ?>
      <h2 class="tip-title">Add Tip?</h2>

      <div class="tip-row">
        <div class="tip-box" data-tip-percent="10">
          <p class="tip-percent">10%</p>
          <p class="tip-amount">$<span class="tip-value"><?= number_format($tip_10, 2) ?></span></p>
        </div>

        <div class="tip-box" data-tip-percent="15">
          <p class="tip-percent">15%</p>
          <p class="tip-amount" id="tip15Text">$<span class="tip-value"><?= number_format($tip_15, 2) ?></span></p>
        </div>

        <div class="tip-box" data-tip-percent="20">
          <p class="tip-percent">20%</p>
          <p class="tip-amount" id="tip20Text">$<span class="tip-value"><?= number_format($tip_20, 2) ?></span></p>
        </div>

        <!-- custom tip box -->
        <div class="tip-box custom" data-tip-custom="1">
          <p class="tip-percent">Custom</p>

          <div class="custom-tip-input-wrap">
            <input
              id="customTipInput"
              class="custom-tip-input"
              type="number"
              min="0"
              step="0.01"
              inputmode="decimal"
              placeholder="$"
              aria-label="Custom tip amount in dollars"
            />
          </div>
        </div>

      </div>
    </section>

    <!-- dashed pink divider -->
    <div class="divider-pink" aria-hidden="true"></div>

    <!-- Summary -->
    <section class="summary">

      <?php 
        foreach ($bag as $item) {
          include 'components/summary_item.php';
        }

        $tip = $items_total * $tip_percentage;
        $sales_tax = $items_total * $tax_percent;
        $total = $items_total + $sales_tax + $tip;
      ?>

      <div class="summary-row">
        <p class="summary-regular" id="tipLabel">Tip (<?= $tip_percentage ?>%)</p>
        <p class="summary-regular">$<span id="tipValue"><?= number_format($tip, 2) ?></span></p>
      </div>

      <div class="summary-row hidden">
        <p class="summary-regular">Pretax</p>
        <p class="summary-regular">$<span id="pretaxValue"><?= number_format($items_total, 2) ?></span></p>
      </div>

      <div class="summary-row">
        <p class="summary-regular">Tax</p>
        <p class="summary-regular">$<span id="taxValue"><?= number_format($sales_tax, 2) ?></span></p>
      </div>

      <form method="post" action="confirmation.php">
        <div class="summary-row total-row">
          <p class="total-label">Total</p>
          <p class="total-amount">$<span id="totalAmount"><?= number_format($total, 2) ?></span></p>
        </div>
        <input type="hidden" name="total" value="<?= number_format($total, 2) ?>">
      </form>

    </section>

    <!-- button -->
    <section class="payment-footer">
      <form method="post" action="confirmation.php">
        <input id="orderTotal" type="hidden" name="total" value="<?= number_format($total, 2) ?>">
        <input class="primary-btn" id="placeOrderBtn" type="submit" value="Place Order"/>
      </form>
    </section>

  </main>

  <div class="loading-overlay" id="loadingOverlay" aria-hidden="true">
    <div class="loading-spinner" aria-label="Loading"></div>
  </div>

  <!-- Apple Pay Overlay -->
  <div class="applepay-overlay" id="applePayOverlay" aria-hidden="true">
    <div class="applepay-sheet" role="dialog" aria-modal="true" aria-label="Apple Pay">

      <div class="applepay-header">
        <div class="applepay-logo">Pay</div>

        <button class="applepay-close" id="applePayCloseBtn" type="button" aria-label="Close Apple Pay">
          ×
        </button>
      </div>

      <div class="applepay-card">
        <div class="applepay-card-left">
          <div class="applepay-card-icon"></div>
          <div class="applepay-card-text">
            <div class="applepay-card-title">Revolut Visa</div>
          </div>
        </div>
        <div class="applepay-card-right">
          <span class="applepay-dots">•••• 1234</span>
          <span class="applepay-chevron">›</span>
        </div>
      </div>

      <div class="applepay-card">
        <div class="applepay-card-left">
          <div class="applepay-card-title">Change Payment Method</div>
        </div>
        <div class="applepay-card-right">
          <span class="applepay-chevron">›</span>
        </div>
      </div>

      <div class="applepay-meta">
        <div class="applepay-company">Company Name</div>
        <div class="applepay-amount" id="applePayAmount">$0.00</div>
        <div class="applepay-info">i</div>
      </div>

      <div class="applepay-faceid">
        <div class="faceid-icon" aria-hidden="true">
          <div class="faceid-box"></div>
          <div class="faceid-smile"></div>
        </div>
        <div class="faceid-text">Pay with Face ID</div>
      </div>

    </div>
  </div>

  <script src="functions/js/update-tip.js"></script>
  <script type="module">
    const placeOrderBtn = document.getElementById("placeOrderBtn");
    const applePayOverlay = document.getElementById("applePayOverlay");
    const applePayCloseBtn = document.getElementById("applePayCloseBtn");
    const loadingOverlay = document.getElementById("loadingOverlay");

    const tipLabel = document.getElementById("tipLabel");
    const tipValue = document.getElementById("tipValue");
    const taxValue = document.getElementById("taxValue");
    const totalAmount = document.getElementById("totalAmount");
    const applePayAmount = document.getElementById("applePayAmount");

    const tip10Text = document.getElementById("tip10Text");
    const tip15Text = document.getElementById("tip15Text");
    const tip20Text = document.getElementById("tip20Text");
    const customTipInput = document.getElementById("customTipInput");

    function getSelectedTipMode(){
      const selected = document.querySelector(".tip-box.is-selected");
      if (!selected) return { type: "percent", value: 0 };
    }

    // TIP SELECTION (and custom input behavior)
    const tipBoxes = document.querySelectorAll(".tip-box");
    tipBoxes.forEach(box => {
      box.addEventListener("click", () => {
        tipBoxes.forEach(b => b.classList.remove("is-selected"));
        box.classList.add("is-selected");

        // if custom selected, focus input
        if (box.dataset.tipCustom === "1" && customTipInput){
          customTipInput.focus();
        }
      });
    });

    if (customTipInput){
      customTipInput.addEventListener("input", formatCurrency);

      function formatCurrency(input) {
        const cents = parseInt(input.target.value.replace(/\D/g, ""), 10) || 0;
        input.target.dataset.cents = cents;
        input.target.value = (cents / 100).toFixed(2);
        updateTip(cents / 100);
      }
    }

    // PAYMENT SELECTION
    const paymentOptions = document.querySelectorAll(".payment-option");
    const cardFormWrap = document.getElementById("cardFormWrap");

    function toggleCardForm() {
      const selected = document.querySelector(".payment-option.is-selected");
      const showCardForm = selected?.dataset.payment === "card";
      if (cardFormWrap) cardFormWrap.classList.toggle("is-hidden", !showCardForm);
    }

    paymentOptions.forEach(option => {
      option.addEventListener("click", () => {
        const wasSelected = option.classList.contains("is-selected");
        paymentOptions.forEach(o => o.classList.remove("is-selected"));
        if (!wasSelected) {
          option.classList.add("is-selected");
        }
        toggleCardForm();
      });
    });
    toggleCardForm();

    // PLACE ORDER
    placeOrderBtn.addEventListener("click", () => {
      if (loadingOverlay) {
        loadingOverlay.classList.add("active");
      }

      const selectedPayment = document.querySelector(".payment-option.is-selected");
      const isApplePay = selectedPayment?.dataset.payment === "applepay";

      if (isApplePay) {
        applePayOverlay.classList.add("active");
      }

      const redirectDelay = isApplePay ? 2000 : 800;
      setTimeout(() => {
        if (loadingOverlay) loadingOverlay.classList.remove("active");
        window.location.href = "confirmation.php";
      }, redirectDelay);
    });

    applePayCloseBtn.addEventListener("click", () => {
      applePayOverlay.classList.remove("active");
    });

    applePayOverlay.addEventListener("click", (e) => {
      if (e.target === applePayOverlay) {
        applePayOverlay.classList.remove("active");
      }
    });
  </script>
</body>
</html>
