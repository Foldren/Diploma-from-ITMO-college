<?php 
header('Content-Type: text/html; charset=utf-8');
$BASE=mysqli_connect("localhost","root","","dealandproducts","3306");
mysqli_set_charset($BASE, "utf8");
session_start();

function removeDirectory($dir)
{
if($objs=glob($dir."/*"))
	{
   	foreach($objs as $obj){
    	is_dir($obj) ? removeDirectory($obj) : unlink($obj);}
	}
rmdir($dir);
 }  

if(isset($_POST['statusU']))
	{
	$query=@mysqli_query($BASE, "update user set status='{$_POST['statusU']}' where id={$_POST['idU']};");
	echo mysqli_error($BASE); 
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['URL']))
	{
	$_SESSION['URL']=$_POST['URL'];
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['exit']))
	{
	$_SESSION['userStatusEXIT']=mysqli_fetch_row(@mysqli_query($BASE, "select status from user where id={$_SESSION['userKey']};"))[0];
	@mysqli_query($BASE, "update user set status=0 where id={$_SESSION['userKey']};");
	@mysqli_close($BASE);
	if($_POST['exit']==1){session_destroy();}
	die();
	;}
if(isset($_POST['avatar']))
	{
	$urlImg=$_SESSION['userKey'];
	if($_POST['avatar']!=1){ $urlImg=$_POST['avatar'];}
	$wayAvatar=@glob("users/{$urlImg}/{*.png,*.bmp,*.jpeg,*.jpg}", GLOB_BRACE);
	if($wayAvatar==false){ $wayAvatar[0]="images/Anonymous.jpg";}
	echo $wayAvatar[0];
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['message']))
	{
	$queryMess=@mysqli_query($BASE, "select id_user, content, status, time_format(time, '%k:%i') from message where id_recipient={$_SESSION['userKey']} and date_format(time, '%Y-%m-%d')=curdate() and status=0 and (message.visibleU=0 or message.visibleU={$_SESSION['userKey']}) LIMIT 3;");
	$messages=mysqli_fetch_all($queryMess, MYSQLI_BOTH);
	$messages['countMes']=mysqli_num_rows($queryMess);
	for($i=0; $i!=$messages['countMes']; $i++){
		$messages['ImgOt'][$i]=@glob("users/{$messages[$i]['id_user']}/{*.png,*.bmp,*.jpeg,*.jpg}", GLOB_BRACE); 
		if($messages['ImgOt'][$i]==false){$messages['ImgOt'][$i][0]="images/Anonymous.jpg";}
		;}
	$arrayCH=mysqli_fetch_all(@mysqli_query($BASE, "select user.status from user, message where user.id=message.id_user and message.id_recipient={$_SESSION['userKey']} and date_format(message.time, '%Y-%m-%d')=curdate() and (message.visibleU=0 or message.visibleU={$_SESSION['userKey']}) LIMIT 3;"), MYSQLI_BOTH);

	for($i=0; $i!=$messages['countMes']; $i++)
		{$messages['statusOT'][$i]=$arrayCH[$i][0];}
	$arrayCH=mysqli_fetch_all(@mysqli_query($BASE, "select user.login from user, message where user.id=message.id_user and message.id_recipient={$_SESSION['userKey']} and date_format(message.time, '%Y-%m-%d')=curdate() and (message.visibleU=0 or message.visibleU={$_SESSION['userKey']}) LIMIT 3;"), MYSQLI_BOTH);

	for($i=0; $i!=$messages['countMes']; $i++)
		{$messages['nameOT'][$i]=$arrayCH[$i][0];}
	echo json_encode($messages);
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['nameUP']))
	{
	$typeUser=mysqli_fetch_row(@mysqli_query($BASE, "select type from user where id={$_SESSION['userKey']};"));
	$fullname=$_POST['secnameUP']." ".$_POST['nameUP']." ".$_POST['thirdnameUP'];
	if($_POST['nameUP']=='' && $_POST['secnameUP']=='' && $_POST['thirdnameUP']==''){ $fullname=null;}
	@mysqli_query($BASE, "update user set FIO='{$fullname}', info='{$_POST['infoUP']}', education='{$_POST['obrazUP']}', speciality='{$_POST['dolshnUP']}' where id={$_SESSION['userKey']};");
	if($typeUser[0]==1)
		{
		$INN=(int)$_POST['innUP'];
		@mysqli_query($BASE, "update user set INN={$INN}, name_org='{$_POST['nameorgUP']}' where id={$_SESSION['userKey']};");
		;}
	if($typeUser[0]==3)
		{@mysqli_query($BASE, "update user set name_org='{$_POST['nameorgUP']}' where id={$_SESSION['userKey']};");}

 	for($t=0; $t!=$_POST['typesLoadFU']; $t++)
 		{
 		if(strpos($_POST['loadSump'.$t], "/") && strpos($_POST['loadSump'.$t], "|")==false)
 			{
 			unlink($_POST['loadSump'.$t]);
 			continue;
 			;}
 		$pozstUr=strpos($_POST['loadSump'.$t], "|");	
 		$urlnew=substr($_POST['loadSump'.$t], 0, $pozstUr);
 		$urlold=substr($_POST['loadSump'.$t], $pozstUr+1);
 		rename($urlold , "users/{$_SESSION['userKey']}/portf/{$urlnew}");
 		;}

	@mysqli_close($BASE);
	die(); 
	;}
