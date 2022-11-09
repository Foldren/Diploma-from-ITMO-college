
<!-- if($_POST){header('Location: forderU.php');} -->

<?php
header('Content-Type: text/html; charset=utf-8');
@$BASEFO=mysqli_connect("localhost","root","","dealandproducts","3306");
@mysqli_set_charset($BASEFO, "utf8");
session_start();
$statusO=1;
$typeMyO=0;

if(isset($_POST['OPENAO']))
	{ $statusO=1; $typeMyO=0; $idUOrders=$_POST['OPENAO']; if($idUOrders==$_SESSION['userKey']){ $typeMyO=1; unset($idUOrders);} }
if(isset($_POST['OPENFO1']))
	{ $statusO=1; $typeMyO=0; $idUOrders=$_POST['OPENFO1']; if($idUOrders==$_SESSION['userKey']){ $typeMyO=1; unset($idUOrders);} }
if(isset($_POST['OPENFO2']))
	{ $statusO=0; $typeMyO=0; $idUOrders=$_POST['OPENFO2']; if($idUOrders==$_SESSION['userKey']){ $typeMyO=1; unset($idUOrders);} }
if(isset($idUOrders))
	{
	$userInfoO=mysqli_fetch_assoc(@mysqli_query($BASEFO, "select type, status, login, id from user where id={$idUOrders};"));
	$userInfoO['imgS']=@glob("users/{$idUOrders}/{*.png,*.bmp,*.jpeg,*.jpg}", GLOB_BRACE)[0];
	if($userInfoO['imgS']==null){ $userInfoO['imgS']='images/Anonymous.jpg'; }
	;}
?>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
*{text-overflow: ellipsis;}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/styles.css">
</head>
<body style="background: #FEFEFE; height: 2000px; overflow-x: hidden">
<script type="text/javascript">
<?php
//ADD AT ALL WINDOWS //////////////////////////////////////////
if(!isset($_SESSION['userKey']))
	{echo 'location.replace("http://localhost/diploma/authorizationU.php"); document.body.innerHTML="";'; session_destroy(); } 
@mysqli_query($BASEFO, "update user set status={$_SESSION['userStatusEXIT']} where id={$_SESSION['userKey']};");
?>
//////////////////////////////////////////////////////////////
</script>
	<img src="images/back4.png" style="width: 1900px; height: 2300px; position: fixed;">
<!-- TYPES ZAKAZ -->
	<div class="forMOVE" style="top: 152px;">
		<input type="button" class="buttons" form="ZAOstOrd" style="left: 525px; border-radius: 10px 10px 0px 0px; border: 0px; height: 28px; padding-bottom: 5px;" onclick="loadZAO(this);" value="Завершенные">
		<input type="button" class="buttons" form="ZAOstOrd" style="left: 420px; border-radius: 10px 10px 0px 0px; border: 0px; height: 28px; padding-bottom: 5px;" onclick="loadZAO(this);" value="Активные">
	</div>
