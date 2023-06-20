<?php
$title  = $_SESSION["menu_" . $_GET["m"]]["export_title"];
$query  = $_SESSION["menu_" . $_GET["m"]]["export_query"];
$column = $_SESSION["menu_" . $_GET["m"]]["export_column"];
include "../config/database.php";
$mysqli = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
function clean_data($str)
{
    $str = preg_replace("/\t/", " ", $str);
    $str = preg_replace("/\r?\n/", " ", $str);
    if (strstr($str, '"'))
        $str = '"' . str_replace('"', '""', $str) . '"';
    $str = preg_replace("/\<br>/", " ", $str);
    return $str;
}
$export = "";
foreach ($column as $col) {
    if (!empty($col["caption"]) && $col["caption"] != "Action") {
        $export .= strtoupper($col["caption"]) . "\t";
    }
}
$export .= "\n";
$total  = array();
$result = $mysqli->query($query);
while ($data = $result->fetch_assoc()) {
    foreach ($column as $col) {
        if (!empty($col["caption"]) && $col["caption"] != "Action") {
            if(isset($data[$col["name"]]) && !empty($col["caption"])) {
				if($data[$col["name"]] != "")
					$export .= clean_data($data[$col["name"]]);
				else
					$export .= " ";
				$export .= "\t";
			}
            if (isset($col["total"])) {
                $total[$col["name"]] += clean_data($data[$col["name"]]);
            }
        }
    }
    $export .= "\n";
}
foreach ($column as $col) {
    if (!empty($col["caption"]) && $col["caption"] != "Action") {
        if (isset($total[$col["name"]])) {
            if ($total[$col["name"]] != "") {
                $export .= $total[$col["name"]];
            }
        }
        $export .= "\t";
    }
}
$export .= "\n";
date_default_timezone_set("Asia/Bangkok");
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=" . date("Y-m-d-H.i.s") . "~" . $_GET["m"] . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
print(trim($export));
?>
<?php
/*edited_by:glennferio@inspiraworld.com;release_date:2021-06-01;*/
?>