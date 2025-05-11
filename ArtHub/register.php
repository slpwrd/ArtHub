<?php
session_start();
require 'config.php';  // Подключаем файл для работы с базой данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['UserName']);
    $password = $_POST['UserPassword'];
    $croppedImage = $_POST['croppedImage']; // Получаем обрезанное изображение в base64

    if (empty($username) || empty($password) || empty($croppedImage)) {
        $error = 'Please fill in all fields';
    } else {
        // Декодируем base64 в изображение и сохраняем
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $croppedImage));
        $imagePath = 'uploads/' . uniqid() . '.png';
        file_put_contents($imagePath, $imageData);

        // Хэшируем пароль
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Записываем в базу
        $stmt = $pdo->prepare("INSERT INTO Users (UserName, UserPassword, UserImagePath) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashedPassword, $imagePath]);

        // Перенаправляем на страницу входа
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
</head>
<body>

<div class="login-container">
    <img src="Media/Logo/ArthubLogo.png" alt="ArtHub Logo" class="logo">
    <h1>Register</h1>

    <form method="POST">
        <input type="text" name="UserName" placeholder="Username" required><br>
        <input type="password" name="UserPassword" placeholder="Password" required><br>

        <label for="ProfileImage">Upload Profile Picture:</label>
        <input type="file" id="ProfileImage" accept="image/*" required><br>

        <div id="croppie-container"></div>

        <input type="hidden" name="croppedImage" id="croppedImage">

        <button type="submit" class="btn">Register</button>
    </form>

    <?php if (!empty($error)): ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script>
    var croppieInstance = null;
    var imageInput = document.getElementById('ProfileImage');
    var croppedImageInput = document.getElementById('croppedImage');

    imageInput.addEventListener('change', function (event) {
        var file = event.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                if (croppieInstance) {
                    croppieInstance.destroy();
                }

                var container = document.getElementById('croppie-container');
                container.innerHTML = '';

                croppieInstance = new Croppie(container, {
                    viewport: { width: 200, height: 200, type: 'circle' },
                    boundary: { width: 300, height: 300 },
                    showZoomer: true
                });

                croppieInstance.bind({ url: e.target.result });
            };

            reader.readAsDataURL(file);
        }
    });

    document.querySelector('form').addEventListener('submit', function (event) {
        event.preventDefault();
        if (croppieInstance) {
            croppieInstance.result({ type: 'base64', size: 'viewport' }).then(function (base64) {
                croppedImageInput.value = base64;
                event.target.submit(); // Отправляем форму после получения изображения
            });
        } else {
            event.target.submit();
        }
    });
</script>

</body>
</html>
