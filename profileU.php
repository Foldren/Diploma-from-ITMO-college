<?php 
header('Content-Type: text/html; charset=utf-8');
@$BASEP=mysqli_connect("localhost","root","","dealandproducts","3306");
@mysqli_set_charset($BASEP, "utf8");
session_start();
if(isset($_SESSION['userKey'])){$idchUser=$_SESSION['userKey'];}
if(isset($_SESSION['userChoose'])){$idchUser=$_SESSION['userChoose'];}
?>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
*{text-overflow: ellipsis;}
input[type='number']{-moz-appearance:textfield;}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button{-webkit-appearance: none;}
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
<body style="background: #FEFEFE; height: 2300px; overflow-x: hidden;" onloadstart="$(this).hide();">
<script type="text/javascript">
//ADD AT ALL WINDOWS //////////////////////////////////////////
<?php
if(!isset($_SESSION['userKey']))
	{echo 'location.replace("http://localhost/diploma/authorizationU.php"); document.body.innerHTML="";'; session_destroy();} 
@mysqli_query($BASEP, "update user set status={$_SESSION['userStatusEXIT']} where id={$_SESSION['userKey']};");
?>	
</script>
<!-- PROFILE IMG-->
	<form id="FUsers" method="POST" action="http://localhost/diploma/fuserU.php" accept-charset="utf8"></form>
	<form id="FOrders" method="POST" action="http://localhost/diploma/forderU.php" accept-charset="utf8"></form>
	<img src="images/back4.png" style="width: 1900px; height: 2300px; position: fixed;">
	<div id="buttonsUpr" class="forMOVE" style="left: 550px; top: 60px;">
		<img id="profileimg" src="images/Anonymous.jpg" onerror='this.src="images/errorLoad.jpeg";' style="left: 415px; width: 170px; height: 170px; border-radius: 25px;">
			<input type="file" name="loadAvatar" style="visibility: hidden; left: 415px; width: 170px; height: 170px; border-radius: 25px;">
		<hr color="#F5F6F5" noshade style="width: 100px; height: 4px; top: 76px; left: 450px; visibility: hidden;">
		<hr color="#F5F6F5" noshade style="height: 100px; width: 4px; left: 497px; top: 30px; visibility: hidden;">
		<div style="left: 250px; top: 200px; width: 500px;">
			<span class="text" style="left: 110px; top: 0px; font-family: 'Exo'; color: #EE0D61; user-select: none;">Tag:</span>
			<span class="text" style="left: 150px; top: 1px; font-family: 'Exo'; color: white; font-size: 12pt;">
				#<?php echo $idchUser; ?>	
			</span>
			<span class="text" style="left: 240px; top: 0px; font-family: 'Exo'; color: #EE0D61; user-select: none;">Nickname:</span>
			<span class="text" style="left: 330px; top: 0px; color: white; font-family: 'Exo 2';">
				<?php echo mysqli_fetch_row(@mysqli_query($BASEP, "select login from user where id='{$idchUser}';"))[0]; ?>
			</span>
			<span class="text" style="left: 110px; top: 25px; color: #EE0D61; visibility: hidden; user-select: none;">Полное имя:</span>
			<span class="text" style="left: 220px; top: 25px; color: white;">
				<?php echo mysqli_fetch_row(@mysqli_query($BASEP, "select FIO from user where id='{$idchUser}';"))[0]; ?>
			</span>
		</div>
		<div class="buttons" style="background-color: #1B998B; border-radius: 15px; width: 214px; height: 35px; left: 164px; top: 265px; padding: 0px; cursor: pointer;">
			<span class="text" style="left: 62px; top: 6px; color: white; user-select: none;">Активные заказы</span>
			<img src="images/activeZ.png" style="left: 36px; top: 6px; width: 21px; height: 24px;">
			<div style="border-right: 1px solid #6DBEB5; width: 33px; height: inherit; top: 0px; left: 0px;">
				<span class="text" style="top: 7px; width: inherit; color: white; font-size: 12pt; text-align: center; user-select: none;">
					<?php
						$queryAO=@mysqli_query($BASEP, "select distinct(id_order) as 'idO', (select count(*) from participant where id_order=idO and manager=0 and noticeADD=1) from participant, order_app where id_user={$idchUser} and noticeADD=1 and order_app.id=participant.id_order and order_app.status=1;");
						echo mysqli_num_rows($queryAO);
					?>
				</span>
			</div>
			<input type="submit" name="OPENAO" form="FOrders" style="opacity: 0; width: inherit; height: inherit; border-radius: 15px; cursor: pointer;" value="<?php echo $idchUser; ?>">
		</div>
		<div class="buttons" style="background-color: #66C3FF; border-radius: 15px; width: 183px; height: 35px; left: 407px; top: 265px; padding: 0px; cursor: pointer;">
			<span class="text" style="left: 61px; top: 6px; color: white; user-select: none;">
				<?php 
					$typeUs=mysqli_fetch_row(@mysqli_query($BASEP, "select type from user where id={$idchUser}"))[0]; if($typeUs==1){echo "Исполнители";} if($typeUs!=1){echo "Руководители";}
				?>	
			</span>
			<img src="images/sotrud.png" style="left: 36px; top: 6px; width: 21px; height: 21px;">
			<div style="border-right: 1px solid #B9E3FF; width: 33px; height: inherit; top: 0px; left: 0px;">
				<span class="text" style="top: 7px; width: inherit; color: white; font-size: 12pt; text-align: center; user-select: none;">
					<?php 
						$queryO=@mysqli_query($BASEP, "select id_order as 'idO', (select count(*) from participant where id_order=idO and manager=0 and noticeADD=1) from participant where id_user={$idchUser} and noticeADD=1;");
						$ordersId=mysqli_fetch_all($queryO, MYSQLI_BOTH);
						$countIs=0;

						if($typeUs==1)
							{
							for($i=0; $i!=mysqli_num_rows($queryO); $i++)
								{ $countIs+=mysqli_fetch_row(@mysqli_query($BASEP, "select count(*) from participant where id_order={$ordersId[$i]['idO']} and manager=0;"))[0]; }
							echo $countIs;
							}
						if($typeUs!=1)
							{ echo mysqli_num_rows($queryO); }
					?>
				</span>
			</div>
			<input type="submit" name="OPENI" form="FUsers" style="opacity: 0; width: inherit; height: inherit; border-radius: 15px; cursor: pointer;" value="<?php echo $idchUser; ?>">
			<input type="hidden" name="typeUPrf" form="FUsers" value="<?php echo $typeUs; ?>">
		</div>
		<div id="MESSAGES" class="buttons" style="background-color: #3EC0F0; border-radius: 15px; width: 220px; height: 35px; left: 617px; top: 265px; padding: 0px; cursor: pointer;">
			<span class="text" style="left: 62px; top: 6px; color: white; user-select: none;"></span>
			<img src="images/uvedsoob.png" style="left: 36px; top: 7px; width: 21px; height: 24px;">
			<div style="border-right: 1px solid #84D6F5; width: 33px; height: inherit; top: 0px; left: 0px;">
				<span class="text" style="top: 7px; width: inherit; color: white; font-size: 12pt; text-align: center; user-select: none;">
					<?php 
						$rowZM=mysqli_fetch_row(@mysqli_query($BASEP, "select count(id) from message where id_recipient={$idchUser} and status=0;"))[0]; 
						if($rowZM==false || $_SESSION['userKey']!=$idchUser){echo "";} 
						else if($rowZM){echo $rowZM;} 
					?>
				</span>
			</div>
		</div>	
		<div class="buttons" id="addNoticeU" style="background-color: #26A96C; border-radius: 12px; left: 600px; top: 130px; padding: 0px; width: 35px; height: 35px;">
			<hr color="#F5F6F5" noshade style="width: 17px; height: 1px; top: 9px; left: 8px;">
			<hr color="#F5F6F5" noshade style="height: 17px; width: 1px; left: 16px; top: 1px;">
		</div>
	</div>

