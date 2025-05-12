<?php
session_start();
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['RoleID']) || $_SESSION['RoleID'] !== 'Admin') {
    header("Location: ArtHub.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = $_POST['password'];
        $avatar = $_POST['avatar'] ?? null;

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (UserName, UserEmail, UserPassword, RoleID, UserImagePath) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword, $role, $avatar]);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $avatar = $_POST['avatar'] ?? null;

        $stmt = $pdo->prepare("UPDATE users SET UserName = ?, UserEmail = ?, RoleID = ?, UserImagePath = ? WHERE UserID = ?");
        $stmt->execute([$username, $email, $role, $avatar, $id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE UserID = ?");
        $stmt->execute([$id]);
    }
}

$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - ArtHub</title>
    <link rel="stylesheet" href="MainStyle.css">

    <!-- Croppie CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css " />

    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            text-align: center;
        }

        .admin-header {
            position: relative;
            text-align: center;
            padding: 20px 0;
        }

        .back-button {
            position: absolute;
            left: 20px;
            top: 60px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 36px;
            padding: 0 15px;
            background: #12a73e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            white-space: nowrap;
            font-size: 14px;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            text-align: center;
        }

        .user-table th, .user-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .user-table th {
            background-color: #f8f9fa;
        }

        .user-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .form-container {
            margin: 30px auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
            width: 100%;
            max-width: 400px;
        }

        .action-button,
        .delete-button {
            display: inline-block;
            padding: 8px 14px;
            margin: 4px;
            font-size: 14px;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        .action-button {
            background-color: #12a73e;
        }

        .action-button:hover {
            background-color: rgb(21, 226, 83);
        }

        .delete-button {
            background-color: #dc3545 !important;
        }

        .delete-button:hover {
            background-color: #a71d2a !important;
        }

        .modal-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            z-index: 1000;
            min-width: 300px;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .cancel-button {
            display: inline-block;
            padding: 8px 14px;
            margin: 4px;
            font-size: 14px;
            color: #fff;
            background-color: #555;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        .cancel-button:hover {
            background-color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .add-user-form button,
        .edit-user-form button {
            padding: 10px 18px;
            font-size: 14px;
            margin-top: 15px;
        }

        h3.modal-title {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 20px;
            color: #333;
        }

        .upload-demo {
            margin: 10px auto;
        }

        .croppie-container {
            margin: 10px auto;
        }
    </style>
</head>
<body>

<header class="admin-header">
    <a href="ArtHub.php" class="back-button">← Back</a>
</header>

<div class="container">

    <!-- Таблица пользователей -->
    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registration Date</th>
                <th>Avatar</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['UserID']) ?></td>
                <td><?= htmlspecialchars($user['UserName']) ?></td>
                <td><?= htmlspecialchars($user['UserEmail']) ?></td>
                <td><?= htmlspecialchars($user['RoleID']) ?></td>
                <td><?= htmlspecialchars($user['UserCreationDate']) ?></td>
                <td>
                    <?php if ($user['UserImagePath']): ?>
                        <img src="<?= htmlspecialchars($user['UserImagePath']) ?>" alt="Avatar" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                    <?php else: ?>
                        No avatar
                    <?php endif; ?>
                </td>
                <td>
                    <button class="action-button" onclick="openUpdateForm('<?= $user['UserID'] ?>')">Edit</button>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['UserID']) ?>">
                        <button type="submit" name="delete" class="delete-button" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Форма добавления нового пользователя -->
    <div class="form-container add-user-form">
        <h2>Add New User</h2>
        <form method="POST">
            <label for="username">Username:</label><br>
            <input type="text" name="username" required><br>
            <label for="email">Email:</label><br>
            <input type="email" name="email"><br>
            <label for="role">Role:</label><br>
            <input type="text" name="role" required><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password" required><br>

            <!-- Загрузка аватара -->
            <label for="avatar">Avatar:</label><br>
            <input type="file" id="upload-avatar" accept="image/*"><br>
            <div class="upload-demo">
                <div id="upload-croppie"></div>
            </div>
            <input type="hidden" name="avatar" id="avatar-data">

            <button type="submit" name="create">Create</button>
        </form>
    </div>

    <!-- Модальное окно для редактирования -->
    <div id="updateModal" class="modal-form" style="display:none;">
        <h3 class="modal-title">Edit User</h3>
        <form id="updateFormContent" method="POST" class="edit-user-form">
            <input type="hidden" name="id" id="edit-id">
            <label for="username">Username:</label><br>
            <input type="text" name="username" id="edit-username" required><br>
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="edit-email"><br>
            <label for="role">Role:</label><br>
            <input type="text" name="role" id="edit-role" required><br>
            <button type="submit" name="update">Update</button>
            <button type="button" class="cancel-button" onclick="closeUpdateForm()">Cancel</button>
        </form>
    </div>
    <div class="overlay" id="overlay" onclick="closeUpdateForm()"></div>

</div>

<!-- Croppie JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js "></script>

<script>
    var $uploadCrop;

    window.onload = function () {
        $uploadCrop = new Croppie(document.getElementById('upload-croppie'), {
            viewport: { width: 120, height: 120, type: 'circle' },
            boundary: { width: 150, height: 150 },
            showZoomer: true
        });

        document.getElementById('upload-avatar').addEventListener('change', function () {
            const reader = new FileReader();
            reader.onload = function (e) {
                $uploadCrop.bind({ url: e.target.result });
            };
            reader.readAsDataURL(this.files[0]);
        });

        $uploadCrop.on('update.croppie', function () {
            $uploadCrop.result('base64').then(function (base64) {
                document.getElementById('avatar-data').value = base64;
            });
        });
    };

    function openUpdateForm(userId) {
        const user = <?= json_encode(array_column($users, null, 'UserID')) ?>;
        const data = user[userId];
        if (!data) return;

        document.getElementById('edit-id').value = data.UserID;
        document.getElementById('edit-username').value = data.UserName;
        document.getElementById('edit-email').value = data.UserEmail;
        document.getElementById('edit-role').value = data.RoleID;

        document.getElementById('updateModal').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function closeUpdateForm() {
        document.getElementById('updateModal').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
</script>

</body>
</html>