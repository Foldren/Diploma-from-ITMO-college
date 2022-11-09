<?php 
header('Content-Type: text/html; charset=utf-8');
@$BASEM=mysqli_connect("localhost","root","","dealandproducts","3306");
$idU=$_POST['id'];
@mysqli_set_charset($BASEM, "utf8");
$typeUM=mysqli_fetch_row(@mysqli_query($BASEM, "select type from user where id={$idU};"))[0];
?>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
*{text-overflow: ellipsis;}
.menu,.menu-text,.upmenu,.downmenu{position: fixed;}
.downmenu{font-family: 'Exo';}
.skritBackGren:hover{
	background-color: #14453D; 
	color: white;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/styles.css">
</head>
<body style="background: #FEFEFE; height: 2000px; overflow-x: hidden;">
		<form method="POST" id="openFU" action="http://localhost/diploma/fuserU.php" accept-charset="utf8"></form>
		<form method="POST" id="openFO" action="http://localhost/diploma/forderU.php" accept-charset="utf8"></form>
<!-- MENU  -->
		<div id="MENU" style="position: fixed; left: 0px; top: 0px; height: 2000px; width: 250px; background: #214F4B; opacity: 0.96;">
			<img id="avatar" class="upmenu" src="images/Anonymous.jpg" style="left: 20px; top: 60px; width: 101px; height: 101px; border-radius: 50px;">
			<span id="tag" class="upmenu" style="color: #FFD151; left: 20px; top: 185px; width: 120px;">
				#<?php echo $idU; ?></span><!-- ТЕГ -->
			<span id="NAMEU" class="upmenu" style="color: white; left: 90px; top: 185px; width: 120px; font-family: 'Exo 2'">
				<?php echo mysqli_fetch_row(@mysqli_query($BASEM, "select login from user where id='{$idU}';"))[0]; ?></span><!-- НИК -->
			
			<a onclick="$.ajax({method: 'POST', url: 'MAIN(server).php', data: {chooseUserNow: '<?php echo $idU; ?>'} });" href="http://localhost/diploma/profileU.php" class="upmenu buttons" style="color: white; left: 20px; top: 215px; font-size: 10pt; height: 20px; padding: 3px 6px 1px 6px; border: 0px; text-decoration: none;">Просмотреть профиль</a>

			<div id="moderator" class="backForms" style="position: fixed; left: 140px; top: 60px; background-color: none; border-radius: 10px; width: 89px; height: 27px; text-align: center; display: flex; align-items: center; padding: 0px; padding-bottom: 2px;"><span style="text-align: center; width: inherit; font-size: 10pt; user-select: none;"></span></div>			
			<div id="EXITU" class="skritBackGren downmenu" style="left: 15px; top: 890px; height: 35px; width: 70px; border-radius: 10px; cursor: pointer;">
				<img id="exit" src="images/exit.png" style="left: 5px;">
				<span style="left: 35px; top: 7px; font-family: 'Exo'; color: #FFD151; user-select: none;">Exit</span>
			</div>
			<div id="skritMENU" class="downmenu" style="background-color: #355F5B; width: 35px; height: 35px; left: 185px; top: 887px; border-radius: 10px;">
				<img class="downmenu" src="images/inviseMenu.png" style="position: absolute; width: 12px; height: 22px; left: 12px; top: 7px;">
			</div>
			<div id="messageU" class="backForms opacity upmenu" style="background-color: gray; width: 11px; height: 22px; left: 140px; top: 150px; border-radius: 8px; padding: 3px 7px 1px 7px;">
				<img src="images/zakazZapr.png" style="left: 3px; top: 3px; width: 20px; height: 20px;">
			</div>
			<div id="statusUser" class="backForms opacity" style="width: 73px; height: 23px; left: 140px; top: 100px; border-radius: 10px; background-color: #214F4B; border: 1px solid white; padding: 3px 7px 1px 7px;">
				<img src="images/openvariants.png" style="right: 6px; top: 9px;">
				<div id="statO" class="" style="visibility: visible; left: -7px; position: relative; width: 86px; height: 20px; display: flex; align-items: center;">
					<img src="images/onlineS.png" style="width: 10px; height: 10px; left: 54px;">
					<input type="button" name="online" value="online" style="background: 0; border: 0; color: white; font-size: 10pt; left: 8px;">
				</div>
				<div id="statS" class="skritBackGren" style="visibility: hidden; left: -7px;  position: relative; width: 86px; height: 20px; display: flex; align-items: center;">
					<img src="images/redS.png" style="width: 10px; height: 10px; left: 54px;">
					<input type="button" name="silent" value="silent" style="background: 0; border: 0; color: white; font-size: 10pt; left: 8px;">
				</div>
				<div id="statB" class="skritBackGren" style="visibility: hidden; left: -7px;  position: relative; width: 86px; height: 20px; display: flex; align-items: center;">
					<img src="images/busyS.png" style="width: 10px; height: 10px; left: 54px;">
					<input type="button" name="busy" value="busy" style="background: 0; border: 0; color: white; font-size: 10pt; left: 8px;">
				</div>
			</div>
 
			<div id="DialogstypeMENU" class="areatext buttons" style="position: fixed; height: 340px; width: 205px; left: 20px; top: 470px; background-color: #3EC0F0; border-radius: 30px; padding: 0px; white-space: normal; line-height: 1.2;">
				<img id="messIcon" src="images/messages.png" style="right: 31px; width: 31px; height: 30px; top: 12px;">
				<span class="textSm" style="visibility: hidden; top: 165px; left: 25px;">Нет новых сообщений</span>
				<div id="dialogs" style="height: 310px; width: 205px; border-radius: 30px;">
					<span class="text" style="left: 20px; top: 15px; color: white;">Недавнее</span>
					<div style="left: 18px; top: 65px; width: 170px; visibility: hidden;">
						<div style="width: inherit; border-top: 1px dashed #84D6F5; top: 18px;"></div>
						<img class="userPhoto" style="width: 40px; height: 40px; top: 27px;" src="">
						<img class="usrSt" src="images/onlineS.png" style="left: 27px; top: 53px; width: 11px; height: 11px; background-color: #3EC0F0; border-color: #3EC0F0;">
						<span class="textSm" style="top: 0px; width: 120px; color: #FFD151; font-size: 11pt;"></span>
						<span class="textSm" style="right: 0px; top: 2px; width: 40px; color: #FFD151; font-size: 10pt; text-align: center;"></span>
						<span class="areatext" style="display: flex; align-items: center; left: 57px; top: 19px; width: 120px; color: white; font-size: 10pt; height: 59px; line-height: 1.2;"></span>
					</div>
					<div style="left: 18px; top: 150px; width: 170px; visibility: hidden;">
						<div style="width: inherit; border-top: 1px dashed #84D6F5; top: 18px;"></div>
						<img class="userPhoto" style="width: 40px; height: 40px; top: 27px;" src="">
						<img class="usrSt" src="images/busyS.png" style="left: 27px; top: 53px; width: 11px; height: 11px; background-color: #3EC0F0; border-color: #3EC0F0;">
						<span class="textSm" style="top: 0px; width: 120px; color: #FFD151; font-size: 11pt;"></span>
						<span class="textSm" style="right: 0px; top: 2px; width: 40px; color: #FFD151; font-size: 10pt; text-align: center;"></span>
						<span class="areatext" style="display: flex; align-items: center; left: 57px; top: 19px; width: 120px; color: white; font-size: 10pt; height: 59px; line-height: 1.2;"></span>
					</div>
					<div style="left: 18px; top: 235px; width: 170px; visibility: hidden;">
						<div style="width: inherit; border-top: 1px dashed #84D6F5; top: 18px;"></div>
						<img class="userPhoto" style="width: 40px; height: 40px; top: 27px;" src="">
						<img class="usrSt" src="images/redS.png" style="left: 27px; top: 53px; width: 11px; height: 11px; background-color: #3EC0F0; border-color: #3EC0F0;">
						<span class="textSm" style="top: 0px; width: 120px; color: #FFD151; font-size: 11pt;"></span>
						<span class="textSm" style="right: 0px; top: 2px; width: 40px; color: #FFD151; font-size: 10pt; text-align: center;"></span>
						<span class="areatext" style="display: flex; align-items: center; left: 57px; top: 19px; width: 120px; color: white; font-size: 10pt; height: 59px; line-height: 1.2;"></span>
					</div>
				</div>
			</div>
			<div id="ZIPtypeMENU" style="position: fixed; top: 200px">
				<div id="isplonitRukU" class="skritBackGren" style="width: 250px; height: 50px; left: 0px; top: 318px; position: fixed; user-select: none;">
					<img id="ispolmitM" src="images/ispolnit.png" class="menu" style="padding: 2px; width: 35px; height: 35px; left: 24px; top: 324px; background-color: #EE0D61; border-radius: 9px;">
						<span class="menu-text text" style="left: 69px; top: 332px; color: white;">Исполнители</span>
					<div class="skritBackRose textSm" style="cursor: pointer; visibility: hidden; left: 63px; top: 50px; width: 181px; height: 23px; padding-left: 6px; padding-top: 1px;">
						<input class="textSm" form="openFU" type="submit" name="OPENI" value="<?php echo $idU; ?>" style="opacity: 0; width: 193px; height: 25px; top: -1px; left: -6px; cursor: pointer;">
						<input type="hidden" name="typeUPrf" form="openFU" value="<?php echo $typeUM; ?>">
					</div>
					<div class="skritBackRose" style="cursor: pointer; visibility: hidden; left: 63px; top: 75px; width: 187px; height: 23px;">
						<input class="textSm" form="openFU" type="submit" value="Поиск" style="background: 0; border: 0px; color: white; top: 0px; left: 0px; cursor: pointer; width: inherit; height: inherit; text-align: left; padding-bottom: 4px;">
					</div>
				</div>
				<div id="zakazUser" class="skritBackGren" style="width: 250px; height: 50px; left: 0px; top: 248px; position: fixed;">
					<img id="zakaziM" src="images/zakazIND.png" class="menu" style="padding: 2px; width: 35px; height: 35px; left: 24px; top: 254px; background-color: #EE0D61; border-radius: 9px;">
						<span class="menu-text text" style="left: 69px; top: 262px; color: white; user-select: none;">Заказы</span>
					<div class="skritBackRose" style="visibility: hidden; left: 63px; top: 50px; width: 181px; height: 23px; padding-left: 6px; padding-top: 1px;">
						Активные
						<input class="textSm" type="submit" form="openFO" name="OPENFO1" value="<?php echo $idU; ?>" style="opacity: 0; top: 0px; left: 0px; height: 24px; width: 187px; cursor: pointer;">
					</div>
					<div class="skritBackRose" style="visibility: hidden; left: 63px; top: 75px; width: 181px; height: 23px; padding-left: 6px; padding-top: 1px;">
						Завершеннные
						<input class="textSm" type="submit" form="openFO" name="OPENFO2" value="<?php echo $idU; ?>" style="opacity: 0; top: 0px; left: 0px; height: 24px; width: 187px; cursor: pointer;">
					</div>
					<div style="visibility: hidden;"><div id="OPENCRORDER" class='buttons menu-text' style="cursor: pointer; left: 160px; top: 264px; font-size: 10pt; height: 18px; background-color: orange; padding-top: 1px;">Добавить</div></div>
				</div>
			</div>
		</div>
<!-- UP MENU -->
		<div id="UPMENU" style="position: fixed; left: 0px; top: 0px; height: 40px; width: 2000px; background-color: #363537;">
			<img id="Logotype" src='images/Logo.png' style="left: 120px; top: 4px; width: 30px; height: 30px; user-select: none;">
			<span style="bottom: 7px; left: 153px; font-family: 'Anton'; font-size: 13pt; color: #EE0D61; user-select: none;">Deal&Products</span>
			<div id="openSupBl" class="skritBackRose" style="top: 10px; right: 220px; border-radius: 7px; width: 26px; height: 25px; background-color: #363537;">
				<img src='images/help.png' style="width: 20px; height: 20px; left: 3px; top: 2px;">
			</div>
			<img id="supportBlock1" src="images/whiteTR.png" style="right: 208px; top: 38px; transform: rotate(90deg);">
			<div id="supportBlock" class="smallBlocks" style="right: 100px; top: 45px; width: 200px; padding: 20px; visibility: hidden;">
				<span style="user-select: none;">Задавайте любой вопрос, мы свяжемся с вами как можно быстрее &#128521</span>
				<span style="color: #EE0D61; left: 70px; top: 100px; user-select: none;">p.s&nbsp<span style="color: black; user-select: none;">Deal&Products</span></span>
				<textarea form="formMessSup" id="messAreaS" name="sentMessU" class="areatext backForms scrollSmall" style="width: 185px; height: 90px; bottom: 50px; white-space: normal; background: #FFFFFF; color: black; overflow-y: auto; border: 1px solid #979DA5; border-radius: 10px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-right: 0px; resize: none; padding-left: 25px; outline: none;" maxlength="999"></textarea>
				<div style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; background: #FFFFFF; width: 10px; height: 88px; bottom: 50px; left: 203px; border-right: 1px solid #979DA5; border-top: 1px solid #979DA5; border-bottom: 1px solid #979DA5;"></div>
				<div id="messSentSup" class="buttons textSm" style="left: 74px; bottom: 15px; height: 12px; display: flex; align-items: center; padding-bottom: 9px; border-radius: 9px; padding-bottom: 8px; padding-top: 4px; user-select: none; cursor: pointer;">Отправить</div>
			</div>
			<span class="redTextSm" style="bottom: 9px; left: 1800px;">Trial v1.0.0</span>
		</div>
		<div id="listADDS3" id="listADDSdop" class="smallBlocks" style="position: fixed; width: 13px; left: 426px; top: 140px; border-bottom-left-radius: 0px; border-top-left-radius: 0px; visibility: hidden; height: 70px;"></div>
		<img id="listADDS2" src="images/whiteTR.png" style="left: 166px; top: 154px; width: 20px; height: 20px; position: fixed; visibility: hidden;">
		<div id="listADDS" class="smallBlocks scrollSmall" style="position: fixed; left: 176px; top: 140px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; background-color: #FFFFFF; visibility: hidden; overflow-y: auto; overflow-x: hidden; width: 250px; height: 70px;">
			<div id="flexOrdersAddN" style="display: flex; flex-direction: column; width: inherit; height: auto; padding-left: 15px; padding-top: 10px;">
				<!-- ADDNOTICE HERE -->
			</div>
		</div>
<script type="text/javascript">
$(document).ready();
$("input").css("outline","none");
// images //////////////////////////////////////////////////////////
params="<?php 
$urlType=mysqli_fetch_row(@mysqli_query($BASEM, "select type from user where id='{$idU}';"))[0]; 
if($urlType==1){echo "#1FA637 moderator";} else if($urlType==2){echo "#3A86FF student";} else if($urlType==3){echo "orange  creator";}
?>";
$("#moderator").css("background-color", params.substr(0,7));
$("#moderator>span").append(params.substr(8));

if(params.substr(8)!='moderator')
	{
	$("#OPENCRORDER").remove();
	$("#ispolmitM").attr('src', "images/managers.png");
	$("#ispolmitM+span").html("Руководители");
	$("#isplonitRukU>div:first>input:first").before("Мои руководители");
	;}
if(params.substr(8)=='moderator')
	{
	$("#OPENCRORDER").on('click', function(){ location.replace("orderCreate.php"); });
	$("#isplonitRukU>div:first>input:first").before("Мои исполнители");
	;}

$.ajax({method: 'POST', url: 'MAIN(server).php', data: {avatar: 1}, dataType: 'text', success: function(data){ $("#avatar").attr("src", data);}});

function sentMessageSup()
{
$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {SentMessSupport: $("#messAreaS").val()},
		success: function(){ 
							alert("Сообщение в поддержку отправлено успешно"); 
							$("#supportBlock").slideToggle(200, 'linear');
							$("#supportBlock1").fadeToggle(200, 'linear');
							$("#openSupBl").css('background-color','#363537'); 
							} 
		});
}