if(isset($_POST['userINFO']))
	{
	$userData=mysqli_fetch_row(@mysqli_query($BASE, "select FIO, name_org, INN, education, speciality, info from user where id={$_POST['userINFO']};"));
	echo json_encode($userData);
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['userPril']))
	{
	$namesSB=@glob("users/{$_POST['userPril']}/portf/{*.png,*.bmp,*.jpeg,*.jpg}", GLOB_BRACE);
	echo json_encode($namesSB);
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['orderPril']))
	{
	$namesSB=@glob("orders/{$_POST['orderPril']}/portf/*");
	echo json_encode($namesSB);
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['loadFunc']))
	{
	$queryFunc=@mysqli_query($BASE, "select functions.name from functions, function_order where functions.id=function_order.id_function and function_order.id_order={$_POST['loadFunc']};");
	$funcData=mysqli_fetch_all($queryFunc, MYSQLI_BOTH);
	$funcData['countF']=mysqli_num_rows($queryFunc);
	echo json_encode($funcData);
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['loadFlist']))
	{
	$queryFL=@mysqli_query($BASE, "select name, info from functions;");
	$flData=mysqli_fetch_all($queryFL, MYSQLI_BOTH);
	$flData['countFl']=mysqli_num_rows($queryFL);
	echo json_encode($flData);
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['orderINFO']))
	{
	$orderData=mysqli_fetch_assoc(@mysqli_query($BASE, "select tech_spec, class, type, date_format(date_start, '%e.%m.%Y') as 'date_start', date_format(date_end, '%e.%m.%Y') as 'date_end', status as 'statusO', period, (SELECT round(AVG(percents)) as 'percents' from step_order where step_order.id_order={$_POST['orderINFO']}) as 'percents' from order_app where order_app.id={$_POST['orderINFO']};"));
	$queryIsp=@mysqli_query($BASE, "select user.id, user.login, user.status as 'statusU' from user, participant where user.id=participant.id_user and participant.manager=0 and participant.id_order={$_POST['orderINFO']} and participant.noticeADD=1;");
	$orderIsp=mysqli_fetch_all($queryIsp, MYSQLI_BOTH);
	$orderData['countIsp']=mysqli_num_rows($queryIsp);

	for($i=0; $i!=$orderData['countIsp']; $i++){
		$orderData['ispImg'][$i]=@glob("users/{$orderIsp[$i]['id']}/{*.png,*.bmp,*.jpeg,*.jpg}", GLOB_BRACE); 
		if($orderData['ispImg'][$i]==false){$orderData['ispImg'][$i][0]="images/Anonymous.jpg";}
		;}

	$orderData=array_merge($orderData, $orderIsp);
	echo json_encode($orderData);
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['showSteps']))
	{
	$querySt=@mysqli_query($BASE,"select round(percents) as 'percents' from step_order where id_user={$_POST['showSteps']} and id_order={$_POST['orderIDFS']} order by name;");
	$stepsData=mysqli_fetch_all($querySt, MYSQLI_BOTH);
	$stepsData['name']=@glob("orders/{$_POST['orderIDFS']}/steps/*",GLOB_ONLYDIR);
	$stepsData['countSt']=count($stepsData['name']);
	for($k=0; $k!=$stepsData['countSt']; $k++)
		{$stepsData['name'][$k]=substr($stepsData['name'][$k], strrpos($stepsData['name'][$k], "/")+1);}

	$queryUi=@mysqli_query($BASE,"select login, sex, type from user where id={$_POST['showSteps']};");
	$usrData=mysqli_fetch_assoc($queryUi);

	for($y=0; $y!=$stepsData['countSt']; $y++)
		{
		$stepsData[$y]["fileN"]=@glob("orders/{$_POST["orderIDFS"]}/steps/{$stepsData["name"][$y]}/{$_POST['showSteps']}/*")[0]; 
		if($stepsData[$y]["fileN"]==false){ $stepsData[$y]["fileN"]='';}
		;}

	$stepsData=array_merge($stepsData, $usrData);
	echo json_encode($stepsData);
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['loadUnicSteps']))
	{
	$queryStu=@mysqli_query($BASE,"select round(avg(percents)) as 'percents' from step_order where id_order={$_POST['loadUnicSteps']} group by name order by name;");
	$stepsUData=mysqli_fetch_all($queryStu, MYSQLI_BOTH);
	$stepsUData['name']=@glob("orders/{$_POST['loadUnicSteps']}/steps/*",GLOB_ONLYDIR);
	$stepsUData['countSt']=count($stepsUData['name']);
	for($k=0; $k!=$stepsUData['countSt']; $k++)
		{$stepsUData['name'][$k]=substr($stepsUData['name'][$k], strrpos($stepsUData['name'][$k], "/")+1);}
	echo json_encode($stepsUData);
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['selectV']))
	{
	@mysqli_query($BASE, "update order_app set name='{$_POST['txtareaName']}', tech_spec='{$_POST['techSpec']}', class={$_POST['selectV']}, type='{$_POST['txtAreaV']}', period='{$_POST['inpPeriod']}' where id={$_SESSION['zakazChoose']};");

//ADD SUPPLEMENTS
 	for($t=0; $t!=$_POST['typesLoadFU']; $t++)
 		{
 		if(strpos($_POST['loadSump'.$t], "/") && strpos($_POST['loadSump'.$t], "|")==false)
 			{
 			unlink($_POST['loadSump'.$t]);
 			continue;
 			;}
 		$pozstUr=strpos($_POST['loadSump'.$t], "|");	
 		$urlnew=substr($_POST['loadSump'.$t], 0, $pozstUr);
 		$urlold=substr($_POST['loadSump'.$t], $pozstUr+1);
 		rename($urlold , "orders/{$_SESSION['zakazChoose']}/portf/{$urlnew}");
 		;}

 	$qyFunc=@mysqli_query($BASE, "select functions.name from functions, function_order where functions.id=function_order.id_function and function_order.id_order={$_SESSION['zakazChoose']};");
 	$allFuncs=mysqli_fetch_all($qyFunc, MYSQLI_BOTH);
 	$numRs=mysqli_num_rows($qyFunc);

//DELETE FUNCTIONS
 	$DEL="";
 	for($k=0; $k!=$_POST['typesLoadF']; $k++)
 		{
 		if(strpos($_POST['FL'.$k], "|delete|"))
 			{$DEL.="functions.name='".substr($_POST['FL'.$k],0,strpos($_POST['FL'.$k],"|delete|"))."' or ";}
 		}
 	$DEL=substr($DEL, 0, strlen($DEL)-4);
 	@mysqli_query($BASE, "delete from function_order where exists (select * from functions where function_order.id_function=functions.id and function_order.id_order={$_SESSION['zakazChoose']} and (".$DEL."));");

//ADD FUNCTIONS
 	for($k=0; $k!=$_POST['typesAddF']; $k++)
 		{
 		$f=0; 

 		while($f!=$numRs){
 			if($_POST['FA'.$k]==$allFuncs[$f]['name'])
 				{break;} $f++; } 

 		if($f==0 || $f==$numRs)
 			{@mysqli_query($BASE, "insert into function_order(id_function, id_order) values((select id from functions where name='".$_POST['FA'.$k]."'),{$_SESSION['zakazChoose']});");}
 		}

//DELETE PARTICIPANTS
 	$DEL="";
 	$rowSteps=@glob("orders/{$_SESSION['zakazChoose']}/steps/*", GLOB_ONLYDIR);
 	$typesSt=count($rowSteps);	
 	for($k=0; $k!=$_POST['typesDelIs']; $k++)
 		{
 		if(strpos($_POST['ID'.$k], "|delete|"))
 			{
 			$DelIsp=substr($_POST['ID'.$k],1,6); 
 			$DEL.="user.id='".$DelIsp."' or ";
 			for($s=0; $s!=$typesSt; $s++)
				{removeDirectory($rowSteps[$s]."/".$DelIsp);}
 			}
 		}
 	$DEL=substr($DEL, 0, strlen($DEL)-4);
 	@mysqli_query($BASE, "delete from participant where exists (select * from user where user.id=participant.id_user and participant.id_order={$_SESSION['zakazChoose']} and (".$DEL."));");

//ADD STEP ORDER
 	$queryP=@mysqli_query($BASE, "select distinct id_user from participant where id_order={$_SESSION['zakazChoose']} and manager=0 and noticeADD=1;");
	$partics=mysqli_fetch_all($queryP, MYSQLI_BOTH);
 	$np=mysqli_num_rows($queryP);
 	for($s=0; $s!=$_POST['typesAddUs']; $s++)
 		{	
 		mkdir("orders/{$_SESSION['zakazChoose']}/steps/".$_POST['SA'.$s], 0700);
 		for($u=0; $u!=$np; $u++)
 			{
 			@mysqli_query($BASE, "insert into step_order(name, id_user, id_order) values('".$_POST['SA'.$s]."', '{$partics[$u]['id_user']}', {$_SESSION['zakazChoose']});");
 			mkdir("orders/{$_SESSION['zakazChoose']}/steps/".$_POST['SA'.$s]."/".$partics[$u]['id_user'], 0700);
 			}
 		;}

//RENAME and DELETE STOR
 	for($s=0; $s!=$_POST['typesLoadUs']; $s++)
 		{	
 		$firstName=substr($_POST['Sname'.$s], 0, strpos($_POST['Sname'.$s], "|"));
 		$secondName=substr($_POST['Sname'.$s], strpos($_POST['Sname'.$s], "|")+1);

 		if($firstName!=$secondName && strpos($secondName, "|delete|")==false)
 			{
	 		rename("orders/{$_SESSION['zakazChoose']}/steps/".$firstName, "orders/{$_SESSION['zakazChoose']}/steps/".$secondName);
	 		@mysqli_query($BASE, "update step_order set name='".$secondName."' where name='".$firstName."';");
	 		;}

	 	if(strpos($secondName, "|delete|"))
	 		{
			@mysqli_query($BASE, "delete from step_order where name='".$firstName."';");
			removeDirectory("orders/{$_SESSION['zakazChoose']}/steps/".$firstName);
	 		;}
 		;}

	@mysqli_close($BASE);
	die(); 
	;}
