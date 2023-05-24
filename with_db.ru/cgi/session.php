#!/usr/bin/php
<?php
session_start(); 
  		
if ($_POST['exit']){           
	session_unset();
	header('Location: http://www.with_db.ru:85/index.html');			
}

if ($_POST['enter']){
	mysql_connect("localhost", "root","") or die(mysql_error());	
	mysql_select_db("mysql") or die(mysql_error());
	$_SESSION['user_enter']=false;
	$P0 = mysql_query("select PASSWORD('".$_POST['password']."')");
	$P1 = mysql_fetch_assoc($P0);
	$P = $P1['PASSWORD(\''.$_POST['password'].'\')'];
	$check_password = mysql_query("SELECT Password,User FROM mysql.user WHERE User='".$_POST['login']."' and Password='".$P."'");
	//$check_password = mysql_query("SELECT Password,User FROM mysql.user WHERE User='".$_POST['login']."'");
    if (mysql_num_rows($check_password)!=0) {
		if ($_POST['login']!="" && $_POST['login']!="root") {
			// Пользователь вошёл в систему:
			$_SESSION['user_enter']=true;
			$_SESSION['user_login']=$_POST['login'];
			$_SESSION['user_password']=$_POST['password'];	
			$_SESSION['fields']=mysql_fetch_assoc(mysql_query("select * from (select * from students.student where student_id=1) S natural join students.address"));
			$_SESSION['fa']=mysql_fetch_assoc(mysql_query("select * from students.address where address_id=1"));
			$_SESSION['fs']=mysql_fetch_assoc(mysql_query("select * from students.student where student_id=1"));
			$_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
		}
		// Хеширование пароля, введённого пользователем, с помощью функции PASSWORD(...):
		/*$P0 = mysql_query("select PASSWORD('".$_POST['password']."')");
		$P1 = mysql_fetch_assoc($P0);
		$P = $P1['PASSWORD(\''.$_POST['password'].'\')'];
		// Получение данных о пользователе:
		while($row = mysql_fetch_assoc($check_password)){
			if ($_POST['login']!="" && $_POST['login']!="root" && $P == $row['Password']){ 
			// Пользователь вошёл в систему:
			$_SESSION['user_enter']=true;
			$_SESSION['user_login']=$_POST['login'];
			$_SESSION['user_password']=$_POST['password'];	
			$_SESSION['fields']=mysql_fetch_assoc(mysql_query("select * from (select * from students.student where student_id=1) S natural join students.address"));
			$_SESSION['fa']=mysql_fetch_assoc(mysql_query("select * from students.address where address_id=1"));
			$_SESSION['fs']=mysql_fetch_assoc(mysql_query("select * from students.student where student_id=1"));
			$_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
			break;
			}
		}*/
	}
	//header("Location: http://www.with_db.ru:85/cgi/session2.php?".session_name()."=".session_id());
	$ABC='
		<form action="http://www.with_db.ru:85/cgi/session2.php" method="post">
			Нажмите "далее", чтобы передать идетификатор сессии методом POST. Так будет безопаснее!<br><br><hr>
			<input autofocus type="submit" name="next" value=Далее>				
		</form>
		';
	echo $ABC;	
}
?>
