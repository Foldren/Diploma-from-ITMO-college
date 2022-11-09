<?php 
header('Content-Type: text/html; charset=utf-8');
@$BASEZ=mysqli_connect("localhost","root","","dealandproducts","3306");
@mysqli_set_charset($BASEZ, "utf8");
session_start();
if(isset($_SESSION['zakazChoose'])){$idchOrder=$_SESSION['zakazChoose']; }
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
<body style="background: #FEFEFE; height: 3000px; overflow-x: hidden" onloadstart="$(this).hide();">
<script type="text/javascript">
//ADD AT ALL WINDOWS //////////////////////////////////////////
<?php
if(!isset($_SESSION['userKey']))
	{echo 'location.replace("http://localhost/diploma/authorizationU.php"); document.body.innerHTML="";'; session_destroy();} 
@mysqli_query($BASEZ, "update user set status={$_SESSION['userStatusEXIT']} where id={$_SESSION['userKey']};");
?>
//////////////////////////////////////////////////////////////
<?php
if(isset($_SESSION['userKey']))
{
$pass=0; 
$type=mysqli_fetch_row(@mysqli_query($BASEZ, "select type from user where id={$_SESSION['userKey']};"))[0];
$notice=mysqli_fetch_row(@mysqli_query($BASEZ, "select noticeADD from participant where id_user={$_SESSION['userKey']} and id_order={$_SESSION['zakazChoose']};"))[0];
$status=mysqli_fetch_row(@mysqli_query($BASEZ, "select status from order_app where id={$_SESSION['zakazChoose']};"))[0];
if($status==1)
	{
	if($notice!=1 && $notice!=null){
		//"INVpartic";
		goto exitP;}
	if($notice==1){
		if($type==1){$pass=1;}//"manager"
		if($type!=1){$pass=2;}//"participant"
		goto exitP;}
	if($type==1){
		$pass=3; goto exitP;}//"FORmanager"
	if($type!=1){
		$pass=4; goto exitP;}//"FORparticipant"
	;}
$pass=5;//unactive order
exitP:
}
?>
</script>
	<img src="images/back4.png" style="width: 1900px; height: 2300px; position: fixed;">
	<form id="formOrder" method="POST" accept-charset="utf8"></form>
	<div id="zakazInf" class="largeBlocks forMOVE" style='left: 530px; top: 120px; height: 1150px; overflow: hidden; padding: 50px; width: 1000px;'>
<!-- HEAD -->
		<div id="headOrder">
			<span class="mainText" style="width: 120px; text-align: center; top: -10px; user-select: none;">Заказ</span>
			<span class="redTextSm" style="width: 120px; left: 150px; top: 2px; font-size: 13pt; user-select: none;">Название:</span>
			<textarea id="nameZakaz" class="areatext" name="txtareaName" form="formOrder" maxlength="75" style="width: 360px; color: black; left: 245px; top: 1px; font-size: 13pt; outline: none; height: 47px; resize: none; border: 0px solid #979DA5; border-radius: 10px; padding-left: 5px; line-height: 1.2;"><?php echo mysqli_fetch_row(@mysqli_query($BASEZ, "select name from order_app where id='{$idchOrder}';"))[0]; ?></textarea>
			<span class="redTextSm" style="width: 120px; left: 650px; top: 2px; font-size: 13pt; user-select: none;">Руководитель:</span>
			<div id="iconM" class="userIconT" style="top: 1px; left: 790px; background-color: #1FA637;"><img src='images/zakazchik.png' style="width: 21px; height: 21px; left: 3px;"></div>
			<a id="nameRuk" onclick="$.ajax({method: 'POST', url: 'MAIN(server).php', data: {chooseRUKNow: $(this).html()} });" href="http://localhost/diploma/profileU.php" class="text" style="width: 250px; color: black; left: 825px; top: 3px; font-size: 13pt; color: purple; text-decoration: none;">
				<?php echo mysqli_fetch_row(@mysqli_query($BASEZ, "select user.login from participant, user where user.id=participant.id_user and participant.manager=1 and participant.id_order='{$idchOrder}' and noticeADD=1;"))[0]; ?>
			</a>
			<hr color='#F5F6F5' noshade style="width: 1000px; size: 1px; top: 55px; border-top: 1px dashed red;">
		</div>
<!-- ZAKAZ INFO -->
		<span class="mediumText" style="width: 120px; left: 483px; text-align: center; top: 130px; user-select: none;">Исполнители</span>
		<div style="top: 170px; width: 950px; height: 110px; padding-left: 45px;">
			<div id="flexPartic" style="width: inherit; height: inherit; display: flex; direction: row; justify-content: center;">
				<!-- PARTICIPANTS HERE -->
			</div>
			<hr color='#F5F6F5' noshade style="width: 1000px; size: 1px; top: 120px; border-top: 1px dashed red; left: 0px;">
		</div>
<!-- MAIN INFO -->
		<div id="Maininf" style="left: 0px; top: 330px;">
			<span class="redTextSm" style="left: 50px; top: 0px;">Общий прогресс:</span>
			<div class="progressBar" style="left: 180px; top: 0px;">
				<div style="width: 0px; height: inherit; background-color: #09E85E; left: 0px; top: 0px;">
					<span style="top: 0px; color: #09E85E; font-size: 11pt;">%</span>
				</div>
			</div>
			<span class="redTextSm" style="left: 300px; top: 0px;">Дата начала:<span id="date_start" style="color: black; left: 98px; top: 0px;"></span></span>
			<span class="redTextSm" style="left: 490px; top: 0px;">Срок:<input type="text" name="inpPeriod" form="formOrder" id="period" class="textSm" style="color: black; left: 40px; top: 0px; padding: 0px; padding-left: 5px; border-radius: 10px; border: 0px solid #979DA5; width: 75px;" onkeypress="this.value=this.value.substring(0,2);" onkeyup="if(!this.value.match(/^\d{1,3}$/)){ this.value=this.value.substring(0, this.value.length-1); }" readonly></span>
			<div class="redTextSm" style="left: 610px; top: 0px;">Вид:<textarea name="txtAreaV" form="formOrder" type="areatext" id="typeHT" class="textSm" maxlength="28" style="color: black; left: 34px; top: 1px; font-size: 11pt; padding: 0px; padding-left: 5px; border-radius: 10px; border: 0px solid #979DA5; text-overflow: clip; outline: none; height: 47px; resize: none; line-height: 1.1; white-space: normal;" readonly></textarea></div>
			<div class="redTextSm" style="left: 850px; top: 0px;">Тип:<div id="typePr" class="buttons" style="left: 40px; top: -5px; padding: 5px 6px 0px 6px;"></div></div>
			<select name="selectV" form="formOrder" style="outline: none; left: 890px; top: -1px; font-size: 11pt; border: 1px solid #979DA5; visibility: hidden; border-radius: 5px;">
				<option value="1">WEB</option><option value="2">DES</option><option value="3">MOB</option>
			</select>
		</div>
