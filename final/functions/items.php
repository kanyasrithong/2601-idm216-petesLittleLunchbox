<?php
  function getItems() {
    global $connection;
    $stmt_items = $connection->prepare('SELECT id, category_id, item_name, base_price, `description`, img_url FROM items');
    $stmt_items->execute();
    $items = $stmt_items->get_result();

    return $items->fetch_all(MYSQLI_ASSOC); 
  }

  function getItemsByCategory($category_id) {
    global $connection;
    $stmt_items = $connection->prepare('SELECT id, category_id, item_name, base_price, `description`, img_url FROM items WHERE category_id = ?');
    $stmt_items->bind_param('i', $category_id);
    $stmt_items->execute();
    $items = $stmt_items->get_result();

    return $items->fetch_all(MYSQLI_ASSOC);
  }

  function getItemByID($item_id) {
    global $connection;
    $stmt_item = $connection->prepare('SELECT id, category_id, item_name, base_price, `description`, img_url FROM items WHERE id = ? LIMIT 1');
    $stmt_item->bind_param('i', $item_id);
    $stmt_item->execute();
    $item = $stmt_item->get_result();

    return $item->fetch_assoc(); 
  }

  function getItemByName($name) {
    global $connection;
    $stmt_item = $connection->prepare('SELECT id, category_id, item_name, base_price, `description`, img_url FROM items WHERE item_name = ? LIMIT 1');
    $stmt_item->bind_param('s', $name);
    $stmt_item->execute();
    $item = $stmt_item->get_result();

    return $item->fetch_assoc(); 
  }
