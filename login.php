<?php
session_start();
include_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $error = '';

    if (!empty($email) && !empty($password)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT user_id, name, password, role FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email); // 's' stands for string (email)
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Check if the password matches
            if (password_verify($password, $row['password'])) {
                // Regenerate session ID for security
                session_regenerate_id();

                // Store user session data
                $_SESSION["user_id"] = $row['user_id'];
                $_SESSION["name"] = $row['name'];
                $_SESSION["role"] = $row['role'];

                // Redirect to dashboard after successful login
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No user found with that email address.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(45deg, #6a11cb, #2575fc); /* Same gradient background as dashboard */
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .login-container {
            background: rgba(0, 0, 0, 0.4); /* Transparent background with some black overlay */
            padding: 40px 35px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
            text-align: center;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.25);
        }

        h2 {
            color: #f5a623; /* Same accent color as dashboard */
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        label {
            display: block;
            color: #ccc;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 15px;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            background-color: #2c3e50; /* Darker background for inputs */
            color: #fff; /* White text */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #f5a623; /* Highlight border on focus */
            box-shadow: 0 0 8px rgba(245, 166, 35, 0.4);
            outline: none;
        }

        button {
            width: 100%;
            padding: 16px;
            background-color: #f5a623; /* Same button color as dashboard */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #2575fc; /* Button hover effect */
            transform: translateY(-2px);
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 10px;
        }

        .register-link {
            margin-top: 25px;
            font-size: 15px;
            color: #ccc;
        }

        .register-link a {
            color: #f5a623;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #fff;
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                padding: 35px 30px;
            }

            h2 {
                font-size: 28px;
            }

            button {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>

        <!-- Display error message if there's an issue -->
        <?php if (!empty($error)) { ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required aria-label="Email address">

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required aria-label="Password">

            <button type="submit">Login</button>
        </form>

        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>

</body>
</html>
