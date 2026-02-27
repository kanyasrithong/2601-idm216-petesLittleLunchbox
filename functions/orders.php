<?php
  function getOrders() {
    global $connection;
    $stmt_order = $connection->prepare('SELECT id, item_id, variant_id, bs_id, quantity,	unit_price, special_requests, img_url FROM `order`');
    $stmt_order->execute();
    $order_result = $stmt_order->get_result();

    return $order_result->fetch_all(MYSQLI_ASSOC);
  }