<!-- FUNCTIONS -->
		<div id="functionsZ" style="left: 50px; top: 380px; width: 850px; height: 55px; padding-left: 80px; overflow: hidden;">
			<span class="redTextSm" style="left: 0px; top: 1px;">Функции:</span>
			<!-- FUNCTIONS HERE -->
			<div id="addFUNC" class="buttons" style="display: inline-block; height: 20px; padding: 2px 6px 3px 6px; width: 13px; position: relative; margin-bottom: 5px; border-radius: 10px; visibility: hidden;">&nbsp<hr color="#F5F6F5" noshade style="width: 11px; height: 1px; top: 3px; left: 6px;"><hr color="#F5F6F5" noshade style="height: 11px; width: 1px; left: 11px; top: -2px;">
			</div>
		</div>
<!-- CHOOSE ISPOLN -->
		<div id="chooseIsp" style="right: 50px; top: 460px; width: 300px; height: 37px; visibility: hidden;">
			<span class="redTextSm" style="right: 130px; top: 8px;">Прогресс исполнителя:</span>
			<div class="smallBlocks" style="background-color: #EE0D61; overflow-y: none; right: 0px; height: 36px; width: 100px;">
				<div class="userIconT" style="top: 5px; left: 7px;"><img src="images/student.png" style="width: 21px; height: 21px; left: 3px;"></div>
				<span style="top: 8px; left: 40px; color: white;"></span>
			</div>
		</div>
<!-- STEPS PROGRESS -->
		<div id="stepsProgressBlock" class="scrollPrS" style="top: 510px; left: 0px; width: 1020px; height: 400px; border-top: 1px solid #F3F4F3; border-top: 1px solid #F3F4F3; padding: 20px 40px; background-color: #F7FFF6; overflow: auto; visibility: hidden;">
			<span class="text" style="color: #26A96C; left: 85px; user-select: none;">Прогресс выполнения</span>
			<span class="text" style="left: 450px; color: #26A96C; user-select: none;">Название этапа</span>
			<span class="text" style="left: 880px; color: #26A96C; user-select: none;">Файлы</span>
			<img id="addSTEP" src="images/addIc.png" style="left: 15px; top: 19px; width: 25px; height: 25px; visibility: hidden;">
			<div id="flexStepsU" style="top: 80px; width: inherit; height: auto; display: flex; flex-direction: column;">
				<!-- STEPS USERS HERE -->
			</div>
		</div>
		<div id="redactSTEPS" class="buttons" style="right: 103px; top: 460px; width: 120px; text-align: center; padding-top: 4px; background-color: #26A96C; display: none;">Редактировать</div>
<!-- TECHSPEC -->
		<div id="tech_spec" style="width: 1000px; height: 600px; top: 468px;">
			<span class="mediumText" style="text-align: center; left: 410px; user-select: none;">Техническое задание</span>
			<hr color='#F5F6F5' noshade style="width: 1000px; size: 1px; top: 40px; border-top: 1px dashed red;">
			<textarea class="areatext" name="techSpec" form="formOrder" style="height: 130px; top: 55px; width: inherit; padding: 25px; color: black; font-size: 13pt; outline: none; resize: none; border: 0px solid #979DA5; border-radius: 10px; padding: 7px; line-height: 1.2;" onload="if(this.scrollTop>0){$(this).style.height=this.scrollHeight+'px';}" onkeyup="if(this.scrollTop>0){this.style.height=this.scrollHeight+'px'; $('#zakazInf').height(1620+$('#tech_spec>textarea').height()-50); }" readonly maxlength="1290"></textarea>
		</div>
<!-- PRILOSHENIA -->
		<span class="mediumText" style="text-align: center; bottom: 540px; left: 494px; user-select: none;">Приложения</span>
		<div id="scrollSmall" style="bottom: 200px; width: 1000px; height: 300px; overflow-x: auto; overflow-y: hidden;">
			<div id="PRILOSHflexOrd" style="height: inherit; display: flex; flex-direction: row; padding-right: -120px;">
				<!-- SUMMPLEMENTS HERE -->
			</div>
		</div>
		<div id="REDACT" class="buttons" style="left: 475px; bottom: 80px; width: 130px; text-align: center; padding-top: 4px; display: none; user-select: none;">Редактировать</div>
		<div id="dateEND" class="redTextSm" style="left: 445px; bottom: 80px; text-align: center; padding-top: 4px; color: gray;">Дата завершения: <?php $dateEnd=mysqli_fetch_row(@mysqli_query($BASEZ, "select date_end from order_app where id={$_SESSION['zakazChoose']};"))[0]; echo $dateEnd; ?></div>
		<div id="FinishOrd" class="buttons" style="left: 615px; bottom: 80px; width: 130px; text-align: center; padding-top: 4px; visibility: hidden; background-color: #09E85E; user-select: none;">Завершить заказ</div>
		<span id="DelOrd" class="text" style="left: 860px; bottom: 87px; font-size: 10pt; color: gray; visibility: hidden; user-select: none;">Удалить заказ</span>
		<span id="mistakePU" class="text" style="left: 50px; bottom: 87px; color: #E8BE4A;"></span>
	</div>
	<img id="UIaddFunc2" src="images/funcTriag.png" style="left: 0px; top: 0px; display: none;">
	<div id="UIaddFunc" class="smallBlocks" style="width: 400px; overflow: hidden; background-color: #363537; left: 0px; top: 0px; display: none;">
		<div id="findFunc" class="buttons textSm" style="overflow: hidden; left: 10px; top: 11px; background-color: #EE0D61; width: 45px; height: 20px; text-align: center; padding-bottom: 2px; padding-top: 0px; user-select: none;">Поиск</div>
		<input name="nameCrFunc" placeholder="Введите название функции..." class="backForms text" id="findzakaz" style="height: 23px; width: 280px; background-color: #FEFEFE; left: 80px; top: 10px; padding: 0px 15px 3px 35px; border: 1px solid #B1B2B1; color: black; font-size: 12pt;" maxlength="17">
			<img src="images/findimage.png" style="left: 88px; top: 14px; width: 15px; height: 15px; opacity: 0.2;">
		<div id="addFUNCL" class="buttons" style="left: 365px; top: 10px; height: 20px; padding: 2px 6px 3px 6px; width: 13px; position: relative; margin-bottom: 5px; border-radius: 10px;">&nbsp<hr color="#F5F6F5" noshade style="width: 11px; height: 1px; top: 3px; left: 6px;"><hr color="#F5F6F5" noshade style="height: 11px; width: 1px; left: 11px; top: -2px;">
			</div>
		<span class="redTextSm" style="left: 30px; top: 60px; user-select: none;">Название</span>
		<span class="redTextSm" style="left: 240px; top: 60px; user-select: none;">Описание</span>
		<hr color='#363537' noshade style="width: 375px; size: 1px; left: 10px; top: 40px; border-top: 1px dashed red;">
		<div class="scrollSmall" style="left: 10px; top: 90px; width: 380px; height: 150px; overflow-y: auto; overflow-x: hidden;">
			<div id="flexFunct" style="display: flex; flex-direction: column; width: inherit; height: auto;">
				<!-- FUNCTION FOR SEARCH HERE -->
			</div>
		</div>
		<textarea name="infoCrFunc" placeholder="Введите описание функции..." style="padding-left: 5px; color: black; font-size: 13pt; outline: none; resize: none; border: 1px solid #979DA5; border-radius: 10px; line-height: 1.1;  left: 80px; top: 50px; width: 280px; height: 70px; visibility: hidden; white-space: normal; font-size: 12pt;" maxlength="66"></textarea>
		<span id="mistakeAddF" class="textSm" style="color:#E8BE4A; top: 140px; left: 110px;"></span>
		<span id='mistakeLoadF' class="textSm" style="color:#E8BE4A; top: 30px; font-size: 9pt; left: 20px;"></span>
	</div>
	<div id="menuBlock"></div>
