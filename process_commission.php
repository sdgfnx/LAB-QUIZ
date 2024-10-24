<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commission Output</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the CSS file -->
</head>
<body>
    <?php
    // MySQLi connection details
    $servername = "localhost";
    $username = "root";  // Default username for XAMPP
    $password = "";      // Default password for XAMPP is empty
    $dbname = "sales"; // Your database name

    // Create a connection to MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form values
        $name = $_POST['name'];
        $month = $_POST['month'];
        $sales = $_POST['sales'];

        // Calculate commission based on sales amount
        if ($sales >= 1 && $sales <= 2000) {
            $commission_rate = 0.03;
        } elseif ($sales >= 2001 && $sales <= 5000) {
            $commission_rate = 0.04;
        } elseif ($sales >= 5001 && $sales <= 7000) {
            $commission_rate = 0.07;
        } else {
            $commission_rate = 0.10;
        }

        // Calculate commission
        $commission = $sales * $commission_rate;

        // Insert data into the sales_commission table in MySQL
        $sql = "INSERT INTO sales_commission (name, month, sales_amount, commission)
                VALUES ('$name', '$month', $sales, $commission)";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='container'>";
            echo "<h2>Sales Commission</h2>";
            echo "Name: " . htmlspecialchars($name) . "<br>";
            echo "Month: " . htmlspecialchars($month) . "<br>";
            echo "Sales Amount: RM " . number_format($sales, 2) . "<br>";
            echo "Sales Commission: RM " . number_format($commission, 2) . "<br>";
            echo "</div>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the MySQL connection
    $conn->close();
    ?>
</body>
</html>
