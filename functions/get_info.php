<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION["username"])) {
    echo "error";
    exit();
}

$connect = mysqli_connect("localhost", "root", "root", "youradventure");

$username = $_SESSION["username"];
$tourID = $_SESSION["tour"];

$query = "select id from user where username = '${username}'";
$result = mysqli_query($connect, $query);
while ($row = mysqli_fetch_array($result)) {
    $userID = $row['id'];
}
?>