<script type="text/javascript">
loadSumpls=0;
loadFunc=0;
filesCh=1;
funcCh=0;
addStep=0;
loadStep=0;
loadIsp=0;
///////////////////////// LOAD /////////////////////////////
$(document).ready(function(){$("#menuBlock").load('MENU.php',{id: "<?php if(isset($_SESSION['userKey'])){echo $_SESSION['userKey'];} ?>"}); 
							////////////////////////ADD AT ALL WINDOWS/////////////////////////////////////////////
							$(window).on('unload', function(){ $.ajax({method: 'POST', url: 'MAIN(server).php', data: {exit: 2}}); }); 
							});

$("#addFUNC").click(function(){
							$("#UIaddFunc").css({"top": $("#addFUNC").offset().top+35, "left": $("#addFUNC").offset().left-173});
							$("#UIaddFunc2").css({"top": $("#addFUNC").offset().top+17, "left": $("#addFUNC").offset().left-18});
							$("#UIaddFunc, #UIaddFunc2").toggle(80,"linear");
							$("#infoCrFunc").css('visibility', 'hidden');});
$("#addFUNCL").click(
function(){
	$("[name=infoCrFunc]").css('visibility', 'visible');
	$("#flexFunct>div").remove();
	$("#UIaddFunc>span:lt(1), #UIaddFunc>img, #UIaddFunc>div:first").hide(); 
	$("#UIaddFunc>input").css('padding-left',5);
	$("#mistakeAddF").html("Введите название функции");
	if($("#UIaddFunc>input").val()!=0 && $("[name=infoCrFunc]").val()!="")
		{
		$.ajax({method: 'POST', 
			url: 'MAIN(server).php', 
			data: {addFuncBut: $("#UIaddFunc>input").val(), FuncInf: $("[name=infoCrFunc]").val()},
			dataType: 'text',
			async: false,
			success: function(data){if(data==1){$("#mistakeAddF").html("Данная функция уже существует"); return; }
									alert("Функция добавлена успешно");
									$("#addFUNC").before('<div class="buttons addFunc" style="display: inline-block; height: 20px; padding: 2px 6px 3px 6px; width: auto; position: relative; margin-bottom: 5px; margin-right: 5px; border-radius: 12px;">'+$("#UIaddFunc>input").val()+'<span style="visibility:hidden">'+$("#UIaddFunc>input").val()+'</span>\
															<img class="deleteImg" src="images\\deleteIc.png"\ onload="$(this).click(deleteAddF);" style="bottom: -4px; right: -4px; width: 18px; height: 18px;">\
					 									 </div>');
									$("[name=infoCrFunc]").val("");
									$("#addFUNC").click();
									funcCh++;
									;}
			});
		;}				
;});

$("#DelOrd").click(function(){
	$.ajax({method: 'POST', 
			url: 'MAIN(server).php', 
			data: {deleteOrderNow: "<?php echo $idchOrder; ?>"},
			success: function() { alert("Заказ удален"); location.replace("http://localhost/diploma/forderU.php"); }
	}); 
});

$("#FinishOrd").click(function(){
	$.ajax({method: 'POST', 
			url: 'MAIN(server).php', 
			data: {finishOrderNow: "<?php echo $idchOrder; ?>"},
			success: function() { alert("Заказ успешно завершен"); location.replace("http://localhost/diploma/forderU.php"); }
	}); 
});

$('#stepsProgressBlock, #chooseIsp').toggle();

$("#addSTEP").click(addStepOrder);
$("#findFunc").click(searchFunc);
$(document).on("change", "[name=addFILE1]", addSumple);
$("#addFUNC").click(loadFuncList);
$("#REDACT").on('click', redactOrd);

/// load funct ////////////////////////////////////////////////////
function deleteLoadF()
{
$(this).parent().find("span").html($(this).parent().find("span").html()+"|delete|");
$(this).parent().hide(); 
;}

$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {loadFunc: "<?php echo $idchOrder; ?>"},
		dataType: 'json',
		success: function(data){for(i=0; i!=data['countF']; i++)
									{
									$('#functionsZ').prepend('<div class="buttons loadFUNC" style="user-select: none; display: inline-block; height: 20px; padding: 2px 6px 3px 6px; width: auto; position: relative; margin-bottom: 5px; margin-right: 5px; border-radius: 12px;">'+data[i]['name']+'<span style="visibility:hidden">'+data[i]['name']+'</span>\
																<img class="deleteImg" src="images\\deleteIc.png"\ onload="$(this).click(deleteLoadF);" style="bottom: -4px; right: -4px; width: 18px; height: 18px; visibility: hidden;">\
															  </div>');
							  		loadFunc++;
							  		;}
							   ;}
		});
