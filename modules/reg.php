<?php
$login = $_POST['login'];
$name = $_POST['name'];
$password = $_POST['password'];
$passwordRepeat = $_POST['repeatPassword'];
$email = $_POST['email'];


if (isset($login) && isset($name) && isset($password) && isset($passwordRepeat) && isset($email)) {
    $err = '';

    if (strlen($login) < 3 or strlen($login) > 30)
        $err .= "Логин должен быть не меньше 3-х символов и не больше 30<br>";
    
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $login))
        $err .= "Логин может состоять только из букв английского алфавита, цифр и символа '_'<br>";
    
    if (strlen($name) < 3 or strlen($name) > 30)
        $err .= "Имя должно быть не меньше 3-х символов и не больше 30<br>";
    
    if (!preg_match('/^[A-Za-zА-Яа-я]+$/u', $name))
        $err .= "Имя может состоять только из букв русского и английского алфавита<br>";
    
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]+$/', $password))
        $err .= "Пароль должен содержать минимум одну заглавную букву, одну строчную букву и одну цифру<br>";
    
    if (strlen($password) < 8 or strlen($password) > 20)
        $err .= "Пароль должен быть не меньше 8-ми символов и не больше 20<br>";
    
    if ($password != $passwordRepeat)
        $err .= "Пароли не совпадают<br>";
    
    if (strlen($email) > 254)
        $err .= "Email слишком длинный<br>";
    
    if ($err != '') {
        echo $err;
        exit();
    }
    
    include "../connect/db.php";
    $query = "SELECT id FROM user WHERE `username`='$login'";
    if ($mysql->query($query)->num_rows > 0) {
        echo "Логин занят!";
        exit();
    } else {
        $salt = mt_rand(100, 999);
        $passwordSalt = md5(md5($password) . $salt);
    
        $mysql->query("INSERT INTO `user` (`username`, `name`, `password`, `email`, `salt`) 
                    VALUES('$login', '$name', '$passwordSalt', '$email', '$salt')");
        header("Location: auth.php");
    }
    $mysql->close();
}
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
                <svg xmlns="http://www.w3.org/2000/svg" class="arrow" fill="#fff" width="40" height="40" viewBox="0 0 24 24">
                    <path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12-5.373-12-12-12-12 5.373-12 12zm7.58 0l5.988-5.995 1.414 1.416-4.574 4.579 4.574 4.59-1.414 1.416-5.988-6.006z" />
                </svg>
                На главную
            </a>
            <form class="auth__form" action="/modules/reg.php" method="POST">
                <p class="auth_subtitle">Добро пожаловать!</p>
                <h1 class="auth__title">Регистрация</h1>
                <label for="login">*Имя пользователя</label><br>
                <input required class="auth__inputData" type="text" name="login"><br>

                <label for="name">*Как Вас зовут?</label><br>
                <input required class="auth__inputData" type="text" name="name"><br>

                <label for="email">*Электронная почта</label><br>
                <input required class="auth__inputData" type="text" name="email"><br>

                <label for="password">*Пароль</label><br>
                <input required class="auth__inputData" type="password" name="password"><br>

                <label for="repeatPassword">*Повторите пароль</label><br>
                <input required class="auth__inputData" type="password" name="repeatPassword"><br>

                <input type="submit" name="submit" value="Зарегистрироваться" name="btnSubmit">
                <div class="auth__reg">
                    <p>Уже есть аккаунт?</p> <a href="auth.php">Войти</a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>


