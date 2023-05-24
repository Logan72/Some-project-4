#!/usr/bin/php
<?php
session_start();

if (isset($_SESSION['HTTP_USER_AGENT'])){
	if ($_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) {
		exit("Отказано в доступе!");
	}
}

mysql_connect("localhost", $_SESSION['user_login'], $_SESSION['user_password']) or die(mysql_error());

$t=mysql_query("select student_id from students.student where passport=".$_POST['passport']);
if(mysql_num_rows($t)!=0){ 
	$q=mysql_query("select address_id from students.student where passport=".$_POST['passport']);
	$q1=mysql_fetch_assoc($q);
	mysql_query("delete from students.student where passport=".$_POST['passport']);
	mysql_query("delete from students.address where address_id =".$q1['address_id']);
	echo "<b>Успешно удалено!</b>";
}
else echo "<b>Не найдено!</b>";

echo "<form method=post>";
echo "<br><button formaction=http://with_db.ru:85/cgi/session2.php>Вернуться</button>";
echo "</form>";
?>