<?php
  $stmt_bs = $connection->prepare('SELECT id, item_id, variant_id, bs_name, img_url FROM bs_variants');
  $stmt_bs->execute();
  $bs_result = $stmt_bs->get_result();
