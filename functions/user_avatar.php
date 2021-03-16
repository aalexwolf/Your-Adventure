<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$target_dir = "../img/avatars/";
$target_file = $target_dir . $_SESSION['username'] . '.jpg';

$uploadOk = 1;

$uploaded_file = basename($_FILES["fileToUpload"]["name"]);

$imageFileType = strtolower(pathinfo($uploaded_file, PATHINFO_EXTENSION));

$err = '';

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $err .= "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $err .= "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
/*
if (file_exists($target_file)) {
    $err .= "Sorry, file already exists.";
    $uploadOk = 0;
}
*/

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $err .= "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg") {
    $err .= "Sorry, only JPG files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $err .= "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $connect = mysqli_connect("localhost", "root", "root", "youradventure");
        $query = "
        UPDATE user SET img='{$_SESSION['username']}' where username='{$_SESSION['username']}'
        ";

        if (mysqli_query($connect, $query)) {
            header("Location: /modules/profile.php");
        } else {
            $err .= "Sorry, your file was not uploaded.";
        }
        
    } else {
        $err .= "Sorry, there was an error uploading your file.";
    }
}

echo $err;
