<?php
   session_start();
   try {
      $conn = mysqli_connect('localhost', 'root', '', 'ledgerdb');
   }catch(mysqli_sql_exception) {
      echo "Failed to connect to the server";
      exit();
   }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ledger</title>
</head>
<style>
   .container form {
      display: grid;
      grid-template-columns: 130px 200px;
      row-gap: 10px;
      row
   }
</style>
<body>
<a href=home.php> <input type=button value=Accounts></a>
<!--<a href="edit.php"><input type="button" value="Edit Account"></a>-->
   <div class="container">
      <form action="ledger.php" method="post">
         <label>Account Number:</label>
         <input type="number" name="account-number" value="<?php echo $_SESSION['account-num'] ?>" readonly> 
         <label>Account Name:</label> 
         <input type="text" name="account-name" value="<?php echo $_SESSION['account-name']; ?>" readonly>
         <label>Date:</label>
         <input type="date" name="account-date" value="<?php echo date("Y-m-d"); ?>" required>
         <label>Description:</label>
         <select name="account-goal" required>
            <?php
                $description = mysqli_query($conn, "SELECT * FROM chart");
                while ($rows = mysqli_fetch_assoc($description)) {
                    echo "<option value='{$rows['chart_id']}'>{$rows['acc_name']}</option>";
                }
            ?>
         </select>
         <label>Amount:</label>
         <input type="number" name="account-amount" required>
         <input type="submit" name="submit">
      </form>
   </div>
   <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $balance = 0;
         try {
            $display_balance = mysqli_query($conn, "SELECT * FROM ledger WHERE acc_number = '{$_SESSION['account-num']}'");
            while ($row = mysqli_fetch_assoc($display_balance)) {
            $balance = $row['acc_balance'];
            } 
         } catch(mysqli_sql_exception) {
            echo "Failed to connect to the server";
         }

         $description = mysqli_query($conn, "SELECT * FROM chart WHERE chart_id = '{$_POST['account-goal']}'");
         while ($rows = mysqli_fetch_assoc($description)) {
             if ($rows['acc_type'] == "owners equity" || $rows['acc_type'] == "asset") {
                 $balance += $_POST['account-amount'];
                 $result = mysqli_query($conn, "INSERT INTO ledger (acc_number, acc_username, acc_date, acc_desc, acc_debit, acc_balance) VALUES ('{$_SESSION['account-num']}', '{$_SESSION['account-name']}', '{$_POST['account-date']}', '{$rows['acc_name']}', '{$_POST['account-amount']}', '{$balance}')");
             } else if ($rows['acc_type'] == "liability") {
                 $balance -= $_POST['account-amount'];
                 $result = mysqli_query($conn, "INSERT INTO ledger (acc_number, acc_username, acc_date, acc_desc, acc_credit, acc_balance) VALUES ('{$_SESSION['account-num']}', '{$_SESSION['account-name']}', '{$_POST['account-date']}', '{$rows['acc_name']}', '{$_POST['account-amount']}', '{$balance}')");
             }
         }
      }

      echo "<table center>
               <tr>
                  <th>Date</th>
                  <th>Description</th>
                  <th>Debit</th>
                  <th>Credit</th>
                  <th>Balance</th>
               </tr>";

      $display = mysqli_query($conn, "SELECT * FROM ledger WHERE acc_number = '{$_SESSION['account-num']}'");
      while ($row = mysqli_fetch_assoc($display)) {
         echo "<tr>
                  <td>{$row['acc_date']}</td>
                  <td>{$row['acc_desc']}</td>
                  <td>₱{$row['acc_debit']}</td>
                  <td>₱{$row['acc_credit']}</td>
                  <td>₱{$row['acc_balance']}</td>
               </tr>";
      }
      echo "</table>"
   ?>
</body>
</html>