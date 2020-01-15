<?php
//1) выяснить какой из двух массивов короче и обрезать его, чтобы оба массива были равной длины
$array1=[1,2,3,4,5,6,7,8,9];
$array2=[1,2,3,4,5];
$array1_sort=[1,2,3,4,5,6,7,8,9];
$array2_sort=[1,2,3,4,5];
parse_str($_SERVER['QUERY_STRING'], $output);
if(isset($output['array1'])){
    $array1=explode(",", $output['array1']);
    $array1_sort=explode(",", $output['array1']);
}
if(isset($output['array2'])){
    $array2=explode(",", $output['array2']);
    $array2_sort=explode(",", $output['array2']);
}

if(count($array1)>count($array2)){
    $array1_sort = array_slice($array1_sort, 0,count($array2_sort));
}else{
    $array2_sort = array_slice($array2_sort, 0,count($array1_sort));
}
//2) отсортировать массив по значениям

sort($array1_sort,SORT_NUMERIC);
sort($array2_sort,SORT_NUMERIC);

//3) строка $postfix добавляемая в последствии к url имеет текстовый формат json.
//преобразовать $postfix так, чтобы после присоединения к url не возникло ошибок связанных
//со спецсимволами в url
$data = ['a'=>1,'b'=>2];
$postfix = json_encode($data);
$query_string = 'postfix=' . urlencode($postfix);
$url =  '<a href="http://'.$_SERVER['HTTP_HOST'].'/php.php?' . htmlentities($query_string) . '">Нажмите и смотрите на строку URL</a>';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Пример веб-страницы</title>
</head>
<body>
<p><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST']?>">Вернуться на главную страницу</a></p>
<h3>1) выяснить какой из двух массивов короче и обрезать его, чтобы оба массива были равной длины</h3>
<p>По умолчанию первый массив равен = [1,2,3,4,5,6,7,8,9]</p>
<p>Второй массив равен = [1,2,3,4,5]</p>
<form action="?" method="get">
    <p><b>Введите элементы массива через запятую</b></p>
    <p>
        <p>Пример: 1,2,3,4,5,6,7,8,9</p>
        <input type="text" name="array1" value="<?php echo isset($output['array1'])? $output['array1']: ''?>">Первый массив<Br>
        <input type="text" name="array2" value="<?php echo isset($output['array2'])?$output['array2']:''?>">Второй массив<Br>
    <p><input type="submit"></p>
    <h3>2) отсортировать массив по значениям</h3>
    <p>Отсортировано по возрастанию</p>
    <p>первый массив</p>
    <ul>
    <?php
        foreach ($array1_sort as $val_1_sort_abc)
        {
           echo"<li>".$val_1_sort_abc."</li>";
        }
    ?>
    </ul>
    <p>второй массив</p>
    <ul>
        <?php
        foreach ($array2_sort as $val_2_sort_abc)
        {
            echo"<li>".$val_2_sort_abc."</li>";
        }
        ?>
    </ul>
    <p>Отсортировано по убыванию</p>
    <p>первый массив</p>
    <ul>
        <?php
        rsort($array1_sort,SORT_NUMERIC);
        rsort($array2_sort,SORT_NUMERIC);

        foreach ($array1_sort as $val_1_sort_desc)
        {
            echo"<li>".$val_1_sort_desc."</li>";
        }
        ?>
    </ul>
    <p>второй массив</p>
    <ul>
        <?php
        foreach ($array2_sort as $val_2_sort_desc)
        {
            echo"<li>".$val_2_sort_desc."</li>";
        }
        ?>
    </ul>
    <h3>3) строка $postfix добавляемая в последствии к url имеет текстовый формат json.
        преобразовать $postfix так, чтобы после присоединения к url не возникло ошибок связанных
        со спецсимволами в url</h3>
        <p>Допустим у вас есть Json строка равная -  <?php echo $postfix?></p>
         <?php echo $url?>
    <h3>4) у вас есть $api_url. Сформируйте и запустите curl GET запрос по данному адресу, в котором явно
        указано,
        что ответ должен быть получен за 120 сек.</h3>

    <p>$url = "https://postman-echo.com/get?foo1=bar1&foo2=bar2";</p>

    <p>Инициализация CURL - $ch = curl_init();</p>

    <p> Возвращаем запрос а не выводим - curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);</p>

    <p> Ждем ответа сервера в течении 120 секунд - curl_setopt($ch, CURLOPT_TIMEOUT, 120);</p>

    <p>Указываем URL - curl_setopt($ch, CURLOPT_URL, $url);</p>

    <p>Получем результат - $result = curl_exec($ch);</p>

    <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/curl.php'?>">Отправть GET запрос CURL - ом</a>
</form>
</body>
</html>
