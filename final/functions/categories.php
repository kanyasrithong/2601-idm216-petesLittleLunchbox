<?php
  function getCategories() {
    global $connection;
    $stmt_categories = $connection->prepare('SELECT id, category_name FROM categories');
    $stmt_categories->execute();
    $categories_result = $stmt_categories->get_result();

    return $categories_result->fetch_all(MYSQLI_ASSOC);
  }
