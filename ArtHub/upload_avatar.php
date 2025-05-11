<?php
require 'config.php';

if (!isset($_SESSION['UserID'])) {
    die("Access denied");
}

if ($_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $new_filename = 'user_' . $_SESSION['UserID'] . '_' . time() . '.jpg';
    $target_path = "Media/Pfp/" . $new_filename;

    // Validate file size and type (optional)
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $file_extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

    if (!in_array(strtolower($file_extension), $allowed_extensions)) {
        die("Invalid file type. Only jpg, jpeg, and png are allowed.");
    }

    if ($_FILES['avatar']['size'] > 2 * 1024 * 1024) { // Max file size 2MB
        die("File size is too large. Max size is 2MB.");
    }

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_path)) {
        $stmt = $pdo->prepare("UPDATE Users SET 
            UserImagePath = ?,
            UserUpdateDate = NOW() 
            WHERE UserID = ?");
        $stmt->execute([$target_path, $_SESSION['UserID']]);
        
        header('Location: profile.php');
        exit();
    } else {
        die("Error uploading file.");
    }
} else {
    die("File upload error. Please try again.");
}
?>