/// sumpl user////////////////////////////////////////////////////
function deleteLoadSumpl()
{
$(this).parent().find("textarea").html($(this).parent().find("img").attr("src"));
$(this).parent().css('display','none');
;}

$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {orderPril: "<?php echo $idchOrder; ?>"},
		dataType: 'json',
		success: function(data){if(!data.length){ return; };
								for(j=0; j!=data.length; j++)
								    {
								    a="<a style='width: inherit; height: inherit;' download href='"+data[j]+"'>";
								    $("#PRILOSHflexOrd").append("\
								   		<div id='loadFILE"+j+"' style='position: relative; height: inherit; width: 200px; margin-right: 40px;'>\
											<img class='prilosh' src='"+data[j]+"''>\
											<textarea name='loadSump"+j+"' class='areatext TA' style='width: 190px; top: 220px; left: 5px; text-align: center; height: 50px;' readonly maxlength='40' form='formOrder'>"+data[j].substring(20, data[j].indexOf("."))+"</textarea>\
											<img class='deleteImg' src='images\\deleteIc.png'\
							   			 		onload='$(this).click(deleteLoadSumpl);' style='top: 5px; right: 5px; width: 30px; height: 30px; visibility: hidden;'>\
										</div>\
								   	");
								   	loadSumpls++;
									;}
								for(z=0; z!=$("#PRILOSHflexOrd>div").length; z++)
									{
									srcP=$("#PRILOSHflexOrd>div:eq("+z+")>img:first").attr('src');
									if(srcP.indexOf('.jpeg')==-1 && srcP.indexOf('.jpg')==-1 && srcP.indexOf('.bmp')==-1 && srcP.indexOf('.png')==-1)
										{
										$("#PRILOSHflexOrd>div:eq("+z+")>img:first").after("<div style='background-color:white; width: inherit; height: 200px;'><img src='images/dataFile.png' style='width: inherit; height: 200px;  border-radius: 15px;'></div>");
										$("#PRILOSHflexOrd>div:eq("+z+")>div:first").after("<a download href='"+$("#PRILOSHflexOrd>div:eq("+z+")>img:first").attr('src')+"' style='width: inherit; height: inherit;'>");
										;}
									;}
							   ;}
		});
/////////////////////////////////////////////////////////////////
heightMainOS=$("#zakazInf").height()+520;
heightMainL=$("#zakazInf").height();
function getUsrSU(status)
{
if(status==0){return "images/offlineS.png";}else if(status==1){return "images/onlineS.png";}else if(status==2){return "images/redS.png";}else if(status==3){return "images/busyS.png";}
}

function CreateIconSU(s, type)
{
typeU=new Array();
if(type==1){typeU[0]='#1FA637';}if(type==2){typeU[0]='#3A86FF';}if(type==3){typeU[0]='#FF7F11';}
if(s==0)
	{if(type==1){typeU[1]='images/zakazchik.png';}if(type==2){typeU[1]='images/student.png';}if(type==3){typeU[1]='images/spec.png';};}
if(s==1)
	{if(type==1){typeU[1]='images/zakazchica.png';}if(type==2){typeU[1]='images/studentca.png';}if(type==3){typeU[1]='images/specca.png';};}	
return typeU;
}

function CreateCO(type)
{
if(type==1){return "#5D2E8C WEB";} else if(type==2){return "#00AFB5 DES";} else if(type==3){return " orange MOB";}
}

function deleteLoadStep(Step)
{
$(Step).parent().find("input").val($(Step).parent().find("input").val()+"|delete|");
$(Step).parent().hide(); 
;}

function deleteAddSt(Step)
{
$(Step).parent().remove(); 
addStep--;
;}

prevIsp=new Object();
/// percents and user's files in order /////////////////////////////////////////
function openUSteps(event)
{
if($("#addSTEP").css('visibility')=='visible'){return;}
$("#flexStepsU>div").remove();
if($("#zakazInf").height()==heightMainOS && this==prevIsp)
	{	
	$("#REDACT").show(200, 'linear');
	$("#zakazInf").animate({'height' : heightMainL}, 100);
	$("#tech_spec").animate({'top' : 468}, 100);
	$(this).css({'background-color':'#FFFFFF','color':'black'});
	$('#chooseIsp').css('visibility','visible').toggle();
	$('#stepsProgressBlock').css('visibility','visible').toggle(100,'linear');
	return;
	;}

$("#flexPartic>div").css({'background-color':'#FFFFFF','color':'black'});
$(this).css({'background-color':'#EE0D61', 'color':'white'});	
prevIsp=this;

$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {showSteps: event.data.idU, orderIDFS: "<?php echo $idchOrder;?>"},
		dataType: 'json',
		success: function(data){for(z=0; z!=data['countSt']; z++) 
									{
									if(data[z]["percents"]==undefined){data[z]["percents"]=0;}
									$("#flexStepsU").prepend('<div style="width: inherit; height: 50px; position: relative; display: flex; align-items: center; margin-bottom: 13px;">\
																	<div class="progressStep" style="left: 35px; height: 38px; width: 200px;">\
																		<div style="height: inherit; background-color: #7EE081; left: 0px; top: 0px;">\
																			<span style="top: 9px; color: black; font-size: 13pt; font-family: \'Exo\'">'+data[z]["percents"]+'%</span>\
																		</div>\
																	</div>\
																	<span class="text" style="left: 280px; top: 13px; width: 370px; white-space: normal; text-align:center;">'+data["name"][z]+'</span>\
																	<div style="left: 700px; top: 7px;">\
																		<a class="skritBackOrng" href="'+data[z]["fileN"]+'" download style="left: 0px; width: 30px; height: 30px; background-color: #F4D35E; border-radius: 10px; padding: 2px;">\
																			<img style="width: 30px; height: 30px;" src="images/download.png">\
																		</a>\
																		<span style="left: 40px; top: 5px; width: 270px;" class="text" title="'+data[z]["fileN"].substring(data[z]["fileN"].lastIndexOf("/")+1)+'">'+data[z]["fileN"].substring(data[z]["fileN"].lastIndexOf("/")+1)+'</span>\
																	</div>\
																	<hr color="#F7FFF6" noshade style="width: 785px; size: 1px; left: 37px; top: 48px; border-top: 1px dashed #C3E7D6;">\
															  </div>');

									if(data[z]["fileN"]==''){$('#flexStepsU>div:first>div:eq(1)>a').removeAttr('href');}
									$("#flexStepsU>div:first>.progressStep>div").width(parseInt(data[z]["percents"])*2);
									if(parseInt(data[z]['percents'])>20)
							    		$("#flexStepsU>div:first>.progressStep>div:first>span").css({'right':6, 'color':'white'})
							    	if(parseInt(data[z]['percents'])<=20)
							    		{$("#flexStepsU>div:first>.progressStep>div:first>span").css('left', $("#flexStepsU>div:first>.progressStep>div").width()+5);}
									;}

								for(i=0;i!=10;i++){$(".progressStep").prepend("<div style='left:"+i*20+"px; height: inherit; top: 0px; width: 1px; background-color: #F3F4F3'></div>");}
								$('#chooseIsp>div>span').html(data['login']);
								$('#chooseIsp>div>div>img').attr('src', CreateIconSU(data['sex'], data['type'])[1]);
								$('#chooseIsp>div>div').css('background-color', CreateIconSU(data['sex'], data['type'])[0]);
							   ;}
	});

