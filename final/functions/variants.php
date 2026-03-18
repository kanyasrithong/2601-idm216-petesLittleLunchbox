<?php
  function getVariants() {
    global $connection;
    $stmt_variants = $connection->prepare('SELECT * FROM variants');
    $stmt_variants->execute();
    $variants_result = $stmt_variants->get_result();
    
    return $variants_result->fetch_all(MYSQLI_ASSOC);
  }

  function getVariantsByCategory($category_id) {
    global $connection;
    $stmt_variants = $connection->prepare('SELECT * FROM variants WHERE category_id = ?');
    $stmt_variants->bind_param('i', $category_id);
    $stmt_variants->execute();
    $variants_result = $stmt_variants->get_result();
    
    return $variants_result->fetch_all(MYSQLI_ASSOC);
  }

  function getVariantByID($variant_id) {
    global $connection;
    $stmt_variant = $connection->prepare('SELECT * FROM variants WHERE id = ? LIMIT 1');
    $stmt_variant->bind_param('i', $variant_id);
    $stmt_variant->execute();
    $variant_result = $stmt_variant->get_result();
    
    return $variant_result->fetch_assoc();
  }