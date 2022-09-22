<?php
    session_start();
    require_once 'WorkWithDatabase.php';
    require_once 'check.php';

    if ($_COOKIE['login'] && $cookiePassword = $_COOKIE['password']) {
        if (checkCookie()) {
            $database = WorkWithDatabase::getInstance();
            $userName = $database->getUserInfo('login',$_COOKIE['login'],'name');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<form>
    <h1>Hello, <?=$userName?></h1>
    <a href="logOut.php" class="btn">Exit</a>
</form>
</body>
</html>
<?php
        }
        else {
            header('Location: main.php');
        }
    }

?>