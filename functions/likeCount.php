<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$connect = mysqli_connect("localhost", "root", "root", "youradventure");

$query = "
    select count(*) count from likes where tour_id = {$_SESSION["tour"]};
";

$result = mysqli_query($connect, $query);

while ($row = mysqli_fetch_array($result)) {
    echo $row['count'];
}
