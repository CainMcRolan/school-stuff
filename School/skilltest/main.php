<?php
try {
    $conn = mysqli_connect('localhost', 'root', '', 'product');
} catch (mysqli_sql_exception $e) {
    echo "Failed to connect to the server";
    exit();
}

session_start();

if (isset($_POST['product_add'])) {
   if (isset($_POST['product_description'])) {
       $product_description = $_POST['product_description'];
       $product_quantity = $_POST['product_quantity'];
       $product_price = $_POST['product_price'];
       $result = mysqli_query($conn, "INSERT INTO products (description, quantity, price, amount) VALUES ('$product_description', '$product_quantity', '$product_price', $product_price * $product_quantity)");
   }

   if (isset($_POST['product_description_1'])) {
       $product_description_1 = $_POST['product_description_1'];
       $product_quantity_1 = $_POST['product_quantity_1'];
       $product_price_1 = $_POST['product_price_1'];
       $result = mysqli_query($conn, "INSERT INTO products (description, quantity, price, amount) VALUES ('$product_description_1', '$product_quantity_1', '$product_price_1', $product_price_1 * $product_quantity_1)");
   }

   $redirect_url = 'main.php';

    header("Location: " . $redirect_url);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SkillTest</title>
   <link rel="stylesheet" href="style.css">
   <script type="module" src="script.js" defer></script>
</head>
<body>
   <?php
      echo "<button id=myBtn>Add</button>";

      $total = 0;

      $display = mysqli_query($conn, "SELECT * FROM products");
      echo "<table>
            <tr>
               <th>Code</th>
               <th>Desc</th>
               <th>Qty</th>
               <th>Price</th>
               <th>Amount</th>
            </tr>";
      while ($row = mysqli_fetch_assoc($display)) {
         echo "<tr>
                  <td>{$row['code']}</td>
                  <td>{$row['description']}</td>
                  <td>{$row['quantity']}</td>
                  <td>{$row['price']}</td>
                  <td>{$row['amount']}</td>
               </tr>";
         
         $total+=$row['amount'];
      }
      echo "<tr>
               <td></td><td></td><td></td><td>Total</td><td>$total</td>
            </tr>
      </table>";  

      echo "
         <div id='myModal' class='modal'>
            <div class='modal-content'>
               <form action='main.php' method='post'>
                  <span class='close'>&times;</span>
                  <div class='container'>
                     <input type='checkbox' name='product_description' value='pizza'>Pizza
                     <input type='hidden' name='product_price' value=500>500 
                     <input type='number' name='product_quantity' placeholder='Qty' style='width:50px;'> 

                     <input type='checkbox' name='product_description_1' value='pasta'>Pasta
                     <input type='hidden' name='product_price_1' value=200>200 
                     <input type='number' name='product_quantity_1' placeholder='Qty' style='width:50px;'> 
                     
                  </div>
                  <input type='submit' name='product_add' value='Add' style='width:50px;'>
               </form>
            </div>
         </div>
      ";
   ?>

</body>
</html>