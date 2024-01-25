<?php
   try {
      $conn = mysqli_connect('localhost', 'root', '', 'ledgerdb');
   }catch(mysqli_sql_exception) {
      echo "Failed to connect to the server";
      exit();
   }
  
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>
</head>
<body>
   <div class="container">
      <form action="home.php" method="POST">
         <label>Account Number:</label>
         <input type="number" name="account-number" required> 
         <label>Username:</label>
         <input type="text" name="account-name" required> 
         <input type="submit" name="register" value="Register">
      </form>
   </div>
</body>
</html>
<?php
   if (isset($_POST['register'])) {
      $account_number = filter_input(INPUT_POST, "account-number", FILTER_SANITIZE_SPECIAL_CHARS); 
      $account_name = filter_input(INPUT_POST, "account-name", FILTER_SANITIZE_SPECIAL_CHARS); 

      try {
         $result = mysqli_query($conn, "INSERT INTO accounts (acc_num, acc_name) VALUES ('$account_number', '$account_name')");
         echo "<strong>Account Registered Succesfully</strong>";
      } catch(mysqli_sql_exception) {
         echo "<strong>Account Number already exist!</strong>";
      }
   }

   
   if (isset($_POST['acc-delete'])) {
      $delete = mysqli_query($conn, "DELETE FROM accounts WHERE acc_name = '{$_POST['acc-delete']}'");
      if ($delete) {
        echo "<strong>Account deleted successfully</strong>";
      } else {
        echo "<strong>Error deleting account</strong>";
    }
   }

   $_SESSION['account-num'] = '';
   $_SESSION['account-name'] = '';

   try {
      $display = mysqli_query($conn, "SELECT * FROM accounts");
      echo " 
         <table style='text-align:center;'>
         <tr>
            <th>Delete</th>
            <th>Ledger</th>
            <th>Account Number</th>
            <th>Account Name</th>
            <th>Balance</th>
         </tr>";
         while ($row = mysqli_fetch_assoc($display)) {
            echo "
            <tr>
               <td>
                  <form action='home.php' method='post'>
                     <input type='hidden' name='acc-delete' value='{$row['acc_name']}'>
                     <input type='submit' name='submit-delete' value='X'>
                  </form>
               </td>
               <td>
                  <form action='home.php' method='post'>
                     <input type='hidden' name='direct-acc-name' value='{$row['acc_name']}'>
                     <input type='hidden' name='direct-acc-num' value='{$row['acc_num']}'>
                     <input type='submit' name='submit-ledger' value='Ledger'>
                  </form>
               </td>
               <td>{$row['acc_num']}</td>
               <td>{$row['acc_name']}</td>
            ";
         
         $display_connection = mysqli_connect('localhost', 'root', '', 'ledgerdb');
         $display_balance = mysqli_query($display_connection, "SELECT * FROM ledger WHERE acc_number = '{$row['acc_num']}'");
         $balance = 0;
         while ($row = mysqli_fetch_assoc($display_balance)) {
            $balance = intval($row['acc_balance']);
         }
         echo "<td>₱$balance</td>";
      } 
   } catch(mysqli_sql_exception) {
      echo "<strong>Cannot connect to the server :<</strong>";
   }

   
   if (isset($_POST['submit-ledger'])) {
      $_SESSION['account-num'] = $_POST['direct-acc-num'];
      $_SESSION['account-name'] = $_POST['direct-acc-name'];
      header("Location: ledger.php?acc_num={$_POST['direct-acc-num']}&acc_name={$_POST['direct-acc-name']}");
   
      exit();
   }
   

   mysqli_close($conn);
?>