<!-- PROFILE INFO -->
	<form id="formDate" method="POST" accept-charset="utf8"></form>
	<form id="formFile" method="POST" enctype="multipart/form-data"></form>
	<div id="profileInf" class="largeBlocks forMOVE" style='left: 600px; top: 380px; height: 1400px; padding: 50px'>
			<span class="text" style="left: 10%; top: 70px; color: #EE0D61; user-select: none;">Основная информация ______________________________________________________</span>
			<span class="text" style="left: 10%; top: 140px; color: #EE0D61; user-select: none;">Ник:</span>
				<span class="text" style="left: 24%; top: 140px; padding-left: 5px;">
					<?php echo mysqli_fetch_row(@mysqli_query($BASEP, "select login from user where id='{$idchUser}';"))[0]; ?>	
				</span>
			<span class="text" style="left: 10%; top: 200px; color: #EE0D61; user-select: none;">Имя:</span>
				<input name="nameUP" type="text" class="text" value="" style="left: 24%; top: 199px; padding: 0px; padding-left: 5px; border-radius: 10px; border: 0px solid #979DA5; width: 320px;" readonly maxlength="20" form="formDate">
			<span class="text" style="left: 10%; top: 260px; color: #EE0D61; user-select: none;">Фамилия:</span>
				<input name="secnameUP" type="text" class="text" value="" style="left: 24%; top: 260px; padding: 0px; padding-left: 5px; border-radius: 10px; border: 0px solid #979DA5; width: 320px;" readonly maxlength="25" form="formDate">
			<span class="text" style="left: 10%; top: 320px; color: #EE0D61; user-select: none;">Отчество:</span>
				<input name="thirdnameUP" type="text" class="text" value="" style="left: 24%; top: 320px; padding: 0px; padding-left: 5px; border-radius: 10px; border: 0px solid #979DA5; width: 320px;" readonly maxlength="35" form="formDate">
			<span class="text" style="left: 10%; top: 420px; color: #EE0D61; user-select: none;">Информация о компании ____________________________________________________</span>
			<span class="text" style="left: 10%; top: 490px; color: #EE0D61; user-select: none;">О себе:</span>
				<textarea name="infoUP" class="areatext" style="left: 24%; top: 489px; outline: none; width: 610px; height: 79px; resize: none; border: 0px solid #979DA5; border-radius: 10px; padding-left: 5px; line-height: 1.2;" readonly maxlength="205" form="formDate"></textarea>
			<span class="text" style="left: 10%; top: 599px; color: #EE0D61; user-select: none;">Организация:</span>
				<input name="nameorgUP" type="text" class="text" value="" style="left: 24%; top: 599px; padding: 0px; padding-left: 5px; border-radius: 10px; border: 0px solid #979DA5; width: 610px;" readonly maxlength="64" placeholder="Пользователь пока не указал данные" form="formDate">
			<span class="text" style="left: 10%; top: 659px; color: #EE0D61; user-select: none;">ИНН:</span>
				<input name="innUP" type="number" class="text" value="" style="left: 24%; top: 659px; padding: 0px; padding-left: 5px; border-radius: 10px; border: 0px solid #979DA5; width: 320px; text-overflow: clip;" readonly onkeypress="this.value=this.value.substring(0,11);" form="formDate">
			<span class="text" style="left: 10%; top: 759px; color: #EE0D61; user-select: none;">Квалификация _____________________________________________________________</span>
			<span class="text" style="left: 10%; top: 819px; color: #EE0D61; user-select: none;">Образование:</span>
				<input name="obrazUP" type="text" class="text" value="" style="left: 24%; top: 819px; padding: 0px; padding-left: 5px; border-radius: 10px; border: 0px solid #979DA5; width: 610px;" readonly maxlength="64" form="formDate">
			<span class="text" style="left: 10%; top: 879px; color: #EE0D61; user-select: none;">Должность:</span>
				<input name="dolshnUP" type="text" class="text" value="" style="left: 24%; top: 879px; padding: 0px; padding-left: 5px; border-radius: 10px; border: 0px solid #979DA5; width: 610px;" readonly maxlength="64" form="formDate">
