<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Главный администратор</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>
    
    <div class="container my-5">
        <div class="row">
            <div class="col-5">
                <input type="text" id="login_s" class="form-control" placeholder="Логин">
            </div>
            <div class="col-5">
                <input type="password" id="pass_s" class="form-control" placeholder="Пароль">
            </div>
            <div class="col-2">
                <button class="btn btn-success" id="btn_log_in">Войти</button>
            </div>
        </div>
    </div>
    
    <script>
        //навешиваем обработчик на кнопку входа
        document.querySelector('#btn_log_in').addEventListener('click', () => {
            //заполняем данные формы
            let data = new FormData();
            data.append('s', 1);
            data.append('login', `${document.querySelector('#login_s').value}`);
            data.append('pass', `${document.querySelector('#pass_s').value}`);
            //отправляем запрос, выводим в окно сообщение об ошибке или html код
            fetch('http://localhost/CW/log_in.php', {method: 'POST', body: data })
            .then(resp => resp.text())
            .then ( res => {
                document.querySelector('#login_s').disabled = true;
                document.querySelector('#pass_s').disabled = true;
                document.querySelector('#btn_log_in').disabled = true;
                document.querySelector('#insert_here').innerHTML = res;
            })
            .catch(err => {console.log(err)});
        })
    </script>
    
    <div id="insert_here" class="container"></div> <!-- Сюда вставлется html, полученный в log_in.php -->

    
    <script> //ловим hmtl код, возвращаемый log_in.php. поймав, навешиваем обработчики. если размещать скрипты в log_in.php, то они не работают (
        let interval = setInterval( ()=> {
        
            let btn_add = document.querySelector('#btn_add');
            if (btn_add) {
                //как только видим, что нужный html появился - завершаем setInterval
                clearInterval(interval);
                
                let insert = document.querySelector('#insert_admins');
                
                btn_add.addEventListener('click', () => {
                    btn_add.setAttribute('disabled', true);
                    
                    let del_form = new FormData();
                    del_form.append('flag', document.querySelector('#flag_a').value);
                    del_form.append('login', document.querySelector('#login_a').value);
                    del_form.append('pass', document.querySelector('#pass_a').value);
                    
                    fetch('http://localhost/CW/add_adm.php', {method: 'POST', body: del_form})
                    .then( resp => resp.text())
                    .then( res => {
                        get_admins();
                        alert(res);
                        btn_add.removeAttribute('disabled');
                    })
            
                });
                
                
                //получаем список администраторов и выводим его, куда надо
                function get_admins() {
                    insert.innerHTML = '';
                    fetch('http://localhost/CW/get_adm.php')
                    .then(resp => resp.json())
                    .then(res => {    
                        if (res['len'] > 0) {
                            let row, col, input, btn;
                            for (i=0; i<res['len']; i++) {
                                // рамка и каркас
                                row = document.createElement('div');
                                row.className = "row content-justufy-center border rounded border-secondary border-opacity-25 border-3 mt-2 mx-5 py-2 align-center"
                                insert.appendChild(row);
                                // первая колонка
                                col = document.createElement('div');
                                col.className = "col-3";
                                row.appendChild(col);
                                //окно
                                input = document.createElement('input');
                                input.setAttribute('type', 'text');
                                input.setAttribute('id', `flag_${i}`);
                                input.className = "form-control"
                                input.setAttribute('placeholder', `Номер окна: ${res[i]['flag']}`);
                                input.setAttribute('disabled', true);
                                col.appendChild(input);
                                // вторая колонка
                                col = document.createElement('div');
                                col.className = "col-7";
                                row.appendChild(col);
                                //логин
                                input = document.createElement('input');
                                input.setAttribute('type', 'text');
                                input.setAttribute('id', `login_${i}`);
                                input.className = "form-control"
                                input.setAttribute('placeholder', `Логин: ${res[i]['login']}`);
                                input.setAttribute('disabled', true);
                                col.appendChild(input);
                                // третья колонка
                                col = document.createElement('div');
                                col.className = "col-2";
                                row.appendChild(col);
                                // кнопка
                                btn = document.createElement('button');
                                btn.setAttribute('id', `btn_del${i}`);
                                btn.className = "btn btn-danger"
                                btn.innerHTML = "Удалить";
                                col.appendChild(btn);
                                //добавление обработчика
                                btn_del_listener(row, btn, res[i]['id']);
                            }
                        }
                    })
                    .catch(err => {console.log(err);})
                }
                //функция для создания обработчкиов нажатия кнопок удаления
                function btn_del_listener(row, btn, id) {
                    btn.addEventListener('click', () => {
                        btn.setAttribute('disabled', true);
                                    
                        let del_form = new FormData();
                        del_form.append('id', id);
                                    
                        fetch('http://localhost/CW/del_adm.php', {method: 'POST', body: del_form})
                        .then( resp => resp.text())
                        .then( res => {
                            alert(res);
                            insert.removeChild(row);
                        })
                            
                    });
                }
                
                get_admins();
            }
        }, 500);
    
    </script>
    
</body>
</html>

