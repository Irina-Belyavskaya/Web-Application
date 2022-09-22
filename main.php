<?php
    session_start();
    require_once 'check.php';

    if ($_COOKIE['login'] && $cookiePassword = $_COOKIE['password']) {
        if (checkCookie()) {
            header('Location: profile.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log in</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <h1>Authorization</h1>
    <form class="form-log-in" >
        <label for="login">Login</label>
        <input type="text" name="login" id="login" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" class="btn" value="Log In">
    </form>
    <p>If you don`t have an account -> <a href="signUp.php" class="link-to-registration">Register</a></p>
    <script type="module" src="logInRequest.js"></script>
</body>
</html>
