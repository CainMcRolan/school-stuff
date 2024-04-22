<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semifinals</title>
    <link rel="stylesheet" href="style.css">
    <script type="module" src="script.js" defer></script>
</head>
<body>
    <?php
    require('fpdf.php');
    try {
        $conn = mysqli_connect('localhost', 'root', '', 'semi');
    } catch (mysqli_sql_exception $e) {
        echo "Failed to connect to the server";
        exit();
    }

    if (isset($_POST['user_edit'])) {
        $user_id = $_POST['user_id'];
        $user_name = $_POST['user_name'];
        $user_course = $_POST['user_course'];
        $user_contact = $_POST['user_contact'];
        $result = mysqli_query($conn, "UPDATE info SET name='$user_name', course='$user_course', contact='$user_contact' WHERE id=$user_id");
        $redirect_url = 'main.php';
        header("Location: " . $redirect_url);
        exit();
    }

    if (isset($_POST['user_add'])) {
        $user_name = $_POST['user_name'];
        $user_course = $_POST['user_course'];
        $user_contact = $_POST['user_contact'];
        $result = mysqli_query($conn, "INSERT INTO info (name, course, contact) VALUES ('$user_name', '$user_course', '$user_contact')");
        $redirect_url = 'main.php';
        header("Location: " . $redirect_url);
        exit();
    }

    function generatePDF() {
        try {
            $conn = mysqli_connect('localhost', 'root', '', 'semi');
        } catch (mysqli_sql_exception $e) {
            echo "Failed to connect to the server";
            exit();
        }

        ob_clean();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Cell(0, 10, 'LIST OF NAMES', 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'NAME', 1);
        $pdf->Cell(60, 10, 'COURSE', 1);
        $pdf->Cell(60, 10, 'CONTACT NO', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 12);
        $display = mysqli_query($conn, "SELECT * FROM info");

        while ($row = mysqli_fetch_assoc($display)) {
            $pdf->Cell(60, 10, $row['name'], 1);
            $pdf->Cell(60, 10, $row['course'], 1);
            $pdf->Cell(60, 10, $row['contact'], 1);
            $pdf->Ln();
        }

        $pdf->Output('user_data.pdf', 'I');
    }

    if (isset($_GET['generate_pdf'])) {
        generatePDF();
        exit;
    }
    ?>

    <button id='myBtn'>Add</button>
    <button id='printer'>Print</button>

    <table>
        <tr>
            <th>Name</th>
            <th>Course</th>
            <th>Contact Info</th>
            <th>Action</th>
        </tr>
        <?php
        $display = mysqli_query($conn, "SELECT * FROM info");
        while ($row = mysqli_fetch_assoc($display)) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['course']}</td>
                    <td>{$row['contact']}</td>
                    <td><button class='edit_button' data-user-id='{$row['id']}'>Edit</button></td>
                </tr>";
        }
        ?>
    </table>

    <div id='myModal' class='modal'>
        <div class='modal-content'>
            <span class='close'>&times;</span>
            <div class='container'>
                <form id="editForm" action='main.php' method='post' style="display: none;">
                    <input type='hidden' name='user_id' class='user_id'>
                    Name: <input type='text' name='user_name' class='user_name'>
                    Course: <select name='user_course'  class='user_course'>
                        <option value='CPE'>CPE</option>
                        <option value='CCS'>CCS</option>
                        <option value='BSBA'>BSBA</option>
                    </select>
                    Contact Info: <input type='number' name='user_contact'  class='user_contact'>
                    <input type='submit' name='user_edit' value='Save'>
                </form>
                <form id="addForm" action='main.php' method='post' style="display: none;">
                    Name: <input type='text' name='user_name' class='user_name'>
                    Course: <select name='user_course'  class='user_course'>
                        <option value='CPE'>CPE</option>
                        <option value='CCS'>CCS</option>
                        <option value='BSBA'>BSBA</option>
                    </select>
                    Contact Info: <input type='number' name='user_contact'  class='user_contact'>
                    <input type='submit' name='user_add' value='Add'>
                </form>
            </div>
        </div>
    </div>
    <script>
        const printerButton = document.getElementById('printer');
        printerButton.addEventListener('click', () => {
            window.location.href = 'main.php?generate_pdf=true';
        });
    </script>
</body>
</html>