function openSupportBlock()
{
if($("#openSupBl").css('background-color')!='rgb(238, 13, 97)')
	{ 
	$("#supportBlock").slideToggle(200, 'linear');
	$("#supportBlock1").fadeToggle(200, 'linear');
	$("#openSupBl").css('background-color', '#EE0D61');
	return; 
	}

$("#supportBlock").slideToggle(200, 'linear');
$("#supportBlock1").fadeToggle(200, 'linear');
$("#openSupBl").css('background-color','#363537'); 
;}

$("#supportBlock, #supportBlock1").toggle().css('visibility','visible');
$("#messSentSup").click(sentMessageSup);
$("#openSupBl").click(openSupportBlock);
// statusUser /////////////////////////////////////////////////////
status="<?php echo mysqli_fetch_row(@mysqli_query($BASEM, "select status from user where id='{$idU}';"))[0]; ?>";
if(status==1)
	{
	if($("#statusUser>div:first").attr("id")!="statO"){
		$("#statusUser>div:first").css("visibility","hidden").insertAfter("#statO").addClass("skritBackGren");
		$("#statO").css("visibility","visible").prependTo("#statusUser").removeClass("skritBackGren");}
	;}
else if(status==2)
	{
	if($("#statusUser>div:first").attr("id")!="statS"){
		$("#statusUser>div:first").css("visibility","hidden").insertAfter("#statS").addClass("skritBackGren");
		$("#statS").css("visibility","visible").prependTo("#statusUser").toggleClass("skritBackGren");}
	;}
