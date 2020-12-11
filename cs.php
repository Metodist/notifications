<?php
//$data = file_get_contents('php://input');


// параметры для баззы данных
$host_bd = '';  // Хост, у нас все локально
$user_bd = '';    // Имя созданного вами пользователя
$pass_bd = ''; // Установленный вами пароль пользователю
$db_name_bd = '';   // Имя базы данных


//получаю тело пост и паршу в json
$data = json_decode(file_get_contents('php://input'), true);

if ($data){
$id = $data["transactionId"];
$amount = $data["amount"]["amount"];
$commission = $data["amount"]["commission"];
$status = $data["status"];
$name = $data["custom"]["Name"];
$desc = $data["custom"]["Description"];
$tarif = $data["custom"]["tarif"];
$c_id = $data["custom"]["id"];


// Соединяемся с базой
$link_bd = mysqli_connect($host_bd, $user_bd, $pass_bd, $db_name_bd);

//Записываю данные
mysqli_query($link_bd, "INSERT INTO session_paid (id, client_id, amount, commission, status, name, descrip, tarif) VALUES ('$id', '$c_id', '$amount', '$commission', '$status', '$name', '$desc', '$tarif')");

//закрываю соединение
mysqli_close($link_bd);

//file_get_contents("https://api.telegram.org/bot<token>/sendMessage?chat_id=123456789&text=Проверка уведомлений! + $data + $id + $amount + $commssion + $status + $name + $desc + $tarif");
}
?>
 