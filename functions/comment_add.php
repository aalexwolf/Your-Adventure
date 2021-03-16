<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION["username"])) {
    echo "Зарегистрируйтесь или войдите!";
    exit();
}

if ($_POST["rate"] == 0) {
    echo "Вы не поставили оценку!";
    exit();
}

$connect = mysqli_connect("localhost", "root", "root", "youradventure");

$username = $_SESSION["username"];
$tourID = $_SESSION["tour"];
$rate = $_POST["rate"];
$comment = $_POST["comment"];


$query = "select id from user where username = '${username}'";
$result = mysqli_query($connect, $query);
while ($row = mysqli_fetch_array($result)) {
    $userID = $row['id'];
}

$query = "
    select * from reviews where user_id = ${userID} and tour_id = ${tourID};
";

$result = mysqli_query($connect, $query);

if ($result->num_rows > 0) 
{
    echo "Вы уже оставляли отзыв!";
    exit();
} 
else 
{
    $queryComment = "
        INSERT INTO reviews (user_id, tour_id, content, rate, date)
        values (${userID}, ${tourID}, '{$comment}', ${rate}, CURDATE())
    ";

    if (mysqli_query($connect, $queryComment)) {
        echo 'OK';
    } else {
        echo "Ошибка!";
    }
}
