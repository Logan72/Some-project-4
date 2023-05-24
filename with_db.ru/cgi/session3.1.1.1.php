#!/usr/bin/php
<?php
session_start();

if (isset($_SESSION['HTTP_USER_AGENT'])){
	if ($_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) {
		exit("Отказано в доступе!");
	}
}

function A ($s) {
	if ($s=="") {$s1=" is null ";} else $s1="='".$s."' ";
	return $s1;
}

if ($_SESSION['user_enter']){
	mysql_connect("localhost", $_SESSION['user_login'], $_SESSION['user_password']) or die(mysql_error());
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
	foreach ($_SESSION['fs'] as $key => $value) {
		if ($key=="address_id") $s1=$s1.",".$key."=".$u;
		if ($key!="student_id" && $key!="address_id") {
			if($_POST[$key]!="") $s1=$s1.",".$key."='".$_POST[$key]."'";
			else $s1=$s1.",".$key."=null";
		}
	}
	$s1=substr($s1,1); 
	if(mysql_query("UPDATE students.student SET ".$s1." WHERE student_id=".$_POST['student_id'])==false) echo "Не удалось внести изменения в БД! Приносим извинения.";
	else echo "Успешно сохранены изменения.";
	echo "<form method=post>";
	echo "<br><button formaction=http://with_db.ru:85/cgi/session2.php>Вернуться</button>";
	echo "</form>";
}
else exit("Отказано в доступе!");
?>