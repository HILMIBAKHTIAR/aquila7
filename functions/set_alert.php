<?php
function set_alert($message, $type = "", $die = "", $url = "", $m = "", $f = "")
{
    if (!empty($message)) {
        if (empty($type))
            $type = "warning";
        if (empty($die))
            $die = 1;
        if (empty($m))
            $m = $_SESSION["g.menu"];
        if (empty($f))
            $f = $_SESSION["g.frame"];
        if (empty($url))
            $url = "?m=" . $m . "&f=" . $f;
        $_SESSION["menu_" . $m]["alert"]["type"]    = $type;
        $_SESSION["menu_" . $m]["alert"]["message"] = $message;
        if ($die == 1){
            die("<meta http-equiv='refresh' content='0;URL=" . $url . "'>");
        }
        return true;
    }
    return false;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>