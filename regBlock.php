<?php header('Content-Type: text/html; charset=utf-8');?>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
*{text-overflow: ellipsis;}
</style>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body style="background: #FEFEFE; height: 2000px; overflow: hidden;">
	<img src="images/back4.png" style="width: 2000px; height: 1200px; left: -10px; top: -10px;">
<form id="REGBlock2" method="POST" accept-charset="utf8">	
	<div id="RegList" class="mediumBlocks forMOVE" style="left: 650px; top: 180px; overflow-y: hidden; background-color: #363537; height: 350px;">
		<span color="#EE0D61" class="mainText" style="top: 30px; left: 230px; user-select: none;">Регистрация</span>
		<span class="redTextNorm" style="top: 100px; left: 50px; user-select: none;">Выберите категорию:</span>
		<div id="us1" class="buttons userCat" style="left: 235px; top: 98px; background-color: #1FA637; opacity: 1; user-select: none;">Руководитель<input checked type="radio" name="userc" value="1" style="visibility: hidden;"></div>
		<div id="us2" class="buttons userCat" style="left: 360px; top: 98px; background-color: #3A86FF; opacity: 0.5; user-select: none;">Студент<input type="radio" name="userc" value="2" style="visibility: hidden;"></div>
		<div id="us3" class="buttons userCat" style="left: 440px; top: 98px; background-color: orange; opacity: 0.5; user-select: none;">Специалист<input type="radio" name="userc" value="3" style="visibility: hidden;"></div>
		<span class="redTextNorm" style="left: 50px; top: 150px; user-select: none;">Пол:</span>
		<span class="redTextNorm" style="left: 109px; top: 130px;" value="0">м</span>
			<input type="radio" checked name="men" value="1" style="width: 21px; height: 20px; left: 100px; top: 149px; padding: 3px 7px 1px 7px;">
		<span class="redTextNorm" style="left: 159px; top: 130px;" value="1">ж</span>
			<input type="radio" name="men" value="2" style="width: 21px; height: 20px; left: 150px; top: 149px; padding: 3px 7px 1px 7px;">
		<span class="redTextNorm" style="top: 200px; left: 50px; user-select: none;">Логин:</span>
			<input required class="backForms" type="text" name="login" style="padding: 3px 7px 1px 7px; background-color: white; border-width: 0px; color: black; font-size: 13pt; top: 198px; left: 140px; padding-bottom: 5px; width: 260px; height: 30px;" maxlength="25">
		<span class="redTextNorm" style="top: 250px; left: 50px; user-select: none;">Пароль:</span>
			<input required class="backForms" type="password" name="pasw" style="padding: 3px 7px 1px 7px; background-color: white; border-width: 0px; color: black; font-size: 13pt; top: 248px; left: 140px; padding-bottom: 5px; width: 260px; height: 30px;" maxlength="45">
		<span required class="redTextNorm" style="top: 300px; left: 50px; user-select: none;">E-mail для отправки ключа:</span>
			<input required class="backForms" type="email" name="email" style="padding: 3px 7px 1px 7px; background-color: white; border-width: 0px; color: black; font-size: 13pt; top: 298px; left: 290px; padding-bottom: 5px; width: 260px; height: 30px;" maxlength="85">
		<input type="button" name="enter" class="buttons" value="Зарегистрироваться" style="border-width: 0px; top: 370px; left: 200px; width: 200px; padding-bottom: 12px; padding-top: 2px;">
		<span id="mistakeR" class="redTextSm" style="width: inherit; text-align: center; top: 410px; color: orange;"></span>
	</div>
</form>
<script type="text/javascript">
$(document).ready();
$("input").css("outline","none");
$(".userCat").click(function(){$(".userCat").css("opacity","0.5"); 
							   $(".userCat>input").removeAttr("checked");
							   $(this).css("opacity","1"); 
							   $("#us1, #us2, #us3").attr("checked","0");
							   $("#"+$(this).attr("id")+">input").attr("checked","checked");});

function registration(event)
{
$.ajax({
	method: 'POST',
	url: 'http://localhost/diploma/authorizationU(server).php', 
	data: $("#REGBlock2").serialize(),
	dataType: 'text',
	success: function(data){
						   if(data==11){$("#mistakeR").html("Пользователь с таким ником уже зарегистрирован"); return;}
						   if(data==12){$("#mistakeR").html("Пользователь с таким e-mail уже зарегистрирован"); return;}
						   if(data==13){$("#mistakeR").html("Допустимые символы: .+-@А-яA-z0-9"); return;}
						   if(data==14){$("#mistakeR").html("Введенный e-mail неккоректный"); return;}
						   $("#back, #KEY").click();
						   $("#mistake").html("Пользователь зарегистрирован, на email отправлен ключ подтверждения");
						   ;},
	});
}
$("[value=Зарегистрироваться]").click(registration);
</script>
</body>
</html>