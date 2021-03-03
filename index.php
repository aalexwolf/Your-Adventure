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
                    <img class="header__logo" src="img/logo.svg" alt="logo">
                </a>
                <nav>
                    <a href="#popular" class="header__item">Туры</a>
                    <a href="#reviews" class="header__item">Отзывы</a>
                    <a href="#" class="header__item">Контакты</a>

                    <?php if ($_SESSION['username'] == '') : ?>
                        <a href="modules/auth.php" class="btn btn_small">Войти</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['username'] != '') : ?>
                        <a href="modules/auth.php" class="circle"><?php echo $_SESSION['username'] ?></a>
                    <?php endif; ?>
                </nav>
            </header>
            <div class="welcome">
                <div class="welcome__text">
                    Начни свое путешествие<br>Прямо сейчас
                </div>
                <a href="#" class="btn btn_big">Найти тур</a>
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
                    $query = "select t.id, c.name city, co.name country, t.price, t.description, DATEDIFF(t.date_out, t.date_in) as days, COUNT(*) kol from bookedtours as b inner join user as u on b.user_id = u.id inner join tours t on b.tour_id = t.id inner join cities c on t.city_id = c.id inner join countries co on c.id_country = co.id group by t.id order by kol desc limit 3";
                    include 'connect/db.php';
                    $result = $mysql->query($query);


                    foreach ($result as $item) : ?>
                        <div class="tours__item">
                        <div class="tours__img">
                            <img src="img/tours/paris.jpg" alt="tour">
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
                                <img src="img/rating/yellow.svg" alt="1">
                                <img src="img/rating/yellow.svg" alt="1">
                                <img src="img/rating/yellow.svg" alt="1">
                                <img src="img/rating/yellow.svg" alt="1">
                                <img src="img/rating/yellow.svg" alt="1">
                                Рейтинг
                            </div>
                            <div class="tours__about">
                                <?
                                    $descrp = strlen($item['description']) > 120 ? substr($item['description'], 0, 218) . '...' : $item['description'];
                                    echo $descrp;
                                ?>
                            </div>
                            <div class="tours__days">
                                <?= $item['days'] ?> дня
                            </div>
                            <a class="tours__button" href="">
                                Подробнее
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section id="promo">
        <div class="container">
            <div class="promo__wrapper">
                <div class="promo__item"><span>1000</span> <br>пользователей</div>
                <div class="promo__item"><span>23</span> <br>активных туров</div>
                <div class="promo__item"><span>350</span> <br>реальных отзывов</div>
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
                            <div class="review__img" style="background: url(img/avatars/defalt.png) center center/cover no-repeat;">
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
                            <div class="review__img" style="background: url(img/avatars/defalt.png) center center/cover no-repeat;">
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
                            <div class="review__img" style="background: url(img/avatars/defalt.png) center center/cover no-repeat;">
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
                            <div class="review__img" style="background: url(img/avatars/defalt.png) center center/cover no-repeat;">
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
                            <div class="review__img" style="background: url(img/avatars/defalt.png) center center/cover no-repeat;">
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