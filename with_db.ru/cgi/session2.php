#!/usr/bin/php
<?php
session_start();

if (isset($_SESSION['HTTP_USER_AGENT'])){
	if ($_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) {
		exit("�������� � �������!");
	}
}

function F(){
	foreach($_SESSION['fields'] as $key => $value){
		if($key!="student_id" && $key!="address_id") echo $key.": <input type=text name=".$key."><br><br>";
	}
}

if ($_SESSION['user_enter']){

$login_form1 ='
	<i>�� ����� ��� <b>'.$_SESSION['user_login'].'</b>.<br>
	��������! �� ������ ������������ MySql ����� ������ � �� "students".</i><hr>
    <form action=http://with_db.ru:85/cgi/session3.1.2.php method=post>
		<font face=arial size=4><b>����� ������ �������� ��� ��� �������� �� ��������.</b></font><br><br>
		������� ��������: <input type=text name=passport> 
		<button formaction=http://with_db.ru:85/cgi/session3.1.1.php>�����</button> <input type=submit name=delete value=�������>
		<hr>
    </form>	';
echo $login_form1;	
echo "<form action=http://with_db.ru:85/cgi/session.php method=post>";
echo "<font face=arial size=4><b>���������� �������� � ��� ������.</b></font><br><br>";
F();	
echo "<input type=reset value=�����> <button formaction=http://with_db.ru:85/cgi/session3.2.php>��������</button><br><br>"; 	
echo "<hr>";
echo "<input type=submit name=exit value=�����>";
echo "</form>";
}
else{
$login_form = '
	<form action="http://www.with_db.ru:85/cgi/session.php" method="post">
		<b>�������� � �������!</b><br>
		<hr>
		<input name="exit" type="submit" autofocus value="������ �����"><br>					
	</form>
';
echo $login_form;
}
?>