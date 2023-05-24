#!/usr/bin/php
<?php

session_start();

if (isset($_SESSION['HTTP_USER_AGENT'])){
	if ($_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) {
		exit("Отказано в доступе!");
	}
}

function B(){
	echo "<form action=http://with_db.ru:85/cgi/session2.php method=post>";
	echo "<br><input type=submit name=return value=Вернуться>";
	echo "</form>";
}

if ($_POST['passport']=="") {
	echo "<b>Поле \"passport\" не может быть пустым!</b>";
	B();
	exit();
}

mysql_connect("localhost", $_SESSION['user_login'], $_SESSION['user_password']) or die(mysql_error());

//Функция!
function A ($s) {
	if ($s=="") {$s=" is null ";} else $s="='".$s."' ";
	return $s;
}

$t=mysql_query("select student_id from students.student where passport=".$_POST['passport']);

if(mysql_num_rows($t)==0){

$s1="";$s2="";
foreach ($_SESSION['fa'] as $key => $value) {
	if ($key!="address_id" && $_POST[$key]!="") {
	$s1=$s1.",".$key;
	$s2=$s2."','".$_POST[$key];
	}
}
if ($s1!="") { 
$s1=substr($s1,1); 
$s2=substr($s2,2)."'";
mysql_query("INSERT INTO students.address (".$s1.") VALUES (".$s2.")");
$q=mysql_query("select address_id from students.address where country".A($_POST['country'])."and town".A($_POST['town'])."and street".A($_POST['street'])."and house".A($_POST['house']));
$u1=mysql_fetch_assoc($q);
$u="'".$u1['address_id']."'";
}
else $u="null";
$s1="";
$s2="";
foreach ($_SESSION['fs'] as $key => $value) {
	if ($key!="student_id" && $key!="address_id" && $_POST[$key]!="") {
		$s1=$s1.",".$key;
		$s2=$s2."','".$_POST[$key]; 
	}
} 
$s1=substr($s1,1); 
$s2=substr($s2,2)."'"; 
mysql_query("INSERT INTO students.student (".$s1.",address_id) VALUES (".$s2.",".$u.")");
echo "<b>Успешно добавлено!</b>";

}
else echo "<b>Уже есть студент с таким паспортом!</b>";

B();
?>