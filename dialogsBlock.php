<?php
header('Content-Type: text/html; charset=utf-8');
$idUMess=$_POST['id'];
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
<body style="background: #FFFFFF; height: 2000px; overflow: hidden">
<!-- DIALOGS -->
	<div style="width: 35px; height: 580px; left: 975px; top: 0px; background-color: white; border-width: 0px; border-bottom-right-radius: 35px; border-top-right-radius: 35px;"></div>
	<div id="dialogsBlock" class="mediumBlocks scrollSmall" style="left:0px; top: 0px; width: 900px; height: 500px; padding-left: 30px; padding-top: 30px; border-top-right-radius: 0px; border-bottom-right-radius: 0px;"><!-- MESSAGES BLOCK --> 
		<div id="messagesBlock" class="text scrollSmall" style="width: 812px; height: 372px; top: 0px; left: 169px; padding: 30px 0px 30px 0px; direction: rtl; overflow-y: auto; overflow-x: hidden;">
 			<div id="flexMess" style="width: inherit; display: flex; flex-direction: column; left: 0px;">
				<!-- MESSAGES HERE -->
			</div>
		</div>
		<div id="zakazDialogs" class="scrollSmall" style="left: 169px; height: inherit; width: 800px; direction: rtl; overflow-y: auto; overflow-x: hidden;">
			<div id="flexDialogs" style="width: inherit; display: flex; flex-direction: column; left: 0px;">
				<!-- DIALOGS HERE -->
			</div>
		</div>
	</div>
<div style="width: 170px; height: 580px; left: -1px; top: 0px; background-color: #363537; border-width: 0px; border-bottom-left-radius: 35px; border-top-left-radius: 35px;"></div>
<!-- LEFT MENU DIALOGS -->
<div id="leftDmenu" style="left: 0px; top: 0px;">
	<div style="width: 170px; height: 41px; left: -1px; top: 50px;">
		<div class="backForms" style="padding: 3px 7px 1px 7px; background-color: #EE0D61; width: 20px; height: 30px; border-radius: 10px; left: 20px; top: 3px;">
			<img src="images/messages.png" style="left: 2px; width: 30px; height: 30px;">
		</div>
		<span class="redTextNorm" style="color: #EE0D61; top: 8px; left: 60px;">Диалоги</span>
	</div>
</div>

<form id="formMess" method="POST" accept-charset="utf8"></form>
<input name="idPay" type="hidden" form="formMess">
<div id="leftMenuMess" style="left: 20px; top: 35px;"><!-- LEFT MENU MESSAGE AND MESS-->
	<div style="width: 841px; height: 145px; top: 400px; left: 149px; background-color: #F5F6F5; border-bottom-right-radius: 35px;">
		<textarea form="formMess" id="messArea" name="sentMess" class="areatext backForms scrollSmall" style="width: 385px; height: 110px; left: 210px; top: 20px; white-space: normal; background: #FFFFFF; color: black; overflow-y: auto; border: 1px solid #979DA5; border-radius: 10px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-right: 0px; resize: none; padding-left: 25px; outline: none;" maxlength="999"></textarea>
		<div style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; background: #FFFFFF; width: 10px; height: 108px; top: 20px; left: 595px; border-right: 1px solid #979DA5; border-top: 1px solid #979DA5; border-bottom: 1px solid #979DA5;"></div>
		<div id="messSent" class="buttons" style="left: 620px; top: 60px; height: 20px; display: flex; align-items: center; padding-bottom: 9px;">Отправить</div>
	</div>
	<img class="userPhoto" src="images/Anonymous.jpg" style="left: 15px; width: 100px; height: 100px;">
	<img class="usrSt" src="" style="left: 85px; top: 75px; width: 20px; height: 20px; background-color: #363537; border: 3px solid #363537;">
	<span class="redTextSm" style="top: 135px;">Tag:</span><span class="textSm" style="color: white; left: 35px; top: 135px;">#294567</span>
	<span class="redTextSm" style="top: 155px;">Nname:</span><span class="textSm" style="color: white; left: 59px; top: 155px; width: 90px;">Alina</span>
	<div id="backU" class="buttons" style="top: 485px; left: 15px;">Назад</div>
	<div class="backForms textSm" style="top: 190px; background-color: #1FA637; height: 21px; padding: 3px 7px 1px 7px;"></div>
