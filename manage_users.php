<?php
include_once("connection.php");
include_once("function.php");

if (!isAdmin()) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE Users SET role = ? WHERE user_id = ?");
    $stmt->bind_param("si", $new_role, $user_id);
    $stmt->execute();

    $update_message = "User role updated successfully.";
}

$users = $conn->query("SELECT user_id, name, email, role FROM Users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom right, #ff7e5f, #feb47b);
            color: #333; /* Darker text for better contrast on textured backgrounds */
            padding: 40px;
            text-align: center;
        }

        h2 {
            margin-bottom: 30px;
            color: #fff;
            font-weight: bold;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            padding-bottom: 15px;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 3px;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            border-radius: 2px;
        }

        table {
            width: 85%;
            margin: 30px auto;
            border-collapse: separate; /* For rounded corners on individual cells */
            background-color: rgba(255, 255, 255, 0.85); /* Slightly transparent */
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        th, td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: rgba(255, 126, 95, 0.2); /* Soft orange for header */
            color: #fff;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }

        tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Arrange label and input side by side */
            gap: 10px;
            align-items: center;
        }

        form td {
            padding: 10px;
        }

        form td:first-child {
            text-align: right;
            font-weight: bold;
            color: #555;
        }

        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            background-color: #f9f9f9;
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.05);
        }

        button[type='submit'] {
            background: linear-gradient(to bottom, #8fbc8f, #6e8b6e); /* Soft green gradient */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1);
        }

        button[type='submit']:hover {
            transform: scale(1.05);
            box-shadow: 5px 5px 8px rgba(0, 0, 0, 0.2);
        }

        .update-message {
            background-color: #e0f2f7; /* Light blue */
            color: #00838f; /* Teal */
            padding: 15px;
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1);
        }

        .back-link {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            text-decoration: none;
            color: #fff;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            border-radius: 10px;
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .back-link:hover {
            transform: scale(1.05);
        }

        /* Subtle texture for the body (optional - you might need to include a pattern) */
        /* body {
            background-image: url('path/to/subtle-texture.png');
            background-repeat: repeat;
        } */

        /* Responsive adjustments */
        @media (max-width: 768px) {
            h2 {
                font-size: 2rem;
            }

            table {
                width: 95%;
                border-spacing: 5px; /* Adjust cell spacing */
            }

            th, td {
                padding: 10px 12px;
                font-size: 0.9rem;
            }

            form {
                grid-template-columns: 1fr; /* Stack label and input */
            }

            form td:first-child {
                text-align: left;
            }

            select, button[type='submit'], .back-link {
                font-size: 0.9rem;
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
    <h2>User Role Management</h2>

    <?php if (isset($update_message)): ?>
        <div class="update-message"><?= htmlspecialchars($update_message) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Change Role</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $users->fetch_assoc()): ?>
                <tr>
                    <form method="POST">
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td>
                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                            <label for="role_<?= $user['user_id'] ?>">Role:</label>
                            <select name="role" id="role_<?= $user['user_id'] ?>">
                                <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                            <button type="submit">Update</button>
                        </td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="back-link">Back to Dashboard</a>
</body>
</html>