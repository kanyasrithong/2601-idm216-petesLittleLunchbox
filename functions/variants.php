<?php
  $stmt_variants = $connection->prepare('SELECT id, item_id, variant_name, price, img_url FROM variants');
  $stmt_variants->execute();
  $variants_result = $stmt_variants->get_result();
