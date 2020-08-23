<?php
	$name=$_POST["name"];
	$surname=$_POST["surname"];
	$password=$_POST["password"];
	$email=$_POST["email"];
	
	if(preg_match_all("/^[А-я]{3,}$/u",$name)){
		echo "Верный ввод.\n";
		echo "<br></br>";
	}
	else{
		echo "Неверно ввели имя.\n";
		echo "<br></br>";
	}
	
	if(preg_match_all("/^[А-я]{3,}$/u",$surname)){
		echo "Верный ввод.\n";
		echo "<br></br>";
	}
	else{
		echo "Неверный ввод фамилии.\n";
		echo "<br></br>";
		}

	if(preg_match("/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/u",$password)){
		echo "Верный ввод.\n";
		echo "<br></br>";
	}
	else{
		echo "Неверный ввод пароля.\n";
		echo "<br></br>";
	}
	
	if(preg_match("/^[A-z]([\w]*\-*[\w]+\.)*[\w]+@[A-z]+([A-z]+)*\.+[A-z]{2,}$/",$email)){
		echo "Верный ввод.\n";
		echo "<br></br>";
	}
	else
		echo "Неверный ввод почты.\n";
?>