else if(status==3)
	{
	if($("#statusUser>div:first").attr("id")!="statB"){
		$("#statusUser>div:first").css("visibility","hidden").insertAfter("#statB").addClass("skritBackGren");
		$("#statB").css("visibility","visible").prependTo("#statusUser").removeClass("skritBackGren");;}
	;}
// messageBlock /////////////////////////////////////////////////////
$.ajax({
	method: 'POST',
	url: 'MAIN(server).php', 
	data: {message : 1},
	dataType: 'json',
	success: function(data){
							for(i=0; i!=data['countMes']; i++)
								{
								$("#dialogs>div:eq("+i+")").css("visibility", "visible");
								$("#dialogs>div:eq("+i+")>img:eq(0)").attr("src", data["ImgOt"][i][0]);
								status= data["statusOT"][i]==0 ? "images/offlineS.png" : data["statusOT"][i]==1 ? "images/onlineS.png" : data["statusOT"][i]==2 ? "images/redS.png" : data["statusOT"][i]==3 ? "images/busyS.png" : "";
								$("#dialogs>div:eq("+i+")>img:eq(1)").attr("src", status);
								$("#dialogs>div:eq("+i+")>span:eq(0)").html(data["nameOT"][i]);
								$("#dialogs>div:eq("+i+")>span:eq(1)").html(data[i]["time_format(time, '%k:%i')"]);
								$("#dialogs>div:eq("+i+")>span:eq(2)").html(data[i]["content"]);
								;}
							if(i==0){$("#DialogstypeMENU>span:first").css('visibility','visible');}
							;}
});
/////////////////////////////////////////////////////////////////////

