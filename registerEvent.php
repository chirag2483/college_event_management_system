<?php
// Include database connection
include_once 'classes/db1.php';

// Get the event ID from the URL
if(isset($_GET['id'])) {
    $event_id = $_GET['id'];
} else {
    // Redirect or display an error if the event ID is not provided
    header("Location: error_page.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (isset($_POST['usn'])) {
        $usn = $_POST['usn'];
        
        // Prepare and execute SQL statement to insert registration
        $stmt = $conn->prepare("INSERT INTO registered (usn, event_id) VALUES (?, ?)");
        $stmt->bind_param("si", $usn, $event_id);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Successfully Registered to Event!');
                    window.location.href='index.php';
                    </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close statement
        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            text-align: center;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register for an Event</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $event_id; ?>">
        <label for="usn" style="font-weight: bold; font-size: 16px;">Enter your USN:</label><br>
            <input type="text" id="usn" name="usn" placeholder="USN"><br>
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
