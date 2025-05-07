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

// Retrieve booking details from the previous page (assuming POST method)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['room_id'], $_POST['checkin_date'], $_POST['checkout_date'], $_POST['guests'])) {
        $room_id = $_POST['room_id'];
        $checkin_date = $_POST['checkin_date'];
        $checkout_date = $_POST['checkout_date'];
        $guests = $_POST['guests'];

        // --- TO DO: Fetch room details from the database based on $room_id ---
        // $room_details_result = $conn->query("SELECT * FROM Rooms WHERE room_id = $room_id");
        // $room = $room_details_result->fetch_assoc();

        if (!$room_id || !$checkin_date || !$checkout_date || !$guests) {
            // Handle missing data
            echo "<p style='color: red;'>Error: Missing booking details.</p>";
            exit();
        }
    } else {
        // Redirect back to the booking page if data is missing
        header("Location: book.php"); // Assuming you renamed book_room.php to book.php
        exit();
    }
} else {
    // If accessed directly without POST data
    header("Location: book.php"); // Redirect to booking page
    exit();
}

// Handle the final booking confirmation
if (isset($_POST['confirm_booking'])) {
    // Sanitize and validate the data again (important!)
    $confirmed_room_id = $_POST['confirmed_room_id'];
    $confirmed_checkin_date = $_POST['confirmed_checkin_date'];
    $confirmed_checkout_date = $_POST['confirmed_checkout_date'];
    $confirmed_guests = $_POST['confirmed_guests'];
    $booking_user_id = $_SESSION["user_id"];
    $booking_date = date("Y-m-d H:i:s"); // Current timestamp for booking

    // --- TO DO: Insert the booking details into your 'Bookings' table ---
    $sql_insert = "INSERT INTO Bookings (user_id, room_id, checkin_date, checkout_date, guests, booking_date)
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iisss", $booking_user_id, $confirmed_room_id, $confirmed_checkin_date, $confirmed_checkout_date, $confirmed_guests, $booking_date);

    if ($stmt_insert->execute()) {
        // Booking successful, redirect to a confirmation page or display a success message
        header("Location: booking_confirmation.php");
        exit();
    } else {
        // Error inserting booking
        echo "<p style='color: red;'>Error confirming booking: " . $stmt_insert->error . "</p>";
    }
    $stmt_insert->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <style>
        /* Styles copied and modified from dashboard.php */
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc); /* Gradient from purple to blue */
            color: #eee; /* Slightly darker text for better contrast */
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
            max-width: 600px; /* Adjust as needed */
        }

        h2 {
            font-size: 2.2rem;
            color: #f5a623;
            font-weight: 600;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .booking-summary {
            text-align: left;
            margin-bottom: 20px;
        }

        .booking-summary p {
            color: #ddd;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .booking-summary strong {
            color: #f5a623;
        }

        .confirm-form button[type="submit"] {
            display: inline-block;
            padding: 15px 30px;
            background-color: #28a745; /* Green for confirm */
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

        .confirm-form button[type="submit"]:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .back-link {
            margin-top: 30px;
            font-size: 1rem;
        }

        .back-link a {
            color: #eee;
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
        <h2>Confirm Your Booking</h2>

        <div class="booking-summary">
            <?php if (isset($room_id, $checkin_date, $checkout_date, $guests)): ?>
                <p><strong>Room ID:</strong> <?php echo htmlspecialchars($room_id); ?></p>
                <p><strong>Check-in Date:</strong> <?php echo htmlspecialchars($checkin_date); ?></p>
                <p><strong>Check-out Date:</strong> <?php echo htmlspecialchars($checkout_date); ?></p>
                <p><strong>Number of Guests:</strong> <?php echo htmlspecialchars($guests); ?></p>
                <?php
                // --- TO DO: Display more room details if fetched ---
                // if (isset($room)):
                //     echo "<p><strong>Room Type:</strong> " . htmlspecialchars($room['room_type']) . "</p>";
                //     echo "<p><strong>Price per Night:</strong> $" . htmlspecialchars($room['price']) . "</p>";
                //     // Calculate total price if needed
                // endif;
                ?>
            <?php else: ?>
                <p style="color: red;">No booking details found.</p>
            <?php endif; ?>
        </div>

        <?php if (isset($room_id, $checkin_date, $checkout_date, $guests)): ?>
        <form method="POST" class="confirm-form">
            <input type="hidden" name="confirmed_room_id" value="<?php echo htmlspecialchars($room_id); ?>">
            <input type="hidden" name="confirmed_checkin_date" value="<?php echo htmlspecialchars($checkin_date); ?>">
            <input type="hidden" name="confirmed_checkout_date" value="<?php echo htmlspecialchars($checkout_date); ?>">
            <input type="hidden" name="confirmed_guests" value="<?php echo htmlspecialchars($guests); ?>">
            <button type="submit" name="confirm_booking">Confirm Booking</button>
        </form>
        <?php endif; ?>

        <div class="back-link">
            <p><a href="book.php">Back to Booking</a></p>
        </div>
    </div>
</body>
</html>