if(isset($_POST['addFuncBut']))
	{
	$flagIS=mysqli_fetch_row(@mysqli_query($BASE, "select id from functions where name='{$_POST['addFuncBut']}';"))[0];
	if($flagIS){echo 1; die();}
	@mysqli_query($BASE, "insert into functions(name,info) values('{$_POST['addFuncBut']}', '{$_POST['FuncInf']}');");
	@mysqli_close($BASE);
	die(); 
	;}
if(isset($_POST['addNotice']))
	{
	$typesIs=mysqli_fetch_row(@mysqli_query($BASE, "select count(*) from participant where noticeADD=1;"));
	if($typesIs==7){echo 1; die();}
	@mysqli_query($BASE, "insert into participant(id_user, id_order, whoSENT) values({$_SESSION['userKey']}, {$_SESSION['zakazChoose']}, 1);");
	@mysqli_close($BASE);
	die(); 
	;}
if(isset($_POST['showADDnoticForU']))
	{
	$queryOrders=@mysqli_query($BASE, "select participant.id_order as 'id', order_app.name as 'name' from participant, order_app where participant.id_order=order_app.id and participant.id_user={$_SESSION['userKey']} and participant.manager=1 and order_app.status=1;");
	$idOrdersU=mysqli_fetch_all($queryOrders, MYSQLI_BOTH);
	for($i=0; $i!=mysqli_num_rows($queryOrders); $i++)
		{
		$queryUsers=@mysqli_query($BASE, "select id_user as 'id' from participant where id_order={$idOrdersU[$i]['id']} and manager=0;");
		$idPartics=mysqli_fetch_all($queryUsers, MYSQLI_BOTH);
		$ISINORD=0;
		for($k=0; $k!=mysqli_num_rows($queryUsers); $k++)
			{
			if($idPartics[$k]['id']==$_POST['showADDnoticForU'])
				{$ISINORD=1; break;}
			}
		if($k==7 || $ISINORD==1)
			{$idOrdersU[$i]['name']=null;}
		;}
	echo json_encode($idOrdersU);
	@mysqli_close($BASE);
	die(); 
	;}
