<?php
    session_start();
    require_once 'check.php';

    if ($_COOKIE['login'] && $cookiePassword = $_COOKIE['password']) {
        if (checkCookie()) {
            header('Location: profile.php');
        }
    }
    if ($_SESSION['user']) {
        header('Location: main.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sing Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <h1>Registration</h1>

    <form class="form-sign-up">
        <label for="login">Login</label>
        <input type="text" name="login" id="login" placeholder="Введите логин" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Введите пароль" required>
        <label for="passwordConfirm">Confirm password</label>
        <input type="password" name="passwordConfirm" id="passwordConfirm"  placeholder="Подтвердите пароль" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Введите email" required>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Введите ваше имя" required>
        <input type="submit" class="btn" value="Register">
    </form>
    <script type="module" src="signUpRequest.js"></script>
</body>
</html>
