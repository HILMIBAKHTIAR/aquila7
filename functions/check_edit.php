<?php
function check_edit($data, $type = "cabang|periode|dihapus|disetujui", $fields = [])
{
    if (empty($fields["tanggal"])) {
        $date_field 	= $_SESSION["setting"]["field_tanggal"];
        $date_format 	= $_SESSION["setting"]["date"];
    }
    else {
        $date = explode("|", $fields["tanggal"]);
        empty($date[0]) ? $date_field   = $_SESSION["setting"]["field_tanggal"] : $date_field = $date[0]; 
        empty($date[1]) ? $date_format  =  $_SESSION["setting"]["date"] : $date_format = $date[1];     
    }
    if (empty($fields["cabang"]))
        $fields["cabang"] = $_SESSION["setting"]["field_cabang"];
    if (empty($fields["status_aktif"]))
        $fields["status_aktif"] = $_SESSION["setting"]["field_status_aktif"];
    if (empty($fields["status_disetujui"]))
        $fields["status_disetujui"] = $_SESSION["setting"]["field_status_disetujui"];
    if (strstr($type, "cabang") && $data[$fields["cabang"]] != $_SESSION["cabang"]["nomor"])
        set_alert(get_message(717));
    if (strstr($type, "periode") && !check_periode($data[$date_field], $date_format))
        set_alert(get_message(718));
    if (strstr($type, "dihapus") && $data[$fields["status_aktif"]] == 0)
        set_alert(get_message(206));
    if (strstr($type, "disetujui") && $data[$fields["status_disetujui"]] > 0)
        set_alert(get_message(719));
    return true;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>