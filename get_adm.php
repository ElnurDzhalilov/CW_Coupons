<?php
    include_once('db.php');
    $res = mysqli_query($db, "SELECT * FROM admins");
    $arr = ['len' => 0];
    $cur = mysqli_fetch_assoc($res);
    while ($cur) {
        $arr[$arr['len']]=$cur;
        $arr['len']++;
        $cur = mysqli_fetch_assoc($res);
    }
    echo(json_encode($arr));
        
?>