<?php
    session_start();
    unset($_SESSION["user_session"]);
    unset($_SESSION["senha"]);
    session_destroy();
    header("Location: index.php");
?>