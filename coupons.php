<?php
    include_once('db.php');
    $action = $_POST['action'] ?? null;

    if ($action == 'open') {
        $flag = $_POST['flag'] ?? null;
        if ($flag) {
            $coupon = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM coupons WHERE flag=0"));
            mysqli_query($db, "UPDATE coupons SET flag=$flag WHERE id=$coupon[id]");
            echo($coupon['name']);
        }
    }
    if ($action == 'close') {
        $coupon = $_POST['coupon'] ?? null;
        if ($coupon) {
            mysqli_query($db, "UPDATE coupons SET flag=-1 WHERE name='$coupon' and flag>0");
            echo("Купон $coupon успешно закрыт");
        }
    }
?>