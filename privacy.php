<?php include_once("connection.php"); include_once("function.php"); 

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
    <title>Privacy Policy</title>
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
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding: 40px;
            background-size: cover;
            background-position: center;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
            text-align: left;
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
            margin-bottom: 30px;
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

        /* Title Section */
        .title-section {
            margin-top: 40px;
            text-align: center;
        }

        .title-section h1 {
            font-size: 3rem;
            color: #f5a623;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .title-section p {
            font-size: 1.2rem;
            color: #ddd;
            margin-top: 15px;
            line-height: 1.8;
        }

        .title-section .btn {
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

        .title-section .btn:hover {
            background-color: #2575fc;
        }

        /* Privacy Policy Content */
        .privacy-content {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        .privacy-content h3 {
            font-size: 2rem;
            color: #f5a623;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .privacy-content p {
            font-size: 1rem;
            color: #ddd;
            line-height: 1.8;
            margin-top: 15px;
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

            .privacy-content {
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
        <!-- Profile Section -->
        <div class="profile">
            <?php
            $result = $conn->query("SELECT name, profile_picture FROM Users WHERE user_id = $user_id");
            $user = $result->fetch_assoc();
            $profile_picture = $user['profile_picture'] ? 'uploads/' . $user['profile_picture'] : 'default-avatar.jpg';
            echo "<img src='" . $profile_picture . "' alt='Profile Picture'><br>";
            ?>
            <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
        </div>

        <!-- Privacy Policy Title Section -->
        <div class="title-section">
            <h1>Privacy Policy</h1>
            <p>We value your privacy and are committed to protecting your personal information.</p>
        </div>

        <!-- Privacy Policy Content -->
        <div class="privacy-content">
            <h3>Introduction</h3>
            <p>Your privacy is important to us. This privacy policy explains what personal information we collect, how we use it, and your choices regarding your information.</p>

            <h3>Information We Collect</h3>
            <p>We collect personal information that you provide to us when you register for an account, update your profile, or use our services. This information may include your name, email address, profile picture, and other relevant details.</p>

            <h3>How We Use Your Information</h3>
            <p>Your personal information is used to provide you with our services, manage your account, and improve your experience. We may also use your information to communicate with you about updates, promotions, and other related activities.</p>

            <h3>Your Choices</h3>
            <p>You can access, update, or delete your personal information at any time through your account settings. If you wish to opt-out of marketing communications, you can do so by following the instructions in the emails you receive or by contacting us directly.</p>

            <h3>Data Security</h3>
            <p>We take appropriate measures to protect your personal information from unauthorized access, alteration, or destruction. However, no method of transmission over the internet or method of electronic storage is 100% secure.</p>

            <h3>Changes to This Policy</h3>
            <p>We may update this privacy policy from time to time. Any changes will be posted on this page with an updated date. Please review this policy regularly to stay informed about how we are protecting your information.</p>

            <h3>Contact Us</h3>
            <p>If you have any questions or concerns about this privacy policy, please contact us at support@hotelreservation.com.</p>
        </div>

        <!-- Footer -->
        <footer>
            <p>&copy; 2025 Hotel Reservation System. <a href="terms.php">Terms & Conditions</a></p>
        </footer>
    </div>
</body>
</html>