<!-- PRILOSHENIA -->
		<span class="text" style="left: 10%; top: 979px; color: #EE0D61; user-select: none;">Портфолио ________________________________________________________________</span>
			<div id="scrollSmall" style="top: 1039px; width: 740px; height: 300px; overflow-x: auto; overflow-y: hidden; left: 10%;">
				<div id="PRILOSHflex" style="height: inherit; display: flex; flex-direction: row; padding-right: -120px;">
					<!-- SUMMPLEMENTS HERE -->
				</div>
			</div>
		<span id="mistakePU" class="textSm" style="color: #E8BE4A; bottom: 68px; width: inherit; left: 10%;"></span>
		<div id="REDACT" class="buttons" style="left: 385px; bottom: 60px; width: 130px; text-align: center; padding-top: 4px; user-select: none;">Редактировать</div>
	</div>
	<div id="messBlock" style="left: 0px; top: 380px;"></div>
	<div id="menuBlock"></div>
		
	<div id="listADDO3" id="listADDSdop" class="smallBlocks" style="width: 13px; left: 1350px; top: 130px; border-bottom-left-radius: 0px; border-top-left-radius: 0px; visibility: hidden; height: 160px;"></div>
	<img id="listADDO2" src="images/whiteTR.png" style="left: 1185px; top: 197px; width: 20px; height: 20px; visibility: hidden;">
	<div id="listADDO1" class="smallBlocks scrollSmall" style="left: 1200px; top: 130px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; background-color: #FFFFFF; visibility: hidden; height: 160px; overflow-y: auto; overflow-x: hidden;">
		<div id="flexOrdersAdd" style="display: flex; flex-direction: column; width: inherit; height: auto; padding-left: 15px; padding-top: 10px;">
			<!-- HERE AVAILABLE ORDERS TO ADD -->
		</div>
	</div>

