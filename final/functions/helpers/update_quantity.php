<?php
session_start();
header('Content-Type: application/json');

ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);
$item_id = $data['item_id'];
$quantity = intval($data['quantity']);

// resets for new calculation
$updated_variants = [];
$updated_base_total = 0;
$updated_variant_total = 0;
$updated_item_total = 0;
$subtotal = 0;

foreach ($_SESSION['bag'] as &$item) {

  if ($item['id'] === $item_id) {
    $item['item_quantity'] = $quantity;
  }

  $base_total = $item['item_total'] * $item['item_quantity'];
  $variants_total = 0;

  // adds updated variant totals
  if (!empty($item['variants'])) {
    foreach ($item['variants'] as $variant) {
      $variant_total = $variant['add_price'] * $item['item_quantity'];
      $variants_total += $variant_total;

      if ($item['id'] === $item_id) {
        $updated_variants[] = [
          'add_price' => number_format($variant['add_price'], 2),
          'total' => number_format($variant_total, 2)
        ];
      }
    }
  }

  $item_total = $base_total + $variants_total;

  if ($item['id'] === $item_id) {
    $updated_base_total = $base_total;
    $updated_variant_total = $variants_total;
    $updated_item_total = $item_total;
  }

  $subtotal += $item_total;
}

echo json_encode([
  "item_id" => $item_id,
  "base_total" => number_format($updated_base_total, 2),
  "variant_total" => number_format($updated_variant_total, 2),
  "variants" => $updated_variants,
  "item_total" => number_format($updated_item_total, 2),
  "subtotal" => number_format($subtotal, 2)
]);
