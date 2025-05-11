<?php
session_start();
require 'config.php';

$userLoggedIn = isset($_SESSION['UserID']); // Проверяем, залогинен ли пользователь

if ($userLoggedIn) {
    // Если пользователь авторизован, получаем его данные
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE UserID = ?");
    $stmt->execute([$_SESSION['UserID']]);
    $user = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="profile-container">
        <?php if ($userLoggedIn): ?>
            <h1>Welcome, <?php echo htmlspecialchars($user['UserName']); ?>!</h1>
            <img src="<?php echo htmlspecialchars($user['UserImagePath']); ?>" alt="Profile Picture" width="150">
            <p>Email: <?php echo htmlspecialchars($user['UserEmail']); ?></p>
            <p>Role: <?php echo htmlspecialchars($user['RoleID']); ?></p>
            <a href="logout.php" class="btn">Logout</a>
        <?php else: ?>
            <h1>Welcome to Your Profile</h1>
            <p>Would you like to log in or register?</p>
            <div class="options">
                <a href="login.php" class="btn">Login</a>
                <a href="register.php" class="btn">Register</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
