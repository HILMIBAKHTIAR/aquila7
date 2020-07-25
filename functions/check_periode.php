<?php
function check_periode($date)
{
    include "config/config.php";
    include "config/database.php";
    include $config["webspira"]."config/connection.php";
    
    if (isset($date)) {
        $query = "\n\t\t\tSELECT a.*\n\t\t\tFROM thperiode a\n\t\t\tWHERE a." . $_SESSION["setting"]["field_status_aktif"] . " = 1\n\t\t\tAND a.tutup = 1\n\t\t\tAND a.periode = DATE_FORMAT('" . $date . "','%Y-%m')\n\t\t";
        if (!empty($_SESSION["setting"]["cek_periode_cabang"])) {
            $query .= " AND a." . $_SESSION["setting"]["field_cabang"] . " = " . $_SESSION["cabang"]["nomor"];
        }
        $count_shperiode = mysqli_num_rows(mysqli_query($con, $query));
        if ($count_shperiode == 0)
            return true;
    }
    return false;
}
?>
<?php
/*created_by:patricklipesik@gmail.com;release_date:2020-05-09;*/
?>