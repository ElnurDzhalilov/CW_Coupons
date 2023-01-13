<?php
    include_once('db.php');
    $flag = $_POST['flag'] ?? null;
    $login = $_POST['login'] ?? null;
    $pass = $_POST['pass'] ?? null;
    if ($flag && $login && $pass) {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        mysqli_query($db, "INSERT INTO admins (login, hash, flag) VALUES ('$login', '$hash', '$flag');");
        echo('New administrator added successfully');
    } else {
        echo('Incorrect input');
    }
?>