<?php
function check_approval($data, $type = "periode|edit|approve|delete|disappr|print", $fields = [])
{
    $string = "";
    if (empty($fields["tanggal"])) {
        $date_field = $_SESSION["setting"]["field_tanggal"];
        $date_format = $_SESSION["setting"]["date"];
    }
    else {
        $date = explode("|", $fields["tanggal"]);
        empty($date[0]) ? $date_field   = $_SESSION["setting"]["field_tanggal"] : $date_field = $date[0]; 
        empty($date[1]) ? $date_format  =  $_SESSION["setting"]["date"] : $date_format = $date[1];     
    }
    if (empty($fields["status_aktif"])) 
        $fields["status_aktif"] = $_SESSION["setting"]["field_status_aktif"];
    if (empty($fields["status_disetujui"]))
        $fields["status_disetujui"] = $_SESSION["setting"]["field_status_disetujui"];
    if ($data[$fields["status_aktif"]] > 0) {
        if ($data[$fields["status_disetujui"]] == 0) {
            if (!strstr($type, "periode") || (strstr($type, "periode") && check_periode($data[$date_field], $date_format))) {
                if (strstr($type, "edit"))
                    $string .= "|edit";
                if (strstr($type, "approve") && $data[$fields["status_aktif"]] == 1)
                    $string .= "|approve";
                if (strstr($type, "reject") && $data[$fields["status_aktif"]] == 1)
                    $string .= "|reject";
                if (strstr($type, "delete"))
                    $string .= "|delete";
            }
        } elseif ($data[$fields["status_disetujui"]] != 0) {
            if (!strstr($type, "periode") || (strstr($type, "periode") && check_periode($data[$date_field], $date_format))) {
                if (strstr($type, "disappr") && $data[$fields["status_disetujui"]] == 1)
                    $string .= "|disappr";
                if (strstr($type, "close") && $data[$fields["status_disetujui"]] == 1)
                    $string .= "|close";
            }
            if (strstr($type, "print") && $data[$fields["status_disetujui"]] != -1)
                $string .= "|print_invoice";
        }
    }
    return $string;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>