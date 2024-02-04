<?php
   session_start();
   try {
      $conn = mysqli_connect('localhost', 'root', '', 'ledgerdb');
   } catch(mysqli_sql_exception) {
      echo "Cannot connect to the server";
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Charts</title>
</head>
<body>
   <a href="home.php"><button>Back to Accounts</button></a>
   <form action="charts.php" method="post">
      <h1>Charts of Account</h1>
      <label>Name:</label>
      <input type="text" name="type_name" required> 
      <label>Type:</label>
      <select name="type_type" required>
         <option value="asset" selected>Asset</option>
         <option value="liability">Liability</option>
         <option value="owners equity">Owners Equity</option>
      </select> 
      <input type="submit" value="Add" name="submit">
   </form>
</body>
</html>

<?php
   if (isset($_POST['submit'])) {
      $insert = mysqli_query($conn, "INSERT INTO chart (acc_type, acc_name) VALUES ('{$_POST['type_name']}', '{$_POST['type_type']}')");
   }

   if (isset($_POST['acc-delete'])) {
      $delete = mysqli_query($conn, "DELETE FROM chart WHERE acc_name = '{$_POST['acc-delete']}'");
   }


   echo "<table><tr><th></th><th>Name</th><th>Type</th></tr>";

   $display = mysqli_query($conn, "SELECT * FROM chart");
   while ($row = mysqli_fetch_assoc($display)) {
      echo "<tr>
               <td><form action='charts.php' method='post'>
               <input type='hidden' name='acc-delete' value='{$row['acc_name']}'>
               <input type='submit' name='submit-delete' value='X'>
            </form></td>
               <td>{$row['acc_type']}</td>
               <td>{$row['acc_name']}</td>
            </tr>";
   }

   echo "</table>"
?> 