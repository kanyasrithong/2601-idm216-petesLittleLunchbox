<?php
  $stmt_process = $connection->prepare('SELECT id, item_name, base_price, `description`, img_url FROM items WHERE id LIKE ?');
  $stmt_process->bind_param("i", $order_id);
  $stmt_process->execute();
  $process_result = $stmt_process->get_result();
  $processed_item = $process_result->fetch_assoc();