<script type="text/javascript">
loadSumpls=0;
// block name ////////////////////////////////////////////////
if($("#buttonsUpr>div:first>span:eq(5)").html()!=false){$("#buttonsUpr>div:first>span:eq(4)").css('visibility', 'visible');};

$("#buttonsUpr>div:eq(3)>span:first").html("<?php if($idchUser!=$_SESSION['userKey']){ echo 'Отправить сообщение'; } if($idchUser==$_SESSION['userKey']){ echo 'Новые сообщения'; }?>");
if($("#buttonsUpr>div:eq(3)>span:first").html()=="Отправить сообщение"){$("#buttonsUpr>div:eq(3)").width(253);}
/// notice button ////////////////////////////////////////////
<?php
$typeUserS=mysqli_fetch_row(@mysqli_query($BASEP, "select type from user where id={$_SESSION['userKey']};"))[0]; 
$typeUserCh=mysqli_fetch_row(@mysqli_query($BASEP, "select type from user where id={$idchUser};"))[0]; 
$notice=mysqli_fetch_row(@mysqli_query($BASEP, "select noticeADD from participant where id_user={$idchUser};"))[0]; 
$statusBut=0;
if($typeUserS==1 && $typeUserCh==1 || $typeUserS!=1)
	{$statusBut=1;} //FORmanager
if($idchUser==$_SESSION['userKey'])
	{$statusBut=2;} 
?>

statusButton=parseInt("<?php echo $statusBut; ?>");
if(statusButton==1 || statusButton==2)
	{$("#addNoticeU").remove(); $("#addNoticeU").off('click');}
if(statusButton!=2)
	{$("#REDACT").remove();}

function sentNoticeADD(nameOrd)
{
$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {sentNoticeOrder: "<?php echo $idchUser; ?>", idOrder: $(nameOrd).parent().find('span').html()} });
$(nameOrd).parent().remove();
$("#addNoticeU").click();
;}

$("#addNoticeU").on('click', function(){
	if($("#listADDO1").css('visibility')=='visible')
		{
		$("#listADDO1, #listADDO2, #listADDO3").css('visibility', 'hidden');  
		$("#flexOrdersAdd>div").remove(); 
		return;
		}
	
	$("#listADDO1, #listADDO2, #listADDO3").css('visibility', 'visible');
	$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {showADDnoticForU : "<?php echo $idchUser; ?>"},
		dataType: 'json',
		success: function(data){for(i=0; i!=data.length; i++)
									{
									if(data[i]['name']!=null)
										{
										$("#flexOrdersAdd").append(
										'<div style="position: relative; width: inherit; height: 21px; margin-bottom: 5px;">\
											<span class="textSm" style="top: 1px; width: 107px;" title="'+data[i]['name']+'">'+data[i]['name']+'</span>\
											<div class="buttons" style="width: 17px; height: 17px; padding: 0px; right: 20px; top: 2px; border-radius: 5px;" onclick="sentNoticeADD(this);">\
												<div style="width: 1px; height: 11px; top: 3px; left: 8px; background-color: #F5F6F5;"></div>\
												<div style="width: 11px; height: 1px; top: 8px; left: 3px; background-color: #F5F6F5;"></div>\
											</div>\
										</div>');
										;}	
									}
								if($("#flexOrdersAdd>div").length==0)
									{
									$("#flexOrdersAdd").append("<span class='textSm' style='color:gray; top: 66px; text-align: center; left: 30px;'>Нет доступных<br>заказов</span>");
									;}
								}
			});
});
/// info about user /////////////////////////////////////////
$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {userINFO : "<?php echo $idchUser;?>"},
		dataType: 'json',
		success: function(data){
							   for(j=0;j<=6;j++){$("#profileInf>input:eq("+j+")").attr('placeholder', "Пользователь пока не указал данные");}
							   $("#profileInf>textarea").attr('placeholder', "Пользователь пока не указал данные");
							   if(data[0]!=null){
							   		fstP=data[0].indexOf(" ",1);
							   		sdP=data[0].indexOf(" ",fstP+1);
								   	if(fstP!=0){$("#profileInf>input:eq(1)").val(data[0].substring(0,fstP));}
							  		if(sdP!=0){$("#profileInf>input:eq(0)").val(data[0].substring(fstP+1,sdP));}
							   		if(sdP!=data[0].length){$("#profileInf>input:eq(2)").val(data[0].substring(sdP+1, data[0].length));}
							   		;}
							   if(data[1]!="null"){$("#profileInf>input:eq(3)").val(data[1]);} if(data[2]!="null"){$("#profileInf>input:eq(4)").val(data[2]);} 
							   if(data[3]!="null"){$("#profileInf>input:eq(5)").val(data[3]);} if(data[4]!='null'){$("#profileInf>input:eq(6)").val(data[4]);}
							   if(data[5]!="null"){$("#profileInf>textarea").val(data[5]);}
							   ;}
		});
