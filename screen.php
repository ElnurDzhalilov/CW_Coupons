<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Экран вызовов</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>

<div id = "insert" class = "container">
</div>
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
</body>
</html>
