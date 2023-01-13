<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Выдача талонов</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container mt-4" align="center">
    <h1> Выдача талонов в регистратуру</h1>
    <h3 id="msg" class="mt-5"></h3>
    <button id="btn" style="height:150px;width:250px" class="btn mt-5 btn-success">ВЗЯТЬ ТАЛОН</button>
    <script>
        msg = document.querySelector('#msg') ;
        btn = document.querySelector('#btn');
        
        btn.addEventListener('click', () => {
            btn.disabled = true;
            msg.innerHTML = 'Ваш запрос обрабатывается, пожалуйста подождите';
            
            fetch('http://localhost/CW/new_coup.php')
            .then(resp => resp.text())
            .then( name => {
                count = 15;
                // косметическое, выдерживаем 15 секунд и обновляем страницу
                setInterval( () => {
                    msg.innerHTML = `Ваш талон: ${name}. Запомните эти четыре знака </br> Через ${count} секунд страница будет обновлена`;
                    count--;
                    if (count < 1)
                        window.location.href = "index.php" 
                }, 1000)
            })
            .catch(err => {console.log(err)});
            
        });
        
    </script>
  </div>
</body>
</html>