
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
   <title>Wasteges</title>
</head>
<body>
   <h1>Wasteges</h1>
   <form action="wasteges.php" method="get">
      <label>Date:</label>
      <input type="date" name="waste-date"> <br>
      <label>Waste No:</label>
      <input type="text" name="waste-number"> <br>
      <label>Reason</label>
      <input type="text" name="waste-reason"> <br>
      <label>Product:</label>
      <select name="waste-product">
      <?php
         $description = mysqli_query($conn, "SELECT * FROM product");
         while ($rows = mysqli_fetch_assoc($description)) {
               echo "<option value='{$rows['name']}'>{$rows['name']}</option>";
         }
      ?>
      </select> <br>
      <label>Quantity:</label>
      <input type="number" name="waste-quantity">
      <input type="submit" name="waste-add" value="Add">
   </form>
</body>
</html>
<?php
   if (isset($_GET['waste-add'])) {
      $waste_date = $_GET['waste-date'];
      $waste_number = $_GET['waste-number'];
      $waste_reason = $_GET['waste-reason'];
      $waste_products = $_GET['waste-product'];
      $waste_quantity = $_GET['waste-quantity'];

      $result = mysqli_query($conn, "INSERT INTO wasteges (date, number, reason, product, quantity) VALUES ('$waste_date', '$waste_number', '$waste_reason', '$waste_products', '$waste_quantity')");
      $result2 = mysqli_query($conn, "INSERT INTO deliveryproducts (del_product, del_quantity, type) VALUES ('$waste_products', '$waste_quantity', 'Waste')");
   }


   if (isset($_GET['acc-delete'])) {
      $delete = mysqli_query($conn, "DELETE FROM wasteges WHERE number = '{$_GET['acc-delete']}'");
   }

   $display = mysqli_query($conn, "SELECT * FROM wasteges");
   echo "<table style='text-align:center;'>
         <tr>
            <th>Delete</th>
            <th>Date</th>
            <th>Waste Number</th>
            <th>Reason</th>
            <th>Product</th>
            <th>Quantity</th>
         </tr>";
   while ($row = mysqli_fetch_assoc($display)) {
      echo "<tr>
               <td>
                  <form action='wasteges.php' method='get'>
                  <input type='hidden' name='acc-delete' value='{$row['number']}'>
                  <input type='submit' name='submit-delete' value='X'>
                  </form>
               </td>
               <td>{$row['date']}</td>
               <td>{$row['number']}</td>
               <td>{$row['reason']}</td>
               <td>{$row['product']}</td>
               <td>{$row['quantity']}</td>
            </tr>";
   }
   echo "</table>";
?>