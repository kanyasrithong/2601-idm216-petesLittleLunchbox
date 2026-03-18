<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$item_id = $data['item_id'];
$quantity = intval($data['quantity']);

// resets for new calculation
$updated_item_total = 0;
$subtotal = 0;

foreach ($_SESSION['bag'] as &$item) {
  if ($item['id'] === $item_id) {
    $item['item_quantity'] = $quantity;
  }

  $base_price_total= $item['item_total'] * $item['item_quantity'];
  $variants_total = 0;
  $item_variants = [];

  // adds updated variant totals
  if (!empty($item['variants'])) {
    foreach ($item['variants'] as $variant) {
      $variant_total = $variant['add_price'] * $item['item_quantity'];

      $item_variants[] = [
          'add_price' => number_format($variant_total, 2)
      ];

      $variants_total += $variant_total;
    }
  }

  // full price of current cart item
  $cart_item_total = $base_price_total + $variants_total;

  // save updated price for item that changed quantity
  if ($item['id'] === $item_id) {
    $updated_item_total = $cart_item_total;
    $updated_variants = $item_variants;
  }

  $subtotal += $cart_item_total;
}

echo json_encode([
  "item_id" => $item_id,
  "item_total" => number_format($base_price_total, 2),
  "subtotal" => number_format($subtotal, 2),
  "variants" => $updated_variants
]);
