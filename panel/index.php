<?php
include_once 'checklogin.php';
LoadUserMain();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Socks\HVNC Panel | main</title>
		<meta name="description" content="Socks\HVNC Panel"/>
		<meta name="google" content="notranslate" />

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script src="js/ajax.js"></script>
		
		<script src="js/jquery.min.js" tppabs="js/jquery.min.js"></script>
		<script src="js/rainyday.js" tppabs="js/rainyday.js"></script>
		<script src="js/main.js" tppabs="js/main.js"></script>
		<link rel="stylesheet" type="text/css" href="css/main.css" tppabs="css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/animate.css" tppabs="css/animate.css" />
		
		<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
	</head>
	<body>
		<img id="background"/>
		<audio autoplay loop id="audio">
			<?php 
			switch(rand(1,2)):
			
				case 1:
				?> <source id="src-audio" src="music/intro.mp3" tppabs="music/intro.mp3" type="audio/mpeg"><?php
				break;
				case 2:
				?> <source id="src-audio" src="music/intro1.mp3" tppabs="music/intro1.mp3" type="audio/mpeg"><?php
				break;
				
				endswitch;
			?>
		</audio>
		
		<ul>
			<li><a href="#" id="login">Authorization</a></li>
			<li><a href="#" id="info">About the project</a></li>
		</ul>
		<img src="img/logo.png" tppabs="img/logo.png" id="logo"/>
		<div id="name-project" class="animated zoomInUp">HVNC Panel</div>
		<div id="pretext-project"></div>
		<div id='content'></div>
		<div id='loginf'>
			<form method="post" id="ajax_form" action="">
				<div class="container">
					<label for="uname"><b>Login</b></label>
					<input type="text" placeholder="Username" name="uname" required>

					<label for="psw"><b>Pass</b></label>
					<input type="password" placeholder="Password" name="psw" required>
					
					<input type="button" id="btn" value="Login" />
				</div>
			</form>
			<br>
			<div id="result_form"></div>
		</div>
		
		<div id="footer-copyright">Copyright ©. Powered by spikerok / Translated by FR3D for Mal4All.com</div>
	</html>
