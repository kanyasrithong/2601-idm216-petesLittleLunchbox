<?php
  $stmt_categories = $connection->prepare('SELECT id, category_name FROM categories');
  $stmt_categories->execute();
  $categories_result = $stmt_categories->get_result();
