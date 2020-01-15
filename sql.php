<?php
try {
    $conn = new PDO("sqlite:test_PDO.sqlite");
    $conn->exec("DROP table t_1");
    $conn->exec("DROP table t_2");

    $conn->exec("Create table if not exists t_1(id_region integer, asin text, price numeric(20,6))");
    $conn->exec("Create table if not exists t_2(asin text, title text)");

    $conn->exec("INSERT INTO t_1(id_region,asin,price) VALUES(1,'B007',11.40)");
    $conn->exec("INSERT INTO t_1(id_region,asin,price) VALUES(2,'B007',11.50)");
    $conn->exec("INSERT INTO t_1(id_region,asin,price) VALUES(2,'B008',13.01)");
    $conn->exec("INSERT INTO t_2(asin,title) VALUES('B007','a11')");
    $conn->exec("INSERT INTO t_2(asin,title) VALUES('B008','a22')");

    $result = $conn->query(
        "SELECT 
                id_region, title, price FROM t_1
                INNER JOIN t_2 ON t_1.asin=t_2.asin");
    $result1 = $conn->query(
        "SELECT title FROM `t_2`
                 WHERE 1<
                (SELECT COUNT(*) FROM `t_1` WHERE t_1.asin=t_2.asin)");
}
catch(PDOException $e)
{
    echo "<br>" . $e->getMessage();
}

$conn = null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Пример веб-страницы</title>
</head>
<body>
<p><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST']?>">Вернуться на главную страницу</a></p>
<h3>1) вывести одним sql-запросом id_region, title, price</h3>
<p>"SELECT
    id_region, title, price FROM t_1
    INNER JOIN t_2 ON t_1.asin=t_2.asin"</p>
<?php
while ($row=$result->fetchObject()){
    echo "id_region - ".$row->id_region." title - ".$row->title." price - ".$row->price;
    echo"</br>";
}
?>
<h3>2) исходя из п.1 предложить индексы для t1 и t2</h3>
Для таблицы t_1 - составной первичный ключ из category_id и asin, а для таблицы t_2 - составной из title и asin.
Внешний ключ для таблицы t_2 - asin
<h3>3) вывести одним sql-запросом title, для которого существуют более одной цены</h3>
<p>"SELECT title FROM `t_2`
    WHERE 1<
    (SELECT COUNT(*) FROM `t_1` WHERE t_1.asin=t_2.asin)"</p>
<?php
while ($row1=$result1->fetchObject()){
    echo " title - ".$row1->title;
    echo"</br>";
}
?>
<h3>4) возможно применить DELETE или TRUNCATE с одинаковым эффектом. что примените и почему?</h3>
TRUNCATE:
<p>- удаляет все строки из базы данных;</p>
<p>- откат невозможен (кроме microsoft sql server);</p>
<p>- используется без WHERE;  тогда как DELETE возможно использовать с WHERE</p>
<p>- удаление не логируется в журнал;</p>
<p>- возвращает 0; тогда как DELETE возвращает количество удаленных строк, елси не удалось удалить не одной строки тогда возвращает 0</p>
<p>- блокирует всю таблицу;</p>
<p>- если нужно удалить все записи из таблице, а этих записей тысячи лучше использовать TRUNCATE операцию, так как она менее ресурсозатратная;</p>
<p>- если есть ограничения внешнего ключа то удалеть записи не пролучится;</p>
<p>Для текущих таблиц если нужно удалить все записи лучше использовать TRUNCATE команду, потому что нет ограничения внешнего ключа, и эта команда менее ресурсоемкая.</p>

</body>
</html>
