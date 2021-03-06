<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$query = "select * from user where username = '{$_SESSION['username']}'";
include '../connect/db.php';
$result = $mysql->query($query);
while ($row = $result->fetch_assoc()) {
    $name = $row['name'];
    $username = $row['username'];
    $email = $row['email'];
    $img = $row['img'];
}
$mysql->close();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $username ?> | Личный кабинет</title>
    <link rel="stylesheet" href="/css/style.css">

</head>

<body>
    <div class="menuDark">
        <div class="container">
            <?php include('header.php'); ?>
        </div>
    </div>

    <section id='profile'>
        <div class="container">
            <div class="profile-header">
                <form class="profile-img" action='/functions/user_avatar.php' method='post' enctype="multipart/form-data">
                    <img src="/img/avatars/<?= $img ?>.jpg" width="200" alt="Profile Image">
                    <label for="fileToUpload" class='cameraIcon' style='background: url(/img/icons/camera.svg) center center/cover no-repeat;'></label>
                    <input id='fileToUpload' name='fileToUpload' style='display:none' accept="image/jpeg" type='file'></input>
                </form>
                <div class="profile-nav-info">
                    <h3 class="user-name" style='text-align: center;'><?= $name ?></h3>
                    <div class="address">
                        <p id="state" class="state" style='margin: 0 auto'><?= $email ?></p>
                    </div>
                </div>
                <a href='/functions/log_out.php' class='profile__log-out'><img src='/img/icons/sign-out.svg'></a>
            </div>

            <div class="main-bd">
                <div class="left-side">
                    <div class="profile-side"><?= $username ?></div>
                </div>

                <div class="right-side">
                    <div class="profile__nav">
                        <ul>
                            <li data-tab=0 class="user-post active">Забронированные туры</li>
                            <li data-tab=1 class="user-review">Понравившиеся</li>
                        </ul>
                    </div>
                    <div class="profile-body">
                        <div class="profile-posts tab">
                            <h1>Забронированные туры</h1>
                            <div class="tours">
                                <div class="tours__wrapper">
                                    <?php
                                    $query = "select t.id, c.name city, co.name country, t.price, t.description, t.img, DATEDIFF(t.date_out, t.date_in) as days
                                    from bookedtours as b 
                                    inner join user as u on b.user_id = u.id 
                                    inner join tours t on b.tour_id = t.id 
                                    inner join cities c on t.city_id = c.id 
                                    inner join countries co on c.id_country = co.id
                                    where u.username = '{$_SESSION['username']}'
                                    ";
                                    include '../connect/db.php';

                                    $result = $mysql->query($query);
                                    if ($result->num_rows > 0) {
                                        foreach ($result as $item) : ?>
                                            <div class="tours__item">
                                                <div class="tours__img">
                                                    <img src="/img/tours/<?= $item['img'] ?>.jpg" width='439px' heigth='376px' alt="tour">
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
                                                    <a class="tours__button" href=<?= "modules/tour.php?tour={$item['id']}" ?>>
                                                        Подробнее
                                                    </a>
                                                </div>
                                            </div>
                                    <?php endforeach;
                                    } else {
                                        echo 'У вас пока нет забронированных туров';
                                    }
                                    $mysql->close();
                                    ?>


                                </div>
                            </div>
                        </div>
                        <div class="profile-reviews tab">
                            <h1>Понравившиеся туры</h1>
                            <div class="tours">
                                <div class="tours__wrapper">
                                    <?php
                                    $query = "select t.id, c.name city, co.name country, t.price, t.description, t.img, DATEDIFF(t.date_out, t.date_in) as days
                                    from likes
                                    inner join user as u on likes.user_id = u.id 
                                    inner join tours t on likes.tour_id = t.id 
                                    inner join cities c on t.city_id = c.id 
                                    inner join countries co on c.id_country = co.id
                                    where u.username = '{$_SESSION['username']}'
                                    ";
                                    include '../connect/db.php';

                                    $result = $mysql->query($query);
                                    if ($result->num_rows > 0) {
                                        foreach ($result as $item) : ?>
                                            <div class="tours__item">
                                                <div class="tours__img">
                                                    <img src="/img/tours/<?= $item['img'] ?>.jpg" width='439px' heigth='376px' alt="tour">
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
                                                    <a class="tours__button" href=<?= "/modules/tour.php?tour={$item['id']}" ?>>
                                                        Подробнее
                                                    </a>
                                                </div>
                                            </div>
                                    <?php endforeach;
                                    } else {
                                        echo 'У вас пока нет понравившихся туров';
                                    }
                                    $mysql->close();
                                    ?>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <script type="text/javascript" src="/js/jquery/jquery-1.11.0.min.js"></script>
    <script src="/js/profile.js"></script>
    <script>
        document.querySelector('input[type=file]').addEventListener('change', () => {
            document.querySelector('form').submit();
        })
    </script>
</body>

</html>