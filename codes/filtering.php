<?php if($filtering_override!=1){$filtering["query"]="";$filtering["session_name"]=$_SESSION["g.menu"];$filtering["urlback"]=$_POST["urlback"];if(!empty($filtering_include))foreach($filtering_include as $setting)include $setting;}unset($_SESSION["menu_".$filtering["session_name"]]["filter_total"]);$_SESSION["menu_".$filtering["session_name"]]["filter_query"]=$filtering["query"];
if(isset($_POST["selected_columns"])){
    mysqli_query($con, "INSERT INTO shfiltercolumnmenu (nomormhadmin, kodeshmenu, columns, dibuat_pada)
    SELECT ".$_SESSION['login']['nomor'].", '".$_SESSION["g.menu"]."', '".implode("|", $_POST['selected_columns'])."', NOW()");
    if(mysqli_error($con)){
        mysqli_query($con, "UPDATE shfiltercolumnmenu 
        SET diubah_pada = NOW(), 
        columns = '".implode("|", $_POST['selected_columns'])."'
        WHERE kodeshmenu = '".$_SESSION["g.menu"]."' 
        AND nomormhadmin = ".$_SESSION['login']['nomor'].";");
    }
    $_SESSION["menu_".$filtering["session_name"]]["filter_selected_columns"] = $_POST["selected_columns"];
}
if(!empty($_POST["keyword_filter"])){$keyword_filter=explode(" ",$_POST["keyword_filter"]);$_SESSION["menu_".$filtering["session_name"]]["keyword_filter"]=$keyword_filter;$_SESSION["menu_".$filtering["session_name"]]["filter_keyword_filter"]=$_POST["keyword_filter"];}else $_SESSION["menu_".$filtering["session_name"]]["keyword_filter"]="";die("<meta http-equiv='refresh' content='0;URL=".$filtering["urlback"]."'>"); ?>
<?php /*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/ ?>