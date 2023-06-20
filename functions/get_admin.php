<?php
function get_admin($nomor, $fields = "nama", $separator = "")
{
	include "config/config.php";
	include "config/database.php";
	include $config["webspira"]."config/connection.php";
	
    $mhadmin = mysqli_fetch_array(mysqli_query($con, "SELECT a.* FROM mhadmin a WHERE a." . $_SESSION["setting"]["field_nomor"] . " = " . $nomor));
    $field   = explode("|", $fields);
    $admin   = "";
    $i       = 0;
    foreach ($field as $f) {
        if (empty($separator))
            $separator = " ";
        if ($i > 0)
            $admin .= $separator;
        $admin .= $mhadmin[$f];
    }
    return $admin;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>