$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {avatar : "<?php if($idchUser==$_SESSION['userKey']){echo 1;} else if($idchUser!=$_SESSION['userKey']){echo $idchUser;} ?>"},
		dataType: 'text',
		success: function(data){$("#profileimg").attr('src', data);}
		});
/// sumpl user////////////////////////////////////////////////////
function deleteLoadSumpl()
{
$(this).parent().find("textarea").html($(this).parent().find("img").attr("src"));
$(this).parent().css('display','none');
;}

$.ajax({method: 'POST', 
		url: 'MAIN(server).php', 
		data: {userPril: "<?php echo $idchUser; ?>"},
		dataType: 'json',
		success: function(data){if(!data.length){ return; };
								for(j=0; j!=data.length; j++)
								    {
								    $("#PRILOSHflex").append("\
								   		<div id='loadFILE"+j+"' style='position: relative; height: inherit; width: 200px; margin-right: 40px;''>\
											<img class='prilosh' src='"+data[j]+"'>\
											<textarea name='loadSump"+j+"' class='areatext TA' style='width: 190px; top: 220px; left: 5px; text-align: center; height: 50px;' readonly maxlength='40' form='formDate'>"+data[j].substring(19, data[j].lastIndexOf("."))+"</textarea>\
											<img class='deleteImg' src='images\\deleteIc.png'\
							   			 		onload='$(this).click(deleteLoadSumpl);' style='top: 5px; right: 5px; width: 30px; height: 30px; visibility: hidden;'>\
										</div>\
								   	");
								   	loadSumpls++;
									;}
							   ;}
		});
/////////////////////////////////////////////////////////////////
$("#messBlock").offset({left: $("#profileInf").offset().left-50});
$(document).ready(function(){
							$("#menuBlock").load('MENU.php',{id: "<?php if(isset($_SESSION['userKey'])){echo $_SESSION['userKey'];} ?>"}); 
							$("#messBlock").load('dialogsBlock.php',{id: "<?php if(isset($_SESSION['userKey'])){echo $_SESSION['userKey'];} ?>", idChuser: "<?php if(isset($_SESSION['userChoose'])){echo $_SESSION['userChoose'];} ?>"});  
							$("#messBlock").hide(); 
							////////////////////////ADD AT ALL WINDOWS/////////////////////////////////////////////
							$(window).on('unload', function(){ $.ajax({method: 'POST', url: 'MAIN(server).php', data: {exit: 2}}); });
							});
filesCh=1;

function openDialogs()
{
$("#messBlock").toggle(200,'linear');
$("#profileInf").toggle(200,'linear');
;}

function deleteSumpl()
{
$(this).parent().find("input").val("");
$(this).parent().remove();
filesCh--;
;}

function changeAvatar()
{
fileAvatar = new FileReader();
fileAvatar.onload = function(event){
	$("#profileimg").attr('src', fileAvatar.result);
	$("#buttonsUpr>hr:lt(2)").css('visibility','hidden');
	;}
fileAvatar.readAsDataURL(this.files[0]);
;}