if($("#zakazInf").height()==heightMainL)
	{
	$("#REDACT").hide(200, 'linear');
	$("#zakazInf").animate({'height' : heightMainOS}, 100);
	$("#tech_spec").css('top',990);
	$('#chooseIsp').css('visibility','visible').toggle();
	$('#stepsProgressBlock').css('visibility','visible').toggle(100,'linear');
	$("#flexStepsU>div").remove();
	return;
	;}

;}

function deleteIspol(event)
{
$(this).parent().find("a").eq(0).html($(this).parent().find("a").eq(0).html()+"|delete|");
$(this).parent().hide();
;}

function sendAddNotice()
{
$.ajax({method: 'POST', 
		url: 'MAIN(server).php',
		data: {addNotice: 1},
		dataType: 'text',
		success: function(data){if(data==1){alert("В заказе достигнуто максимальное число исполнителей"); return;} alert("Запрос отправлен успешно"); location.reload();}
		});
;}

function animateStep()
{
width=event.clientX-613;
if(width==201){width==200;}
$(this).find("div:eq(10)").width(width);

if(width>40)
	{$(this).find("div:eq(10)").find("span:first").css({'left': 'auto', 'right':6, 'color':'white'});}
if(width<=40)
	{$(this).find("div:eq(10)").find("span:first").css({'left': $(this).find("div:eq(10)").width()+5, 'color':'black'});}
$(this).find("span:first").html("%"+parseInt(width/2));
}

function loadStepPartic()
{
if($(this).html()=="Редактировать")
	{
	$(this).html("Сохранить").css('background-color','#3EC0F0');
	$(this).after('<div id="stopRedactSteps" class="buttons" style="right: 253px; top: 460px; width: 70px; text-align: center; user-select: none; padding-top: 4px; background-color: #EE0D61;" onclick="location.reload();">Отмена</div>');

	$("#flexStepsU>div>div:first-child").each(function(){ 
		$(this).click(function(){
			if($(this).find("div:eq(10)").css('background-color')!='rgb(62, 192, 240)')
				{$(this).off('mousemove'); $(this).find("div:eq(10)").css('background-color','#3EC0F0'); return;} 
			if($(this).find("div:eq(10)").css('background-color')!='rgb(126, 224, 129)')
				{$(this).on('mousemove', animateStep); $(this).mousemove(); $(this).find("div:eq(10)").css('background-color','#7EE081');}  
			});
		});
	$("#flexStepsU>div>div:first-child").on('mousemove', animateStep);

	$(".skritBackOrng").remove();
	$(".downloadFS").prepend(
		'<div class="skritBackOrng" style="left: 0px; width: 30px; height: 30px; background-color: #F4D35E; border-radius: 10px; padding: 2px;" onclick="this.children[1].click();">\
			<img style="width: 30px; height: 30px;" src="images/download.png">\
			<input class="lSParc" type="file" style="visibility: hidden;" onchange="$(this).parent().parent().find(\'span\').html(this.files[0].name); $(this).parent().css(\'background-color\',\'#3EC0F0\');">\
		 </div>'
		);
	return;
	;}

formFS=new FormData();
for(i=0; i!=$("#flexStepsU>div").length; i++)
	{
	formFS.append('FS'+i, $(".lSParc:eq("+i+")").prop('files')[0]);
	formFS.append('FST'+i, $("#flexStepsU>div:eq("+i+")>span:first").html());

	spanP=new Object($("#flexStepsU>div:eq("+i+")>div:first>div>span"));
	if(spanP.parent().css('background-color')=='rgb(62, 192, 240)')
		{formFS.append('SP'+i, spanP.html().substring(1));}
	}

formFS.append('loadStepsUPart', "<?php if(isset($_SESSION['userKey'])){ echo $_SESSION['userKey']; }?>");
formFS.append('typesLS', $("#flexStepsU>div").length);

$.ajax({method: 'POST', 
		url: 'LOADFILES(server).php',
		cache: false,
        contentType: false,
        processData: false, 
		data: formFS,
		dataType: 'text',
		success: function(data){ if(data==1){ alert("Объем одного из файлов выше допустимого"); return; } alert("Данные изменены успешно"); location.reload();}
	});
;}

function LeaveOrderNow()
{
$.ajax({method: 'POST', url: 'MAIN(server).php', data: {leaveOrderNow: "<?php if(isset($_SESSION['zakazChoose'])){ echo $_SESSION['zakazChoose']; } ?>"}, success: function(){ alert("Вы покинули проект"); location.reload(); } });	
}

