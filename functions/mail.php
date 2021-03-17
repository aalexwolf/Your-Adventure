<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$connect = mysqli_connect("localhost", "root", "root", "youradventure");

$username = $_SESSION["username"];
$tourID = $_SESSION["tour"];

$query = "select email from user where username = '${username}'";

$result = mysqli_query($connect, $query);
while ($row = mysqli_fetch_array($result)) {
    $email = $row['email'];
}


$code = '';

for ($i = 0; $i < 4; $i++) {
    $code .= mt_rand(0, 9);
}

$_SESSION['code'] = $code;

mail($email, 'Booking Tour', "Your code is: ${code}", 'From: youradventure.by@gmail.com');
