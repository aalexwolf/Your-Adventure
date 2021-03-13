<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if ($_COOKIE['username'] != '') {
    $_SESSION['username'] = $_COOKIE['username'];
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="../css/slick/slick-theme.css" />
    <script src="https://use.fontawesome.com/a4f7fde117.js"></script>
    <title>Поиск Тура | Your Adventure</title>
</head>

<body>
    <div class="menuDark">
        <div class="container">
            <?php include('header.php'); ?>
        </div>

    </div>


    <section id="popular">
        <div class="container">
            <div class="tours" style="margin-top: 100px">
                <div class="tours__title">
                    <h2 class="title" style='color:#09C299; text-align:left'>Найдите тур вашей мечты</h2>
                </div>


                <div class="search">
                    <input class="search__input" type="text" placeholder="Найти..." name="search_text">
                    <div class="search__row">
                        <div class="select-box">
                            <label for="select-box1" class="label select-box1"><span class="label-desc">Сортировать
                                    по...</span> </label><br>
                            <select id="select-box1" class="select">
                                <option value="default">По умолчанию</option>
                                <option value="cheap">Сначала дешевые</option>
                                <option value="rich">Сначала дороогие</option>
                                <option value="rating">Рейтингу</option>
                                <option value="popularity">Популярности</option>
                            </select>
                        </div>
                        <div class="range-box">
                            <label class='selectLabel' for="select-box1">Минимальная стоимость</span> </label><br>
                            <input type="range" onchange="changeRangeValue(this.value, '.priceValueMin')" min="1"
                                max="100" class="slider" id="rangeMin">
                            <label for="range" class='priceValueMin'></label>
                            <label class='selectLabel' for="select-box1">Максимальная стоимость</span> </label><br>
                            <input type="range" onchange="changeRangeValue(this.value, '.priceValueMax')" min="1"
                                max="100" class="slider" id="rangeMax">
                            <label for="range" class='priceValueMax'></label>
                            <script>
                                document.querySelector('#rangeMin').value = document.querySelector('#rangeMin').min;
                                document.querySelector('#rangeMax').value = document.querySelector('#rangeMax').max;

                                document.querySelector('.priceValueMin').innerHTML = document.querySelector('#rangeMin')
                                    .min;
                                document.querySelector('.priceValueMax').innerHTML = document.querySelector('#rangeMax')
                                    .max;

                                function changeRangeValue(value, selector) {
                                    document.querySelector(selector).innerHTML = value;
                                }
                            </script>
                        </div>
                        <div class="date-box">
                            <label for="date-arr">Дата отправления:</label><br>
                            <input type="date" id="birthday" name="date-arr">
                        </div>
                        <div class="people-box">
                            <label for="peopleNum">Количество человек:</label><br>
                            <input type="number" max=5 min=1 name="peopleNum">
                        </div>
                    </div>

                </div>

                <div class="tours__wrapper">
                    <?php
                    $query = "select t.id, c.name city, co.name country, t.price, t.description, t.img, DATEDIFF(t.date_out, t.date_in) as days from tours t inner join cities c on t.city_id = c.id inner join countries co on c.id_country = co.id";
                    include '../connect/db.php';
                    $result = $mysql->query($query);

                    foreach ($result as $item) : ?>
                    <div class="tours__item">
                        <div class="tours__img">
                            <img src="/img/tours/<?= $item['img'] ?>.jpg" alt="tour">
                        </div>
                        <div class="tours__info">
                            <div class="tours__place-and-price">
                                <div class="tours__place">
                                    <h3><?= $item['city'] ?>, <?= $item['country'] ?></h3>
                                </div>
                                <div class="tours__price">
                                    <?= $item['price'] ?>
                                </div>
                            </div>
                            <div class="tours__rating">
                                <img src="/img/rating/yellow.svg" alt="1+">
                                <img src="/img/rating/yellow.svg" alt="1+">
                                <img src="/img/rating/yellow.svg" alt="1+">
                                <img src="/img/rating/yellow.svg" alt="1+">
                                <img src="/img/rating/yellow.svg" alt="1">
                                Рейтинг
                            </div>
                            <div class="tours__about">
                                <?
                                        $descr = strlen($item['description']) > 120 ? mb_substr($item['description'], 0, 120).'...' : $item['description'];
                                        echo $descr;
                                ?>
                            </div>
                            <div class="tours__days">
                                <?
                                        $days = $item['days'];
                                        if( $days == '1'){ 
                                            echo "$days день";
                                        } elseif( substr($days, -1) == '2'){ 
                                            echo "$days дня"; 
                                        } elseif( substr($days, -1) == '3'){ 
                                            echo "$days дня"; 
                                        } elseif( substr($days, -1) == '4'){ 
                                            echo "$days дня"; 
                                        } else { 
                                            echo "$days дней"; 
                                        }
                                    ?>
                            </div>
                            <a class="tours__button" href=<?= "tour.php?tour={$item['id']}"?>>
                                Подробнее
                            </a>
                        </div>
                    </div>
                    <?php endforeach;
                    $mysql->close(); 
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php' ?>
</body>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src='/js/ajaxTour.js'></script>
</html>