</div>
<script type="text/javascript">
$("#findzakaz").unbind("click");
$("#messagesBlock, #leftMenuMess").hide();
arrM=['Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Ноября','Декабря'];
today=new Date();
usersIDs=new Array();
lastDatemess=new Date();

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

function CreateTU(type)
{
if(type==1){return "#1FA637 moderator";} else if(type==2){return "#3A86FF student";} else if(type==3){return "orange  creator";}
}

function getUsrSU(status)
{
if(status==0){return "images/offlineS.png";}else if(status==1){return "images/onlineS.png";}else if(status==2){return "images/redS.png";}else if(status==3){return "images/busyS.png";}
}

function sentMessage(event)
{
$("[name=idPay]").val(event.data.idSentUs);
$.ajax({method: 'POST', url: 'Messages(server).php', dataType: 'text', data: $("#formMess").serialize() });
today=new Date();
todayD=today.getDate();
todayM=today.getMonth();
if(todayD<=9){todayD=("0"+todayD);}
if(todayM<=9){todayM=("0"+(parseInt(todayM)+1));}
if(lastDatemess.getFullYear()<=today.getFullYear())
	{
	if(lastDatemess.getMonth()<=parseInt(today.getMonth())+1)
		{
		if(lastDatemess.getDate()<today.getDate())
			{
			$("#flexMess").append("<span class='redTextSm' style='display: inline-block; position: relative; margin-right: 370px; margin-bottom: 19px; width: auto;'>"+todayD+'-'+todayM+'-'+today.getFullYear()+"</span>");
			;}
		;}	
	;}

$("#flexMess").append('<div class="yourmess" style="display: inline-block; position: relative; margin: auto; background: #3EC0F0; padding: 5px 7px 7px 9px; border-radius: 15px; color: white; font-size: 12pt; max-width: 330px; white-space: normal; margin-bottom: 19px; margin-right: 14px; text-align: left;">&nbsp'+$('#messArea').val()+'&nbsp<img src="images/dialogMe.png" style="right: -8px; top: 8px; width: 15px; height: 15px;"><span class="textSm" style="top: 7px; color: gray; font-size: 10pt; left: -43px; text-align: right; width: 40px;">'+today.getHours()+":"+today.getMinutes()+'</span></div>');
$("#messagesBlock").scrollTop($("#flexMess").height());

lastDatemess.setDate($("#flexMess>span:last").html().substring(0,2));
lastDatemess.setMonth($("#flexMess>span:last").html().substring(3,5));
lastDatemess.setFullYear($("#flexMess>span:last").html().substring(6,10));
$("#backU").show();
;}

function deleteDialog(idDDial)
{
$.ajax({method: 'POST',	url: 'Messages(server).php', data: {deleteDUs : idDDial}, dataType: 'text', success: function(){alert(data);} });
loadDialogsBlock();
;}

