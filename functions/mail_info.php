<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$connect = mysqli_connect("localhost", "root", "root", "youradventure");

$username = $_SESSION["username"];
$tourID = $_SESSION["tour"];

$query = "
    select u.name, u.email, t.name tour, b.seats_booked, t.price, t.date_in, t.date_out, city.name city, country.name country
    from bookedtours b
    inner join user u on u.id = b.user_id
    inner join tours t on b.tour_id = t.id
    inner join cities city on city.id = t.city_id
    inner join countries country on country.id = city.id_country
    where u.username = '{$username}'
    and t.id = ${tourID}
";

$result = mysqli_query($connect, $query);
while ($row = mysqli_fetch_array($result)) {
    $email = $row['email'];
    $name = $row['name'];
    $tour = $row['tour'];
    $seats = $row['seats_booked'];
    $price = $row['price'];
    $date_in = $row['date_in'];
    $date_out = $row['date_out'];
    $city = $row['city'];
    $country = $row['country'];
}

$message = "
    Дорогой ${name}, Вы забронировали тур ${tour}!\n
    Информация о брони:\n
    Место: ${city}, ${country}\n
    Дата выезда: ${date_in}\n
    Дата приезда: ${date_out}\n
    Стоимость: ${price}\n
    Количество забронированных мест: ${seats}\n
    Приятного путешествия! Ваш youradventure.by :)
";


mail($email, 'Booking Tour', $message, 'From: youradventure.by@gmail.com');
