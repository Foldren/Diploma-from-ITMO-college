
<!-- if($_POST){header('Location: fuserU.php');} -->

<?php 
header('Content-Type: text/html; charset=utf-8');
@$BASEFU=mysqli_connect("localhost","root","","dealandproducts","3306");
@mysqli_set_charset($BASEFU, "utf8");
session_start();
$userTypes=0;
$typeMyU=0;

if(isset($_POST['OPENI'])){ 
	$idUisps=$_POST['OPENI']; $typeMyU=0; 
	if($_POST['typeUPrf']!=1){ $userTypes=1; } if($_POST['typeUPrf']==1){ $userTypes=2; } if($_POST['OPENI']==$_SESSION['userKey']){ unset($idUisps); }
	}

if(isset($idUisps))
	{
	$userInfoU=mysqli_fetch_assoc(@mysqli_query($BASEFU, "select type, status, login, id from user where id={$idUisps};"));
	$userInfoU['imgS']=@glob("users/{$idUisps}/{*.png,*.bmp,*.jpeg,*.jpg}", GLOB_BRACE)[0];
	if($userInfoU['imgS']==null){ $userInfoU['imgS']='images/Anonymous.jpg'; }
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
//ADD AT ALL WINDOWS //////////////////////////////////////////
<?php
if(!isset($_SESSION['userKey']))
	{echo 'location.replace("http://localhost/diploma/authorizationU.php"); document.body.innerHTML="";'; session_destroy();} 
@mysqli_query($BASEP, "update user set status={$_SESSION['userStatusEXIT']} where id={$_SESSION['userKey']};");
?>	
</script>
	<img src="images/back4.png" style="width: 1900px; height: 2300px; position: fixed;">
<!-- ZAKAZLIST -->
	<!-- TYPES USERS -->
	<div id="typesUsB" class="forMOVE" style="user-select: none;">
		<div class="buttons" style="left: 440px; top: 152px; border-radius: 10px 10px 0px 0px;" onclick="loadARI(this);">Все</div>
		<div class="buttons" style="left: 495px; top: 152px; border-radius: 10px 10px 0px 0px;" onclick="loadARI(this);">Руководители</div>
		<div class="buttons" style="left: 632px; top: 152px; border-radius: 10px 10px 0px 0px;" onclick="loadARI(this);">Исполнители</div>
	</div>
	<div id="UsersList" class="largeBlocks forMOVE" style="left: 395px; top: 180px; width: 1250px; height: 900px; padding: 50px; overflow-y: none;">
	<!-- MENUPOISK -->
		<div id="menuPoisk" style="user-select: none;">
			<div id="FBut" class="buttons" style="background-color: #EE0D61; width: 80px; text-align: center; height: 24px;" onclick="FindWithFiltr();">Поиск</div>
			<div class="buttons" style="background-color: #97CC04; width: 75px; left: 740px; text-align: center;" onclick="toggleFiltr(this);">Никнейм</div>
			<div class="buttons" style="background-color: #F5B700; width: 42px; left: 840px; text-align: center;" onclick="toggleFiltr(this);">ФИО</div>
			<div class="buttons" style="background-color: #8D5A97; width: 42px; left: 908px; text-align: center;" onclick="toggleFiltr(this);">Tag</div>
			<input placeholder="Введите данные для поиска..." class="buttons text" id="findUser" style="height: 27px; width: 600px; background-color: #FEFEFE; left: 120px; padding: 0px 15px 3px 35px; border: 1px solid #B1B2B1; color: black; font-size: 12pt;">
				<img src="images/findimage.png" style="left: 128px; top: 4px; width: 20px; height: 20px; opacity: 0.2;">
			<hr color='#F5F6F5' noshade style="width: 1250px; size: 1px; top: 100px; border-top: 1px dashed red;">
		</div>
	<!-- INFOFIND USERS -->
		<div class="redTextSm" style="background-color: white; width: 1000px; top: 190px; user-select: none;">
			<span style="left: 37px;">Категория</span>
			<span style="left: 233px;">Никнейм</span>
			<span style="left: 409px;" title="Число активных заказов">А-З</span>
			<span style="left: 489px;" title="Число завершенных заказов">З-З</span>
			<span style="left: 572px;" title="Число исполнителей/руководителей">И/Р</span>
			<span style="left: 870px;">Полное имя</span>
		</div>
		<span id="moN" class="redTextSm" style="right: 120px; top: 110px; color: #EE0D61; user-select: none; visibility: hidden;"></span>
		<div class="buttons" id="MineorNot" style="width: 40px; right: 50px; top: 105px; background-color: white; border: 1px solid #B1B2B1; opacity: 1; visibility: hidden;">
			<div class="buttons" style="width: 12px; height: 18px; left: 23px; background-color: #EE0D61;" onclick="ActivateMyU();"></div>
		</div>
		<div class="scrollSmall" style="width: inherit; height: 750px; top: 230px; overflow-x: hidden; overflow-y: auto;">
			<div id="flexUsL" style="display: flex; flex-direction: column; width: inherit; height: auto;">
				<!-- FIND USERS HERE -->
			</div>
		</div>
		<span id="mistakeFord" class="textSm" style="color: gray; top: 100px;"></span>
	</div>
	<div id="menuBlock"></div>
<script type="text/javascript">
lastTypeU=0;
FLOAD=0;
loadIDU=new String();
typeUs=parseInt("<?php echo $userTypes; ?>");
typeUsSes=parseInt("<?php if(isset($_SESSION['userKey'])){ echo mysqli_fetch_row(@mysqli_query($BASEFU, "select type from user where id={$_SESSION['userKey']};"))[0]; } ?>");
/////////////////////////////////////////////////////////////
$(document).ready(function(){$("#menuBlock").load('MENU.php', {id: "<?php if(isset($_SESSION['userKey'])){echo $_SESSION['userKey'];} ?>"});
						     $(window).on('unload', function(){ $.ajax({method: 'POST', url: 'MAIN(server).php', data: {exit: 2}}); });});

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

function loadARI(zaoOb)
{
if($("#MineorNot>div").css('left')==23+"px")
	{
	$("#MineorNot>div").css({'left':5, 'background-color':'gray'});
	$("#MineorNot>div, #moN").css('color','gray');
	$("#UpMenuMess").show();
	;}
if($(zaoOb).css('background-color')=='rgb(255, 255, 255)'){ return; }
$("#typesUsB>div").css({'background-color': '#EE0D61', 'color': 'white', 'border-bottom': '0px', 'opacity': 'auto'}); 

if($(zaoOb).html()=="Все")
	{ 
	$("#UsersList>div:eq(2), #UsersList>span:first").css('visibility', 'hidden');
	$(zaoOb).css({'background-color': 'white', 'color': '#EE0D61', 'border-bottom': '1px solid white', 'opacity': 1});
	loadUserList(0);	
	;}
if($(zaoOb).html()=="Руководители")
	{ 
	$("#UsersList>div:eq(2), #UsersList>span:first").css('visibility', 'hidden');
	$(zaoOb).css({'background-color': 'white', 'color': '#EE0D61', 'border-bottom': '1px solid white', 'opacity': 1});
	if(typeUsSes!=1){
		$("#UsersList>div:eq(2)").css('visibility', 'visible');
		$("#UsersList>span:first").html('Мои руководители').css('visibility', 'visible');}
	loadUserList(1);	
	}
if($(zaoOb).html()=="Исполнители")
	{ 
	$("#UsersList>div:eq(2), #UsersList>span:first").css('visibility', 'hidden');
	$(zaoOb).css({'background-color': 'white', 'color': '#EE0D61', 'border-bottom': '1px solid white', 'opacity': 1});
	if(typeUsSes==1){
		$("#UsersList>div:eq(2)").css('visibility', 'visible');
		$("#UsersList>span:first").html('Мои исполнители').css('visibility', 'visible');}
	loadUserList(2);	
	}
;}

function deleteUIR()
{
$("#UpMenuMess").remove();
loadIDU=1;
loadUserList();
;}

function ActivateMyU()
{
if($("#UpMenuMess")!=undefined){ $("#UpMenuMess").toggle(); }

$("#findUser").val("");
$("#menuPoisk>div:eq(1)").css('background-color', '#97CC04');
$("#menuPoisk>div:eq(2)").css('background-color', '#F5B700');
$("#menuPoisk>div:eq(3)").css('background-color', '#8D5A97');


if($("#MineorNot>div").css('left')==23+"px")
	{
	$("#MineorNot>div").css({'left':5, 'background-color':'gray'});
	$("#MineorNot>div, #moN").css('color','gray');
	loadUserList();
	return;
	;}

$("#MineorNot>div").css({'left':23, 'background-color':'#EE0D61'});
$("#MineorNot>div, #moN").css('color','#EE0D61');
loadUserList();
;}

function toggleFiltr(Fltr)
{
if($(Fltr).css('background-color')!='rgb(238, 13, 97)')
	{
	$("#menuPoisk>div:eq(1)").css('background-color', '#97CC04');
	$("#menuPoisk>div:eq(2)").css('background-color', '#F5B700');
	$("#menuPoisk>div:eq(3)").css('background-color', '#8D5A97');
	$(Fltr).css('background-color', '#EE0D61');
	return;
	}

$("#menuPoisk>div:eq(1)").css('background-color', '#97CC04');
$("#menuPoisk>div:eq(2)").css('background-color', '#F5B700');
$("#menuPoisk>div:eq(3)").css('background-color', '#8D5A97');
;}

function FindWithFiltr()
{
if($("#menuPoisk>div:eq(1)").css('background-color')!='rgb(238, 13, 97)' && $("#menuPoisk>div:eq(2)").css('background-color')!='rgb(238, 13, 97)' && $("#menuPoisk>div:eq(3)").css('background-color')!='rgb(238, 13, 97)' && $("#findUser").val()!="")
	{ $("#mistakeFord").html("Укажите фильтр поиска"); return; }
if($("#findUser").val()=='' && 
	($("#menuPoisk>div:eq(1)").css('background-color')=='rgb(238, 13, 97)' || 
	$("#menuPoisk>div:eq(2)").css('background-color')=='rgb(238, 13, 97)' || 
	$("#menuPoisk>div:eq(3)").css('background-color')=='rgb(238, 13, 97)'))
		{ $("#mistakeFord").html("Заполните форму"); return; }

$("#flexUsL>a").show();
$("#mistakeFord").html('');
if($("#menuPoisk>div:eq(1)").css('background-color')=='rgb(238, 13, 97)')
	{
	for(z=0; z!=$("#flexUsL>a").length; z++)
		{ 
		if($("#flexUsL>a:eq("+z+")>span:first").html().indexOf($("#findUser").val())==-1)
			{ $("#flexUsL>a:eq("+z+")").hide(); }	
		}
	;}
if($("#menuPoisk>div:eq(2)").css('background-color')=='rgb(238, 13, 97)')
	{
	for(z=0; z!=$("#flexUsL>a").length; z++)
		{ 
		if($("#flexUsL>a:eq("+z+")>span:last").html().indexOf($("#findUser").val())==-1)
			{ $("#flexUsL>a:eq("+z+")").hide(); } 
		}
	;}
if($("#menuPoisk>div:eq(3)").css('background-color')=='rgb(238, 13, 97)')
	{
	for(z=0; z!=$("#flexUsL>a").length; z++)
		{ 
		if($("#flexUsL>a:eq("+z+")").attr("data-tag").indexOf($("#findUser").val())==-1)
			{ $("#flexUsL>a:eq("+z+")").hide(); } 
		}
	;}
;}

////////////////// load /////////////////////////////////////////////////
idUserCh="<?php if(isset($idUisps)){ echo $idUisps; }?>";
myN=parseInt("<?php echo $typeMyU; ?>");

if(typeUs==0)
	{ $("#typesUsB>div:eq(0)").css({"background-color": "white", "color": "#EE0D61", "border-bottom": "1px solid white", "opacity": "1"}); }
if(typeUs==1)
	{ 
	$("#typesUsB>div:eq(1)").css({"background-color": "white", "color": "#EE0D61", "border-bottom": "1px solid white", "opacity": "1"}); 
	if(typeUsSes!=1){
		$("#UsersList>div:eq(2)").css('visibility', 'visible');
		$("#UsersList>span:first").html('Мои руководители').css('visibility', 'visible');}
	}
if(typeUs==2)
	{ 
	$("#typesUsB>div:eq(2)").css({"background-color": "white", "color": "#EE0D61", "border-bottom": "1px solid white", "opacity": "1"});
	if(typeUsSes==1){
		$("#UsersList>div:eq(2)").css('visibility', 'visible');
		$("#UsersList>span:first").html('Мои исполнители').css('visibility', 'visible');}
	}
if(myN==1)
	{
	ActivateMyU();
	;}
if(!myN)
	{
	loadUserList();
	;}

if(idUserCh!="")
{
$("body>img:first").after('<div id="UpMenuMess" class="mediumBlocks" style="left: 1250px; top: 90px; display: flex; height: 60px; padding: 0px; align-items: center; overflow: hidden; border-radius: 20px;">\
		<img class="userPhoto" src="<?php echo @$userInfoU['imgS']; ?>" style="left: 25px; width: 50px; height: 50px;">\
		<img class="usrSt" src="'+getUsrSUf("<?php echo @$userInfoU['status']; ?>")+'" style="left: 58px; top: 38px; width: 13px; height: 13px; background-color: #FFFFFF; border: 2px solid #FFFFFF;">\
		<span class="redTextNorm" style="left: 205px;">Tag:</span><span class="text" style="left: 245px;">#<?php echo @$userInfoU['id']; ?></span>\
		<span class="redTextNorm" style="left: 330px;">Nname:</span><span class="text" style="left: 400px; width: 90px;"><?php echo @$userInfoU['login']; ?></span>\
		<img class="deleteImg opacity" src="images\\deleteIc.png" onload="$(this).click(deleteUIR);" style="bottom: 19px; right: 11px; width: 20px; height: 20px;">\
		<div class="backForms textSm" style="left: 105px; background-color: '+createSmIcTU("<?php echo @$userInfoU['type']; ?>")[0]+'; height: 21px;">'+createSmIcTU("<?php echo @$userInfoU['type']; ?>")[1]+'</div>\
	</div>');
;}

function loadUserList(typeU)
{
if(!FLOAD)
	{
	typeU=parseInt("<?php echo $userTypes; ?>"); 
	lastTypeU=typeU;
	loadIDU=parseInt("<?php if(isset($idUisps)==true){ echo $idUisps; } if(isset($idUisps)==false){ echo 1; }?>");
	}
$("#flexUsL>a").remove();
loadIDcomplete=loadIDU;

if(typeU!=null){lastTypeU=typeU;}
if(typeU==null){typeU=lastTypeU;}

if($("#MineorNot>div").css('left')=='23px' && ((typeU==1 && typeUsSes!=1) || (typeU==2 && typeUsSes==1)))
	{ loadIDcomplete="<?php if(isset($_SESSION['userKey'])){echo $_SESSION['userKey'];} ?>"; }

$.ajax({method: 'POST',
		url: 'MAIN(server).php',
		data: {idULus: loadIDcomplete},
		dataType: 'json',
		success: function(data){$("#flexUsL>a").remove();
								if(!FLOAD){FLOAD=1;}
								for(p=0; p!=data.length; p++)
									{
									if(typeU==1 && data[p]['type']!=1){ continue; }
									if(typeU==2 && data[p]['type']==1){ continue; }
									$("#flexUsL").append(
										'<a class="skritBackRose" onclick="$.ajax({method: \'POST\', url: \'MAIN(server).php\', data: {chooseUserNow: \''+data[p]['id']+'\'} });" href="http://localhost/diploma/profileU.php" style="position: relative; margin-bottom: 7px; height: 74px; width: 1250px; border: 1px solid #F3F4F3; border-radius: 10px; display: flex; align-items: center;" data-tag="'+data[p]['id']+'">\
											<div class="backForms" style="background-color: '+createSmIcTU(data[p]['type'])[0]+'; left: 25px; width: 80px; text-align: center;">'+createSmIcTU(data[p]['type'])[1]+'</div>\
											<div style="width: 70px; height: 70px; top: 12px; left: 170px;">\
												<img src="'+data[p]['imgSrc']+'" class="userPhoto" style="width: 50px; height: 50px;">\
												<img class="usrSt" src="'+getUsrSUf(data[p]['status'])+'" style="left: 32px; bottom: 20px;">\
											</div>\
											<span class="text" style="left: 260px; width: 125px;">'+data[p]['login']+'</span>\
											<div style="width: 50px; height: 20px; left: 400px;">\
												<img src="images/zakazIND.png" style="width: 21px; height: 21px;">\
												<span class="text" style="left: 26px;">'+data[p]['actOrd']+'</span>\
											</div>\
											<div style="width: 50px; height: 20px; left: 480px;">\
												<img src="images/allnice.png" style="width: 21px; height: 21px;">\
												<span class="text" style="left: 26px;">'+data[p]['unactOrd']+'</span>\
											</div>\
											<div style="width: 50px; height: 20px; left: 560px;">\
												<img src="images/workers.png" style="width: 25px; height: 25px; top: -2px;">\
												<span class="text" style="left: 26px;">'+data[p]['isplTypes']+'</span>\
											</div>\
											<span class="text" style="left: 720px;" title="'+data[p]['FIO']+'">'+data[p]['FIO']+'</span>\
										</a>');
									if(data[p]['type']!=1){ $("#flexUsL>a:last>div:last>img").attr('src','images/managersT.png'); }
									;}
								}
		});
;}
///////////////////////////////////////////////////////////////////////////
<?php @mysqli_close($BASEP); ?>///////////////// ADD ON ALL WINDOWS /////////////////////////////////////////////
</script>
</body>
</html>