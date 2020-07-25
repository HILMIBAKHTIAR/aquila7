<?php
function check_approval($data, $type = "periode|edit|approve|delete|disappr|print", $fields ="")
{
    $string = "";
    if (empty($fields["status_aktif"])) {
        $fields["status_aktif"] = $_SESSION["setting"]["field_status_aktif"];
    }
    if (empty($fields["status_disetujui"]))
        $fields["status_disetujui"] = $_SESSION["setting"]["field_status_disetujui"];
    if (empty($fields["tanggal"]))
        $fields["tanggal"] = $_SESSION["setting"]["field_tanggal"];
    if ($data[$fields["status_aktif"]] > 0) {
        if ($data[$fields["status_disetujui"]] == 0) {
            if (!strstr($type, "periode") || (strstr($type, "periode") && check_periode($data[$fields["tanggal"]]))) {
                if (strstr($type, "edit"))
                    $string .= "|edit";
                if (strstr($type, "approve") && $data[$fields["status_aktif"]] == 1)
                    $string .= "|approve";
                if (strstr($type, "reject") && $data[$fields["status_aktif"]] == 1)
                    $string .= "|reject";
                if (strstr($type, "delete"))
                    $string .= "|delete";
            }
        /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-06-07;*/
        } elseif ($data[$fields["status_disetujui"]] != 0) {
            if (!strstr($type, "periode") || (strstr($type, "periode") && check_periode($data[$fields["tanggal"]]))) {
                if (strstr($type, "disappr") && $data[$fields["status_disetujui"]] == 1)
                    $string .= "|disappr";
                if (strstr($type, "close") && $data[$fields["status_disetujui"]] == 1)
                    $string .= "|close";
            }
            if (strstr($type, "print") && $data[$fields["status_disetujui"]] != -1)
                $string .= "|print_invoice";
        }
        /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-06-07;*/
    }
    return $string;
}
?>
<?php
/*created_by:patricklipesik@gmail.com;release_date:2020-05-09;*/
?>