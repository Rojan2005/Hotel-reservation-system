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

// --- TO DO: Fetch the user's bookings from the database ---
// $bookings_result = $conn->query("SELECT * FROM Bookings WHERE user_id = $user_id");
// $bookings = $bookings_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
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
            max-width: 800px; /* Adjust width as needed for bookings table */
        }

        h2 {
            font-size: 2.2rem;
            color: #f5a623;
            font-weight: 600;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .booking-list {
            text-align: left;
            margin-top: 20px;
        }

        .booking-item {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 5px solid #f5a623;
        }

        .booking-item h3 {
            color: #f5a623;
            margin-bottom: 10px;
        }

        .booking-item p {
            color: #ddd;
            margin-bottom: 5px;
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
        <h2>My Bookings</h2>

        <div class="booking-list">
            <?php
            // --- TO DO: Loop through the fetched bookings and display them ---
            // if (isset($bookings) && !empty($bookings)):
            //     foreach ($bookings as $booking):
            //         echo "<div class='booking-item'>";
            //         echo "<h3>Booking ID: " . htmlspecialchars($booking['booking_id']) . "</h3>";
            //         echo "<p>Room ID: " . htmlspecialchars($booking['room_id']) . "</p>";
            //         echo "<p>Check-in Date: " . htmlspecialchars($booking['checkin_date']) . "</p>";
            //         echo "<p>Check-out Date: " . htmlspecialchars($booking['checkout_date']) . "</p>";
            //         echo "<p>Number of Guests: " . htmlspecialchars($booking['guests']) . "</p>";
            //         // Add more details as needed
            //         echo "</div>";
            //     endforeach;
            // else:
            //     echo "<p>No bookings found.</p>";
            // endif;
            ?>
            <p>--- Your bookings will be displayed here ---</p>
        </div>

        <div class="back-link">
            <p><a href="dashboard.php">Back to Dashboard</a></p>
        </div>
    </div>
</body>
</html>