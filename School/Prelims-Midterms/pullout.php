<?php
   try {
      $conn = mysqli_connect('localhost', 'root', '', 'prelims_database');
   } catch (mysqli_sql_exception $e) {
      echo "Failed to connect to the server";
      exit();
   }
   session_start();

   echo '
   <a href="category.php"><input type="button" value="Move To Category"></a>
   <a href="login.php?category=cake"><input type="button" value="Move To Login"></a>
   <a href="delivery.php"><input type="button" value="Move To Delivery"></a>
   <a href="pullout.php"><input type="button" value="Move To Pullout"></a>
   <a href="wasteges.php"><input type="button" value="Move To Wasteges"></a>
   <a href="transfer.php"><input type="button" value="Move To Transfer"></a>
   '
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pull Out</title>
</head>
<body>
   <h1>Pull Out</h1>
   <form action="pullout.php" method="get">
      <label>Date:</label>
      <input type="date" name="delivery-date"> <br>
      <label>Product:</label>
      <select name="delivery-products">
         <?php
             $description = mysqli_query($conn, "SELECT * FROM product");
             while ($rows = mysqli_fetch_assoc($description)) {
                 echo "<option value='{$rows['name']}'>{$rows['name']}</option>";
             }
         ?>
      </select> <br>
      <label>Quantity:</label>
      <input type="number" name="delivery-quantity">
      <input type="submit" name="delivery-add" value="Add">
   </form>
</body>
</html>
<?php
   if (isset($_GET['delivery-add'])) {
      $delivery_date = $_GET['delivery-date'];
      $delivery_product = $_GET['delivery-products'];
      $delivery_quantity = $_GET['delivery-quantity'];

      $result = mysqli_query($conn, "INSERT INTO deliveryproducts (del_date, del_product, del_quantity, type) VALUES ('$delivery_date', '$delivery_product', '$delivery_quantity', 'PullOut')");
   }


   if (isset($_GET['acc-delete'])) {
      $delete = mysqli_query($conn, "DELETE FROM deliveryproducts WHERE del_code = '{$_GET['acc-delete']}'");
   }

   $display = mysqli_query($conn, "SELECT * FROM deliveryproducts WHERE type = 'PullOut'");
   echo "<table style='text-align:center;'>
         <tr>
            <th>Delete</th>
            <th>Date</th>
            <th>Product</th>
            <th>Quantity</th>
         </tr>";
   while ($row = mysqli_fetch_assoc($display)) {
      echo "<tr>
               <td>
                  <form action='delivery.php' method='get'>
                  <input type='hidden' name='acc-delete' value='{$row['del_code']}'>
                  <input type='submit' name='submit-delete' value='X'>
                  </form>
               </td>
               <td>{$row['del_date']}</td>
               <td>{$row['del_product']}</td>
               <td>{$row['del_quantity']}</td>
            </tr>";
   }
   echo "</table>";
?>