if(isset($_POST['sentNoticeOrder']))
	{
	@mysqli_query($BASE, "insert into participant(id_user, id_order) values({$_POST['sentNoticeOrder']}, (select id from order_app where name='{$_POST['idOrder']}'));");
	echo 1;
	@mysqli_close($BASE);
	die(); 
	;}
if(isset($_POST['showADDnotRI']))
	{
	$typeSU=mysqli_fetch_row(@mysqli_query($BASE, "select type from user where id={$_POST['showADDnotRI']};"))[0];
	if($typeSU==1)
		{
		$querySU=@mysqli_query($BASE, "select participant.id_order as 'id', order_app.name as 'name' from participant, order_app where participant.id_order=order_app.id and participant.id_user={$_SESSION['userKey']} and participant.manager=1;");
		$ordersSU=mysqli_fetch_all($querySU, MYSQLI_BOTH);
		$COMPLETE['countOrders']=mysqli_num_rows($querySU);
		for($i=0; $i!=$COMPLETE['countOrders']; $i++)
			{
			$COMPLETE[$i]=mysqli_fetch_all(@mysqli_query($BASE, "select participant.id_user as 'id_user', user.sex as 'sex', user.login as 'login', user.type as 'type' from participant, user where participant.id_user=user.id and participant.whoSENT=1 and participant.id_order={$ordersSU[$i]['id']} and manager=0 and noticeADD=0;"), MYSQLI_BOTH);
			$COMPLETE[$i]['countNotices']=count($COMPLETE[$i]);
			$COMPLETE[$i]['id_order']=$ordersSU[$i]['id'];
			$COMPLETE[$i]['name']=$ordersSU[$i]['name'];
			;}
		;}
	if($typeSU!=1)
		{
		$querySU=@mysqli_query($BASE, "select participant.id_order as 'id', order_app.name as 'name' from participant, order_app where participant.id_order=order_app.id and participant.id_user={$_SESSION['userKey']} and participant.manager=0 and noticeADD=0;");
		$ordersSU=mysqli_fetch_all($querySU, MYSQLI_BOTH);
		$COMPLETE['countOrders']=mysqli_num_rows($querySU);
		for($i=0; $i!=$COMPLETE['countOrders']; $i++)
			{
			$COMPLETE[$i]=mysqli_fetch_all(@mysqli_query($BASE, "select participant.id_user as 'id_user', user.sex as 'sex', user.login as 'login', user.type as 'type' from participant, user where participant.id_user=user.id and participant.id_order={$ordersSU[$i]['id']} and participant.manager=1;"), MYSQLI_BOTH);
			$COMPLETE[$i]['countNotices']=count($COMPLETE[$i]);
			$COMPLETE[$i]['id_order']=$ordersSU[$i]['id'];
			$COMPLETE[$i]['name']=$ordersSU[$i]['name'];
			;}
		;}
	echo json_encode($COMPLETE);
	@mysqli_close($BASE);
	die(); 
	;}
