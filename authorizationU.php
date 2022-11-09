<?php 
header('Content-Type: text/html; charset=utf-8');
session_start();
?>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
*{text-overflow: ellipsis;}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body style="background: #FEFEFE; height: 2000px; overflow: hidden;">
	<img src="images/back4.png" style="width: 2000px; height: 1200px; left: -10px; top: -10px;">
	<form method="POST" accept-charset="utf8">
		<div id="UsersList" class="mediumBlocks forMOVE" style="left: 650px; top: 180px; overflow-y: hidden; background-color: #363537; display: flex; flex-direction: column; align-items: center;">
			<div style="height: 60px; width: 200px; position: relative; left: -115px; top: 0px;">
				<img id="Logotype" src='images/Logo.png' style="left: 90px; bottom: 2px; width: 60px; height: 60px;">
				<span style="bottom: 7px; left: 153px; font-family: 'Anton'; font-size: 23pt; color: #EE0D61;">Deal&Products</span>
			</div>
			<span id="logS" class="redTextNorm" style="top: 152px; left: 105px;">Логин:</span>
			<span id="keyN" class="redTextNorm" style="top: 152px; left: 110px;">Ключ:</span>
					<input required class="backForms" type="text" name="login1" style="background-color: white; border-width: 0px; color: black; font-size: 13pt; position: relative; top: 40px; padding: 3px 7px 1px 7px; padding-bottom: 5px; width: 260px; height: 30px;" maxlength="25">
				<span class="redTextNorm skrit" style="top: 202px; left: 95px;">Пароль:</span>
					<input required class="backForms skrit" type="password" name="pasw2" style="background-color: white; border-width: 0px; color: black; font-size: 13pt; position: relative; top: 60px; padding: 3px 7px 1px 7px; padding-bottom: 5px; width: 260px; height: 30px;" maxlength="45">
				<input type="button" name="enter" class="buttons" value="Войти" style="border-width: 0px; top: 250px; width: 100px; padding-bottom: 9px;">
				<span id="mistake" class="redTextSm" style="width: inherit; text-align: center; top: 320px; color: orange;"></span>
				<div id="KEY" class="buttons" style="background-color: #FFD151; width: 25px; height: 25px; border-radius: 10px; top: 250px; left: 210px; padding: 0px;"><img src="images/key.png" style="width: 24px; height: 24px;"></div>
				<span id="REG" class="redTextSm" style="top: 253px; left: 365px; user-select: none;">У меня нет аккаунта</span>
		</div>
	</form>
	<div id="regBlock">
	</div>
	<span id="back" class="buttons" style="left: 700px; top: 215px; user-select: none;">Назад</span>
<script type="text/javascript">
<?php
if(isset($_SESSION['userKey']))
	{echo 'location.replace("http://localhost/diploma/profileU.php"); document.body.innerHTML="";';} 
?>

$("#regBlock").load('regBlock.php');
$("input").css("outline","none");
$("#regBlock, #back, #keyN").hide();

function showRegBlock()
{
$("#regBlock").toggle();
$("#back").toggle(200,"linear");
;}

function showKey(){
$(".skrit, #logS, #keyN").toggle(200, 'linear');
if($('[name=pasw2]').attr("disabled")==undefined){$('[name=pasw2]').attr("disabled","disabled"); return;}
if($('[name=pasw2]').attr("disabled")!=undefined){$('[name=pasw2]').removeAttr("disabled"); return;}
;}

function authorization(event)
{
$.ajax({
	method: 'POST',
	url: 'authorizationU(server).php', 
	data: $("form").serialize(),
	dataType: 'text',
	success: function(data){
						   if(data==1){$("#mistake").html("Пользователь с таким ником не найден"); return;}
						   if(data==2){$("#mistake").html("Неверный пароль"); return;}
						   if(data==3){$("#mistake").html("Неверный ключ"); return;}
						   location.replace("http://localhost/diploma/profileU.php");
						   ;},
	});
}
$("#KEY").click(showKey);
$("#back, #REG").click(showRegBlock);
$("[name=enter]").click(authorization);
</script>
</body>
</html>