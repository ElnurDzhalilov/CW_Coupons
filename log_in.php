<?php
    include_once('db.php');
    $s = $_POST['s'] ?? null;
    $login = $_POST['login'] ?? null;
    $pass = $_POST['pass'] ?? null;
    
    if ($login && $pass) {
        if ($s == 0) { // для простых администраторов
            $res = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM admins WHERE login='$login'"));
            
            if($res) {
                if (password_verify($pass, $res['hash'])) {
                    $res = ['msg' => 'Signup succcesfull', 'flag' => "$res[flag]"];
                    echo (json_encode($res));
                } 
                else {
                    echo('Tncorrect password');
                }
            } else {
                echo('Tncorrect login');
            }
        }
        else { //s = 1, т.е. для главадмина
            $res = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM s_admin WHERE login='$login'"));
            
            if($res) {
                if (password_verify($pass, $res['hash'])) {
                    ?>
                        
                        <div class="container border rounded border-secondary border-opacity-25 border-3 py-3">
                            <h5> Новый администратор: </h5>
                            <div class="row">
                                <div class="col-2">
                                    <input type="text" id="flag_a" class="form-control" placeholder="Номер окна">
                                </div>
                                <div class="col-4">
                                    <input type="text" id="login_a" class="form-control" placeholder="Логин">
                                </div>
                                <div class="col-4">
                                    <input type="password" id="pass_a" class="form-control" placeholder="Пароль">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-success" id="btn_add">Добавить</button>
                                </div>
                            </div>
                        </div>
                        
                        <div id="insert_admins" class="container"></div>
                        
                    <?php

                }
                else {
                    echo('Tncorrect password');
                }
            }
            else {
                echo('Incorrect login');
            }
        }
    }
    else {
        echo('Empty input');
    }
?>