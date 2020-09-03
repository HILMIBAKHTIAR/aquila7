<?php 
session_start();
include "../functions/generate_navbutton.php";
include "../functions/check_approval.php";
include "../functions/check_periode.php";
include "../functions/number_formatting.php";
include $_POST["database"];
include "../config/connection.php";

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

// getting index data link for include and index_table array data
$index_type = $_POST["index_type"];
$index_data = $_POST["index_data"];
$index_table = json_decode($_POST["index_table"], true);

// getting total number records without any search
$sql = $_POST['query_select'];
if(!empty($_POST['query_where'])){
  $sql .= " WHERE ".$_POST['query_where'];
}

if ($index_type == "report"){
    if(isset($_SESSION["menu_".$_SESSION["g.menu"]]["filter_total"])){
        $totalData      = $_SESSION["menu_".$_SESSION["g.menu"]]["filter_total"];
        $totalFiltered  = $totalData;
    }
    else{
        $sqltotal      = $sql;
        $sqltotal      = str_replace('footer','1', $sqltotal);
        $sqltotal      = str_replace('start','0', $sqltotal);
        $sqltotal      = str_replace('limit','18446744073709551615', $sqltotal);
        $querytotal    = mysqli_query($con, $sqltotal) or die("ajax-grid-data.php: get Total Data With Stored Procedure");
        $data          = mysqli_fetch_array($querytotal);
        $totalData     = $data["footer_total_data"];
        $totalFiltered = $totalData;
        $_SESSION["menu_".$_SESSION["g.menu"]]["filter_total"] = $totalFiltered;
        mysqli_next_result($con);
    }

    $sql = str_replace('start',$requestData['start'], $sql);
    $sql = str_replace('limit',$requestData['length'], $sql);
    $query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get Data With Stored Procedure");
}
else{
    $query = mysqli_query($con, $sql) or die("ajax-grid-data.php: get Total Filtered Data");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

    if( !empty($requestData['search']['value']) ) {
        // if there is a search parameter
        $sql = $_POST['query_select'];
        $sql .= " WHERE ";
        if(!empty($_POST['query_where'])){
          $sql .= $_POST['query_where']." AND";
        }
        $sql .= " ( FALSE";
        foreach ($index_table["column"] as $column) {
          if($column["search"] == 1){
            if(!empty($column["sort"]) AND $column["sort"] != "empty"){
              $sql .= " OR ".$column["sort"]." LIKE '%".$requestData['search']['value']."%' "; 
            }
            else{
              $sql .= " OR ".$column["name"]." LIKE '%".$requestData['search']['value']."%' "; 
            }
          }
        }
        $sql .= " )";
        $query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get Data With Search");
        $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 
        if($requestData['order'][0]['column'] > 0){
          if($index_table["column"][$requestData['order'][0]['column']]["search"] == 1){
            if(!empty($index_table["column"][$requestData['order'][0]['column']]["sort"]) AND $index_table["column"][$requestData['order'][0]['column']]["sort"] != "empty"){
                $orders = $index_table["column"][$requestData['order'][0]['column']]["sort"]."   ".$requestData['order'][0]['dir']; 
              }
          }
        }else{
          $orders = $_POST['query_order'];
        }
        if(!empty($orders)){
          $sql .= " ORDER BY ".$orders;
        }
        $sql .= " LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get Data With Search"); // again run query with limit
        
    } else {    
        $sql = $_POST['query_select'];
        if(!empty($_POST['query_where'])){
          $sql .= " WHERE ".$_POST['query_where'];
        }
        if($requestData['order'][0]['column'] > 0){
          if($index_table["column"][$requestData['order'][0]['column']]["search"] == 1){
            if(!empty($index_table["column"][$requestData['order'][0]['column']]["sort"]) AND $index_table["column"][$requestData['order'][0]['column']]["sort"] != "empty"){
                $orders = $index_table["column"][$requestData['order'][0]['column']]["sort"]."   ".$requestData['order'][0]['dir']; 
            }
          }
        }else{
          $orders = $_POST['query_order'];
        }
        if(!empty($orders)){
          $sql .= " ORDER BY ".$orders;
        }
        $sql .= " LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get Data Without Search");
    }
}
$allData = array(); 
$row = "";
$i  = 0;
$no = $requestData['start'];
$index_page["position"]  = 0;
while ($data = mysqli_fetch_array($query)) {
    $nestedData=array();
    $index_table["data"][$i]["class"] = "";
    $index_table["data"][$i]["action"] = "";
    $index_table["data"][$i]["break"] = "";
    $index_table["data"][$i]["after"] = "";
    $index_table["data"][$i]["element"] = ""; 
    include $index_data;
    if (!empty($index_table["data"][$i]["element"])){
        $row = explode("</td>", $index_table["data"][$i]["element"]);
        foreach ($row as $key => $data) {
            $row[$key] = $data . "</td>";
        }
        array_pop($row);
        $nestedData = $row;
    }
    else{
        $column_numb = 0;
        foreach ($index_table["column"] as $column) {
            if(!isset($column["class"]))  
                $column["class"] = "";  
            $align = "";
            if (!empty($column["align"]))
                $align = "align=\"" . $column["align"] . "\"";
            $width = "";
            if (!empty($column["width"]))
                $width = " style='width:" . $column["width"] . "px;' ";
            if ($table["id"] == "index_report" && $width != "")
                $width = " style='width:" . $column["width"] . "px!important;min-width:" . $column["width"] . "px!important;' ";
            $row = "<td " . $align . " " . $width . " class='col_detail_numb_" . $column_numb . " col_detail_name_" . $column["name"] . " " . $column["class"] . "'>" . $index_table["data"][$i][$column["name"]] . "</td>";
            $column_numb++;
            $nestedData[] = $row;
        }
        $no++;
    }
    $i++;
    $allData[] = $nestedData;
}
$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $allData   // total data array
            );
echo json_encode($json_data);  // send data as json format
?>