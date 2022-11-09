<?php
header('Content-Type: text/html; charset=utf-8');
$BASE=mysqli_connect("localhost","root","","dealandproducts","3306");
mysqli_set_charset($BASE, "utf8");
session_start();

if(isset($_POST['prilULoad']))
	{
	$fileT=$_POST['filesTypes'];
	if($fileT==0){ echo 4; die(); }
	while($fileT!=1)
		{
		$typeF=$_FILES['addFILE'.$fileT]['type'];
		if(($typeF!="image/jpeg") && ($typeF!="image/jpg") && ($typeF!="image/bmp") && ($typeF!="image/png")){ echo 1; die(); }
		if($_FILES['addFILE'.$fileT]['size']>10000000){ echo 2; die(); }
		$fileT--;
		;}
	$fileT=$_POST['filesTypes'];
	while($fileT!=1)
		{
		if($_FILES['addFILE'.$fileT]==""){continue;}
		$nameF=$_POST['nameSump'.$fileT];
		move_uploaded_file($_FILES['addFILE'.$fileT]['tmp_name'], "users/{$_POST['prilULoad']}/portf/".$nameF.".".substr($_FILES['addFILE'.$fileT]['type'],6));
		$fileT--;
		;}
	if($_FILES['fileAvatar']['name']!='')
		{
		$typeA=$_FILES['fileAvatar']['type'];
		if(($typeA!="image/jpeg") && ($typeA!="image/jpg") && ($typeA!="image/bmp") && ($typeA!="image/png")){ echo 1; die(); }
		$urlAv=@glob("users/{$_POST['prilULoad']}/{*.png,*.bmp,*.jpeg,*.jpg}", GLOB_BRACE)[0];
			if($urlAv)
				{unlink($urlAv);}
		move_uploaded_file($_FILES['fileAvatar']['tmp_name'], "users/{$_POST['prilULoad']}/{$_FILES['fileAvatar']['name']}");
		;}
	@mysqli_close($BASE);
	echo 3;
	die();
	;}
if(isset($_POST['prilOLoad']))
	{
	$fileT=$_POST['filesTypes'];
	if($fileT==0){ echo 4; die(); }
	while($fileT!=1)
		{
		$typeF=$_FILES['addFILE'.$fileT]['type'];
		if(($typeF!="image/jpeg") && ($typeF!="image/jpg") && ($typeF!="image/bmp") && ($typeF!="image/png") && ($typeF!="application/vnd.openxmlformats-officedocument.wordprocessingml.document") && ($typeF!="application/pdf") && ($typeF!="application/msword") && ($typeF!="text/plain")){ echo 1; die(); }
		if($_FILES['addFILE'.$fileT]['size']>500000000){ echo 2; die(); }
		$fileT--;
		;}
	$fileT=$_POST['filesTypes'];
	while($fileT!=1)
		{
		if($_FILES['addFILE'.$fileT]==""){continue;}
		$nameF=$_POST['nameSump'.$fileT];
		move_uploaded_file($_FILES['addFILE'.$fileT]['tmp_name'], "orders/{$_POST['prilOLoad']}/portf/".$nameF.".".substr($_FILES['addFILE'.$fileT]['type'], strpos($_FILES['addFILE'.$fileT]['type'],'/')+1));
		$fileT--;
		;}
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['loadStepsUPart']))
	{
	for($i=0; $i!=$_POST['typesLS']; $i++)
		{
		//CHANGE PROGRESS
		if(isset($_POST['SP'.$i]))
			{@mysqli_query($BASE, "update step_order set percents=".$_POST['SP'.$i]." where id_order={$_SESSION['zakazChoose']} and id_user={$_SESSION['userKey']} and name='".$_POST['FST'.$i]."';");}
		//LOAD FILES
		if($_FILES['FS'.$i]==""){continue;}
		if($_FILES['FS'.$i]['size']>2000000000){ echo 1; die(); }
		$urlSF=@glob("orders/{$_SESSION['zakazChoose']}/steps/".$_POST['FST'.$i]."/{$_SESSION['userKey']}/*")[0];
		unlink($urlSF);
		move_uploaded_file($_FILES['FS'.$i]['tmp_name'], "orders/{$_SESSION['zakazChoose']}/steps/".$_POST['FST'.$i]."/{$_SESSION['userKey']}/".$_FILES['FS'.$i]['name']);
		;}
	@mysqli_close($BASE);
	die(); 
	;}
?>