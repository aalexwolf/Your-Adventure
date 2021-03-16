<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
    session_unset();
    session_destroy();
    setcookie("username", '', time() - 3600 * 24 * 7, "/");
    header("Location: /");
?>  