function showMess(event)
{
$("#zakazDialogs, #leftDmenu, #messagesBlock, #leftMenuMess").toggle(200);
$("#flexMess>div, #flexMess>span").remove(); 
if($(this).width()<500){ loadDialogsBlock(); }
if($(this).width()>500)
	{
	$.ajax({
	method: 'POST',
	url: 'Messages(server).php', 
	data: {loadMess : event.data.idChUser},
	dataType: 'json',
	success: function(data){$("#flexDialogs>div").remove(); 
							$("#leftMenuMess>img:eq(1)").attr('src', getUsrSU(event.data.stChUser));
							$("#leftMenuMess>span:eq(1)").html('#'+event.data.idChUser);
							$("#leftMenuMess>span:eq(3)").html('#'+event.data.logChUser);
							$("#leftMenuMess>div:last").css("background-color", CreateTU(event.data.typeChUser).substr(0,7));
							$("#leftMenuMess>div:last").html(CreateTU(event.data.typeChUser).substr(8));
							$("#leftMenuMess>.userPhoto").attr('src', data['avatar']);
							prevD=-1;
							for(p=0; p!=data['countM']; p++)
						   		{
						   		if(data[p]['dayB']>prevD)
						   			{
						   			$("#flexMess").append("<span class='redTextSm' style='display: inline-block; position: relative; margin-right: 370px; margin-bottom: 19px; width: auto;'>"+data[p]['timeY']+"</span>");
						   			prevD=data[p]['dayB'];
						   			;}
						   		if(data[p]['id_user']==event.data.idChUser)
						   			{
						   			if(!data[p]['content']){ data[p]['content']="&nbsp"; }
						   			$("#flexMess").append('<div class="hismess" style="display: inline-block; position: relative; margin: auto; white-space: normal; padding: 5px 7px 7px 9px; border-radius: 15px; color: white; background: #1D586E; height: auto; max-width: 330px; margin-bottom: 19px; margin-right: 10px; text-align: left; font-size: 12pt; direction: ltr;">'+data[p]['content']+'<img src="images/dialogHe.png" style="left: -10px; top: 8px; transform: rotate(181deg); width: 15px; height: 15px;"><span class="textSm" style="top: 7px; right: -43px; color: gray; font-size: 10pt; text-align: left; width: 40px;">'+data[p]['timeM']+'</span></div>');
						   			;}
						   		if(data[p]['id_user']!=event.data.idChUser)
						   			{
						   			if(!data[p]['content']){ data[p]['content']="&nbsp"; }
						   			$("#flexMess").append('<div class="yourmess" style="display: inline-block; position: relative; margin: auto; background: #3EC0F0; padding: 5px 7px 7px 9px; border-radius: 15px; color: white; font-size: 12pt; max-width: 330px; white-space: normal; margin-bottom: 19px; margin-left: 10px; text-align: left; direction: ltr;">'+data[p]['content']+'<img src="images/dialogMe.png" style="right: -8px; top: 8px; width: 15px; height: 15px;"><span class="textSm" style="top: 7px; color: gray; font-size: 10pt; left: -43px; text-align: right; width: 40px;">'+data[p]['timeM']+'</span></div>');
						   			;}
						   		;}
						   	lastDatemess.setDate($("#flexMess>span:last").html().substring(0,2));
						   	lastDatemess.setMonth($("#flexMess>span:last").html().substring(3,5));
						   	lastDatemess.setFullYear($("#flexMess>span:last").html().substring(6,10));
						   	$("#messagesBlock").scrollTop($("#flexMess").height());
						   	$("#messSent").off('click', sentMessage);
						   	$("#messSent").on('click', {idSentUs: event.data.idChUser}, sentMessage);
						   ;}
			})
	;}
;}

