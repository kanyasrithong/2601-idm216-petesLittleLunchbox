<?php
  $stmt_variants = $connection->prepare('SELECT id, category_id, variant_name, add_price, img_url FROM variants');
  $stmt_variants->execute();
  $variants_result = $stmt_variants->get_result();
