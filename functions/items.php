<?php
  $stmt_items = $connection->prepare('SELECT id, category_id, item_name, base_price, `description`, img_url FROM items');
  $stmt_items->execute();
  $items_result = $stmt_items->get_result();
