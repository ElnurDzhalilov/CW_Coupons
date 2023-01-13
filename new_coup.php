<?php
    include("db.php");
    
    //без предварительного объявления сервер выдаёт ошибку
    $name ='';
    $let_len = '';
    $num_len = '';
    $flag = 0;
    
    while ($flag == 0) {
        $letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $numbers = "0123456789";
        $let_len = strlen($letters);
        $num_len = strlen($numbers);

        $name .= $letters[rand(0, $let_len - 1)];
        $name .= $letters[rand(0, $let_len - 1)];
        $name .= $numbers[rand(0, $num_len - 1)];
        $name .= $numbers[rand(0, $num_len - 1)];
        
        // проверка на существование незакрытого талона с тем же именем
        $res = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM coupons WHERE name ='$name' AND flag>=0"));
        if (!$res) 
            $flag = 1;  
    }

    mysqli_query($db, "INSERT INTO coupons (id, name, flag) VALUES (NULL, '$name', '0')");
    echo($name);
?>
