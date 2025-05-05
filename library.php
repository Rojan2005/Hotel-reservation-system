<?php
include_once("connection.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$result = $conn->query("SELECT name, profile_picture FROM Users WHERE user_id = $user_id");
$user = $result->fetch_assoc();
$profile_picture = $user['profile_picture'] ? 'uploads/' . $user['profile_picture'] : 'default-avatar.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <style>
        /* General Reset */
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }

        /* Profile Section */
        .profile {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            width: 320px;
            margin: 0 auto;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile:hover {
            transform: translateY(-10px);
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
        }

        /* Navigation Links - Organized in a Grid */
        nav {
            margin-top: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        nav a {
            text-decoration: none;
            color: #fff;
            font-size: 1.1rem;
            padding: 15px 30px;
            border-radius: 50px;
            background-color: #f5a623;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        nav a:hover {
            background-color: #fff;
            color: #2575fc;
            transform: scale(1.1);
        }

        /* Hidden Class to hide buttons */
        .hidden {
            display: none;
        }

        /* Content Section - Library Content */
        .content-container {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            margin-top: 30px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .content-container:hover {
            transform: translateY(-10px);
        }

        .content-container h3 {
            font-size: 2rem;
            color: #f5a623;
            margin-bottom: 20px;
        }

        .content-container p {
            font-size: 1.2rem;
            color: #ddd;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .colorful-section {
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 15px;
        }

        /* Footer Section */
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile {
                width: 100%;
                max-width: 280px;
                padding: 20px;
            }

            nav a {
                font-size: 1rem;
                padding: 12px 25px;
            }

            .content-container {
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
            <img src="<?php echo $profile_picture; ?>" alt="Profile Picture"><br>
            <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
        </div>

        <!-- Navigation Links -->
        <nav id="nav-links">
            <a href="library.php" onclick="hideButtons(this)">Library</a>
            <a href="changepassword.php" onclick="hideButtons(this)">Change Password</a>
            <a href="update_profile.php" onclick="hideButtons(this)">Update Profile</a>
            <a href="logout.php" onclick="hideButtons(this)">Logout</a>
        </nav>

        <!-- Content Section -->
        <div class="content-container">
            <h3>Welcome to the Library</h3>
            <p>This is a placeholder for your library content. You can fill it with books, articles, or other resources. You can also organize your materials by category and manage their access.</p>
            
            <div class="colorful-section">
                <h3>Explore Categories</h3>
                <p>Browse through our extensive collection of books and resources. We have materials from various categories including fiction, non-fiction, technology, business, and much more.</p>
            </div>

            <a href="dashboard.php" class="btn">Back to Dashboard</a>
        </div>

        <!-- Footer -->
        <footer>
            <p>&copy; 2025 Hotel Reservation System. <a href="privacy.php">Privacy Policy</a> | <a href="terms.php">Terms & Conditions</a></p>
        </footer>
    </div>

    <script>
        function hideButtons(clickedLink) {
            // Hide all links in the navigation
            const navLinks = document.querySelectorAll('#nav-links a');
            navLinks.forEach(link => {
                if (link !== clickedLink) {
                    link.classList.add('hidden');  // Hide other links
                }
            });

            // Optionally, add a way to show the buttons again (e.g., by adding a back button)
            const backButton = document.createElement('a');
            backButton.href = "#";
            backButton.textContent = "Back to Dashboard";
            backButton.classList.add('btn', 'back-button');
            backButton.onclick = function() {
                navLinks.forEach(link => link.classList.remove('hidden'));  // Show all links again
                backButton.remove();  // Remove the back button
            };

            document.querySelector('.content-container').appendChild(backButton); // Append back button
        }
    </script>

</body>
</html>