if(isset($_POST['removeAddNot']))
	{
	@mysqli_query($BASE, "delete from participant where id_user={$_POST['removeAddNot']} and id_order={$_POST['removeAddOrd']};");
	@mysqli_close($BASE);
	die(); 
	;}
if(isset($_POST['acceptAddNot']))
	{
	$typeUN=mysqli_fetch_row(@mysqli_query($BASE, "select type from user where id={$_SESSION['userKey']};"))[0];
	$idTorder=$_POST['acceptAddNot'];
	if($typeUN!=1){$idTorder=$_SESSION['userKey'];}

	@mysqli_query($BASE, "update participant set noticeADD=1 where id_user={$idTorder} and id_order={$_POST['acceptAddOrd']};");
	$steps=@glob("orders/{$_POST['acceptAddOrd']}/steps/*", GLOB_ONLYDIR);

	for($i=0; $i!=count($steps); $i++)
		{
		@mysqli_query($BASE, "insert into step_order(id_user, id_order, name) values({$idTorder},{$_POST['acceptAddOrd']}, '".substr($steps[$i], strrpos($steps[$i], "/")+1)."');");
		mkdir("{$steps[$i]}/{$idTorder}");
		;}

	@mysqli_close($BASE);
	die(); 
	;}	
if(isset($_POST['nameOrdCr']))
	{
	if(mysqli_fetch_row(@mysqli_query($BASE, "select id from order_app where name='{$_POST['nameOrdCr']}';"))[0]!="")
		{echo 1; @mysqli_close($BASE); die();}
	
	@mysqli_query($BASE, "insert into order_app(name, class, type, period, tech_spec, date_start) values('{$_POST['nameOrdCr']}', {$_POST['CordS']}, '{$_POST['typeOrdCr']}', '{$_POST['periodOrdCr']}', '{$_POST['techSpecOrdCr']}', CURDATE());");
	$_SESSION['zakazChoose']=mysqli_fetch_row(@mysqli_query($BASE, "select id from order_app where name='{$_POST['nameOrdCr']}';"))[0];
	@mysqli_query($BASE, "insert into participant(id_user, id_order, manager, noticeADD) values({$_SESSION['userKey']}, {$_SESSION['zakazChoose']}, 1, 1);");
	mkdir("orders/{$_SESSION['zakazChoose']}");
	mkdir("orders/{$_SESSION['zakazChoose']}/steps");
	mkdir("orders/{$_SESSION['zakazChoose']}/portf");
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['idUloadOrderF']))
	{
	if($_POST['idUloadOrderF']==1)
		{
		$queryOFAll=@mysqli_query($BASE, "select order_app.id as 'id', date_format(order_app.date_start, '%d.%m.%Y') as 'start', date_format(order_app.date_end, '%d.%m.%Y') as 'end', order_app.status as 'status', order_app.name as 'name', order_app.class as 'class' from order_app, participant where order_app.id=participant.id_order and participant.noticeADD=1 group by id;");
		$ordersAll=mysqli_fetch_all($queryOFAll, MYSQLI_BOTH);
		for($i=0; $i!=mysqli_num_rows($queryOFAll); $i++)
			{
			$ordersInf[$i]=mysqli_fetch_assoc(@mysqli_query($BASE, "select (select count(participant.id) from participant where participant.noticeADD=1 and participant.manager=0 and participant.id_order={$ordersAll[$i]['id']}) as 'ispS', round(avg(step_order.percents)) as 'percents' from step_order where step_order.id_order={$ordersAll[$i]['id']};"));

			$ordersInf[$i]['id']=$ordersAll[$i]['id']; $ordersInf[$i]['start']=$ordersAll[$i]['start'];	$ordersInf[$i]['end']=$ordersAll[$i]['end']; $ordersInf[$i]['status']=$ordersAll[$i]['status'];	$ordersInf[$i]['name']=$ordersAll[$i]['name']; $ordersInf[$i]['class']=$ordersAll[$i]['class'];

			$ordersInf[$i]['nameR']=mysqli_fetch_row(@mysqli_query($BASE, "select user.login from user, participant where participant.id_user=user.id and participant.id_order={$ordersAll[$i]['id']} and participant.manager=1;"))[0];
			$ordersInf[$i]['sex']=mysqli_fetch_row(@mysqli_query($BASE, "select user.sex from user, participant where participant.id_user=user.id and participant.id_order={$ordersAll[$i]['id']} and participant.manager=1;"))[0];
			;}
		echo json_encode($ordersInf);
		@mysqli_close($BASE);
		die();
		;}

	$queryOF=@mysqli_query($BASE, "select order_app.id as 'id', date_format(order_app.date_start, '%d.%m.%Y') as 'start', date_format(order_app.date_end, '%d.%m.%Y') as 'end', order_app.status as 'status', order_app.name as 'name', order_app.class as 'class' from order_app, participant where order_app.id=participant.id_order and participant.noticeADD=1 and participant.id_user={$_POST['idUloadOrderF']};");
	$ordersU=mysqli_fetch_all($queryOF, MYSQLI_BOTH);
	for($i=0; $i!=mysqli_num_rows($queryOF); $i++)
		{
		$ordersInf[$i]=mysqli_fetch_assoc(@mysqli_query($BASE, "select (select count(participant.id) from participant where participant.noticeADD=1 and participant.manager=0 and participant.id_order={$ordersU[$i]['id']}) as 'ispS', round(avg(step_order.percents)) as 'percents' from step_order where step_order.id_order={$ordersU[$i]['id']};"));

		$ordersInf[$i]['id']=$ordersU[$i]['id']; $ordersInf[$i]['start']=$ordersU[$i]['start'];	$ordersInf[$i]['end']=$ordersU[$i]['end']; $ordersInf[$i]['status']=$ordersU[$i]['status'];
		$ordersInf[$i]['name']=$ordersU[$i]['name']; $ordersInf[$i]['class']=$ordersU[$i]['class'];

		$ordersInf[$i]['nameR']=mysqli_fetch_row(@mysqli_query($BASE, "select user.login from user, participant where participant.id_user=user.id and participant.id_order={$ordersU[$i]['id']} and participant.manager=1;"))[0];
		$ordersInf[$i]['sex']=mysqli_fetch_row(@mysqli_query($BASE, "select user.sex from user, participant where participant.id_user=user.id and participant.id_order={$ordersU[$i]['id']} and participant.manager=1;"))[0];
		;}
	echo json_encode($ordersInf);
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['chooseOrderNow']))
	{
	$_SESSION['zakazChoose']=mysqli_fetch_row(@mysqli_query($BASE, "select id from order_app where name='{$_POST['chooseOrderNow']}';"))[0];
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['idULus']))
	{
	if($_POST['idULus']==1)
		{
		$queryUs=@mysqli_query($BASE, "select login, FIO, type, status, id, (select count(order_app.id) from participant, order_app where participant.id_user=user.id and participant.id_order=order_app.id and participant.noticeADD=1 and order_app.status=1) as 'actOrd', (select count(order_app.id) from participant, order_app where participant.id_user=user.id and participant.id_order=order_app.id and participant.noticeADD=1 and order_app.status=0) as 'unactOrd' from user where type<>4;");
		$usersInf=mysqli_fetch_all($queryUs, MYSQLI_BOTH);
		for($i=0; $i!=mysqli_num_rows($queryUs); $i++)
			{
			$usersInf[$i]['imgSrc']=@glob("users/{$usersInf[$i]['id']}/{*.png,*.bmp,*.jpeg,*.jpg}", GLOB_BRACE);
			if($usersInf[$i]['imgSrc']==null){ $usersInf[$i]['imgSrc']="images/Anonymous.jpg"; }
			if($usersInf[$i]['FIO']==null){ $usersInf[$i]['FIO']=""; }
			if($usersInf[$i]['type']==1)
				{
				$queryIs=@mysqli_query($BASE, "select id_order as 'orderIDup', (select count(*) from participant where id_order=orderIDup and manager=0 and noticeADD=1) as 'cIsp' from participant where id_user={$usersInf[$i]['id']};");
				$usersIsp=mysqli_fetch_all($queryIs, MYSQLI_BOTH);
				$cIsp=0;
				for($k=0; $k!=mysqli_num_rows($queryIs); $k++)
					{ $cIsp+=$usersIsp[$k]['cIsp']; }
				$usersInf[$i]['isplTypes']=$cIsp;
				;}
			if($usersInf[$i]['type']!=1)
				{
				$queryIs=@mysqli_query($BASE, "select id_order as 'orderIDup', (select count(*) from participant where id_order=orderIDup and manager=1 and noticeADD=1) as 'cIsp' from participant where id_user={$usersInf[$i]['id']};");
				$usersIsp=mysqli_fetch_all($queryIs, MYSQLI_BOTH);
				$cIsp=0;
				for($k=0; $k!=mysqli_num_rows($queryIs); $k++)
					{ $cIsp+=$usersIsp[$k]['cIsp']; }
				$usersInf[$i]['isplTypes']=$cIsp;
				;}	
			;}
		echo json_encode($usersInf);
		@mysqli_close($BASE);
		die();	
		;}

	$queryUs=@mysqli_query($BASE, "select login, FIO, type, status, id, (select count(order_app.id) from participant, order_app where participant.id_user=user.id and participant.id_order=order_app.id and participant.noticeADD=1 and order_app.status=1) as 'actOrd', (select count(order_app.id) from participant, order_app where participant.id_user=user.id and participant.id_order=order_app.id and participant.noticeADD=1 and order_app.status=0) as 'unactOrd' from user;");
	$usersInf=mysqli_fetch_all($queryUs, MYSQLI_BOTH);
	$lengthFor=mysqli_num_rows($queryUs);
	$typeChU=mysqli_fetch_row(@mysqli_query($BASE, "select type from user where id={$_POST['idULus']};"))[0];

	for($i=0; $i!=$lengthFor; $i++)
		{
		if(!isset($usersInf[$i]['type'])){ break; }

		$usersInf[$i]['imgSrc']=@glob("users/{$usersInf[$i]['id']}/{*.png,*.bmp,*.jpeg,*.jpg}", GLOB_BRACE);
		if($usersInf[$i]['imgSrc']==null){ $usersInf[$i]['imgSrc']="images/Anonymous.jpg"; }
		if($usersInf[$i]['FIO']==null){ $usersInf[$i]['FIO']=""; }
		
		$YES=0;
		if($usersInf[$i]['type']==1)
			{
			$queryIs=@mysqli_query($BASE, "select id_order as 'orderIDup', (select count(*) from participant where id_order=orderIDup and manager=0 and noticeADD=1) as 'cIsp' from participant where id_user={$usersInf[$i]['id']};");
			$usersIsp=mysqli_fetch_all($queryIs, MYSQLI_BOTH);

			$cIsp=0;
			for($k=0; $k!=mysqli_num_rows($queryIs); $k++)
				{ 
				$cIsp+=$usersIsp[$k]['cIsp'];
				$ifor=mysqli_fetch_row(@mysqli_query($BASE, "select id_user from participant where id_order={$usersIsp[$k]['orderIDup']} and id_user={$_POST['idULus']} and noticeADD=1;"))[0];
				if($ifor!="")
					{ $YES=1; }
				;}
			$usersInf[$i]['isplTypes']=$cIsp;
			
			;}

		if($usersInf[$i]['type']!=1)
			{
			$queryIs=@mysqli_query($BASE, "select id_order as 'orderIDup', (select count(*) from participant where id_order=orderIDup and manager=1 and noticeADD=1) as 'cIsp' from participant where id_user={$usersInf[$i]['id']};");
			$usersIsp=mysqli_fetch_all($queryIs, MYSQLI_BOTH);

			$cIsp=0;
			for($k=0; $k!=mysqli_num_rows($queryIs); $k++)
				{ 
				$cIsp+=$usersIsp[$k]['cIsp']; 
				$ifor=mysqli_fetch_row(@mysqli_query($BASE, "select id_user from participant where id_order={$usersIsp[$k]['orderIDup']} and id_user={$_POST['idULus']} and noticeADD=1;"))[0];
				if($ifor !="")
					{ $YES=1; }
				}
			$usersInf[$i]['isplTypes']=$cIsp;
			;}

		if(!$YES){ unset($usersInf[$i]); }	
		;}

	$usersInf=array_values($usersInf);
	for($i=0; $i!=mysqli_num_rows($queryUs); $i++)
		{
		if(!isset($usersInf[$i]['type'])){ break; }
		if($typeChU==1 && $usersInf[$i]['type']==1)
			{ unset($usersInf[$i]); }
		if($typeChU!=1 && $usersInf[$i]['type']!=1)
			{ unset($usersInf[$i]); }
		;}

	$usersInf=array_values($usersInf);
	echo json_encode(array_values($usersInf));
	@mysqli_close($BASE);
	die();	
	;}