function showStepPartic(userid)
{
$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {showSteps: userid, orderIDFS: "<?php echo $idchOrder;?>"},
		dataType: 'json',
		success: function(data){for(z=0; z!=data['countSt']; z++) 
									{
									if(data[z]["percents"]==undefined){data[z]["percents"]=0;}
									$("#flexStepsU").prepend('<div style="width: inherit; height: 50px; position: relative; display: flex; align-items: center; margin-bottom: 13px;">\
																	<div class="progressStep" style="left: 35px; height: 38px; width: 200px;">\
																		<div style="height: inherit; background-color: #7EE081; left: 0px; top: 0px;">\
																			<span style="top: 9px; color: black; font-size: 13pt; font-family: \'Exo\'">'+data[z]["percents"]+'%</span>\
																		</div>\
																	</div>\
																	<span class="text" style="left: 280px; top: 13px; width: 370px; white-space: normal; text-align:center;">'+data["name"][z]+'</span>\
																	<div class="downloadFS" style="left: 700px; top: 7px;">\
																		<a class="skritBackOrng" href="'+data[z]["fileN"]+'" download style="left: 0px; width: 30px; height: 30px; background-color: #F4D35E; border-radius: 10px; padding: 2px;">\
																			<img style="width: 30px; height: 30px;" src="images/download.png">\
																		</a>\
																		<span style="left: 40px; top: 5px; width: 270px;" class="text" title="'+data[z]["fileN"].substring(data[z]["fileN"].lastIndexOf("/")+1)+'">'+data[z]["fileN"].substring(data[z]["fileN"].lastIndexOf("/")+1)+'</span>\
																	</div>\
																	<hr color="#F7FFF6" noshade style="width: 785px; size: 1px; left: 37px; top: 48px; border-top: 1px dashed #C3E7D6;">\
															  </div>');

									if(data[z]["fileN"]==''){$('#flexStepsU>div:first>div:eq(1)>a').removeAttr('href');}
									$("#flexStepsU>div:first>.progressStep>div").width(parseInt(data[z]["percents"])*2);
									if(parseInt(data[z]['percents'])>20)
							    		$("#flexStepsU>div:first>.progressStep>div:first>span").css({'right':6, 'color':'white'})
							    	if(parseInt(data[z]['percents'])<=20)
							    		{$("#flexStepsU>div:first>.progressStep>div:first>span").css('left', $("#flexStepsU>div:first>.progressStep>div").width()+5);}
									;}

								for(i=0;i!=10;i++){$(".progressStep").prepend("<div style='left:"+i*20+"px; height: inherit; top: 0px; width: 1px; background-color: #F3F4F3'></div>");}
								$('#chooseIsp>div>span').html(data['login']);
								$('#chooseIsp>div>div>img').attr('src', CreateIconSU(data['sex'], data['type'])[1]);
								$('#chooseIsp>div>div').css('background-color', CreateIconSU(data['sex'], data['type'])[0]);
							   ;}
		});
;}

/// info about order ///////////////////////////////////////////////////////////
$("#iconM>img").attr('src', CreateIconSU('<?php echo mysqli_fetch_row(@mysqli_query($BASEZ, "select user.sex from user, participant where participant.manager=1 and participant.id_order={$idchOrder} and user.id=participant.id_user;"))[0]; ?>',1)[1]);
$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {orderINFO : "<?php echo $idchOrder;?>"},
		dataType: 'json',
		success: function(data){$("#Maininf>div:eq(1)>textarea").html(data['type']);
							    $("#period").val(data['period']+" дней");
							    $("#date_start").html(data['date_start']);
							    $("#Maininf>div:eq(2)>div").css('background-color', CreateCO(data['class']).substring(0,7));
							    $("#Maininf>div:eq(2)>div").html(CreateCO(data['class']).substring(7));
							    $("#Maininf>div:eq(0)>div").width(0);
							    $("#Maininf>div:eq(0)>div>span").html("0%");
							    if(data['percents']!=null)
							    	{
							    	$("#Maininf>div:eq(0)>div").width(data['percents']);
							    	$("#Maininf>div:eq(0)>div>span").html(data['percents']+"%");
							    	if(data['percents']>65)
							    		{
							    		$("#Maininf>div:eq(0)>div>span").css('color','white');
							    		$("#Maininf>div:eq(0)>div>span").css('right',3);
							    		;}
							    	if(data['percents']<=65)
							    		{
							    		$("#Maininf>div:eq(0)>div>span").css('left', $("#Maininf>div:eq(0)>div").width()+3);
							    		;}
							    	;}
							    $("#tech_spec>textarea").html(data['tech_spec']);
							    for(k=0; k!=data['countIsp']; k++)
							    	{
							    	$("#flexPartic").append('\
							    	<div class="skritBackRose" style="position: relative; height: 120px; width: 100px; margin-right: 59px; border-radius: 20px;">\
			    						<img class="userPhoto" src="'+data['ispImg'][k]+'" style="left: 15px; top: 10px;">\
			    						<img class="usrSt" src="'+getUsrSU(data[k]['statusU'])+'" style="left: 62px; top: 62px;">\
			    						<a onclick="event.stopPropagation(); $.ajax({method: \'POST\', url: \'MAIN(server).php\', data: {chooseUserNow: \''+data[k]['id']+'\'} });" href="http://localhost/diploma/profileU.php" class="usrName" style="top: 85px; text-decoration: none; user-select: none;">#'+data[k]['id']+'</a>\
			    						<span class="usrName" style="top: 103px; font-family: \'Exo 2\'; user-select: none;">'+data[k]['login']+'</span>\
			    						<img class="deleteImg" src="images\\deleteIc.png" onload="$(this).click(deleteIspol);" style="top: 6px; right: 13px; width: 25px; height: 25px; visibility: hidden;">\
			    					</div>');
							    	$("#flexPartic>div:last").on('click', {idU: data[k]['id']}, openUSteps);
			    					loadIsp++;
							    	}
//// COMPETENCE //////////////////////////////////////////////////////////////////////////////////////////////////////
pass=parseInt("<?php echo $pass; ?>");
idUser=parseInt("<?php if(isset($_SESSION['userKey'])){ echo $_SESSION['userKey']; }?>");

if(pass==5)
	{
	$('#flexPartic>div').off('click');
	;}
if(pass==4)
	{
	$('#REDACT').off('click');
	$('#REDACT').css({'display':'block', 'width':150, 'left': 465});
	$('#dateEND').css('display','none');
	$('#flexPartic>div').off('click');
	$('#REDACT').html('Отправить запрос');
	$('#REDACT').click(sendAddNotice);
	;}
if(pass==3)
	{
	$('#REDACT').off('click');
	$('#dateEND').css('display','none');
	$('#flexPartic>div').off('click');
	;}
if(pass==2)
	{
	$('#REDACT').off('click');
	$('#dateEND').css('display','none');
	$('#flexPartic>div').off('click');
	$("#REDACT").html("Покинуть").css({'display':'block', 'background': 'none', 'color':'gray', 'user-select': 'none'});
	$("#REDACT").click(LeaveOrderNow);
	$("#zakazInf").css('height', heightMainOS);
	$("#tech_spec").css('top',990);
	$('#stepsProgressBlock').css('visibility','visible').toggle();
	$('#flexPartic>div>a:contains('+idUser+')').parent().css({'background-color':'#EE0D61', 'color':'white'});
	$('#redactSTEPS').css('display','block').click(loadStepPartic);
	showStepPartic(idUser);
	;}
if(pass==1)
	{
	$('#REDACT').css('display','block');
	$('#dateEND').css('display','none');
	}
if(pass==0)
	{
	$('#REDACT').off('click');
	$('#dateEND').html('Отправлен запрос на добавление').css({'left':435, color: '#26A96C'});
	$('#flexPartic>div').off('click');
	;}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
							   ;}
		});
