<?php
// параметры для баззы данных
$host_bd = '';  // Хост, у нас все локально
$user_bd = '';    // Имя созданного вами пользователя
$pass_bd = ''; // Установленный вами пароль пользователю
$db_name_bd = '';   // Имя базы данных

//yandex http-notification
$secret='';

if ($_POST) {
$params='notification_type&operation_id&amount&currency&datetime&sender&codepro';

$params=explode('&',$params);
$forHASH=array();
foreach($params as $key=>$p) {
 if (isset($_POST[$p])) array_push($forHASH,$_POST[$p]);
}

if ($secret!="") array_push($forHASH,$secret);
if (isset($_POST['label'])) array_push($forHASH,$_POST['label']);

$forHASH=implode('&',$forHASH);

if ($_POST['sha1_hash']===sha1($forHASH) && $_POST['codepro']!=='true') { //transact ok.
         ////////////////////////////////
         ///////  Платёж прошел /////////
         ////////////////////////////////
           $status="done";
           $id=$_POST['label'];
           $money=$_POST['amount'];
           $tranid=$_POST["operation_id"];
           $flow="in";
           $paysystem="ym";
           $ymfrom=$_POST['sender'];

          file_get_contents("https://api.telegram.org/bot<token>/sendMessage?chat_id=123456789&text=Проверка уведомлений!+$status+$id+$money+$tranid+$flow+$paysystem+$ymfrom");
		  
		  $link_bd = mysqli_connect($host_bd, $user_bd, $pass_bd, $db_name_bd); // Соединяемся с базой
		  
		  mysqli_query($link_bd, "INSERT INTO session_paid (status, id, amount, operation_id, flow, paysystem, sender) VALUES ('$status', '$id', '$money', '$tranid', '$flow', '$paysystem', '$ymfrom')");
		  
		  mysqli_close($link_bd);

         ////////////////////////////////
  }
}

?>