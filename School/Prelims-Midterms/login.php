<?php
try {
    $conn = mysqli_connect('localhost', 'root', '', 'prelims_database');
} catch (mysqli_sql_exception $e) {
    echo "Failed to connect to the server";
    exit();
}

session_start();

if (isset($_GET['product_add'])) {
    $product_code = $_GET['product_code'];
    $product_name = $_GET['product_name'];
    $product_stocks = $_GET['product_stocks'];
    $product_price = $_GET['product_price'];
    $result = mysqli_query($conn, "INSERT INTO product (code, name, stocks, price, category) VALUES ('$product_code', '$product_name', '$product_stocks', '$product_price', '$_GET[category]')");
}

if (isset($_GET['acc-delete'])) {
    $delete = mysqli_query($conn, "DELETE FROM product WHERE code = '{$_GET['acc-delete']}'");
}

echo '
   <a href="category.php"><input type="button" value="Move To Category"></a>
   <a href="login.php"><input type="button" value="Move To Login"></a>
   <a href="delivery.php"><input type="button" value="Move To Delivery"></a>
   <a href="pullout.php"><input type="button" value="Move To Pullout"></a>
   <a href="wasteges.php"><input type="button" value="Move To Wasteges"></a>
   <a href="transfer.php"><input type="button" value="Move To Transfer"></a>
';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <style>
        .container {
            display: flex;
            margin-top: 30px;
        }
        .categories {
            border: 1px solid black;
            height: 100vh;
            width: 10%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .productsss {
            margin-left: 50px;
            border: 1px solid black;
            padding: 10px;
            height: 400px;
        }
        .product_caterogy {
            width: 90%;
            height: 10%;
            border: 1px solid black;
            background-color: green;
            margin: 10px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: black;
            font-size: 30px;
            font-weight: bold;
        }
        .product_caterogy:hover {
            background-color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="categories">
            <?php
            $display = mysqli_query($conn, "SELECT * FROM category");
            while ($row = mysqli_fetch_assoc($display)) {
                echo "<a class='product_caterogy' href='login.php?category={$row['category']}'>{$row['category']}</a>";
            }
            ?>
        </div>
        <div class="productsss">
          
            <?php
                $display = mysqli_query($conn, "SELECT * FROM category WHERE category = '$_GET[category]'");
                while ($row = mysqli_fetch_assoc($display)) {
                  echo "  <h1>$row[category]</h1>
                  <form action='login.php?category={$row['category']}' method='get'>
                  <label>Code:</label>
                  <input type='number' name='product_code'> <br>
                  <label>Name:</label>
                  <input type='text' name='product_name'> <br>
                  <label>Stocks:</label>
                  <input type='number' name='product_stocks'> <br>
                  <label>Price:</label>
                  <input type='text' name='product_price'>
                  <input type='submit' value='Add' name='product_add'>
              </form>";
                }
        

            $display = mysqli_query($conn, "SELECT * FROM product WHERE category='$_GET[category]'");
            echo "<table style='text-align:center;'>
                <tr>
                    <th>Delete</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Stocks</th>
                    <th>Price</th>
                </tr>";
            while ($row = mysqli_fetch_assoc($display)) {
                echo "<tr>
                    <td>x
                        <form action='login.php' method='get'>
                        <input type='hidden' name='acc-delete' value='{$row['code']}'>
                        <input type='submit' name='submit-delete' value='X'>
                        </form>
                    </td>
                    <td>{$row['code']}</td>
                    <td><a href='history.php?code={$row['code']}&name={$row['name']}'>{$row['name']}</a></td>
                    <td>{$row['stocks']}</td>
                    <td>{$row['price']}</td>
                </tr>";
            }
            echo "</table>";
            ?>
        </div>
    </div>
</body>
</html>