
<html>
    <head>
        <title>Ledger</title>
        <link rel="stylesheet" href="ledger.css">
    </head>
    <body style="font-family: arial;">
        <div id="divInp" align=center>
            <br><a href=account.php> <input type=button value=Accounts></a>

            <form method=get action=ledger.php> 
                <br>Account Number: <input type="text" name="txtaccount" readonly value='<?PHP echo $_GET["txtaccount"]?>'>
                <br><br>Account Name: <input type="text" name="txtname" readonly value='<?PHP echo $_GET["txtname"]?>'>
                <br><br>Date: <input type="date" name="txtdate" value="<?PHP echo date('Y-m-d')?>">
                <br><br>Description: <input type='text' name="txtdesc">
                <br><br>Type: <select name="txttype">
                    <option value="debit">Debit</option>
                    <option value="credit">Credit</option>
                </select>
                <br><br>Amount: <input type="number" name=txtamount required>
                <br><br><input type="submit" value=Add>
            </form>
        </div><br><br>
        <table cellpadding=0 cellspacing=0 border=0 id="Tbl">
            <tr align=center>
                <td>      
                    <br>  
                    <?php

                    $conn=new mysqli("localhost", "root", "", "dbactone");

                    if(isset($_GET["txttype"])){
                        $balance=0;
                        $result=$conn->query("SELECT * FROM tblledger WHERE fldaccno='$_GET[txtaccount]'");
                        while($row=$result->fetch_assoc()){ 
                            $balance=$row["fldbalance"];
                        }

                        if($_GET["txttype"]=="debit"){
                            $balance=$balance+$_GET["txtamount"];
                            $conn->query("insert into tblledger (fldaccno, flddate, flddesc, flddebit, fldbalance) values ('$_GET[txtaccount]','$_GET[txtdate]','$_GET[txtdesc]',$_GET[txtamount],$balance)");
                        }else{
                            $balance=$balance-$_GET["txtamount"];
                            $conn->query("insert into tblledger (fldaccno, flddate, flddesc, fldcredit, fldbalance) values ('$_GET[txtaccount]','$_GET[txtdate]','$_GET[txtdesc]',$_GET[txtamount],$balance)");
                        }
                    }
                    ?>
                    <table border=1>
                        <tr><th>Date</th><th>Description</th><th>Debit</th><th>Credit</th><th>Balance</th></tr>
                        <?php
                            $result = $conn->query("SELECT * FROM tblledger WHERE fldaccno='$_GET[txtaccount]'");
                            while($row=$result->fetch_assoc()){ 
                                echo "<tr>
                                <td>$row[flddate]</td>
                                <td>$row[flddesc]</td>
                                <td>$row[flddebit]</td>
                                <td>$row[fldcredit]</td>
                                <td>$row[fldbalance]</td>
                                </tr>";
                            }
                        ?>
                    </table><br>
                </td>
            </tr>
        </table>
    </body>
</html>