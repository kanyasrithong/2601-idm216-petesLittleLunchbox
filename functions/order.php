<?php
  $stmt_order = $connection->prepare('SELECT id, item_id, variant_id, bs_id, quantity,	unit_price,	subtotal,	special_requests,	tip FROM `order`');
  $stmt_order->execute();
  $order_result = $stmt_order->get_result();