function menuSkrit()
{
if($("#MENU").width()==250){
	$("#MENU").animate({'width': 70},200);
	$("#ZIPtypeMENU>div>img").animate({'left': 17},200);
	$("#avatar").animate({'width': 50, 'height': 50, 'left': 10},200);
	$("#ZIPtypeMENU>span, #dialogs, .upmenu.buttons, #NAMEU, #EXITU, #exit+span, #messageU, #friendsU, #statusUser, #moderator, .menu-text").hide(200,'linear');
	$("#DialogstypeMENU").animate({'padding' : 2+"px", 'width': 35+"px", 'height': 35+"px", 'left': 17+"px", 'top': 388+"px", 'border-radius': 9+"px"},200);
	$("#messIcon").animate({'right': 4+"px", 'top': 4+"px"},200);
	$("#DOWNMENU").animate({'left': -100+"px"},200);
	$('#skritMENU').animate({'left': 17}, 200).css("transform", "rotate(" + 180 + "deg)");
	$('#avatar+span').animate({'left': 12, 'font-size': 13, 'top': 120, 'width': 50},200, 
		function(){
			$('#NAMEU').css({'text-overflow': 'ellipsis', 
							 'white-space': 'nowrap', 
							 'overflow': 'hidden'});
				  ;}); 
	$('.forMOVE').each(function(elem){ $(this).animate({'left': $(this).offset().left-90+"px"},200); } );
	$("#zakazUser, #isplonitRukU, #ProgressU").toggleClass("skritBackGren").toggleClass("opacity");
	$("#listADDS, #listADDS2, #listADDS3").css({'visibility': "hidden"});
	$("#flexOrdersAddN>div").remove();
	$("#zakaziM").after('<input id="addInpZ" class="textSm" type="submit" form="openFO" name="OPENFO1" value="<?php echo $idU; ?>" style="opacity: 0; top: 254px; left: 24px; height: 35px; width: 35px; cursor: pointer;">');

	;}
if($("#MENU").width()==70){
	$("#MENU").animate({'width': 250},200);
	$("#ZIPtypeMENU>div>img").animate({'left': 24},200);
	$("#avatar").animate({'width': 101, 'height': 101, 'left': 20},200);
	$("#ZIPtypeMENU>span, #dialogs, .upmenu.buttons, #NAMEU, #EXITU, #exit+span, #messageU, #friendsU, #statusUser, #moderator, .menu-text").show(200,'linear');
	$("#DialogstypeMENU").animate({'padding' : 0+"px", 'width': 205+"px", 'height': 340+"px", 'left': 20+"px", 'top': 470+"px", 'border-radius': 30+"px"},200);
	$("#messIcon").animate({'right': 31+"px", 'top': 15+"px"},200);
	$("#DOWNMENU").animate({'left': 0+"px"},200);
	$('#skritMENU').animate({'left': 185}, 200).css("transform", "rotate(" + 0 + "deg)");
	$('#avatar+span').animate({'left': 20, 'font-size': 16, 'top': 185, 'width': 120},200, 
		function(){
			$('#NAMEU').css({'text-overflow': 'ellipsis', 
							 'white-space': 'nowrap', 
							 'overflow': 'hidden'});
				  ;}); 
	$('.forMOVE').each(function(elem){ $(this).animate({'left': $(this).offset().left+74+"px"},200); } );
	$("#zakazUser, #isplonitRukU, #ProgressU").toggleClass("opacity").toggleClass("skritBackGren");
	$("#zakaziM+input:first").remove();
	;}
;}

