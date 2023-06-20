<?php
function transactions($con, $mode = "", $message = "", $type = "", $die = "", $url = "", $m = "", $f = "")
{
    if (!empty($mode)) {
        if (empty($message))
            $message = get_message(704);
        if (empty($type))
            $type = "danger";
        if (empty($die))
            $die = 1;
        if (empty($m))
            $m = $_SESSION["g.menu"];
        if (empty($f))
            $f = $_SESSION["g.frame"];
        if (empty($url))
            $url = "?m=" . $m . "&f=" . $f;
        if ($mode == "start") {
            // $autocommit_off = mysqli_query($con, "SET AUTOCOMMIT = 0;");
            $start_transaction = mysqli_query($con, "START TRANSACTION;");
            if (!$start_transaction)
                set_alert($message, $type, $die, $url, $m, $f);
        } elseif ($mode == "commit") {
            $commit = mysqli_query($con, "COMMIT;");
            if (!$commit)
                set_alert($message, $type, $die, $url, $m, $f);
        } elseif ($mode == "rollback") {
            $rollback = mysqli_query($con, "ROLLBACK;");
            if (!$rollback)
                set_alert($message, $type, $die, $url, $m, $f);
        }
        return true;
    }
    return false;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>