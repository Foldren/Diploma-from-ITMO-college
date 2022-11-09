<?php
header('Content-Type: text/html; charset=utf-8');
$BASEMB=mysqli_connect("localhost","root","","dealandproducts","3306");
mysqli_set_charset($BASEMB, "utf8");
session_start();

if(isset($_POST['loadDialogs']))
	{
	$queryD=@mysqli_query($BASEMB, "select user.id, message.id_recipient, user.login, user.status as 'userSt', user.type, user.sex, message.time as 'timecheck', message.status as 'mesSt', date_format(message.time,'%e') as 'date', date_format(message.time,'%c') as 'month', message.content, message.time from user, message where ((user.id=message.id_user and message.id_recipient={$_SESSION['userKey']}) or (user.id=message.id_recipient and message.id_user={$_SESSION['userKey']})) and (message.visibleU=0 or message.visibleU={$_SESSION['userKey']}) order by message.time desc;");
	$dialogs=mysqli_fetch_all($queryD, MYSQLI_BOTH);
	$dialogs['countD']=count($dialogs);
	echo json_encode($dialogs);
	@mysqli_close($BASEMB);
	die();
	;}
if(isset($_POST['getUAv']))
	{
	for($a=0; $a<=count($_POST['getUAv']); $a++){
		$wayAvatar[$a]=@glob("users/{$_POST['getUAv'][$a]}/{*.png,*.bmp,*.jpeg,*.jpg}", GLOB_BRACE)[0]; 
		if(!$wayAvatar[$a]){$wayAvatar[$a]="images/Anonymous.jpg";}}
	echo json_encode($wayAvatar);
	@mysqli_close($BASEMB);
	die();
	;}
if(isset($_POST['loadMess']))
	{
	@mysqli_query($BASEMB,"update message set status=1 where id_recipient={$_SESSION['userKey']} and id_user={$_POST['loadMess']};");
	$queryM=@mysqli_query($BASEMB,"select id_user, content, time_format(time, '%H:%i') as 'timeM', date_format(time, '%e-%m-%Y') as 'timeY', date_format(time, '%Y%m%d') as 'dayB' from message where ((id_user={$_POST['loadMess']} and id_recipient={$_SESSION['userKey']}) or (id_user={$_SESSION['userKey']} and id_recipient={$_POST['loadMess']})) and (message.visibleU=0 or message.visibleU={$_SESSION['userKey']}) order by time;");
	$messChUs=mysqli_fetch_all($queryM, MYSQLI_BOTH);
	$messChUs['countM']=mysqli_num_rows($queryM);
	$messChUs['avatar']=@glob("users/{$_POST['loadMess']}/{*.png,*.bmp,*.jpeg,*.jpg}", GLOB_BRACE)[0]; 
		if(!$messChUs['avatar']){$messChUs['avatar']="images/Anonymous.jpg";}
	echo json_encode($messChUs);
	@mysqli_close($BASEMB);
	die();
	;}
if(isset($_POST['sentMess']))
	{
	@mysqli_query($BASEMB,"insert into message(id_user, id_recipient, content, time) values('{$_SESSION['userKey']}', '{$_POST['idPay']}', '{$_POST['sentMess']}', NOW());");
	@mysqli_close($BASEMB);
	echo $_POST['sentMess'];
	die();
	;}
if(isset($_POST['deleteDUs']))
	{
	@mysqli_query($BASEMB, "delete from message where visibleU={$_SESSION['userKey']} and ((id_user={$_POST['deleteDUs']} and id_recipient={$_SESSION['userKey']}) or (id_user={$_SESSION['userKey']} and id_recipient={$_POST['deleteDUs']}));");
	@mysqli_query($BASEMB,"update message set visibleU={$_POST['deleteDUs']} where (id_user={$_POST['deleteDUs']} and id_recipient={$_SESSION['userKey']}) or (id_user={$_SESSION['userKey']} and id_recipient={$_POST['deleteDUs']});"); 
	echo $_POST['deleteDUs']; 
	@mysqli_close($BASEMB);
	die();
	;}
?>


