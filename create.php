<?php

include("include.php"); //Выполняем подключение к базе данных

function encode() { //Функция генерирования url
    $url_encode = "";
    $nums = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789"; //Набор символов для генерации
    for ($i = 0; $i < 6; $i++) { //Цикл от 0 до 6
        $url_encode .= $nums[rand(0, strlen($nums))]; //Делаем рандомный url
    }
    return $url_encode; //Возращаем значение url
}

$msg_box = "";
$short_link = "";

if($_POST['url'] == null) { //Проверяем введенный пользователем url на пустоту
    $msg_box = "Empty Url";
}   
$url = htmlspecialchars(mysqli_real_escape_string($db, $_POST['url']), ENT_QUOTES); //Читаем введеный url в переменную
if ($_POST['your_url'] != null) { //Если пользователь захотел ввести свой короткий url
    $short_link = htmlspecialchars(mysqli_real_escape_string($db, $_POST['your_url']), ENT_QUOTES); //Читаем введенный короткий url в переменную
    $query = mysqli_query($db, "SELECT `encode` FROM `urls` WHERE `encode` = '$short_link'"); //Ищем в базе данные об этой ссылке
    $myrow = mysqli_fetch_array($query); ////Читаем массив данных полученый из БД
    if ($myrow != 0) { //Если такая ссылка уже существует, то скажем об этом
        $msg_box = "This URL already exists";
    }
} else { //Если пользователь не ввел свой короткий урл
    $myrow = 1;
    while ($myrow != 0) { //Генерируем короткий url до тех пор, пока такого в базе не найдется
        $short_link = encode();
        $query = mysqli_query($db, "SELECT `encode` FROM `urls` WHERE `encode` = '$short_link'");
        $myrow = mysqli_fetch_array($query);
    }
}
if(empty($msg_box)) { //Если нет никаких ошибок 
    $query = mysqli_query($db, "INSERT INTO `urls` (`url`, `encode`) VALUES ('$url', '$short_link')"); //То записываем url и короткий url в базу
    $msg_box = "Your short link is - <a href=\"$short_link\" target=\"_blank\">$short_link</a>"; //Выводим короткий url
}
echo json_encode(array('result' => $msg_box)); //Ответ клиенту в формате json
