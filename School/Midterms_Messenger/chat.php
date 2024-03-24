<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
   <?php
      $conn = mysqli_connect("localhost", "root", "", "dbsample");

      $no = 0;

      $result = mysqli_query($conn, "SELECT * FROM tbldname WHERE fldname='$_GET[txtname]'");

      while($row= mysqli_fetch_assoc($result)) {
         $no++;
      }

      if($no==0) {
         $result = mysqli_query($conn, "INSERT INTO tblname (fldname, fldcolor) VALUES ('$_GET[txtname]', '$_GET[txtcolor]')");
         $result = mysqli_query($conn, "SELECT * FROM tblname ORDER BY id DESC LIMIT 1");
      } else {
         $result = mysqli_query($conn, "SELECT * FROM tblname WHERE fldname='$_GET[txtname]'");
      }

      $myid = 0;
      while($row= mysqli_fetch_assoc($result)) {
         $myid=$row["id"];
      }
   ?>

   <table style="border:1px solid grey">
      <tr>
         <td height=300>
            <iframe src="messages.php" width="100%" height="100%" frameborder="0"></iframe>
         </td>
      </tr>   
      <tr style="background-color:grey">
         <td></td>
      </tr>
      <tr>
         <td>Message <input type="text" size="20"><input type="text" value="<?php echo $myid;?>"></td>
      </tr>
   </table>
</body>
</html>