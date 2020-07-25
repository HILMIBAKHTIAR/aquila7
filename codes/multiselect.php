<?php
// $multiselect_nomor = $_POST["multiselect_nomor"];
$multiselect_query = $_POST["multiselect_query"];

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