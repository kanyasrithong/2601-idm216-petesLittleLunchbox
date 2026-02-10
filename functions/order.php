<?php
  $stmt_order = $connection->prepare('SELECT id, item_id, variant_id, bs_id, quantity,	unit_price,	special_requests FROM `order`');
  $stmt_order->execute();
  $order_result = $stmt_order->get_result();