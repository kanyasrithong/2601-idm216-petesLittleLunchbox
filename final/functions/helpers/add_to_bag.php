<?php
  session_start();
  require_once "../../../db.php";
  include '../items.php';
  include '../variants.php';
  include '../bs_variants.php';

  $item = getItemByID(intval($_GET['item_id']));
  $variants = [];
  $quantity = intval($_POST['quantity'] ?? 1);

  if (!empty($_POST['variants'])) {
    $variant_ids = $_POST['variants'];
    
    foreach ($variant_ids as $variant_type => $variant_id) {
      $variant_id = intval($variant_id);
      
      // switches GET function depending on variant type
      $variant = $variant_type === 'meat' ?
      getBSVariantByID($variant_id) :
      getVariantByID($variant_id);

      // switches reference table column depending on variant type
      $variants[$variant_type] = $variant_type === 'meat' ?
      [
        'id' => $variant_id,
        'variant_name' => $variant['bs_name'],
        'add_price' => floatval($variant['add_price'])
      ] :
      [
        'id' => $variant_id,
        'variant_name' => $variant['variant_name'],
        'add_price' => floatval($variant['add_price'])
      ];
    }
  }

  $bag_item = [
    'id' => uniqid(),
    'item_name' => $item['item_name'],
    'item_quantity' => $quantity,
    'item_total' => $item['base_price'],
    'img_url' => $item['img_url']
  ];

  if (!empty($variants)) {
    $bag_item['variants'] = $variants;
  }

  $_SESSION['bag'][] = $bag_item;

  header("Location: ../../menu.php");