<!-- ZAKAZLIST -->
	<div id="ZakazList" class="largeBlocks forMOVE" style="left: 370px; top: 180px; width: 1300px; height: 900px; padding: 50px; overflow-y: none;">
	<!-- MENUPOISK -->
		<div id="menuPoisk">
			<div id="FINDfiltrs" class="buttons" style="background-color: #EE0D61; width: 80px; text-align: center; height: 24px; user-select: none;">Поиск</div>
			<div class="buttons" style="background-color: #97CC04; width: 75px; left: 740px; text-align: center; user-select: none;" onclick="toggleFil(this);">Название</div>
			<div class="buttons" style="background-color: #28AFB0; width: 106px; left: 840px; text-align: center; user-select: none;" onclick="toggleFil(this);">Руководитель</div>
			<span id="mistakeFord" class="textSm" style="color: gray; top: 50px;"></span>

			<select name="selectV" form="formOrder" style="outline: none; left: 1190px; width: 106px; font-size: 11pt; border: 1px solid #979DA5; border-radius: 5px; height: 30px;">
				<option disabled>Тип</option><option value="0" selected>По всем</option><option value="1">Web</option><option value="2">Desktop</option><option value="3">Mobile</option>
			</select>
			<input placeholder="Введите данные для поиска..." class="buttons text" id="findOrder" style="height: 27px; width: 600px; background-color: #FEFEFE; left: 120px; padding: 0px 15px 3px 35px; border: 1px solid #B1B2B1; color: black; font-size: 12pt;">
				<img src="images/findimage.png" style="left: 128px; top: 4px; width: 20px; height: 20px; opacity: 0.2;">
			<hr color='#F5F6F5' noshade style="width: 1300px; size: 1px; top: 150px; border-top: 1px dashed red;">
		</div>
	<!-- INFOFIND ZAKAZ -->
		<div id="FZM" class="redTextSm" style="background-color: white; width: 1000px; top: 180px; user-select: none;">
			<span style="left: 22px; top: 55px;">Тип</span>
			<span style="left: 70px; top: 55px;">Исполнители</span>
			<span style="left: 190px; top: 55px;">Активность</span>
			<span style="left: 328px; top: 55px;">Прогресс</span>
			<span style="left: 465px; top: 55px;">Руководитель</span>
			<span style="left: 860px; top: 55px;">Название разработки</span>
		</div>
		<span id="moN" class="redTextSm" style="right: 120px; top: 164px; color: gray; user-select: none;">Данные по моим заказам</span>
		<div class="buttons" id="MineorNot" style="width: 40px; right: 50px; top: 160px; background-color: white; border: 1px solid #B1B2B1; opacity: 1;">
			<div class="buttons" style="width: 12px; height: 18px; left: 5px; background-color: gray;"></div>
		</div>
		<div class="scrollSmall" style="width: 1300px; height: 680px; top: 280px; overflow-y: auto; overflow-x: hidden;">
			<div id="flexOrdersF" style="display: flex; flex-direction: column; width: inherit; height: auto;">
				<!-- ORDERS HERE -->
			</div>
		</div>
	</div>
	<div id="menuBlock"></div>
<script type="text/javascript">
FLOAD=0;
loadID=new String();
lastStatus=0;
/////////////////////////////////////
$(document).ready(function(){$("#menuBlock").load('MENU.php',{id: "<?php if(isset($_SESSION['userKey'])){echo $_SESSION['userKey'];} ?>"});
						     $(window).on('unload', function(){ $("input, select, textarea").attr('readonly', 'readonly'); $.ajax({method: 'POST', url: 'MAIN(server).php', data: {exit: 2}}); });});

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

function toggleFil(Fr)
{
if($(Fr).css('background-color')=='rgb(238, 13, 97)')
	{
	if($(Fr).html()=="Название")
		{
		$(Fr).css('background-color', '#97CC04');
		return;
		;}
	if($(Fr).html()=="Руководитель")
		{
		$(Fr).css('background-color', '#28AFB0');
		return;
		;}
	;}

if($(Fr).html()=="Название")
	{
	$(Fr).css('background-color', '#EE0D61');
	$(Fr).next().css('background-color', '#28AFB0');
	return;
	;}
if($(Fr).html()=="Руководитель")
	{
	$(Fr).css('background-color', '#EE0D61');
	$(Fr).prev().css('background-color', '#97CC04');
	return;
	;}	
;}

function CreateClassO(classOr)
{
typeO=new Array();
if(classOr==1)
	{typeO[0]='#5D2E8C'; typeO[1]='images/ithernet.png'; typeO[2]="Web-приложение";}
if(classOr==2)
	{typeO[0]='#00AFB5'; typeO[1]='images/computer.png'; typeO[2]="Desktop-приложение";}
if(classOr==3)
	{typeO[0]='orange'; typeO[1]='images/mobile.png'; typeO[2]="Мобильное приложение";}	
return typeO;
}

