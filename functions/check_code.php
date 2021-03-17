<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$connect = mysqli_connect("localhost", "root", "root", "youradventure");

$username = $_SESSION["username"];
$tourID = $_SESSION["tour"];

$query = "select id from user where username = '${username}'";
$result = mysqli_query($connect, $query);
while ($row = mysqli_fetch_array($result)) {
    $userID = $row['id'];
}

$code = $_SESSION['code'];
$code_input = $_POST['code'];

if ($code == $code_input) {
    $queryLike = "
    INSERT INTO bookedtours (user_id, tour_id, seats_booked)
    values (${userID}, ${tourID}, 1);
    ";

    if (mysqli_query($connect, $queryLike)) {
        echo "OK";
    } else {
        echo "error";
    }
    
    exit();
} else {
    echo 'error';
    exit();
}
