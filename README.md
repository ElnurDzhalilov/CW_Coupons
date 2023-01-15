# Курсовой проект
------

## Основное задание ( Вариант 1 ).
Электронная очередь. В системе реализованы интерфейсы для получения талонов, отображения очереди, админка для добавления служащих.

## Ход работы

### 1. Разработка интерфейса для получения талонов.

- Страница получения талона

![Рис.1.](https://github.com/ElnurDzhalilov/CW_Coupons/blob/main/1st.png)

![Рис.2](https://github.com/ElnurDzhalilov/CW_Coupons/blob/main/1st_coup.png)

- Страница добавления новых работников ( админка ).

![Рис.3](https://github.com/ElnurDzhalilov/CW_Coupons/blob/main/s_adm.png)

- Страница с очередью
![Рис.4](https://github.com/ElnurDzhalilov/CW_Coupons/blob/main/screen.png)

### 2. Описание пользовательских сценариев работы
Доступны следующие возможности:
- Пользователь может взять талон, чтобы встать в очередь.
- Администратор может добавлять новых рабочих.
- Работники могут принимать людей по талонам.
- На экране высвечивается очередь.

Когда человек берет талон - ему даётся 15 секунд, чтобы запомнить его номер. Талон не печатается исходя из соображений экологии. 

### 3. Описание API сервера и хореографии.

- Пример запросов, когда пользователь берет талон:
<p align = "center"><img src="https://github.com/ElnurDzhalilov/CW_Coupons/blob/main/diag1.png"></p>
Запрос содержит следующие данные: текст купона.

- Пример запросов, когда мы добавляем нового администратора (работника) через панель суперадмиина:
<p align = "center"><img src="https://github.com/ElnurDzhalilov/CW_Coupons/blob/main/diag2.png  "></p>
Запрос "POST" содержит следующие данные: логин, хешированный пароль.

- Отображение очереди на экране:
<p align = "center"><img src="https://github.com/ElnurDzhalilov/CW_Coupons/blob/main/diag3.png"></p>

###4. Описание структуры базы данных.

Для хранения данных форума используется база данных MySQL. Всего в базе данных содержится 3 таблицы: таблица с информацией о рабочих, таблица с суперадмином и таблица с информацией о талонах.

Пример записи талона ```sh
{
  "id": 3,
  "name": "VR97",
  "flag": 1
}
```

Таблица о купонах содержит в себе flag, который указывает на то, был ли закрыт купон и в каком состоянии он сейчас. flag = 1 означает, что человек в действующей очереди, flag = 0 означает, что сейчас он находится на приёме, ну и flag = -1 означает, что талон закрыт.

Пример записи о работниках.

```sh
{
  "id": 1,
  "login": "admin1",
  "pass": 1234
}
```

### 5. Описание алгоритмов.

- Пользователь берет талон в очередь:
<p align = "center"><img src = "https://github.com/ElnurDzhalilov/CW_Coupons/blob/main/alg1.png" width = "400"></p>

- Работник вызывает человека из очереди:
<p align = "center"><img src = "https://github.com/ElnurDzhalilov/CW_Coupons/blob/main/alg2.png" width = "400"></p>

- Админ добавляет нового работника:
<p align = "center"><img src = "https://github.com/ElnurDzhalilov/CW_Coupons/blob/main/alg3.png" width = "400"></p>

- На экране появляется новый вызов:
<p align = "center"><img src = "https://github.com/ElnurDzhalilov/CW_Coupons/blob/main/alg4.png" width = "400"></p>

## 6. Значимые фрагменты кода.

Фрагмент кода, создающий талон.
```sh
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
```

Навешиваем обработчик на кнопку входа
```sh
    <script>
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
```

Фрагмент кода показа очереди на экране:
```sh
<script>
  let insert = document.querySelector('#insert');
  // раз в секунду делаем запрос
  setInterval(()=>{
    //запрос
    fetch('http://localhost/CW/get_coupons.php')
    .then(resp => resp.json())
    .then ( res => {
      //получаем данные о окнах и открытых талонах
      insert.innerHTML = "";
      Object.keys(res).forEach( key=> { // выводим все окна, для которых сущ.ет открытый талон
        if (res[key]) {
            let row = document.createElement('div');
            row.className = "row";
            insert.appendChild(row);

            let col = document.createElement('div');
            col.className = "col-5 h2 text-center";
            col.innerHTML = `Номер окна: ${key}`;
            row.appendChild(col);

            col = document.createElement('div');
            col.className = "col-7 h2 text-center";
            col.innerHTML = `Номер талона: ${res[key]}`;
            row.appendChild(col);
        }
      })
    })
    .catch(err => {console.log(err)});
  }, 1000);
</script>
```