function changeUserData()
{
if($("#REDACT").width()!=165)
	{
    $("#PRILOSHflex").prepend('\
		<div class="prilosh buttons" style="position: relative; visibility: visible; background-color: #54C6EB; padding: 0px; margin-right: 40px;" onclick="this.children[0].click();">\
			<input name="addFILE1" type="file" class="buttons" style="width: inherit; height: inherit; visibility: hidden;" form="formFile">\
			<hr color="#F5F6F5" noshade style="width: 100px; height: 4px; top: 96px; left: 50px;">\
			<hr color="#F5F6F5" noshade style="height: 100px; width: 4px; left: 98px; top: 48px;">\
			<textarea name="nameSump1" class="areatext downl" style="width: 190px; top: 220px; left: 5px; text-align: center; white-space: normal; color: black; outline: none; resize: none; border: 0px; border-radius: 10px; padding-left: 5px; line-height: 1.2; height: 50px;" readonly maxlength="40" form="formDate" placeholder="Введите описание к приложению">Ограничения: изображение до 10Мб</textarea>\
		</div>');
	$("input,textarea").css('border-width', 1).removeAttr("readonly");
	$("#REDACT").html("Сохранить изменения").width(165).css('left',350).after(
		'<div class="buttons" onclick="location.reload();" style="left: 535px; bottom: 60px; width: 60px; text-align: center; padding-top: 4px;">Отмена</div>');
	$(".deleteImg").css('visibility','visible');
	$("#delAcc").css('visibility','visible');
	$("#profileimg").toggleClass('opacity').on('click', function(){$("#profileimg+input:first").click();});
	$("#buttonsUpr>hr:lt(2)").css('visibility','visible');
	document.getElementById("MESSAGES").removeEventListener("click", openDialogs);
	return;
    ;}

var formD=new FormData();
for(typesF=2; typesF<=filesCh; typesF++)
	{
	fileData=$('[name=addFILE'+typesF+']').prop('files')[0];
	formD.append('addFILE'+typesF, fileData);
	formD.append('nameSump'+typesF, $('[name=nameSump'+typesF+']').val());
	;}
formD.append('prilULoad', "<?php echo $idchUser; ?>");
formD.append('filesTypes', filesCh);
formD.append('fileAvatar', $('[name=loadAvatar]').prop('files')[0]);
formDateMas=$("#formDate").serializeArray();
startF=filesCh+8;
for(i=startF; i!=formDateMas.length; i++)
	{
	if(formDateMas[i]['value'].indexOf("/")==-1)
		{
		formDateMas[i]['value']+=$("#loadFILE"+(i-startF)+">img").attr("src").substring($("#loadFILE"+(i-startF)+">img").attr("src").lastIndexOf("."))+"|"+$("#loadFILE"+(i-startF)+">img").attr("src");
		;}
	;}
formDateMas.push({name: 'typesLoadFU', value: loadSumpls});

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
										success: function(data){alert("Данные загружены успешно");}
										});
								location.reload();
								}
		});
;}

function addSumple()
{
fileData = new FileReader();
fileData.onload = function(event){
	filesCh++;
	$("#PRILOSHflex>div:first").clone().insertBefore("#PRILOSHflex>div:first").find('input').val('');
	$("#PRILOSHflex>div:eq(1)").append("<img src="+fileData.result+" class='prilosh' onerror='this.src=\"images/errorLoad.jpeg\";'>\
							   			<img src='images\\deleteIc.png'\
							   			 onload='$(this).click(deleteSumpl);' style='top: 5px; right: 5px; width: 30px; height: 30px;'>")
							   .find("input")
							   .attr("name","addFILE"+filesCh);
	$("#PRILOSHflex>div:eq(1)>textarea").removeAttr("readonly").css('border',"1px solid #979DA5").val(null).attr('name','nameSump'+filesCh);
	$("#PRILOSHflex>div:eq(1)>input").attr('disabled',"disabled");

;}
fileData.readAsDataURL(this.files[0]);
;}

$(document).on("change", "[name=addFILE1]", addSumple);
$(document).on("change", "[name=loadAvatar]", changeAvatar);
$("#REDACT").click(changeUserData);
document.getElementById("MESSAGES").addEventListener("click", openDialogs);
<?php @mysqli_close($BASEP); ?>///////////////// ADD ON ALL WINDOWS /////////////////////////////////////////////
$("body").show();
</script>
</body>
</html>