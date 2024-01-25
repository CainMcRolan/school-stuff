<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ledger</title>
</head>
<body>
   <?php
   try {
      echo "{$_SESSION['account-num']}";
      echo "{$_SESSION['account-name']}";
   } catch(Error){
      echo "failed to connect";
   }
   
   ?>
</body>
</html>