if(isset($_POST['chooseUserNow']))
	{
	$_SESSION['userChoose']=$_POST['chooseUserNow'];
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['deleteOrderNow']))
	{
	@mysqli_query($BASE, "delete from order_app where id={$_POST['deleteOrderNow']};");
	removeDirectory("orders/{$_POST['deleteOrderNow']}");
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['finishOrderNow']))
	{
	@mysqli_query($BASE, "delete from step_order where id_order={$_POST['finishOrderNow']};");
	@mysqli_query($BASE, "update order_app set status=0 where id={$_POST['finishOrderNow']};");
	removeDirectory("orders/{$_POST['finishOrderNow']}/steps");
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['leaveOrderNow']))
	{
	@mysqli_query($BASE, "delete from step_order where id_order={$_POST['leaveOrderNow']} and id_user={$_SESSION['userKey']};");
	@mysqli_query($BASE, "delete from participant where id_order={$_POST['leaveOrderNow']} and id_user={$_SESSION['userKey']};");
	$typesSt=@glob("orders/{$_POST['leaveOrderNow']}/steps/*", GLOB_ONLYDIR);

	for($i=0; $i!=count($typesSt); $i++)
		{ removeDirectory("orders/{$_POST['leaveOrderNow']}/steps/{$typesSt[$i]}/{$_SESSION['userKey']}"); }

	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['chooseRUKNow']))
	{
	$id=mysqli_fetch_row(@mysqli_query("select id from user where name={$_POST['chooseRUKNow']};"))[0];
	$_SESSION['userChoose']=$id;
	@mysqli_close($BASE);
	die();
	;}
if(isset($_POST['SentMessSupport']))
	{
	@mysqli_query($BASE, "insert into message(id_user, id_recipient, content, time) values({$_SESSION['userKey']}, 197090, '{$_POST['SentMessSupport']}', curtime());");
	@mysqli_close($BASE);
	die();
	;}
?>