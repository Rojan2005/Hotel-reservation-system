<?php
include_once("connection.php");
include_once("function.php");

// Ensure the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$result = $conn->query("SELECT name FROM Users WHERE user_id = $user_id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <style>
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
        }

        /* Container for both navigation and content */
        .container {
            display: flex;
            width: 100%;
        }

        /* Sidebar for navigation links */
        .sidebar {
            background-color: #2c3e50;
            width: 250px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .sidebar a {
            text-decoration: none;
            color: #fff;
            font-size: 1.1rem;
            padding: 15px 30px;
            margin: 10px 0;
            border-radius: 50px;
            background-color: #f5a623;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #fff;
            color: #2575fc;
            transform: scale(1.1);
        }

        /* Main Content Area */
        .main-content {
            flex-grow: 1;
            padding: 30px;
            text-align: center;
        }

        /* Profile Section */
        .profile {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(0, 0, 0, 0.3));
            border-radius: 15px;
            padding: 30px;
            width: 320px;
            margin: 0 auto;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }

        .profile:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .profile img {
            border-radius: 50%;
            width: 130px;
            height: 130px;
            object-fit: cover;
            margin-bottom: 20px;
            border: 3px solid #fff;
        }

        .profile h2 {
            font-size: 1.6rem;
            color: #f5a623;
            font-weight: 600;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .profile .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #f5a623;
            color: #fff;
            font-size: 1rem;
            border-radius: 50px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .profile .btn:hover {
            background-color: #2575fc;
        }

        /* Info Panel */
        .info-panel {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            margin-top: 40px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.3));
        }

        .info-panel:hover {
            transform: translateY(-10px);
        }

        .info-panel h1 {
            font-size: 2.8rem;
            color: #f5a623;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .info-panel h3 {
            font-size: 1.8rem;
            color: #fff;
            margin-bottom: 10px;
        }

        .info-panel p {
            font-size: 1rem;
            color: #ddd;
            line-height: 1.8;
            margin-top: 15px;
        }

        .info-panel .get-started-btn {
            margin-top: 20px;
            padding: 15px 30px;
            background-color: #2575fc;
            color: #fff;
            font-size: 1.2rem;
            border-radius: 50px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .info-panel .get-started-btn:hover {
            background-color: #f5a623;
        }

        /* Footer */
        footer {
            margin-top: 60px;
            font-size: 1rem;
            color: #fff;
        }

        footer a {
            color: #fff;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
            color: #f5a623;
        }

        /* Mobile-Friendly Design */
        @media (max-width: 768px) {
            .profile {
                width: 100%;
                max-width: 280px;
                padding: 20px;
            }

            .sidebar {
                width: 100%;
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                padding: 10px;
            }

            .sidebar a {
                font-size: 1rem;
                padding: 10px 20px;
            }

            .main-content {
                padding: 20px;
            }

            footer {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar for Navigation Links -->
        <div class="sidebar">
            <a href="library.php">Library</a>
            <?php if (isAdmin()): ?>
                <a href="manage_users.php">Manage Users</a>
            <?php endif; ?>
            <a href="changepassword.php">Change Password</a>
            <a href="update_profile.php">Update Profile</a>
            <a href="logout.php">Logout</a>
        </div>

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Profile Section -->
            <div class="profile">
                <?php
                $result = $conn->query("SELECT name, profile_picture FROM Users WHERE user_id = $user_id");
                $user = $result->fetch_assoc();
                $profile_picture = $user['profile_picture'] ? 'uploads/' . htmlspecialchars($user['profile_picture']) : 'default-avatar.jpg';
                echo "<img src='" . $profile_picture . "' alt='Profile Picture'><br>";
                ?>
                <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
                <a href="update_profile.php" class="btn">View Profile</a>
            </div>

            <!-- Info Panel -->
            <div class="info-panel">
                <h1>Hotel Reservation System</h1>
                <h3>Welcome Panel</h3>
                <p>This dashboard lets you manage your bookings, access the library, and update your account settings. Explore the system using the navigation links on the left.</p>
                <a href="library.php" class="get-started-btn">Get Started</a>
            </div>

            <!-- Footer -->
            <footer>
                <p>&copy; 2025 Hotel Reservation System. <a href="privacy.php">Privacy Policy</a> | <a href="terms.php">Terms & Conditions</a></p>
            </footer>
        </div>
    </div>
</body>
</html>
