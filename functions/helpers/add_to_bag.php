<?php
  session_start();
  require_once "../../db.php";
  include '../items.php';
  include '../variants.php';
  include '../bs_variants.php';

  $item = getItemByID(intval($_GET['item_id']));

  $variants = [];

  if (isset($_POST['variants'])) {
    $variant_ids = $_POST['variants'];
    
    foreach ($variant_ids as $variant_type => $variant_id) {
      $variant_id = intval($variant_id);
      
      // switches GET function depending on variant type
      $variant = $variant_type === 'meat' ?
      getBSVariantByID($variant_id) :
      getVariantByID($variant_id);

      // switches reference table column depending on variant type
      $variants[$variant_type] = $variant_type === 'meat' ?
      $variants[$variant_type] = [
        'id' => $variant_id,
        'variant_name' => $variant['bs_name'],
        'add_price' => floatval($variant['add_price'])
      ] :
      $variants[$variant_type] = [
        'id' => $variant_id,
        'variant_name' => $variant['variant_name'],
        'add_price' => floatval($variant['add_price'])
      ];
    }
  }

  $bag_item = [
    'id' => uniqid(),
    'item_name' => $item['item_name'],
    'item_total' => $item['base_price']
  ];

  if (isset($variants)) {
    $bag_item['variants'] = $variants;
  }

  $_SESSION['bag'][] = $bag_item;

  header("Location: ../../menu.php");
