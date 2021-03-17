
<header class="header">
    <a href="/" class="header__logo">
        <img class="header__logo" src="/img/logo _dark.svg" alt="logo" width="300px">
    </a>
    <nav>
        <a href="/modules/tours.php" class="header__item">Искать туры</a>

        <?php if ($_SESSION['username'] == '') : ?>
        <a href="/modules/auth.php" class="btn btn_small">Войти</a>
        <?php endif; ?>

        <?php if ($_SESSION['username'] != '') : ?>
        <a href="/modules/profile.php" class="circle"><?php echo $_SESSION['username'] ?></a>
        <?php endif; ?>
    </nav>
</header>