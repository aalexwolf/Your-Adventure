<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$tourID = $_GET['tour'];
$_SESSION['tour'] = $tourID;

if ($_COOKIE['username'] != '') {
    $_SESSION['username'] = $_COOKIE['username'];
}
?>

<?php
    $username = $_SESSION['username'];
    
    $query = "select t.id, t.name, c.name city, co.name country, t.price, t.description, t.img, DATEDIFF(t.date_out, t.date_in) days from tours t inner join cities c on t.city_id = c.id inner join countries co on c.id_country = co.id where t.id = ${tourID}";
    include '../connect/db.php';
    $result = $mysql->query($query);
    while ($row = $result->fetch_assoc()) 
    {
        $tourName = $row['name'];
        $tourCity = $row['city'];
        $tourCountry = $row['country'];
        $tourPrice = $row['price'];
        $tourDesc = $row['description'];
        $tourDays = $row['days'];
        $tourImg = $row['img'];
    }


    $query = "select * from likes inner join user on user.id = likes.user_id where user.username = '${username}' and tour_id = ${tourID}";
    
    $result = $mysql->query($query);
    if (mysqli_num_rows($result) > 0) {
        $likeColor = 'red';
    } else {
        $likeColor = 'gray';
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
    <title><?= $tourName ?> | Your Adventure</title>
</head>

<body>
    <div class="menuDark">
        <div class="container">
            <?php include('header.php'); ?>
        </div>
    </div>

    <section id="singleTour">
        <div class="container">
            <div class="singleTour">
                <div class="singleTour__title">
                    <h1><?= $tourName ?></h1>
                </div>


                <div class="singleTour_wrapper">
                    <div class="singleTour__img">
                        <img src="/img/tours/<?= $tourImg ?>.jpg" alt="">
                    </div>

                    <div class="singleTour__info">
                        <div class="singleTour__place"><?= $tourCity ?>, <?= $tourCountry ?></div>
                        <div class="singleTour__rating">
                            <img src="/img/rating/yellow.svg" alt="" width="30px">
                            <img src="/img/rating/yellow.svg" alt="" width="30px">
                            <img src="/img/rating/yellow.svg" alt="" width="30px">
                            <img src="/img/rating/yellow.svg" alt="" width="30px">
                            <img src="/img/rating/yellow.svg" alt="" width="30px">
                        </div>
                        <div class="singleTour__price">Стоимость: <strong><?= $tourPrice ?></strong></div>
                        <div class="singleTour__days">Продолжительность: 
                            <strong>
                                <?
                                $days = $tourDays;
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
                            </strong>
                        </div>
                        <div class="singleTour__actions">
                            <p class="singleTour__actions-item order">
                                Забронировать тур
                            </p>
                            <p class="singleTour__actions-item like" style='color:<?= $likeColor ?>'>
                                &#10084;
                            </p>
                           <strong class='likesCount'></strong>&nbspотметок "Нравится"
                        </div>

                    </div>
                </div>

                <div class="singleTout__desc">
                    <?= $tourDesc ?>
                </div>
            </div>

        </div>
    </section>



    <?php  include 'footer.php'; ?>
</body>
<?php
    $mysql->close();
?>
<script type="text/javascript" src="/js/jquery/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/js/slick/slick.min.js"></script>
<script src="/js/script.js"></script>
<script src="/js/ajaxLike.js"></script>

</html>