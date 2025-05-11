<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['UserName']);
    $password = $_POST['UserPassword'];

    $stmt = $pdo->prepare("SELECT * FROM Users WHERE UserName = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['UserPassword'])) {
        $_SESSION['UserID'] = $user['UserID'];
        $_SESSION['UserName'] = $user['UserName'];
        $_SESSION['UserImagePath'] = $user['UserImagePath'];
        $_SESSION['RoleID'] = $user['RoleID'];
        header('Location: profile.php'); //перенаправление в профиль
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="login-container">
    <img src="Media/Logo/ArthubLogo.png" alt="ArtHub Logo" class="logo">
    <h1>Login</h1>

    <form method="POST">
        <input type="text" name="UserName" placeholder="Username" required><br>
        <input type="password" name="UserPassword" placeholder="Password" required><br>

        <button type="submit" class="btn">Login</button>
    </form>

    <?php if (!empty($error)): ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>
</div>

</body>
</html>
