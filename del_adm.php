<?php
    include_once('db.php');
    $id = $_POST['id'] ?? null;
    if ($id) {
        mysqli_query($db, "DELETE FROM admins WHERE id = $id");
        echo('Administrator deleted successfully');
    } else {
        echo('Incorrect input');
    }
?>