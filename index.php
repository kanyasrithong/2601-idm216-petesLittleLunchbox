<?php
  require_once "db.php";
  $stmt = $connection->prepare('SELECT id, category_id, category_name, display_order FROM category');
  $stmt->execute();
  $stmt->bind_result( $id, $category_id, $category_name, $display_order);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pete's Little Lunchbox</title>
</head>
<body>
  <h1>Category Table</h1>
  <table>
    <tr>
      <th>id</th>
      <th>category_id</th>
      <th>category_name</th>
      <th>display_order</th>
    </tr>
    <?php
      while ($stmt->fetch()) : ?>
        <tr>
          <th><?php echo $id ?></th>
          <th><?php echo $category_id ?></th>
          <th><?php echo $category_name ?></th>
          <th><?php echo $display_order ?></th>
        </tr>
    <?php endwhile ?>
  </table>
</body>
</html>