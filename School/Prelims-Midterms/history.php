<?php
   try {
      $conn = mysqli_connect('localhost', 'root', '', 'prelims_database');
   } catch (mysqli_sql_exception $e) {
      echo "Failed to connect to the server";
      exit();
   }
   session_start();

   echo '
   <a href="list.php?category=' . urlencode($_GET['category']) . '"><input type="button" value="GO BACK TO PRODUCT LIST"></a>
   '
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>History</title>
</head>
<body>
   <h1>History</h1>
   <?php
      $display = mysqli_query($conn, "SELECT * FROM deliveryproducts WHERE del_product = '$_GET[name]'");
      echo "<table style='text-align:center;'>
            <tr>
               <th>Date</th>
               <th>Type</th>
               <th>Qty</th>
               <th>Balance</th>
            </tr>";

      $balance = 0;
      while ($row = mysqli_fetch_assoc($display)) {
         if ($row['type'] == 'Delivery' || $row['type'] == 'Transfer') {
            $balance += $row['del_quantity'];
         } else {
            $balance -= $row['del_quantity'];
         }
         echo "<tr>
                  <td>{$row['del_date']} </td>
                  <td>{$row['type']}</td>
                  <td>{$row['del_quantity']}</td>
                  <td>$balance</td>
               </tr>";
      }
      echo "</table>";
   ?>
</body>
</html>