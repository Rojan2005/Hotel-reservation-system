<?php
include_once("connection.php");

// Ensure the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$result = $conn->query("SELECT name FROM Users WHERE user_id = $user_id");
$user = $result->fetch_assoc();

// Handle form submission (you can add your logic here later)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $guests = $_POST['guests'];

    // For now, just display the submitted data
    echo "<div class='container'>";
    echo "<h2>Booking Request</h2>";
    echo "<p>Check-in Date: " . htmlspecialchars($checkin_date) . "</p>";
    echo "<p>Check-out Date: " . htmlspecialchars($checkout_date) . "</p>";
    echo "<p>Number of Guests: " . htmlspecialchars($guests) . "</p>";
    echo "<p><a href='dashboard.php' class='back-link'>Back to Dashboard</a></p>";
    echo "</div>";
    exit(); // Stop further page rendering for now
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Room</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <style>
        /* Styles copied from dashboard.php */
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc); /* Gradient from purple to blue */
            color: #fff;
            display: flex;
            height: 100vh;
            text-align: center;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
        }

        .container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(0, 0, 0, 0.3));
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px; /* Adjust as needed for the booking form */
        }

        h2 {
            font-size: 2.2rem;
            color: #f5a623;
            font-weight: 600;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            color: #ddd;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 50px;
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        input[type="date"]::placeholder,
        input[type="number"]::placeholder {
            color: #ccc;
        }

        input[type="date"]:focus,
        input[type="number"]:focus {
            background-color: rgba(255, 255, 255, 0.3);
            outline: none;
        }

        button[type="submit"] {
            display: inline-block;
            padding: 15px 30px;
            background-color: #f5a623;
            color: #fff;
            font-size: 1.1rem;
            border-radius: 50px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            background-color: #fff;
            color: #2575fc;
            transform: scale(1.05);
        }

        .back-link {
            margin-top: 30px;
            font-size: 1rem;
        }

        .back-link a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #f5a623;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book a Room</h2>
        <form method="POST">
            <div class="form-group">
                <label for="checkin_date">Check-in Date:</label>
                <input type="date" id="checkin_date" name="checkin_date" required>
            </div>
            <div class="form-group">
                <label for="checkout_date">Check-out Date:</label>
                <input type="date" id="checkout_date" name="checkout_date" required>
            </div>
            <div class="form-group">
                <label for="guests">Number of Guests:</label>
                <input type="number" id="guests" name="guests" min="1" value="1" required>
            </div>
            <button type="submit">Check Availability</button>
        </form>
        <div class="back-link">
            <p><a href="dashboard.php">Back to Dashboard</a></p>
        </div>
    </div>
</body>
</html>