///////////////////////////////////////////////////////////
function deleteAddF()
{
$(this).parent().remove(); 
funcCh--;
}

function addNewFunc(name)
{
for(e=0; e!=$("#functionsZ>div").length-1; e++)
	{
	if(name==$("#functionsZ>div:eq("+e+")>span").html()){$("#mistakeLoadF").html("Данная функция уже добавлена"); return;}
	;}
$("#addFUNC").before('<div class="buttons addFunc" style="display: inline-block; height: 20px; padding: 2px 6px 3px 6px; width: auto; position: relative; margin-bottom: 5px; margin-right: 5px; border-radius: 12px;">'+name+'<span style="visibility:hidden">'+name+'</span>\
							<img class="deleteImg" src="images\\deleteIc.png"\ onload="$(this).click(deleteAddF);" style="bottom: -4px; right: -4px; width: 18px; height: 18px;">\
					  </div>');
$("#mistakeLoadF").html("");
$("#UIaddFunc, #UIaddFunc2").hide();
funcCh++;
;}

function loadFuncList()
{
$("[name=infoCrFunc]").css('visibility', 'hidden');
$("#UIaddFunc>span:lt(1), #UIaddFunc>img, #UIaddFunc>div:first").show();
$("#UIaddFunc>input").css('padding-left',35);
$("#mistakeAddF").html("");

$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {loadFlist: 1},
		dataType: 'json',
		success: function(data){$('#flexFunct>div').remove();
								for(i=0; i!=data['countFl']; i++)
									{
									$('#flexFunct').prepend('\
										<div class="skritBackRose" style="position: relative; width: inherit; height: 60px; display: flex; align-items: center; margin-bottom: 7px;" onclick="addNewFunc(\''+data[i]["name"]+'\');">\
											<span class="textSm" style="left: 5px; color: white;">'+data[i]["name"]+'</span>\
											<span class="areatext" style="color: white; left: 155px; white-space: normal; max-height: 50px; width: 220px; font-size: 11pt; line-height: 1.1;">'+data[i]["info"]+'</span>\
										</div>');
							  		;}
							   ;}
		});
;}

loadSteps=new Array();
function loadUnicSteps()
{
$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {loadUnicSteps: "<?php echo $idchOrder;?>"},
		dataType: 'json',
		success: function(data){for(z=0; z!=data['countSt']; z++)
									{
									percents=0;
									if(data[z]["percents"]!=""){percents=data[z]["percents"];}
									$("#flexStepsU").prepend('<div class="loadStepCl" style="width: inherit; height: 50px; position: relative; display: flex; align-items: center; margin-bottom: 13px;">\
																	<div class="progressStep" style="left: 35px; height: 38px; width: 200px;">\
																		<div style="height: inherit; background-color: #7EE081; left: 0px; top: 0px;">\
																			<span style="top: 9px; color: black; font-size: 13pt; user-select: none; font-family: \'Exo\'">'+percents+'%</span>\
																		</div>\
																	</div>\
																	<input type="text" class="text" style="left: 280px; top: 13px; width: 370px; white-space: normal; text-align:center; padding: 0px; padding-left: 5px; border-radius: 10px; border: 1px solid #979DA5; outline: none; user-select: none;" value="'+data["name"][z]+'" maxlength="38">\
																	<img class="deleteImg" style="width: 25px; height: 25px; left: -25px; top: 7px;" src="images/deleteIc.png" onclick="deleteLoadStep(this);">\
																	<hr color="#F7FFF6" noshade style="width: 785px; size: 1px; left: 37px; top: 48px; border-top: 1px dashed #C3E7D6;">\
															  </div>');

									$("#flexStepsU>div:first>.progressStep>div").width(parseInt(percents)*2);
									if(parseInt(percents)>20)
							    		$("#flexStepsU>div:first>.progressStep>div:first>span").css({'right':6, 'color':'white'})
							    	if(parseInt(percents)<=20)
							    		{$("#flexStepsU>div:first>.progressStep>div:first>span").css('left', $("#flexStepsU>div:first>.progressStep>div").width()+5);}
							    	loadStep++;
							    	loadSteps.push(data["name"][z]);
							    	
									;}

								for(i=0;i!=10;i++){$(".progressStep").prepend("<div style='left:"+i*20+"px; height: inherit; top: 0px; width: 1px; background-color: #F3F4F3'></div>");}
							   ;}
	});
;}

function deleteSumpl()
{
$(this).parent().find("input").val("");
$(this).parent().remove();
filesCh--;
;}

function addSumple()
{
fileData = new FileReader();
fileData.onload = function(event){
	filesCh++;
	$("#PRILOSHflexOrd>div:first").clone().insertBefore("#PRILOSHflexOrd>div:first").find('input').val('');
	$("#PRILOSHflexOrd>div:eq(1)").append("<img src="+fileData.result+" class='prilosh' onerror='this.src=\"images/dataFile.png\";'>\
							   			<img src='images\\deleteIc.png'\
							   			 onload='$(this).click(deleteSumpl);' style='top: 5px; right: 5px; width: 30px; height: 30px;'>")
							   .find("input")
							   .attr("name","addFILE"+filesCh);
	$("#PRILOSHflexOrd>div:eq(1)>textarea").removeAttr("readonly").css('border',"1px solid #979DA5").val(null).attr('name','nameSump'+filesCh);
	$("#PRILOSHflexOrd>div:eq(1)>input").attr('disabled',"disabled");

;}
fileData.readAsDataURL(this.files[0]);
;}

