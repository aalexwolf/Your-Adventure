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

$query = "
select t.id, t.name, c.name city, co.name country, t.price, t.description, t.img, t.date_in, DATEDIFF(t.date_out, t.date_in) days, avg(r.rate) rate
from tours t 
inner join reviews r on r.tour_id = t.id
inner join cities c on t.city_id = c.id 
inner join countries co on c.id_country = co.id 
where t.id = ${tourID}
";

include '../connect/db.php';
$result = $mysql->query($query);
while ($row = $result->fetch_assoc()) {
    $tourName = $row['name'];
    $tourCity = $row['city'];
    $tourCountry = $row['country'];
    $tourPrice = $row['price'];
    $dateIn = $row['date_in'];
    $tourDesc = $row['description'];
    $tourDays = $row['days'];
    $tourImg = $row['img'];
    $rate = intval($row['rate']);
}


$query = "select * from likes inner join user on user.id = likes.user_id where user.username = '${username}' and tour_id = ${tourID}";

$result = $mysql->query($query);
if (mysqli_num_rows($result) > 0) {
    $likeColor = 'red';
} else {
    $likeColor = 'gray';
}

$query = "select * from bookedtours inner join user on user.id = bookedtours.user_id where user.username = '${username}' and tour_id = ${tourID}";

$result = $mysql->query($query);
$isOrdered = mysqli_num_rows($result) > 0 ? 'ordered' : 'order';
$orderText = mysqli_num_rows($result) > 0 ? 'Вы уже забронировали тур' : 'Забронировать тур';
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
                <div class="singleTour__header">обзор</div>
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
                            <?php
                            for ($i = 0; $i < $rate; $i++) {
                                echo "<img src='/img/rating/yellow.svg' width='40px' alt='1'>";
                            };
                            for ($i = $rate; $i < 5; $i++) {
                                echo "<img src='/img/rating/gray.svg' width='40px' alt='1'>";
                            };
                            ?>
                            Рейтинг
                        </div>
                        <div class="singleTour__price">Стоимость: <strong><?= $tourPrice ?></strong></div>
                        <div class="singleTour__price">Дата отправления: <strong><?= $dateIn ?></strong></div>
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
                            <p id='orderBtn' class="singleTour__actions-item <?= $isOrdered ?>">
                                <?= $orderText ?>
                            </p>
                            <p class="singleTour__actions-item like" style='color:<?= $likeColor ?>'>
                                &#10084;
                            </p>
                            <strong class='likesCount'></strong>&nbspотметок "Нравится"
                        </div>

                    </div>
                </div>

                <div class="singleTour__header">описание</div>
                <div class="singleTout__desc">
                    <?= $tourDesc ?>
                </div>
            </div>

        </div>
    </section>


    <section id='comments'>
        <div class="container">
            <div class="singleTour__header">отзывы</div>
            <div class="review" style="padding: 20px 0">


                <div class="review__wrapper">

                </div>
            </div>
        </div>
    </section>


    <?php include 'footer.php'; ?>


    <section class='modal' style='display: none'>
        <div class="container">
            <div class="modal__window">
                <div class="modal__confirm">
                    <div class="modal__confirmText">Вы действительно хотите забронировать этот тур?</div>
                    <div class="modal__confirmButtons">
                        <div class="modal__confirmButton modal__confirmButton_yes">Да</div>
                        <div class="modal__confirmButton modal__confirmButton_no">Нет</div>
                    </div>
                </div>

                <div class="modal__email" style='display: none'>
                    <div class="modal__emailText">Введите код, отправленный на вашу почту</div>
                    <div class="modal__emailInput">
                        <input id='inputCode' type="text">
                        <div class="btn btn_confirmOrder">Отправить</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<?php
$mysql->close();
?>
<script type="text/javascript" src="/js/jquery/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/js/slick/slick.min.js"></script>
<script src="/js/ajaxLike.js"></script>
<script src='/js/ajaxComments.js'></script>

<script>
    let username = "<?= $_SESSION['username'] ?>";

    document.querySelector('.order').addEventListener('click', () => {
        if (username != '') {
            document.querySelector('.modal').style.display = 'flex';
        } else {
            alert('Чтобы забронировать тур, необходимо войти!');
        }
    });


    document.querySelector('.modal__confirmButton_yes').addEventListener('click', () => {
        document.querySelector('.modal__confirm').style.display = 'none';

        $.ajax({
            url: "/functions/mail.php",
            method: "post",
            success: function(data) {
                document.querySelector('.modal__email').style.display = 'block';
            }
        });
    });

    document.querySelector('.modal__confirmButton_no').addEventListener('click', () => {
        document.querySelector('.modal').style.display = 'none';
    });

    document.querySelector('.btn_confirmOrder').addEventListener('click', () => {
        let inputCode = document.querySelector('#inputCode').value;

        $.ajax({
            url: "/functions/check_code.php",
            method: "post",
            data: {
                code: inputCode
            },
            success: function(data) {
                if (data == 'error') {
                    alert('Неправильный код!');
                } else {
                    alert('Вы забронировали тур!');
                    $.ajax({
                        url: "/functions/mail_info.php",
                        method: "post",
                        success: function() {
                            document.location.reload();
                        }
                    });

                }
            }
        });
    });
</script>

</html>