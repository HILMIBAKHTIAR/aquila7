<?php
// $multiselect_query = $_POST["multiselect_query"];
$multiselect_query = $_SESSION["grid_" . $_GET["id"]]["query"];
$where = "";
if (!empty($_SESSION["grid_" . $_GET["id"]]["param_input"])) {
    foreach ($_SESSION["grid_" . $_GET["id"]]["param_input"] as $parameter) {
        $param   = explode("|", $parameter);
        $param_0 = str_replace(".", "", $param[0]);
        if ($_GET[$param_0] != "skip") {
            $operator = "=";
            if (isset($param[1]) && !empty($param[1]))
                $operator = $param[1];
            if (isset($param[2]) && !empty($param[2]))
                $multiselect_query = str_replace($param[2], $_GET[$param_0], $multiselect_query);
            else
                $where .= " AND " . $param[0] . " " . $operator . " '" . $_GET[$param_0] . "'";
        }
    }
}


$query 	= 'SELECT allData.* FROM (';
$query .= $multiselect_query;
$query .= ") allData";

$selected_row = $_POST["selected_row"];
$where 	= " WHERE FIND_IN_SET(allData.nomor, '" . $selected_row . "')"; 

$query 	= str_replace("?", "", $query);
$query .= $where;

$mysqli = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
$result = $mysqli->query($query);

$data = array();
while ($row = $result->fetch_assoc()) {
	array_push($data, $row);
}
echo json_encode($data);
?>