<?php
session_start();
unset($_SESSION["id"]);
unset($_SESSION["isShow"]);
unset($_SESSION["isIncorrect"]);
header("Location: ../login.php");
?>