function ActivateMyIsp()
{
if($("#UpMenuMess")!=undefined){ $("#UpMenuMess").toggle(); }

$("#findOrder").val("");
selectVP=$("[name=selectV]");
$("#menuPoisk>div:eq(1)").css('background-color', '#28AFB0');
$("#menuPoisk>div:eq(2)").css('background-color', '#97CC04');
selectVP[0].selectedIndex=1;


if($("#MineorNot>div").css('left')==23+"px")
	{
	$("#MineorNot>div").css({'left':5, 'background-color':'gray'});
	$("#MineorNot>div, #moN").css('color','gray');
	loadUOrders();
	return;
	;}

$("#MineorNot>div").css({'left':23, 'background-color':'#EE0D61'});
$("#MineorNot>div, #moN").css('color','#EE0D61');
loadUOrders();
;}

function createSmIcTU(urlType)
{
mass=new Array();
if(urlType==1){mass[0]="#1FA637"; mass[1]="moderator"; return mass;} 
else if(urlType==2){mass[0]="#3A86FF"; mass[1]="student"; return mass;} 
else if(urlType==3){mass[0]="orange"; mass[1]="creator"; return mass;}
;}

function getUsrSUf(status)
{
if(status==0){return "images/offlineS.png";}else if(status==1){return "images/onlineS.png";}else if(status==2){return "images/redS.png";}else if(status==3){return "images/busyS.png";}
}

function deleteUOrds()
{
$("#UpMenuMess").remove();
loadID=1;
loadUOrders();
;}

function loadZAO(zaoOb)
{
if($(zaoOb).css('background-color')=='rgb(255, 255, 255)'){ return; }
if($(zaoOb).val()=="Активные")
	{ 
	$(zaoOb).prev().css({'background-color': '#EE0D61', 'color': 'white', 'border-bottom': '0px', 'opacity': 'auto'}); 
	$(zaoOb).css({'background-color': 'white', 'color': '#EE0D61', 'border-bottom': '1px solid white', 'opacity': 1});
	loadUOrders(2);	
	;}
if($(zaoOb).val()=="Завершенные")
	{ 
	$(zaoOb).next().css({'background-color': '#EE0D61', 'color': 'white', 'border-bottom': '0px', 'opacity': 'auto'}); 
	$(zaoOb).css({'background-color': 'white', 'color': '#EE0D61', 'border-bottom': '1px solid white', 'opacity': 1});
	loadUOrders(1);	
	}
;}
/// LOAD ///////////////////////////////////////////////////
idUserCh="<?php if(isset($idUOrders)){ echo $idUOrders; }?>";
statusOrd="<?php echo $statusO; ?>";
myO=parseInt("<?php echo $typeMyO; ?>");

if(statusOrd==0)
	{$(".forMOVE:first>input:eq("+0+")").css({'background-color': 'white', 'color': '#EE0D61', 'border-bottom': '1px solid white', 'font-size': '12pt', 'opacity': 1});}
if(statusOrd==1)
	{$(".forMOVE:first>input:eq("+1+")").css({'background-color': 'white', 'color': '#EE0D61', 'border-bottom': '1px solid white', 'font-size': '12pt', 'opacity': 1});}

