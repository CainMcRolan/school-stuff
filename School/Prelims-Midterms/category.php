<?php
   try {
      $conn = mysqli_connect('localhost', 'root', '', 'prelims_database');
  } catch (mysqli_sql_exception $e) {
      echo "Failed to connect to the server";
      exit();
  }
  
  session_start();
  
  if (isset($_POST['category_add'])) {
      $category_name = $_POST['category'];
      $stmt = $conn->prepare("INSERT INTO category (category) VALUES (?)");
      $stmt->bind_param("s", $category_name);
      $stmt->execute();
      $stmt->close();
  }
  
  if (isset($_POST['category_update'])) {
      $category_name = $_POST['category'];
      $category_id = $_POST['category_id'];
      $stmt = $conn->prepare("UPDATE category SET category = ? WHERE category = ?");
      $stmt->bind_param("ss", $category_name, $category_id);
      $stmt->execute();
      $stmt->close();
  }
  
  if (isset($_GET['acc-delete'])) {
      $delete = mysqli_query($conn, "DELETE FROM category WHERE category = '{$_GET['acc-delete']}'");
  }
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
   <title>Category</title>
</head>
<body>
<h1>Category</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Category:</label>
        <input type="text" name="category" value="<?php
        if (isset($_GET['category'])) {
            echo $_GET['category'];
        } else {
            echo "";
        } ?>">
        <input type="hidden" name="category_id" value="<?php
        if (isset($_GET['category'])) {
            echo $_GET['category'];
        } else {
            echo "";
        } ?>">
        <input type="submit" value="Add" name="category_add">
        <input type="submit" value="Update" name="category_update">
    </form>
   <?php
      $display = mysqli_query($conn, "SELECT * FROM category");
      echo "<table style='text-align:center;'>
            <tr>
               <th>Delete</th>
               <th>Name</th>
            </tr>";
      while ($row = mysqli_fetch_assoc($display)) {
         echo "<tr>
                  <td>
                     <form action='category.php' method='get'>
                        <input type='hidden' name='acc-delete' value='{$row['category']}'>
                        <input type='submit' name='submit-delete' value='X'>
                     </form>
                  </td>
                  <td><a href=category.php?category=$row[category]>{$row['category']}</td>
               </tr>";
      }
      echo "</table>";
   ?>
</body>
</html>