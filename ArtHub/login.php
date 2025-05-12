<?php
session_start();
require 'config.php';  // Подключаем файл для работы с базой данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['UserName']);
    $password = $_POST['UserPassword'];

    // Проверяем, что оба поля не пустые
    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        // Проверяем, существует ли пользователь с таким именем
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE UserName = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Если пользователь существует, проверяем правильность пароля
        if ($user && password_verify($password, $user['UserPassword'])) {
            // Если логин успешен, сохраняем данные в сессии
            $_SESSION['UserID'] = $user['UserID'];
            $_SESSION['UserName'] = $user['UserName'];
            $_SESSION['UserImagePath'] = $user['UserImagePath'];  // Путь к изображению профиля
            $_SESSION['RoleID'] = $user['RoleID'];  // Роль пользователя

            // Перенаправляем на главную страницу или другую страницу
            header('Location: ArtHub.php');
            exit();
        } else {
            // Если логин не успешен
            $error = 'Invalid username or password';
        }
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
    <p>Dont have a account? <a href="register.php">Register now</a></p>

    <?php if (!empty($error)): ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>
</div>

</body>
</html>
