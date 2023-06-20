<?php
session_start();
include "../functions/check_periode.php";
include "../functions/get_message.php";

$flag = check_periode($_POST[$_POST["date_field"]], $_POST["date_format"]);
if(!$flag)
    echo get_message(718);
else 
    echo "";
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>