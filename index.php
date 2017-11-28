<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Short Url</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="submit.js" type="text/javascript"></script>
</head>
<body>
    <label>URL:</label><br/>
    <input type="text" id="url" value="" /><br />
    <label>Your short url (optional):</label><br />
    <input type="text" id="short" value="" /><br /><br />
    <input type="button" value="Отправить" id="btn_submit" /><br /><br />
    <div class="messages"></div>
</body>
</html>
<?php
include('include.php'); //Подключение к базе данных
if (isset($_GET['link'])) { //Если происходит переход по ссылке
    $url = htmlspecialchars(mysqli_real_escape_string($db, $_GET['link']), ENT_QUOTES); //В переменную присваиваем значение link
    $query = mysqli_query($db, "SELECT `url` FROM `urls` WHERE `encode` = '$url'"); //Ищем в базе данные об этой ссылке
    $myrow = mysqli_fetch_array($query); //Читаем массив данных полученый из БД
    if ($myrow != 0) { //Если существует такой url, то выполняем переход
        Header('Location: '.$myrow['url']);
    }
}
?>
