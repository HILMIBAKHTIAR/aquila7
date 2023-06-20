<?php
function update_status_print($con, $table = "", $nomor = "", $field_nomor = "", $field_status_print = "")
{
    
    if (empty($table) || empty($nomor))
        return false;
    if (empty($field_status_print))
        $field_status_print = $_SESSION["setting"]["field_status_print"];
    if (empty($field_nomor))
        $field_nomor = $_SESSION["setting"]["field_nomor"];
    $sql    = "\n\tUPDATE " . $table . "\n\tSET " . $field_status_print . " = " . $field_status_print . " + 1\n\tWHERE " . $field_nomor . " = " . $nomor;
    $update = mysqli_query($con, $sql);
    if (!$update)
        return false;
    else
        return true;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>