if(idUserCh!="")
	{
	$("body>img:first").after('<div id="UpMenuMess" class="mediumBlocks" style="left: 1250px; top: 90px; display: flex; height: 60px; padding: 0px; align-items: center; overflow: hidden; border-radius: 20px;">\
			<img class="userPhoto" src="<?php echo @$userInfoO['imgS']; ?>" style="left: 25px; width: 50px; height: 50px;">\
			<img class="usrSt" src="'+getUsrSUf("<?php echo @$userInfoO['status']; ?>")+'" style="left: 58px; top: 38px; width: 13px; height: 13px; background-color: #FFFFFF; border: 2px solid #FFFFFF;">\
			<span class="redTextNorm" style="left: 205px;">Tag:</span><span class="text" style="left: 245px;">#<?php echo @$userInfoO['id']; ?></span>\
			<span class="redTextNorm" style="left: 330px;">Nname:</span><span class="text" style="left: 400px; width: 90px;"><?php echo @$userInfoO['login']; ?></span>\
			<img class="deleteImg opacity" src="images\\deleteIc.png" onload="$(this).click(deleteUOrds);" style="bottom: 19px; right: 11px; width: 20px; height: 20px;">\
			<div class="backForms textSm" style="left: 105px; background-color: '+createSmIcTU("<?php echo @$userInfoO['type']; ?>")[0]+'; height: 21px;">'+createSmIcTU("<?php echo @$userInfoO['type']; ?>")[1]+'</div>\
		</div>');
	;}

if(myO)
	{ ActivateMyIsp(); }

if(!myO)
	{ loadUOrders(); }
