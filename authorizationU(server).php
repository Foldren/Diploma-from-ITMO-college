<?php
session_start();
@require_once 'PHPMailer/PHPMailerAutoload.php';
@header('Content-Type: text/html; charset=utf-8');

@$BASE=mysqli_connect("localhost","root","","dealandproducts","3306");
@mysqli_set_charset($BASE, "utf8");

function mailKEY($key, $name, $email)
{
$mail = new PHPMailer;
$mail->CharSet = 'UTF-8';

// Настройки SMTP
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPDebug = 0;

$mail->Host = 'ssl://smtp.yandex.ru';
$mail->Port = 465;
$mail->Username = 'DealANDProducts@yandex.ru';
$mail->Password = 'Log10378';

// От кого
$mail->setFrom('DealANDProducts@yandex.ru', 'Deal&Products');        

// Кому
$mail->addAddress($email);

// Тема письма
$mail->Subject = "Ключ регистрации для {$name}";

// Тело письма
$body = '<p><strong>«Здравствуйте уважаемый пользователь Deal&Products! Вот ваш ключ '.$key.'» </strong></p>';
$mail->msgHTML($body);

if(!$mail->send()){return $mail->ErrorInfo;};
;} 

function randomString($length)
{
$chars='abdefhiknrstyzABDEFGHKNQRSTYZ0123456789';
$numChars = strlen($chars);
$string='';
for ($i = 0; $i < $length; $i++){
	$string.=substr($chars, rand(1, $numChars) - 1, 1);
	}
return $string;
}

function authorization()
{
global $BASE;
@$logCheck=mysqli_fetch_row(mysqli_query($BASE, "select id, keyREG from user where login='{$_POST["login1"]}';"));
@$PassCheck=mysqli_fetch_row(mysqli_query($BASE, "select id from user where login='{$_POST["login1"]}' and password='{$_POST["pasw2"]}';"));
if(($logCheck[1]!="0")||($logCheck[0]==""))
	{session_destroy(); return 1;}//такого ника не существует
else if($PassCheck[0]=="")
	{session_destroy(); return 2;}//неверный пароль
@mysqli_query($BASE, "update user set status='1' where id={$logCheck[0]};");
$_SESSION["userKey"]=$logCheck[0];
$_SESSION['statMenu']=1;
return $PassCheck[0];
;}
function registration($TYPER)
{
global $BASE;
if($TYPER==0)//отправка ключа на почту
	{
	session_destroy();
	@$logCheck=mysqli_fetch_row(mysqli_query($BASE, "select id from user where login='{$_POST["login"]}';"));
	@$mailCheck=mysqli_fetch_row(mysqli_query($BASE, "select id from user where email='{$_POST["email"]}';"));
	$message=randomString(25);
	if($logCheck[0]!="")
		{return 11;}//есть такой логин
	if($mailCheck[0]!="")
		{return 12;}//есть такой мэйл
	if((preg_match("/^[a-zA-ZА-я0-9\.@+-]{1,25}$/", $_POST["login"])==false)||(preg_match("/^[a-zA-ZА-я0-9\.@+-]{1,45}$/", $_POST["email"])==false)||(preg_match("/^[a-zA-ZА-я0-9\.@+-]{1,85}$/", $_POST["pasw"])==false))
		{return 13;}
	if(mailKEY($message, $_POST["login"], $_POST["email"])!="")
		{return 14;}//неккоректный мэйл
	@mysqli_query($BASE, "insert into user(type, date_reg, sex, login, password, keyREG, email) values('{$_POST["userc"]}', CURDATE(), '{$_POST["men"]}','{$_POST["login"]}','{$_POST["pasw"]}','".$message."','{$_POST["email"]}');");
	return 1;//зарегистрирован
	;}
else if($TYPER==1)//по ключу
	{
	@$keyCheck=mysqli_fetch_row(mysqli_query($BASE, "select id from user where keyREG='{$_POST["login1"]}';"));
	if($_POST["login1"]=="0" || $keyCheck[0]=="")
		{return 3;}//неверный ключ
	@mysqli_query($BASE, "update user set keyREG='0' where id={$keyCheck[0]};");
	$_SESSION["userKey"]=$keyCheck[0];
	$_SESSION['statMenu']=1;
	mkdir("users/{$keyCheck[0]}", 0700);
	mkdir("users/{$keyCheck[0]}/portf", 0700);
	// copy("images/Anonymous.png","users/{$keyCheck[0]}/Anonymous.png");
	return $keyCheck[0];//подтвержден (id)
	;}	
;}

if(isset($_POST['pasw2'])){echo authorization(); die();}
if(isset($_POST['login1'])){echo registration(1); die();}
if(isset($_POST['email'])){echo registration(0); die();}
mysqli_close($BASE);
?>
