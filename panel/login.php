<?php

if (isset($_POST["uname"]) && isset($_POST["psw"]) ) { 

    $result = array(
    	'name' => "echo"
    ); 
	
	$login = $_POST["uname"];
	$password = $_POST["psw"];
	$admin = '0';
	
	include_once 'vars.php';
	
	$db = new mysqli($host, $user, $pass, $database);
	
	if ($db->connect_errno) {
		$result['name'] = "Error connecting to the database!";
	}
	else{
		$sql = "select * from users where login = '$login' and password = '$password'";
		$resultbd = $db->query($sql);
		
		if ($resultbd->num_rows === 0) {
			$result['name'] = "Not a valid username / password!";
		}
		else{
			$actor = $resultbd->fetch_assoc();
			if($actor['banned'] == '1'){
				$result['name'] = "Your account has been suspended!";
			}else{
				$admin = $actor['admin'];
				$userid = $actor['id'];
				$usersession = randomPassword();
				$db->query("update users set session = '$usersession' where id = '$userid'");
				
				$userip = $_SERVER['REMOTE_ADDR'];
				$db->query("update users set ip = '$userip' where id = '$userid'");
				$db->query("update whitelist set ip = '$userip' where user = '$login'");
				
				if($admin == 0 || $admin == 1){
					$ii = 0;
					$resultbd = $db->query("select * from whitelist where user = '$login'");
					while ($actor = $resultbd->fetch_assoc()) {
						$ii = 1;
					}
				
					if($ii == 0){
						$db->query("insert into whitelist(ip, port, user) values ('$userip', 'all', '$login')");
					}
				}
				
				session_start();
				$_SESSION['usersession'] = $usersession;
				$_SESSION['username'] = $login;
				$_SESSION['useradmin'] = $admin;
				$_SESSION['userip'] = $userip;
			
				$result['name'] = "405";
			}
		}
	}
	
	
    echo json_encode($result); 
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

?>