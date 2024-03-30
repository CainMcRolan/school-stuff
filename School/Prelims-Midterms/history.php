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
   <form method="POST" action="<?php echo 'history.php?name=' . $_GET['name'] . '&category=' . $_GET['category']; ?>">
      <input type="text" name="update_value" placeholder="Insert Value">
      <input type="date" name="update_date">
      <select name="update_select">
         <option value="pullout">PullOut</option>
         <option value="delivery">Deliver</option>
         <option value="wasteges">Wasteges</option>
         <option value="transfer">Transfer</option>
      </select>
      <input type="submit" name="update_submit" value="Add">
   </form>
   <?php
      if (isset($_POST['update-submit'])) { 
         $result = mysqli_query($conn, "INSERT INTO deliveryproducts (del_date, del_product, del_quantity, type) VALUES ('$_POST[update_date]', '$_GET[name]', '$_POST[update_value]', '$_POST[update_select]')");
       
      }


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