<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Администратор</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>
    
    <div class="container my-5">
        <div class="row">
            <div class="col-5">
                <input type="text" id="login" class="form-control" placeholder="Логин" value="admin1">
            </div>
            <div class="col-5">
                <input type="password" id="pass" class="form-control" placeholder="Пароль" value="1234">
            </div>
            <div class="col-2">
                <button class="btn btn-success" id="btn_log_in">Войти</button>
            </div>
        </div>
    </div>

    <script>
        // навешиваем обработчик на кнопку логина
        document.querySelector('#btn_log_in').addEventListener('click', () => {
            //собираем данные для отправки
            let data = new FormData();
            data.append('s', 0);
            data.append('login', `${document.querySelector('#login').value}`);
            data.append('pass', `${document.querySelector('#pass').value}`);
            //аякс-запрос
            fetch('http://localhost/CW/log_in.php', {method: 'POST', body: data })
            .then(resp => resp.text())
            .then ( res => {
                //если логин и пароль верны...
                if (res[0] == '{') {
                    //то выводим кнопку открытия талона, ...
                    res = JSON.parse(res);
                    alert(res['msg']);
                    document.querySelector('#login').disabled = true;
                    document.querySelector('#pass').disabled = true;
                    document.querySelector('#btn_log_in').disabled = true;
                    let insert = document.querySelector('#insert0');
                    
                    let h = document.createElement('h2');
                    h.innerHTML = `Номер окна: ${res['flag']}`;
                    insert.appendChild(h);
                    
                    let btn_o = document.createElement('button');
                    btn_o.setAttribute("style", "height:150px;width:250px");
                    btn_o.className = "btn mt-5 btn-success";
                    btn_o.innerHTML = "Вызвать следующего пациента";
                    insert.appendChild(btn_o);
                    
                    //...и навешиваем на неё обработчик; ...
                    btn_o.addEventListener('click', () => {
                        //косметическое
                        btn_o.disabled = true;
                        let row = document.createElement('div');
                        let col1 = document.createElement('div');
                        let col2 = document.createElement('div');
                        let btn_c = document.createElement('button');
                        btn_c.disabled = true;
                        //собираем данные в форму для отправки         
                        let data_o = new FormData();
                        data_o.append("flag", res['flag']);
                        data_o.append("action", 'open');
                        //отправляем форму
                        fetch('http://localhost/CW/coupons.php', {method: 'POST', body: data_o})
                        .then(resp => resp.text()) 
                        .then (coupon => {
                            //выводим номер открытого талона
                            col1.innerHTML = `<h2>Открыт талон ${coupon}</h2>`
                            btn_c.removeAttribute('disabled');
                            //и навешиваем обработчик на кнопку закрытия талона
                            btn_c.addEventListener('click', () => {
                                let data_c = new FormData();
                                data_c.append("coupon", coupon);
                                data_c.append("action", 'close');
                                fetch('http://localhost/CW/coupons.php', {method: 'POST', body: data_c})
                                .then(resp => resp.text()) 
                                .then(msg => {
                                    console.log(msg);
                                    insert.removeChild(row);
                                    btn_o.removeAttribute('disabled');
                                    alert(msg)
                                })
                                .catch(err =>{console.log(err)});
                            })
                        })
                        .catch(err =>{console.log(err)});
                        
                        //выводим DOM-элементы на экран
                        row.className = "row m-2 mt-1 justify-content-center align-items-end";
                        insert.appendChild(row);
                        
                        col1.className = "col-4";
                        row.appendChild(col1);
                        
                        col2.className = "col-2 mb-2";
                        row.appendChild(col2);
                        
                        btn_c.className = "btn mt-5 btn-danger";
                        btn_c.innerHTML = "Закрыть талон";
                        
                        col2.appendChild(btn_c);
                    
                    
                    })
                }
                else //если возникла ошибка на сервере - сообщаем о ней
                    alert(res);
            }) //если возникла ошибка при запросе - сообщаем о ней
            .catch(err => {console.log(err)});
        })
    </script>
    
    <div id="insert0" class="container mt-4" align="center"></div>
    
    
</body>