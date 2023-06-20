<?php
error_reporting(0);
$query = $_SESSION["grid_" . $_GET["id"]]["query"];
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
                $query = str_replace($param[2], $_GET[$param_0], $query);
            else
                $where .= " AND " . $param[0] . " " . $operator . " '" . $_GET[$param_0] . "'";
        }
    }
}

if (!empty($_GET["search"])) {
	$multi_search = explode(" ", $_GET["search"]);
	$h = 0;
	$where .= " AND ( ( (";	
	foreach ($multi_search as $multi_keyword) {
        if(!empty($multi_keyword)){
            if ($h > 0)
            $where .= " OR ( (";
            $get_search = str_replace(" - ", " ", $multi_keyword);
            $search     = explode(" ", $get_search);
            $i = 0;
            foreach ($search as $keyword) {
                if ($i > 0)
                    $where .= " AND ( ";
                $j = 0;
                foreach ($_SESSION["grid_" . $_GET["id"]]["query_search"] as $column) {
                    if ($j > 0)
                        $where .= " OR ";
                    $where .= " " . $column . " LIKE '%" . addslashes($keyword) . "%' ";
                    $j++;
                }
                $where .= " ) ";
                $i++;
            }
            $where .= " ) ";
            $h++;
        }
	}
	$where .= " ) ";    
}
$SQL   = str_replace("?", $where, $query);
$page  = $_REQUEST["page"];
$limit = $_REQUEST["rows"];
$sord  = $_REQUEST["sord"];
$sidx  = $_REQUEST["sidx"];
if (!$sidx) {
    if (!empty($_SESSION["grid_" . $_GET["id"]]["query_order"])) {
        $sidx = $_SESSION["grid_" . $_GET["id"]]["query_order"];
        $sord = "";
    } else
        $sidx = 1;
}
$totalrows    = isset($_REQUEST["totalrows"]) ? $_REQUEST["totalrows"] : false;
$query_count  = "SELECT COUNT(*) AS total FROM (" . $SQL . ") aqtotal";
$result_count = mysqli_fetch_array(mysqli_query($con, $query_count));
$count        = $result_count["total"];
if ($count > 0)
    $total_pages = ceil($count / $limit);
else
    $total_pages = 0;
if ($page > $total_pages)
    $page = $total_pages;
if ($limit < 0)
    $limit = 0;
$start = 0;
if (!empty($limit) && !empty($page))
    $start = $limit * $page - $limit;
if ($start < 0)
    $start = 0;
if (!empty($sidx))
    $SQL .= " ORDER BY " . $sidx . " " . $sord;
if (!empty($limit))
    $SQL .= " LIMIT " . $start . ", " . $limit;
$result            = mysqli_query($con, $SQL);
$response          = new \stdClass();
$response->records = $count;
$response->page    = $page;
$response->total   = $total_pages;
if ($_SESSION["setting"]["environment"] != "live") {
    $response->debug = str_replace(array(
        "\n",
        "\r",
        "\t"
    ), " ", $SQL);
    if (!$result)
        $response->debug_error = str_replace(array(
            "\n",
            "\r",
            "\t"
        ), " ", mysqli_error($con));
    if ($count == 0)
        $response->debug_count = str_replace(array(
            "\n",
            "\r",
            "\t"
        ), " ", $query_count);
}
$i = 0;
while ($row = mysqli_fetch_array($result)) {
    $response->rows[$i]["id"] = $i + 1;
    $j                        = 0;
    foreach ($_SESSION["grid_" . $_GET["id"]]["items"] as $items) {
        $cell[$j] = trim($row[$items]);
        $j++;
    }
    $response->rows[$i]["cell"] = $cell;
    $i++;
}
echo json_encode($response);
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>