function selectStatus(event)
{
if(event.data.value==0 && $("#statusUser").height()<50)
	{
	$("#statusUser>img").css("transform", "rotate(" + 90 + "deg)");
	$("#statusUser").animate({'height': 65+"px"},200);
	$("#statusUser>div").css({'visibility': "visible"});
	;}
if(event.data.value==1 && $("#statusUser").height()>23) 
	{
	$("#statusUser>img").css("transform", "rotate(" + 0 + "deg)");
	$("#statusUser").animate({'height': 23+"px"},200);
	$("#statusUser>div").css({'visibility': "hidden"});
	$("#statusUser>div:first").css({'visibility': "visible"});
	;}
;}

function selectZUP(event)
{
idHesh="#"+event.data.idB;
if(event.data.value==0)
		{
		$(idHesh).animate({'height': 115+"px"},200);
		$(idHesh+">div").css({'visibility': "visible"});
		;}
if(event.data.value==1)
		{
		$(idHesh).animate({'height': 50+"px"},200);
		$(idHesh+">div").css({'visibility': "hidden"});
		;}
;}

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

function removeAddNot(objNot, idNoticeUs, idOrder)
{
$.ajax({method: 'POST', url: 'MAIN(server).php', data: {removeAddNot: idNoticeUs, removeAddOrd: idOrder}, success: function(){ $(objNot).parent().remove(); if($("#flexOrdersAddN>div").length==0){$("#flexOrdersAddN").append("<span class='textSm' style='color: gray; left: 33px; top: 23px;'>Нет запросов на добавление</span>");} } });
;}

