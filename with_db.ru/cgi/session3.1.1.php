#!/usr/bin/php
<?php
session_start();

if (isset($_SESSION['HTTP_USER_AGENT'])){
	if ($_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) {
		exit("Отказано в доступе!");
	}
}

function F($a) {
	echo "<font face=arial size=4>";
	foreach ($a as $name => $value) {
		if ($name=="address_id" || $name=="student_id") {
			echo "<b>".$name.": </b>".$value."<br>";
			if ($name=="student_id") echo "<input type=hidden name=".$name." value=".$value.">";
		}
		else echo "<b>".$name.": </b><input type=text name=".$name." value=".$value."><br>";
	}
	echo "</font>";
}
echo "<br><form action=http://with_db.ru:85/cgi/session3.1.1.1.php method=post>";
mysql_connect("localhost", $_SESSION['user_login'], $_SESSION['user_password']) or die(mysql_error());
	$r=mysql_query("select * from students.student where passport=".$_POST['passport']);
	if (mysql_num_rows($r)!=0) {
		$r=mysql_query("select * from students.student where passport=".$_POST['passport']." and address_id is null");
		if (mysql_num_rows($r)!=0) {
		$r2=mysql_fetch_assoc($r);
		F($r2);
		echo "<font face=arial size=4>";
		foreach ($_SESSION['fa'] as $key=>$value){
			if($key!="address_id") echo  "<b>".$key.": </b><input type=text name=".$key."><br>";
		}
		echo "<font face=arial size=4>";		
		}
		else {
			$q=mysql_query("select * from (select * from students.student where passport=".$_POST['passport'].") S natural join students.address");
			$q2=mysql_fetch_assoc($q);
			F($q2);
		}
		echo "<input type=submit name=save value='Сохранить изменения'>";
	}
	else echo "<b>Не найдено!</b><br>";

echo "<button formaction=http://with_db.ru:85/cgi/session2.php>Вернуться</button>	";
echo "</form>";
?>