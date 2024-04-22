<?php
require('fpdf.php');
try {
    $conn = mysqli_connect('localhost', 'root', '', 'semi');
} catch (mysqli_sql_exception $e) {
    echo "Failed to connect to the server";
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

function generatePDF()
{
    try {
        $conn = mysqli_connect('localhost', 'root', '', 'semi');
    } catch (mysqli_sql_exception $e) {
        echo "Failed to connect to the server";
        exit();
    }

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Center the title
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
    echo "<button id='myBtn'>+</button>";
    echo "<button id='printer'>Print</button>";
    $display = mysqli_query($conn, "SELECT * FROM info");
    echo "<table>
            <tr>
                <th>Name</th>
                <th>Course</th>
                <th>Contact Info</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($display)) {
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['course']}</td>
                <td>{$row['contact']}</td>
            </tr>";
    }
    echo "</table>";
    echo " <div id='myModal' class='modal'>
            <div class='modal-content'>
                <form action='main.php' method='post'>
                    <span class='close'>&times;</span>
                    <div class='container'>
                        Name: <input type='text' name='user_name'>
                        Course: <select name='user_course'>
                            <option value='CPE'>CPE</option>
                            <option value='CCS'>CCS</option>
                            <option value='BSBA'>BSBA</option>
                        </select>
                        Contact Info: <input type='number' name='user_contact'>
                    </div>
                    <input type='submit' name='user_add' value='Add' style='width:50px;'>
                </form>
            </div>
        </div>";
    ?>
    <script>
        const printerButton = document.getElementById('printer');
        printerButton.addEventListener('click', () => {
            window.location.href = 'main.php?generate_pdf=true';
        });
    </script>
</body>
</html>