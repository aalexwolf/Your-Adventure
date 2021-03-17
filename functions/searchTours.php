<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$connect = mysqli_connect("localhost", "root", "root", "youradventure");

$output = '';

$sort = $_POST["sort"];
$search = $_POST["search"];
$priceMin = $_POST["priceMin"];
$priceMax = $_POST["priceMax"];
$date = $_POST["date"];
$people = $_POST["people"];

if ($date == '') {
    $query = "
    select t.id, t.name, c.name city, co.name country, t.price, t.description, t.img, t.date_in date, t.seats, DATEDIFF(t.date_out, t.date_in) days, avg(r.rate) rate 
    from tours t 
    inner join reviews r on r.tour_id = t.id
    inner join cities c on t.city_id = c.id
    inner join countries co on c.id_country = co.id 
    WHERE (t.date_in > CURDATE())
    and (t.seats - '${people}' >= 0)
    and (t.price >= '${priceMin}') and (t.price <= '${priceMax}')
    and (c.name like '%${search}%' or co.name like '%${search}%' or t.name like '%${search}%')
    group by t.id ${sort}
    ";
} else {
    $query = "
    select t.id, t.name, c.name city, co.name country, t.price, t.description, t.img, t.date_in date, DATEDIFF(t.date_out, t.date_in) days, avg(r.rate) rate  
    from tours t 
    inner join reviews r on r.tour_id = t.id
    inner join cities c on t.city_id = c.id 
    inner join countries co on c.id_country = co.id 
    WHERE (t.date_in > CURDATE())
    and (t.date_in = '${date}')
    and (t.seats - '${people}' >= 0)
    and (t.price >= '${priceMin}') and (t.price <= '${priceMax}')
    and (c.name like '%${search}%' or co.name like '%${search}%' or t.name like '%${search}%')
    group by t.id {$sort}
    ";
}


$result = mysqli_query($connect, $query);


if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_array($result)) {
        $descr = strlen($row['description']) > 120 ? mb_substr($row['description'], 0, 120) . '...' : $row['description'];
        $days = $row['days'];
        $daysRow = $row['days'];
        if ($daysRow == '1') {
            $days = "$daysRow день";
        } elseif (substr($daysRow, -1) == '2') {
            $days = "$days дня";
        } elseif (substr($daysRow, -1) == '3') {
            $days = "$days дня";
        } elseif (substr($daysRow, -1) == '4') {
            $days = "$days дня";
        } else {
            $days = "$days дней";
        }

        $rate = intval($row['rate']);
        $rateHTML = '';
        for ($i = 0; $i < $rate; $i++) {
            $rateHTML .= "<img src='/img/rating/yellow.svg' width='25px' alt='1'>";
        };
        for ($i = $rate; $i < 5; $i++) {
            $rateHTML .= "<img src='/img/rating/gray.svg' width='25px' alt='1'>";
        };
        $output .= "
        <div class='tours__item'>
        <div class='tours__img'>
            <img src='/img/tours/{$row['img']}.jpg' alt='tour'>
        </div>
        <div class='tours__info'>
            <div class='tours__place-and-price'>
                <div class='tours__place'>
                    <h3>{$row['city']}, {$row['country']}</h3>
                </div>
                <div class='tours__price'>
                    {$row['price']}
                </div>
            </div>
            <div class='tours__rating'>
                ${rateHTML}
                Рейтинг
            </div>
            <div class='tours__about'>{$descr}</div>
            <div class='tours__days'>{$days}
            </div>
            <a class='tours__button' href='../modules/tour.php?tour={$row['id']}'>
                Подробнее
            </a>
        </div>
    </div>
    ";
    }
    echo $output;
} else {
    echo 'Туров не найдено';
}
