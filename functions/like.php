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

$query = "
    select * from likes where user_id = ${userID} and tour_id = ${tourID};
";

$result = mysqli_query($connect, $query);

if ($result->num_rows > 0) 
{
    $queryDelete = "
        delete from likes where user_id=${userID} and tour_id=${tourID}
    ";

    if (mysqli_query($connect, $queryDelete)) {
        echo "gray";
    } else {
        echo "red";
    }
} 
else 
{
    $queryLike = "
        INSERT INTO likes (user_id, tour_id)
        values (${userID}, ${tourID})
    ";

    if (mysqli_query($connect, $queryLike)) {
        echo "red";
    } else {
        echo "gray";
    }
}
