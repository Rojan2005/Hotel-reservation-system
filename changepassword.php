<?php
include_once("connection.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_pass = password_hash(trim($_POST['new_password']), PASSWORD_DEFAULT);
    $user_id = $_SESSION["user_id"];

    $stmt = $conn->prepare("UPDATE Users SET password = ? WHERE user_id = ?");
    $stmt->bind_param("si", $new_pass, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Password changed successfully.'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        $error = "Failed to update password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            text-align: center;
        }

        .container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(0, 0, 0, 0.3));
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            font-size: 2.2rem;
            color: #f5a623;
            font-weight: 600;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        label {
            display: block;
            color: #ddd;
            font-size: 1.1rem;
            margin-bottom: 10px;
            text-align: left;
        }

        input[type="password"] {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            border-radius: 50px;
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        input[type="password"]::placeholder {
            color: #ccc;
        }

        input[type="password"]:focus {
            background-color: rgba(255, 255, 255, 0.3);
            outline: none;
        }

        button {
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

        button:hover {
            background-color: #fff;
            color: #2575fc;
            transform: scale(1.05);
        }

        .error {
            color: #ff4d4d;
            margin-top: 15px;
            font-size: 1rem;
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

        /* Mobile-Friendly Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 1.8rem;
                margin-bottom: 20px;
            }

            label {
                font-size: 1rem;
            }

            input[type="password"] {
                padding: 12px;
                font-size: 0.9rem;
                margin-bottom: 15px;
            }

            button {
                padding: 12px 25px;
                font-size: 1rem;
            }

            .back-link {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Change Password</h2>

        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" required placeholder="Enter new password">

            <button type="submit">Update Password</button>
        </form>

        <div class="back-link">
            <p><a href="dashboard.php">Back to Dashboard</a></p>
        </div>
    </div>

</body>
</html>