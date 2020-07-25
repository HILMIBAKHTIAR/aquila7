<?php /*START created_by:glennferio@inspiraworld.com;release_date:2020-05-24;*/ ?>
<?php
	session_start();
	$_SESSION["print"]["company_mode"]=$_POST["company_mode"];
	$_SESSION["print"]["company_logo"]=$_POST["company_logo"];
	$_SESSION["print"]["company_name"]=$_POST["company_name"];
	$_SESSION["print"]["company_address"]=$_POST["company_address"];
	$_SESSION["print"]["company_contact"]=$_POST["company_contact"];
	$_SESSION["print"]["title"]=$_POST["title"];
	$_SESSION["print"]["periode"]=$_POST["periode"];
	$_SESSION["print"]["header"]=$_POST["header"];
	$_SESSION["print"]["table_header"]=$_POST["table_header"];
	$_SESSION["print"]["table_body"]=$_POST["table_body"];
	$_SESSION["print"]["table_footer"]=$_POST["table_footer"];
	$_SESSION["print"]["total_column"]=$_POST["total_column"];
?>
<?php /*END created_by:glennferio@inspiraworld.com;release_date:2020-05-24;*/ ?>