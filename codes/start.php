<?php /*START created_by:glennferio@inspiraworld.com;release_date:2020-05-24;*/ ?>
<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();

	$config = $_SESSION["config"];
	include "../functions/number_formatting.php";
	include "../../".$config["project"]."config/config.php";
	include "../../".$config["project"]."config/database.php";
	include "../config/connection.php";

	$_SESSION["menu_" . $_SESSION["g.menu"]]["aksi_start"] = date('Y-m-d H:i:s');
?>
<?php /*END created_by:glennferio@inspiraworld.com;release_date:2020-05-24;*/ ?>