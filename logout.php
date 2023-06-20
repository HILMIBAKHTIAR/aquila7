<?php 
session_destroy();
$logout = "";
if(isset($_SESSION["setting"]["logout"]))
	$logout = $_SESSION["setting"]["logout"];
if(empty($logout))
	$logout = "index.php";
die("<meta http-equiv='refresh' content='0;URL=".$logout."'>"); 
?>
<?php /*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/ ?>