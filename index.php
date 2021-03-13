<?php
session_start();
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="css/slick/slick-theme.css" />
    <script src="https://use.fontawesome.com/a4f7fde117.js"></script>
    <title>Your Adventure</title>
</head>

<body>
    <section id="start">
        <div class="container">
            <header class="header">
                <a href="/" class="header__logo">
                    <img class="header__logo" src="/img/logo.svg" alt="logo" width="300px">
                </a>
                <nav>
                    <a href="/modules/tours.php" class="header__item header__white">Туры</a>
                    <a href="#reviews" class="header__item header__white">Отзывы</a>
                    <a href="#" class="header__item header__white">Контакты</a>

                    <?php if ($_SESSION['username'] == '') : ?>
                    <a href="modules/auth.php" class="btn btn_small header__white">Войти</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['username'] != '') : ?>
                    <a href="modules/auth.php" class="circle header__white"><?php echo $_SESSION['username'] ?></a>
                    <?php endif; ?>
                </nav>
            </header>
            <div class="welcome">
                <div class="welcome__text">
                    Начни свое путешествие<br>Прямо сейчас
                </div>
                <a href="modules/tours.php" class="btn btn_big">Найти тур</a>
            </div>
        </div>
    </section>

    <section id="popular">
        <div class="container">
            <div class="tours">
                <div class="tours__title">
                    <h2 class="title">Самые популярные туры</h2>
                </div>
                <?php
                //'select t.id, c.name, co.name, t.price, t.description, DATEDIFF(t.date_out, t.date_in), COUNT(*) from bookedtours as b inner join user as u on b.user_id = u.id inner join tours t on b.tour_id = t.id inner join cities c on t.city_id = c.id inner join countries co on c.id_country = co.id group by t.id'
                ?>
                <div class="tours__wrapper">

                    <?php
                    $query = "select t.id, c.name city, co.name country, t.price, t.description, t.img, DATEDIFF(t.date_out, t.date_in) as days, COUNT(*) kol from bookedtours as b inner join user as u on b.user_id = u.id inner join tours t on b.tour_id = t.id inner join cities c on t.city_id = c.id inner join countries co on c.id_country = co.id group by t.id order by kol desc limit 3";
                    include 'connect/db.php';
                    $result = $mysql->query($query);

                    foreach ($result as $item) : ?>
                    <div class="tours__item">
                        <div class="tours__img">
                            <img src="img/tours/<?= $item['img'] ?>.jpg" width='439px' heigth='376px' alt="tour">
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
                                <img src="img/rating/yellow.svg" alt="1+">
                                <img src="img/rating/yellow.svg" alt="1+">
                                <img src="img/rating/yellow.svg" alt="1+">
                                <img src="img/rating/yellow.svg" alt="1+">
                                <img src="img/rating/yellow.svg" alt="1">
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
                            <a class="tours__button" href=<?= "modules/tour.php?tour={$item['id']}" ?>>
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

    <section id="promo">
        <div class="container">
            <div class="promo__wrapper">
                <?php
                include 'connect/db.php';
                $result = $mysql->query("select COUNT(*) count from user");
                while ($row = $result->fetch_assoc()) {
                    $userCount = $row['count'];
                }
                ?>
                <div class="promo__item">
                    <?php
                    if ($result == '1') {
                        echo "<span>${$userCount}</span><br>пользователь";
                    } elseif (substr($userCount, -1) == '2') {
                        echo "<span>{$userCount}</span><br>пользователя";
                    } elseif (substr($userCount, -1) == '3') {
                        echo "<span>{$userCount}</span><br>пользователя";
                    } elseif (substr($userCount, -1) == '4') {
                        echo "<span>{$userCount}</span><br>пользователя";
                    } else {
                        echo "<span>{$userCount}</span><br>пользователей";
                    }
                    ?>

                </div>


                <div class="promo__item">
                    <?php
                    include 'connect/db.php';
                    $result = $mysql->query("select COUNT(*) count from tours");
                    while ($row = $result->fetch_assoc()) {
                        $toursCount = $row['count'];
                    }
                    if ($result == '1') {
                        echo "<span>${$toursCount}</span><br>активный тур";
                    } elseif (substr($toursCount, -1) == '2') {
                        echo "<span>{$toursCount}</span><br>активных туров";
                    } elseif (substr($toursCount, -1) == '3') {
                        echo "<span>{$toursCount}</span><br>активных туров";
                    } elseif (substr($toursCount, -1) == '4') {
                        echo "<span>{$toursCount}</span><br>активных туров";
                    } else {
                        echo "<span>{$toursCount}</span><br>активных туров";
                    }
                    ?>
                </div>


                <div class="promo__item">
                    <?php
                    include 'connect/db.php';
                    $result = $mysql->query("select COUNT(*) count from reviews");
                    while ($row = $result->fetch_assoc()) {
                        $reviewsCount = $row['count'];
                    }
                    if ($result == '1') {
                        echo "<span>${$reviewsCount}</span><br>реальный отзыв";
                    } elseif (substr($reviewsCount, -1) == '2') {
                        echo "<span>{$reviewsCount}</span><br>реальных отзывов";
                    } elseif (substr($reviewsCount, -1) == '3') {
                        echo "<span>{$reviewsCount}</span><br>реальных отзывов";
                    } elseif (substr($reviewsCount, -1) == '4') {
                        echo "<span>{$reviewsCount}</span><br>реальных отзывов";
                    } else {
                        echo "<span>{$reviewsCount}</span><br>реальных отзывов";
                    }
                    ?>
                </div>

                <?php
                $mysql->close();
                ?>
            </div>
        </div>
    </section>

    <section id="reviews">
        <div class="container">
            <div class="review">
                <div class="review__title">
                    <h2 class="title review__title">Последние отзывы</h2>
                    <h3 class="subtitle review__subtitle">Последние впечатления счастливчиков, побывавших на одном из
                        наших туров</h3>
                </div>
                <div class="review__wrapper">
                    <div class="review__item">
                        <div class="review__item-wrapper">
                            <div class="review__img"
                                style="background: url(img/avatars/defalt.png) center center/cover no-repeat;">
                            </div>
                            <div class="review__text">
                                Far far away, behind the word
                                mountains, far from the countries
                                Vokalia and Consonantia, there live
                                the blind texts.
                            </div>
                            <div class="review__author">
                                Джон Доуэл
                            </div>
                            <div class="review__tour">
                                о туре <span>Париж, Франция</span>
                            </div>
                        </div>
                    </div>
                    <div class="review__item">
                        <div class="review__item-wrapper">
                            <div class="review__img"
                                style="background: url(img/avatars/defalt.png) center center/cover no-repeat;">
                            </div>
                            <div class="review__text">
                                Far far away, behind the word
                                mountains, far from the countries
                                Vokalia and Consonantia, there live
                                the blind texts.
                            </div>
                            <div class="review__author">
                                Джон Доуэл
                            </div>
                            <div class="review__tour">
                                о туре <span>Париж, Франция</span>
                            </div>
                        </div>
                    </div>
                    <div class="review__item">
                        <div class="review__item-wrapper">
                            <div class="review__img"
                                style="background: url(img/avatars/defalt.png) center center/cover no-repeat;">
                            </div>
                            <div class="review__text">
                                Far far away, behind the word
                                mountains, far from the countries
                                Vokalia and Consonantia, there live
                                the blind texts.
                            </div>
                            <div class="review__author">
                                Джон Доуэл
                            </div>
                            <div class="review__tour">
                                о туре <span>Париж, Франция</span>
                            </div>
                        </div>
                    </div>
                    <div class="review__item">
                        <div class="review__item-wrapper">
                            <div class="review__img"
                                style="background: url(img/avatars/defalt.png) center center/cover no-repeat;">
                            </div>
                            <div class="review__text">
                                Far far away, behind the word
                                mountains, far from the countries
                                Vokalia and Consonantia, there live
                                the blind texts.
                            </div>
                            <div class="review__author">
                                Джон Доуэл
                            </div>
                            <div class="review__tour">
                                о туре <span>Париж, Франция</span>
                            </div>
                        </div>
                    </div>
                    <div class="review__item">
                        <div class="review__item-wrapper">
                            <div class="review__img"
                                style="background: url(img/avatars/defalt.png) center center/cover no-repeat;">
                            </div>
                            <div class="review__text">
                                Far far away, behind the word
                                mountains, far from the countries
                                Vokalia and Consonantia, there live
                                the blind texts.
                            </div>
                            <div class="review__author">
                                Джон Доуэл
                            </div>
                            <div class="review__tour">
                                о туре <span>Париж, Франция</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'modules/footer.php' ?>
</body>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/slick/slick.min.js"></script>
<script src="js/script.js"></script>

</html>