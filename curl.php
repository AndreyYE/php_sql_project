<?php

// Адрес
$url = "https://postman-echo.com/get?foo1=bar1&foo2=bar2";

// Инициализация CURL
$ch = curl_init();

// Возвращаем запрос а не выводим
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// Ждем ответа сервера в течении 120 секунд
curl_setopt($ch, CURLOPT_TIMEOUT, 120);

//Указываем URL
curl_setopt($ch, CURLOPT_URL, $url);
//Получем результат
$result = curl_exec($ch);

var_dump($result);
?>]
<br>
<a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/php.php'?>">Вернуться обратно</a>