function redactOrd()
{
if($("#REDACT").width()!=165)
	{
    $("#PRILOSHflexOrd").prepend('\
		<div class="prilosh buttons" style="position: relative; visibility: visible; background-color: #54C6EB; padding: 0px; margin-right: 40px;" onclick="this.children[0].click();">\
			<input name="addFILE1" type="file" class="buttons" style="width: inherit; height: inherit; visibility: hidden;" form="formFile">\
			<hr color="#F5F6F5" noshade style="width: 100px; height: 4px; top: 96px; left: 50px;">\
			<hr color="#F5F6F5" noshade style="height: 100px; width: 4px; left: 98px; top: 48px;">\
			<textarea name="nameSump1" class="areatext downl" style="width: 190px; top: 220px; left: 5px; text-align: center; white-space: normal; color: black; outline: none; resize: none; border: 0px; border-radius: 10px; padding-left: 5px; line-height: 1.2; height: 50px;" readonly maxlength="40" placeholder="Введите описание к приложению">Ограничения: файл до 500Мб</textarea>\
		</div>');
	$("input,textarea").css('border-width', 1).removeAttr("readonly");
	$("#REDACT").html("Сохранить изменения").width(165).css('left',350).after(
		'<div class="buttons" onclick="location.reload();" style="left: 535px; bottom: 80px; width: 60px; text-align: center; padding-top: 4px; user-select: none;">Отмена</div>');
	$(".deleteImg, #addFUNC, #FinishOrd, #DelOrd, [name=selectV], #addSTEP").css('visibility','visible');
	$("#period").val(0);
	$('#stepsProgressBlock').css('visibility','visible').toggle(300,'linear');
	$("#zakazInf").animate({'height' : heightMainOS}, 100);
	$("#tech_spec").animate({'top' : 990}, 100);
	$("#typePr, #stepsProgressBlock>span:eq(2)").css('visibility', 'hidden');
	$("#PRILOSHflexOrd>div>a").remove();
	loadUnicSteps();
	return;
    ;}

var formD=new FormData();
for(typesF=2; typesF<=filesCh; typesF++)
	{
	fileData=$('[name=addFILE'+typesF+']').prop('files')[0];
	formD.append('addFILE'+typesF, fileData);
	formD.append('nameSump'+typesF, $('[name=nameSump'+typesF+']').val());
	;}
formD.append('prilOLoad', "<?php echo $idchOrder; ?>");
formD.append('filesTypes', filesCh);
formDateMas=$("#formOrder").serializeArray();
startF=filesCh+4;
for(i=startF; i!=formDateMas.length; i++)
	{
	if(formDateMas[i]==undefined){ continue; }
	if(formDateMas[i]['value'].indexOf("/")==-1)
		{
		formDateMas[i]['value']+=$("#loadFILE"+(i-startF)+">img:first").attr("src").substring($("#loadFILE"+(i-startF)+">img:first").attr("src").indexOf("."))+"|"+$("#loadFILE"+(i-startF)+">img:first").attr("src");
		;}
	;}

for(i=0; i!=loadStep; i++)
	{formDateMas.push({name: "Sname"+i, value: loadSteps[i]+"|"+$(".loadStepCl:eq("+(loadStep-i-1)+")>input").val()});}

formDateMas.push({name: 'typesLoadFU', value: loadSumpls});

formDateMas.push({name: 'typesLoadF', value: loadFunc});
formDateMas.push({name: 'typesAddF', value: funcCh});

formDateMas.push({name: 'typesLoadUs', value: loadStep});
formDateMas.push({name: 'typesAddUs', value: addStep});

formDateMas.push({name: 'typesDelIs', value: loadIsp});

for(Y=0; Y!=Math.max(loadFunc, funcCh, loadStep, addStep, loadIsp); Y++)
	{
	if(Y!=loadFunc){formDateMas.push({name: 'FL'+Y, value: $('.loadFUNC:eq('+Y+')>span').html()});}
	if(Y!=funcCh){formDateMas.push({name: 'FA'+Y, value: $('.addFunc:eq('+Y+')>span').html()});}
	if(Y!=loadStep){formDateMas.push({name: 'SL'+Y, value: $('.loadStepCl:eq('+Y+')>input').val()});}
	if(Y!=addStep){formDateMas.push({name: 'SA'+Y, value: $('.addStepCl:eq('+Y+')>input').val()});}
	if(Y!=loadIsp){formDateMas.push({name: 'ID'+Y, value: $("#flexPartic>div:eq("+Y+")>a:eq(0)").html()});}
	;}

$.ajax({method: 'POST', 
		url: 'LOADFILES(server).php', 
		cache: false,
        contentType: false,
        processData: false,
		data: formD,
		dataType: 'text',
		success: function(data){if(data==1){$("#mistakePU").html("Формат данных не соответствует"); return;}
								if(data==2){$("#mistakePU").html("Размер файла превышен"); return;}
								$.ajax({method: 'POST', 
										url: 'MAIN(server).php', 
										data: formDateMas, 
										dataType: 'text',
										success: function(data){alert("Данные успешно изменены");}
										});
								location.reload();
								}
		});
;}

function searchFunc()
{
if($("[name=nameCrFunc").val()==""){$('#flexFunct>div').show(); return;}
for(r=0; r!=$('#flexFunct>div').length; r++)
	{
	if($('#flexFunct>div:eq('+r+')>span:eq(0)').html().indexOf($("[name=nameCrFunc").val())==-1)
		{$('#flexFunct>div:eq('+r+')').hide();}
	;}
;}

function addStepOrder()
{
$("#flexStepsU").append('<div class="addStepCl" style="width: inherit; height: 50px; position: relative; display: flex; align-items: center; margin-bottom: 13px;">\
							<div class="progressStep" style="left: 35px; height: 38px; width: 200px;">\
								<div style="height: inherit; background-color: #7EE081; left: 0px; top: 0px;">\
									<span style="top: 9px; color: black; font-size: 13pt; font-family: \'Exo\'">0%</span>\
								</div>\
							</div>\
							<input type="text" class="text" style="left: 280px; top: 13px; width: 370px; white-space: normal; text-align:center; padding: 0px; padding-left: 5px; border-radius: 10px; border: 1px solid #979DA5; outline: none;" maxlength="38">\
							<input type="hidden">\
							<img class="deleteImg" style="width: 25px; height: 25px; left: -25px; top: 7px;" src="images/deleteIc.png" onclick="deleteAddSt(this);">\
							<hr color="#F7FFF6" noshade style="width: 785px; size: 1px; left: 37px; top: 48px; border-top: 1px dashed #C3E7D6;">\
					  	 </div>');
addStep++;
;}

<?php @mysqli_close($BASEP); ?>///////////////// ADD ON ALL WINDOWS /////////////////////////////////////////////
$("body").show();
</script>
</body>
</html>