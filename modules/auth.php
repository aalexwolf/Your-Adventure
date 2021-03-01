<?php
session_start();

$login = $_POST['login'];
$password = $_POST['password'];
$remember = $_POST['remember'];

include "../connect/db.php";
$query = "SELECT `username`, `password`, `salt` FROM user WHERE `username`='$login'";
$result = $mysql->query($query);
if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    if (md5(md5($password) . $row["salt"]) == $row["password"]) {
        header("Location: /");
        if (isset($_POST['remember'])) {
            setcookie("username", '', time() - 3600 * 24 * 7, "/");
            setcookie("username", $login, time() + 3600 * 24 * 7, "/");
        } else {
            setcookie("username", '', time() - 3600 * 24 * 7, "/");
        }
        $_SESSION['username'] = $login;
    }
}
$mysql->close();

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/authentication.css">
    <link rel="stylesheet" href="../css/button.css">
    <style>
        @media (max-width: 1000px) {
            .auth__item:first-child {
                display: none;
            }
            .auth__item:last-child {
                min-width: calc(100%);
            }
            .btn_big {
                font-size: 24px;
            }
        }

        .btn_big {
            background: #04C45C;
            font-size: 24px;
            width: 80%;
            height: 60px;
            margin-bottom: 20px;
            padding: 20px;
            transition: background 0.5s;
        }

        .btn_big:hover {
            background: #047AC4
        }

        .arrow {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <section class="auth">
        <div class="auth__item"></div>
        <div class="auth__item">
            <a href="/" class="btn btn_big">
                <svg xmlns="http://www.w3.org/2000/svg" class="arrow" fill="#fff" width="40" height="40" viewBox="0 0 24 24"><path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12-5.373-12-12-12-12 5.373-12 12zm7.58 0l5.988-5.995 1.414 1.416-4.574 4.579 4.574 4.59-1.414 1.416-5.988-6.006z"/></svg>                
                На главную
            </a>
            <form class="auth__form" action="auth.php" method="POST">
                <p class="auth_subtitle">С возвращением!</p>
                <h1 class="auth__title">Войдите в ваш аккаунт</h1>

                <label for="login">Имя пользователя или email</label><br>
                <input required class="auth__inputData" type="text" name="login"><br>

                <label for="password">Пароль</label><br>
                <input required class="auth__inputData" type="password" name="password"><br>

                <input type="checkbox" name="remember">
                <label for="remember">Запомнить меня</label>

                <input type="submit" value="Войти" name="btnSubmit">

                <div class="auth__reg">
                    <p>Еще нет аккантунта?</p> <a href="reg.php">Зарегестрируйтесь!</a>
                </div>
            </form>
        </div>
    </section>
</body>
</html>