function acceptAddNot(objNot, idNoticeUs, idOrder)
{
$.ajax({method: 'POST', url: 'MAIN(server).php', data: {acceptAddNot: idNoticeUs, acceptAddOrd: idOrder}, success: function(){ $(objNot).parent().remove(); if($("#flexOrdersAddN>div").length==0){$("#flexOrdersAddN").append("<span class='textSm' style='color: gray; left: 33px; top: 23px;'>Нет запросов на добавление</span>");} } });
;}

function showAddN(event)
{
$("#flexOrdersAddN>div").remove();
if($('#listADDS2').css('visibility')=='visible')
	{
	$("#listADDS, #listADDS2, #listADDS3").css({'visibility': "hidden"});
	$("#messageU").toggleClass("opacity");
	return;
	;}

$.ajax({
	method: 'POST',
	url: 'MAIN(server).php', 
	data: {showADDnotRI: "<?php echo $idU; ?>"},
	dataType: 'json',
	success: function(data){for(i=0; i!=data['countOrders']; i++)
								{
								for(j=0; j!=data[i]['countNotices']; j++)
									{
									$("#flexOrdersAddN").append(
										'<div style="position: relative; width: 225px; height: 21px; margin-bottom: 7px;">\
											<div class="userIconT" style="background-color: '+CreateIconSU(data[i][j]['sex'],data[i][j]['type'])[0]+'; left: 0px; top: 0px; width: 19px; height: 19px;" title="'+data[i][j]['login']+'" onclick="replaceToUserPage('+data[i][j]['id_user']+')">\
												<img src="'+CreateIconSU(data[i][j]['sex'],data[i][j]['type'])[1]+'" style="width: 17px; height: 17px; left: 3px;">\
											</div>\
											<span class="textSm" style="left: 28px; top: 1px; width: 155px;" title="'+data[i]['name']+'">'+data[i]['name']+'</span>\
											<div class="buttons" style="width: 17px; height: 17px; padding: 0px; right: 20px; top: 2px; border-radius: 5px;" onclick="removeAddNot(this, '+data[i][j]['id_user']+', '+data[i]['id_order']+');">\
												<div style="width: 11px; height: 1px; top: 8px; left: 3px; background-color: #F5F6F5;"></div>\
											</div>\
											<div class="buttons" style="width: 17px; height: 17px; padding: 0px; right: 0px; top: 2px; border-radius: 5px;" onclick="acceptAddNot(this, '+data[i][j]['id_user']+', '+data[i]['id_order']+');">\
												<div style="width: 1px; height: 11px; top: 3px; left: 8px; background-color: #F5F6F5;"></div>\
												<div style="width: 11px; height: 1px; top: 8px; left: 3px; background-color: #F5F6F5;"></div>\
											</div>\
										</div>');
									;}
								;}
							if($("#flexOrdersAddN>div").length==0){$("#flexOrdersAddN").append("<span class='textSm' style='color: gray; left: 33px; top: 23px;'>Нет запросов на добавление</span>");}
							;}
		});


$("#listADDS, #listADDS2, #listADDS3").css({'visibility': "visible"});
$("#messageU").toggleClass("opacity");
;}

