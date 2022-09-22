<?php
session_start();
unset($_SESSION['user']);
setcookie('login','', time()+3600,"/");
setcookie('password','', time()+3600,"/");
header('Location: main.php');
