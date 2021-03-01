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
                    <a href="#" class="header__item">Туры</a>
                    <a href="#" class="header__item">Отзывы</a>
                    <a href="#" class="header__item">Контакты</a>

                    <?php if($_SESSION['username'] == ''):?>
                    <a href="modules/auth.php" class="btn btn_small">Войти</a>
                    <?php endif;?>

                    <?php if($_SESSION['username'] != ''):?>
                    <a href="modules/auth.php" class="circle"><?php echo $_SESSION['username'] ?></a>
                    <?php endif;?>
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
                <div class="tours__header">
                    <h2>Самые популярные туры</h2>
                </div>

                <div class="tours__wrapper">
                    <div class="tours__item">
                        <div class="tours__img">
                            <img src="" alt="tour">
                        </div>
                    </div>
                    <div class="tours__item">
                        <div class="tours__img">
                            <img src="" alt="tour">
                        </div>
                    </div>
                    <div class="tours__item">
                        <div class="tours__img">
                            <img src="" alt="tour">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="js/script.js"></script>

</html>