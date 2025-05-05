<?php
include_once("connection.php");
include_once("function.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/";
    $file = $_FILES["profile_picture"];
    $filename = basename($file["name"]);
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("UPDATE Users SET profile_picture = ? WHERE user_id = ?");
        $stmt->bind_param("si", $filename, $user_id);
        $stmt->execute();

        echo "<p style='color:green;'>Profile picture updated!</p>";
    } else {
        echo "<p style='color:red;'>Upload failed. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Profile Picture</title>
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
            padding: 40px;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 2rem;
            color: #f5a623;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            color: #fff;
            margin-bottom: 10px;
            font-weight: 500;
        }

        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: #f8f8f8;
        }

        input[type="file"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #f5a623;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #f44336;
        }

        .message {
            margin-top: 10px;
            font-size: 14px;
            text-align: center;
        }

        .message.green {
            color: green;
        }

        .message.red {
            color: red;
        }

        .back-link {
            margin-top: 20px;
            text-align: center;
        }

        .back-link a {
            color: #fff;
            font-size: 1.1rem;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 1.5rem;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Upload Profile Picture</h2>

        <form method="POST" enctype="multipart/form-data">
            <label for="profile_picture">Choose a Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture" required>

            <button type="submit">Upload</button>
        </form>

        <?php if (isset($filename)) { ?>
            <div class="message green">Profile picture uploaded successfully!</div>
        <?php } elseif (isset($error)) { ?>
            <div class="message red"><?php echo $error; ?></div>
        <?php } ?>

        <div class="back-link">
            <p><a href="dashboard.php">Back to Dashboard</a></p>
        </div>
    </div>

</body>
</html>
