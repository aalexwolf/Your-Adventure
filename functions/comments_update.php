<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$connect = mysqli_connect("localhost", "root", "root", "youradventure");
$username = $_SESSION['username'];
$query = "select id from user where username = '${username}'";
$result = mysqli_query($connect, $query);
while ($row = mysqli_fetch_array($result)) {
    $userID = $row['id'];
}

$output = '';
if (isset($_SESSION['username'])) {
    $output .= "
        <div class='comment'>
            <div class='comment__header'>Оставьте свой отзыв</div>
            <div class='comment__input'>
                <textarea name='comment' id='comment_text' rows='3' maxlength='250' minlength='10' required></textarea>
            </div>

            <div class='comment__actions'>
                <div class='comment__stars'>
                    Ваша оценка:&nbsp;&nbsp;&nbsp;
                    <img class='star-img' src='/img/rating/gray.svg' data-rate='1' alt='star' width='50px'>
                    <img class='star-img' src='/img/rating/gray.svg' data-rate='2' alt='star' width='50px'>
                    <img class='star-img' src='/img/rating/gray.svg' data-rate='3' alt='star' width='50px'>
                    <img class='star-img' src='/img/rating/gray.svg' data-rate='4' alt='star' width='50px'>
                    <img class='star-img' src='/img/rating/gray.svg' data-rate='5' alt='star' width='50px'>
                </div>
                <div class='comment__send'>
                    Оставить отзыв
                </div>
            </div>
        </div>
    ";
} else {
    $output .= "
        <a href='/modules/auth.php'>Войдите</a>, чтобы оставить свой отзыв о туре<br><br><br>
    ";
}

$tourID = $_SESSION["tour"];

$query = "
select reviews.user_id, user.name, user.username, user.img, reviews.date, reviews.rate, reviews.content, cities.name city, countries.name country 
from reviews 
inner join user on user.id = reviews.user_id 
inner join tours on reviews.tour_id = tours.id
inner join cities on tours.city_id = cities.id
inner join countries on cities.id_country = countries.id
where tour_id = {$tourID}
order by reviews.date desc
";


$result = mysqli_query($connect, $query);


if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_array($result)) {

        $starRatingHTML = '';
        $starRating = intval($row['rate']);
        for ($i = 0; $i < $starRating; $i++) {
            $starRatingHTML .= "<img src='/img/rating/yellow.svg' alt='star' width='30px'>";
        }
        for ($i = $starRating; $i < 5; $i++) {
            $starRatingHTML .= "<img src='/img/rating/gray.svg' alt='star' width='30px'>";
        }

        $buttonsHTML = '';
        if ($userID == $row['user_id']) {
            $buttonsHTML = "                   
                <div class='review__btn review__reply'>Ответить</div>
                <div class='review__btn review__delete'>Удалить</div>
            ";
        }
        else {
            $buttonsHTML = "                   
                <div class='review__btn review__reply'>Ответить</div>
            ";
        }

        $output .= "
        <div class='review__item'>
        <div class='review__item-wrapper'>
            <div class='review__img'
                style='background: url(/img/avatars/{$row['img']}.jpg) center center/cover no-repeat;'>
            </div>
            <div class='review__info'>
                <span>{$row['date']}</span>
                ${starRatingHTML}
            </div>
            <div class='review__text'>
                {$row['content']}
            </div>

            <div class='review__footer'>
                <div class='review__footer-info'>
                    <div class='review__author'>
                        {$row['name']} ({$row['username']})
                    </div>
                    <div class='review__tour'>
                        о туре <span>{$row['city']}, {$row['country']}</span>
                    </div>
                </div>

                <div class='review__buttons'>
                    {$buttonsHTML}
                </div>

            </div>

        </div>
    </div>
        ";
    }
    echo $output;
} else {
    echo 'Отзывов о туре пока нет. Будьте превым!<br>'.$output;
}
