<?php
  $stmt_bs = $connection->prepare('SELECT id, bs_name, add_price, img_url FROM bs_variants');
  $stmt_bs->execute();
  $bs_result = $stmt_bs->get_result();
