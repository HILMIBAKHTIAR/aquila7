<?php
function create_id($con, $string_id = "")
{
    if (empty($string_id))
        return false;
    transactions($con, "start");
    $count = mysqli_num_rows(mysqli_query($con, "SELECT a.* FROM shnomor a WHERE a." . $_SESSION["setting"]["field_kode"] . " = '" . $string_id . "'"));
    if ($count <= 0) {
        $new = mysqli_query($con, "INSERT INTO shnomor (" . $_SESSION["setting"]["field_kode"] . "," . $_SESSION["setting"]["field_dibuat_oleh"] . "," . $_SESSION["setting"]["field_dibuat_pada"] . ") VALUES ('" . $string_id . "'," . $_SESSION["login"]["nomor"] . ",now())");
        if (!$new) {
            transactions("rollback");
            set_alert(get_message(705), "danger");
        }
    }
    $update = mysqli_query($con, "UPDATE shnomor SET akhir = akhir + 1 WHERE " . $_SESSION["setting"]["field_kode"] . " = '" . $string_id . "'");
    if (!$update) {
        transactions($con, "rollback");
        set_alert(get_message(705), "danger");
    }
    $count = mysqli_fetch_array(mysqli_query($con, "SELECT a.* FROM shnomor a WHERE a." . $_SESSION["setting"]["field_kode"] . " = '" . $string_id . "'"));
    if (empty($count)) {
        transactions($con, "rollback");
        set_alert(get_message(705), "danger");
    }
    transactions($con, "commit");
    return $count["akhir"];
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>