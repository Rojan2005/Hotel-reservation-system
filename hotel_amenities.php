<?php
include_once("connection.php");

// Ensure the user is logged in (optional for a public amenities page)
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
} else {
    $user_id = $_SESSION["user_id"];
    $result = $conn->query("SELECT name FROM Users WHERE user_id = $user_id");
    $user = $result->fetch_assoc();
}

// --- TO DO: Fetch hotel amenities from the database (optional) ---
// $amenities_result = $conn->query("SELECT * FROM Amenities");
// $amenities = $amenities_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Amenities</title>
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
            max-width: 800px; /* Adjust width as needed for amenities list */
        }

        h2 {
            font-size: 2.2rem;
            color: #f5a623;
            font-weight: 600;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .amenities-list {
            text-align: left;
            margin-top: 20px;
        }

        .amenity-item {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 5px solid #2575fc; /* Different accent color */
        }

        .amenity-item h3 {
            color: #2575fc; /* Different accent color */
            margin-bottom: 10px;
        }

        .amenity-item p {
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
        <h2>Hotel Amenities</h2>

        <div class="amenities-list">
            <?php
            // --- TO DO: Loop through the fetched amenities and display them ---
            // if (isset($amenities) && !empty($amenities)):
            //     foreach ($amenities as $amenity):
            //         echo "<div class='amenity-item'>";
            //         echo "<h3>" . htmlspecialchars($amenity['name']) . "</h3>";
            //         echo "<p>" . htmlspecialchars($amenity['description']) . "</p>";
            //         // Add more details or images if available
            //         echo "</div>";
            //     endforeach;
            // else:
            //     echo "<p>No amenities listed.</p>";
            // endif;
            ?>
            <div class="amenity-item">
                <h3>Swimming Pool</h3>
                <p>Enjoy our refreshing outdoor swimming pool.</p>
            </div>
            <div class="amenity-item">
                <h3>Free Wi-Fi</h3>
                <p>Stay connected with our complimentary high-speed Wi-Fi.</p>
            </div>
            <div class="amenity-item">
                <h3>Restaurant</h3>
                <p>Savor delicious meals at our on-site restaurant.</p>
            </div>
            </div>

        <div class="back-link">
            <p><a href="dashboard.php">Back to Dashboard</a></p>
        </div>
    </div>
</body>
</html>