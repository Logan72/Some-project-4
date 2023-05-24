#!/usr/bin/php
<?php
session_start();

if (isset($_SESSION['HTTP_USER_AGENT'])){
	if ($_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) {
		exit("Отказано в доступе!");
	}
}

function F(){
	foreach($_SESSION['fields'] as $key => $value){
		if($key!="student_id" && $key!="address_id") echo $key.": <input type=text name=".$key."><br><br>";
	}
}

if ($_SESSION['user_enter']){

$login_form1 ='
	<i>Вы вошли как <b>'.$_SESSION['user_login'].'</b>.<br>
	Внимание! Не каждый пользователь MySql имеет доступ к БД "students".</i><hr>
    <form action=http://with_db.ru:85/cgi/session3.1.2.php method=post>
		<font face=arial size=4><b>Вывод данных студента или его удаление по паспорту.</b></font><br><br>
		Паспорт студента: <input type=text name=passport> 
		<button formaction=http://with_db.ru:85/cgi/session3.1.1.php>Найти</button> <input type=submit name=delete value=Удалить>
		<hr>
    </form>	';
echo $login_form1;	
echo "<form action=http://with_db.ru:85/cgi/session.php method=post>";
echo "<font face=arial size=4><b>Добавление студента и его данных.</b></font><br><br>";
F();	
echo "<input type=reset value=Сброс> <button formaction=http://with_db.ru:85/cgi/session3.2.php>Добавить</button><br><br>"; 	
echo "<hr>";
echo "<input type=submit name=exit value=Выход>";
echo "</form>";
}
else{
$login_form = '
	<form action="http://www.with_db.ru:85/cgi/session.php" method="post">
		<b>Отказано в доступе!</b><br>
		<hr>
		<input name="exit" type="submit" autofocus value="Ввести снова"><br>					
	</form>
';
echo $login_form;
}
?>