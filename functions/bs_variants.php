<?php
  function getBSVariants() {
    global $connection;
    $stmt_bs = $connection->prepare('SELECT * FROM bs_variants');
    $stmt_bs->execute();
    $bs_result = $stmt_bs->get_result();
    
    return $bs_result->fetch_all(MYSQLI_ASSOC);
  }

  function getBSVariantByID($bs_variant_id) {
    global $connection;
    $stmt_bs = $connection->prepare('SELECT * FROM bs_variants WHERE id = ? LIMIT 1');
    $stmt_bs->bind_param('i', $bs_variant_id);
    $stmt_bs->execute();
    $bs_result = $stmt_bs->get_result();
    
    return $bs_result->fetch_assoc();
  }