function loadUOrders(statusCh)
{
if(!FLOAD)
	{
	statusCh=parseInt("<?php echo $statusO; ?>")+1; 
	lastStatus=statusCh;
	loadID="<?php if(isset($idUOrders)){ echo $idUOrders; } if(isset($idUOrders)==false){ echo 1; }?>";
	}
$("#flexOrdersF>a").remove();
loadIDcompl=loadID;

if(statusCh!=null){lastStatus=statusCh;}
if(statusCh==null){statusCh=lastStatus;}

if($("#MineorNot>div").css('left')=='23px')
	{ loadIDcompl="<?php if(isset($_SESSION['userKey'])){echo $_SESSION['userKey'];} ?>"; }

$.ajax({method: 'POST', 
		url: 'MAIN(server).php',  
		data: {idUloadOrderF: loadIDcompl},
		dataType: 'json',
		success: function(data){if(!FLOAD){FLOAD=1;}
								if(statusCh==1){ $("#FZM>span:eq(3)").hide(); $("#FZM>span:eq(2)").css('left',259); }
								if(statusCh==2){ $("#FZM>span:eq(3)").show(); $("#FZM>span:eq(2)").css('left',190); }
								for(i=0; i!=data.length; i++)
									{									
									if(data[i]['status']==0 && statusCh==2){ continue; }
									if(data[i]['status']==1 && statusCh==1){ continue; }
									percents=data[i]['percents'];
									if(percents==null){ percents=0; }
									if(data[i]['ispS']==null){ data[i]['ispS']=0; }
									$("#flexOrdersF").append(
										'<a onclick="$.ajax({method: \'POST\', url: \'MAIN(server).php\', data: {chooseOrderNow: \''+data[i]['name']+'\'} });" href="http://localhost/diploma/orderU.php" class="skritBackRose" style="position: relative; height: 54px; width: 1300px; border: 1px solid #F3F4F3; border-radius: 10px; margin-bottom: 7px; text-decoration: none;">\
											<div class="priloshIconT" style="top: 7px; left: 15px; background-color: '+CreateClassO(data[i]['class'])[0]+';" title="'+CreateClassO(data[i]['class'])[2]+'">\
												<img src="'+CreateClassO(data[i]['class'])[1]+'" style="top: 6px; left: 6px; width: 28px; height: 28px;">\
											</div>\
											<span class="text" style="width: 700px; left: 630px; top: 15px;">'+data[i]['name']+'</span>\
											<div class="backForms" style="width: 17px; top: 15px; left: 99px; height: 21px; text-align: center; padding-top: 2px; background-color: #09E85E;">'+data[i]['ispS']+'</div>\
											<span class="text" style="left: 180px; top: 15px;">c '+data[i]['start']+'</span>\
											<div class="progressBar" style="left: 310px; top: 15px;">\
												<div style="width: 0px; height: inherit; background-color: #5BC0EB; left: 0px; top: 0px;">\
													<span style="top: 0px; color: #5BC0EB; font-size: 11pt;">'+percents+'%</span>\
												</div>\
											</div>\
											<div id="iconM" class="userIconT" style="top: 12px; left: 470px; background-color: #1FA637;"><img src='+CreateIconSU(data[i]['sex'], 1)[1]+' style="width: 21px; height: 21px; left: 3px;"></div>\
											<span class="text" style="left: 505px; top: 15px;">'+data[i]['nameR']+'</span>\
										 </a>');
									$("#flexOrdersF>a:last>.progressBar>div").width(parseInt(percents));
									if(parseInt(percents)>35)
							    		{ $("#flexOrdersF>a:last>.progressBar>div>span").css({'right': 5, 'color':'#FFFFFF'}); }
							    	if(parseInt(percents)<=35)
							    		{ $("#flexOrdersF>a:last>.progressBar>div>span").css('left', $("#flexOrdersF>a:last>.progressBar>div").width()+5); }
							    	if(data[i]['ispS']==7){ $("#flexOrdersF>a:last>.backForms").css('background-color', 'red'); }
							    	if(data[i]['ispS']==0){ $("#flexOrdersF>a:last>.backForms").css('background-color', 'blue'); }

							    	if(data[i]['status']==0){ $("#flexOrdersF>a:last>.progressBar").after('<span class="text" style="left: 310px; top: 15px;">по '+data[i]['end']+'</span>'); $("#flexOrdersF>a:last>.progressBar").remove(); }										
									;}
							   ;}
})
;}
//////////////////////////////////////////////////////////////
function FindWithF()
{
typeTitle=0;
if($("[name=selectV]").val()==1){ typeTitle="Web-приложение"; } if($("[name=selectV]").val()==2){ typeTitle="Desktop-приложение"; } if($("[name=selectV]").val()==3){ typeTitle="Мобильное приложение"; }

if($("#menuPoisk>div:eq(1)").css('background-color')!='rgb(238, 13, 97)' && $("#menuPoisk>div:eq(2)").css('background-color')!='rgb(238, 13, 97)' && $("#findOrder").val()!="")
	{ $("#mistakeFord").html("Укажите фильтр поиска"); return; }
if($("#findOrder").val()=='' && ($("#menuPoisk>div:eq(1)").css('background-color')=='rgb(238, 13, 97)' || $("#menuPoisk>div:eq(2)").css('background-color')=='rgb(238, 13, 97)'))
	{ $("#mistakeFord").html("Заполните форму"); return; }

$("#flexOrdersF>a").show();
$("#mistakeFord").html('');
if($("#menuPoisk>div:eq(1)").css('background-color')=='rgb(238, 13, 97)')
	{
	for(z=0; z!=$("#flexOrdersF>a").length; z++)
		{ 
		if($("#flexOrdersF>a:eq("+z+")>span:first").html().indexOf($("#findOrder").val())==-1)
			{ $("#flexOrdersF>a:eq("+z+")").hide(); }	
		}
	;}
if($("#menuPoisk>div:eq(2)").css('background-color')=='rgb(238, 13, 97)')
	{
	for(z=0; z!=$("#flexOrdersF>a").length; z++)
		{ 
		if($("#flexOrdersF>a:eq("+z+")>span:last").html().indexOf($("#findOrder").val())==-1)
			{ $("#flexOrdersF>a:eq("+z+")").hide(); } 
		}
	;}

for(z=0; z!=$("#flexOrdersF>a").length; z++)
	{
	if(typeTitle!=0 && $("#flexOrdersF>a:eq("+z+")>div:first").attr('title')!=typeTitle)
			{ $("#flexOrdersF>a:eq("+z+")").hide(); }  
	}
;}

$("#FINDfiltrs").click(FindWithF);
$("#MineorNot").click(ActivateMyIsp);
<?php @mysqli_close($BASEP); ?>///////////////// ADD ON ALL WINDOWS /////////////////////////////////////////////
</script>
</body>
</html>