function loadDialogsBlock()
{
$.ajax({
	method: 'POST',
	url: 'Messages(server).php', 
	data: {loadDialogs : "<?php echo $idUMess; ?>"},
	dataType: 'json',
	success: function(data){$("#flexDialogs>div").remove(); 
							var content;
							for(i=0; i!=data['countD']; i++)
						   		{
						   		content=data[i]['content'];
						   		if(usersIDs.length){if($.inArray(data[i]['id'], usersIDs)!=-1){ continue; }}

						   		var dateD=data[i]["date"]+" "+arrM[data[i]["month"]-1];
						    	if(data[i]["date"]==today.getDate() && data[i]["month"]==(today.getMonth()+1))
						    		{dateD="Сегодня";}

						    	var typeUs=CreateIconSU(data[i]['sex'],data[i]['type']);
						   		var dialog='\
									<div class="messAge skritBackGray" style="width: 804px; position: relative; height: 90px; display: flex; align-items: center;">\
										<img class="userPhoto" src="" style="width: 50px; height: 50px; left: 40px;">\
										<span class="textSm" style="left: 136px; width: 75px; direction: ltr;">'+data[i]['login']+'</span>\
										<div class="userIconT" style="background-color: '+typeUs[0]+'; left: 105px;"><img src="'+typeUs[1]+'" style="width: 21px; height: 21px; left: 3px;"></div>\
										<img src="'+getUsrSU(data[i]['userSt'])+'" class="usrSt" style="left: 72px; top: 55px;">\
										\
										<span class="textarea" style="left: 240px; font-size: 12pt; width: 400px; max-height: 60px; text-overflow: ellipsis; overflow: hidden; text-align: left; direction: ltr;">'+content+'</span>\
										<span class="textSm" style="position: absolute; right: 60px; direction: ltr;">'+dateD+'</span>\
										<img class="delBut opacityX2" src="images/deleteIc.png" style="width: 20px; height: 20px; right: 20px;" onclick="event.stopPropagation(); deleteDialog('+data[i]['id']+');">\
										<hr color="#F5F6F5" noshade style="width: 700px; bottom: -9px; left: 0px;">\
									</div>';
						   		if(data[i]['mesSt']=='0' && data[i]['id_recipient']=="<?php echo $idUMess; ?>")
						   			{
						   			$("#flexDialogs").prepend(dialog);
						   			$("#flexDialogs>div:first").css('background-color', '#E3DE8F').append('<img src="images/notRead.png" style="left: 10px; width: 15px; height: 15px;">');
						   			usersIDs.unshift(data[i]['id']);
						   			$("#flexDialogs>div:first").click({idChUser: data[i]['id'], stChUser: data[i]['userSt'], logChUser: data[i]['login'], typeChUser: data[i]['type']}, showMess);
						   			;}
						   		if(data[i]['mesSt']!='0' || data[i]['id_recipient']!="<?php echo $idUMess; ?>")
						   			{
						   			$("#flexDialogs").append(dialog);
						   			if(data[i]['id_recipient']!="<?php echo $idUMess; ?>")
						   				{$("#flexDialogs>div:last").append("<span class='textSm' style='color: gray; left: 215px; direction: ltr;'>Я:</span>");}
						   			usersIDs.push(data[i]['id']);
						   			$("#flexDialogs>div:last").click({idChUser: data[i]['id'], stChUser: data[i]['userSt'], logChUser: data[i]['login'], typeChUser: data[i]['type']}, showMess);
						   			;}
						   		;}
						   	$.ajax({method: 'POST', url: 'Messages(server).php', data: {getUAv: usersIDs}, dataType: 'json', 
						   			success: function(data){ for(t=0; t!=(data.length-1); t++){$("#flexDialogs>div:eq("+t+")>img:first").attr('src',data[t]);} ;}
						   		   });
						   	usersIDs.length=0;
						   ;}
		});
}

$("#backU").click(showMess);
<?php
@$BASES=mysqli_connect("localhost","root","","dealandproducts","3306");
@mysqli_set_charset($BASES, "utf8");
$isDialogs=null;
if($_POST['idChuser']!=null)
	{$isDialogs=mysqli_fetch_row(@mysqli_query($BASES, "select id from message where id_user={$idUMess} and id_recipient={$_POST['idChuser']} and visibleU=0;"))[0];}
if($idUMess==$_POST['idChuser'] || $isDialogs!=null && $_POST['idChuser']!=null)
	{echo "loadDialogsBlock();"; die();} 
if($idUMess!=$_POST['idChuser'] && $_POST['idChuser']!="" && $isDialogs==null && $_POST['idChuser']!=null)
	{
	@mysqli_query($BASES, "insert into message(id_user, id_recipient, time, content) values({$idUMess}, {$_POST['idChuser']}, curtime(), 'Пользователь #{$idUMess} начал диалог');");
	echo 'loadDialogsBlock(); setTimeout(\'$("#flexDialogs>div:first").click();\', 300); ';
	die();
	}
echo "loadDialogsBlock();";
@mysqli_close($BASES);
?>
</script>
</body>
</html>