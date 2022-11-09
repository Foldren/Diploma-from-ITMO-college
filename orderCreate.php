<?php 
header('Content-Type: text/html; charset=utf-8');
@$BASECR=mysqli_connect("localhost","root","","dealandproducts","3306");
@mysqli_set_charset($BASECR, "utf8");
session_start();
if(isset($_SESSION['userKey'])){$idManager=$_SESSION['userKey'];}
?>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
*{text-overflow: ellipsis;}
.TA{
	outline: none; 
	resize: none; 
	border: 0px solid #979DA5; 
	border-radius: 10px; 
	padding-left: 5px; 
	line-height: 1.2;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body style="background: #FEFEFE; height: 3000px; overflow-x: hidden">
<script type="text/javascript">
//ADD AT ALL WINDOWS //////////////////////////////////////////
<?php
if(!isset($_SESSION['userKey']))
	{echo 'location.replace("http://localhost/diploma/authorizationU.php"); document.body.innerHTML="";'; session_destroy();} 
@mysqli_query($BASEZ, "update user set status={$_SESSION['userStatusEXIT']} where id={$_SESSION['userKey']};");
//////////////////////////////////////////////////////////////
?>
</script>
	<img src="images/back4.png" style="width: 1900px; height: 2300px; position: fixed;">
	<form id="formOrdCreate" method="POST" accept-charset="utf8"></form>
	<div id="zakazInf" class="largeBlocks forMOVE" style='left: 530px; top: 120px; height: 950px; overflow: hidden; padding: 50px; width: 1000px;'>
		<span class="mainText" style="top: 40px; font-size: 19pt; width:inherit; text-align: center;">Добавление заказа</span>
		<hr color='#F5F6F5' noshade style="width: 1000px; size: 1px; top: 80px; border-top: 1px dashed red;">
		<span class="redTextSm" style="top: 140px;">Название:</span><input name="nameOrdCr" type="text" class="text" value="" style="left: 160px; top: 139px; padding: 0px; padding-left: 5px; border-radius: 10px; border: 1px solid #979DA5; width: 580px;" maxlength="76" form="formOrdCreate">
		<span class="redTextSm" style="top: 190px;">Тип:</span>
			<select name="CordS" value="" style="outline: none; left: 160px; top: 189px; font-size: 11pt; border: 1px solid #979DA5; border-radius: 5px;" form="formOrdCreate">
				<option selected disabled>Выбрать</option><option value="1">WEB</option><option value="2">DES</option><option value="3">MOB</option>
			</select>
		<span class="redTextSm" style="top: 240px;">Вид:</span><input name="typeOrdCr" type="text" class="text" style="left: 160px; top: 239px; padding: 0px; padding-left: 5px; border-radius: 10px; border: 1px solid #979DA5; width: 260px;" maxlength="28" form="formOrdCreate">
		<span class="redTextSm" style="top: 290px;">Срок:</span><input type="text" name="periodOrdCr" id="period" class="textSm" style="color: black; left: 160px; top: 290px; padding: 0px; padding-left: 5px; border-radius: 10px; border: 1px solid #979DA5; width: 75px;" onkeypress="this.value=this.value.substring(0,2);" onkeyup="if(!this.value.match(/^\d{1,3}$/)){ this.value=this.value.substring(0, this.value.length-1); }" form="formOrdCreate">
		<span class="mediumText" style="text-align: center; width: inherit; text-align: center; top: 390px;">Техническое задание</span>
		<hr color='#F5F6F5' noshade style="width: 1000px; size: 1px; top: 430px; border-top: 1px dashed red;">
			<textarea class="areatext" name="techSpecOrdCr" style="height: 230px; top: 465px; width: inherit; padding: 25px; color: black; font-size: 13pt; outline: none; resize: none; border: 1px solid #979DA5; border-radius: 10px; padding: 7px; line-height: 1.2;" onload="if(this.scrollTop>0){this.style.height=this.scrollHeight+'px';}" onkeyup="if(this.scrollTop>0){this.style.height=this.scrollHeight+'px'; $('#zakazInf').height(1620+$('#tech_spec>textarea').height()-50); }" maxlength="1290" form="formOrdCreate"></textarea>
		<input type="button" id="CreateOrder" class='buttons' style="left: 482px; bottom: 80px; border: 0px; padding-bottom: 5px; height: 27px;" value="Сформировать">
		<span class="redTextSm" style="text-align: center; width: inherit; text-align: center; bottom: 220px;">Приложения, функции и этапы будут доступны для добавления после формирования заказа</span>
		<span id="mistakeFP" class="redTextSm" style="text-align: center; bottom: 86px; right: 640px; color: #E8BE4A;"></span>
	</div>
	<div id="menuBlock"></div>
<script type="text/javascript">
$(document).ready(function(){$("#menuBlock").load('MENU.php',{id: "<?php if(isset($_SESSION['userKey'])){echo $_SESSION['userKey'];} ?>"}); 
							////////////////////////ADD AT ALL WINDOWS/////////////////////////////////////////////
							$(window).on('unload', function(){ $.ajax({method: 'POST', url: 'MAIN(server).php', data: {exit: 2}}); }); 
							});
$("#CreateOrder").click(function(){
	if($("[name=nameOrdCr]").val()=="" || $("[name=CordS]").val()=="null" || $("[name=typeOrdCr]").val()=="" || $("[name=periodOrdCr]").val()=="" || $("[name=techSpecOrdCr]").val()=="")
		{$("#mistakeFP").html("Заполнены не все поля"); return;}
	$.ajax({method: 'POST', url: 'MAIN(server).php', data: $("form").serialize(), dataType: 'text', 
		success: function(data){ 
			if(data==1){$("#mistakeFP").html("Заказ с таким названием уже существует"); return;} 
			alert("Заказ сформирован успешно");
			location.replace("http://localhost/diploma/orderU.php");
			} }); 
});
<?php @mysqli_close($BASEP); ?>///////////////// ADD ON ALL WINDOWS /////////////////////////////////////////////
</script>
</body>
</html>