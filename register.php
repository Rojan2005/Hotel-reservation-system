<?php
include_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $phone = htmlspecialchars(trim($_POST['phone']));

    if (!empty($name) && !empty($email) && !empty($_POST['password'])) {
        $stmt = $conn->prepare("INSERT INTO Users (name, email, password, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $phone);
        
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Please fill in all required fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
            background-color: #e6f7ff; /* Soft blue background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .register-container {
            background: linear-gradient(145deg, #ffffff, #f0f4f7);
            padding: 40px 35px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .register-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
        }

        h2 {
            color: #1a5276;
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        label {
            display: block;
            color: #7f8c8d;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 15px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.4);
            outline: none;
        }

        button {
            width: 100%;
            padding: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 10px;
        }

        .back-to-login {
            margin-top: 25px;
            font-size: 15px;
            color: #7f8c8d;
        }

        .back-to-login a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-to-login a:hover {
            color: #2980b9;
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .register-container {
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

    <div class="register-container">
        <h2>Create Your Account</h2>

        <?php if (isset($error)) { ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Enter your full name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Create a password" required>

            <label for="phone">Phone (optional):</label>
            <input type="text" name="phone" id="phone" placeholder="Enter your phone number (optional)">

            <button type="submit">Register</button>
        </form>

        <div class="back-to-login">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>

</body>
</html>
