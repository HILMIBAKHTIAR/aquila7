<?php if($searching_override!=1){$searching["session_name"]=$_SESSION["g.menu"];if(!empty($searching_include))foreach($searching_include as $setting)include $setting;}if(!empty($_POST["keyword"])){$keyword=explode(" ",$_POST["keyword"]);$_SESSION["menu_".$searching["session_name"]]["keyword"]=$keyword;}else $_SESSION["menu_".$searching["session_name"]]["keyword"]="";die("<meta http-equiv='refresh' content='0;URL=".$_POST["urlback"]."'>"); ?>
<?php /*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/ ?>