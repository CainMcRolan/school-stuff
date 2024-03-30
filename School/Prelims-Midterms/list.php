<?php
try {
    $conn = mysqli_connect('localhost', 'root', '', 'prelims_database');
} catch (mysqli_sql_exception $e) {
    echo "Failed to connect to the server";
    exit();
}

$category = $_GET['category'];

$result = mysqli_query($conn, "SELECT * FROM product WHERE category = '$category'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
         
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stocks</th>
            <th>Action</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
         echo "<tr>
                  <td>" . $row['code'] . "</td>
                  <td><a href='history.php?name=" . urlencode($row['name']) . "&category=" . urlencode($row['category']) ."'>" . $row['name'] . "</a></td>
                  <td>" . $row['price'] . "</td>
                  <td>" . $row['stocks'] . "</td>
                  <td>
                     <a href='login.php?acc-delete=" . $row['code'] . "'>Delete</a>
                  </td>
               </tr>";
        }
        ?>
    </table>
</body>
</html>