function chooseStatus(event)
{
if(event.data.idSt==$("#statusUser>div:first").attr("id")){return;}
$("#statusUser>div:first").css("visibility","hidden").insertAfter("#"+event.data.idSt).addClass("skritBackGren");
$("#"+event.data.idSt).css("visibility","visible").prependTo("#statusUser").removeClass("skritBackGren");
statusCh = event.data.idSt=="statO" ? 1 : event.data.idSt=="statS" ? 2 : event.data.idSt=="statB" ? 3 : "";
$.ajax({
	method: 'POST',
	url: 'MAIN(server).php', 
	data: {statusU : statusCh, idU: "<?php echo $idU; ?>"},
	dataType: 'text',
	error: function(data){alert(data);},
});
selectStatus(event);
;}

$("#EXITU").click(function(){
$.ajax({
	method: 'POST',
	url: 'MAIN(server).php', 
	data: {exit: 1},
	dataType: 'text',
	success: function(data){location.replace("http://localhost/diploma/authorizationU.php");},
});	
});

$("#skritMENU").click(menuSkrit);
$("#statusUser").click({value:0}, selectStatus).mouseleave({value:1}, selectStatus);
$("#statusUser>div").each(function(){$(this).click({value:1, idSt:$(this).attr("id")}, chooseStatus);});
$("#zakazUser, #isplonitRukU, #ProgressU").each(function(){$(this).click({idB:$(this).attr("id"), value:0}, selectZUP).mouseleave({idB:$(this).attr("id"), value:1}, selectZUP)});
$("#messageU").click(showAddN);
</script>
</body>
</html>