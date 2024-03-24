<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messenger Demo</title>
</head>
<body>
   <form action="chat.php" method="get">
      <table style="border:1px solid silver; position:absolute; top:50%; left: 50%; transform: translate(-50%, -50%)">
         <tr style="background-color:grey; color:white">
            <th colspan="2">Register</th>
            <tr>
               <td>Name</td>
               <td><input type="text" name="index_name"></td>
            </tr>
            <tr>
               <td>Color</td>
               <td>
                  <input type="radio" name="index_color" value="red">Red
                  <input type="radio" name="index_color" value="blue">Blue
                  <input type="radio" name="index_color" value="green">Green
               </td>
            </tr>
            <tr>
               <td colspan="2" align="right">
                  <input type="submit" value="Ok">
               </td>
            </tr>
         </tr>
      </table>
   </form>
</body>
</html>