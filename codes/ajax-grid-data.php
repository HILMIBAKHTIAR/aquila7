<?php 
session_start();
// error_reporting(0);
include "../functions/generate_navbutton.php";
/*START edited_by:thomy@inspiraworld.com;last_updated:2020-06-08;*/
include "../functions/check_approval.php";
include "../functions/check_periode.php";
include "../functions/number_formatting.php";
include $_POST["database"];
include "../config/connection.php";
/*END edited_by:thomy@inspiraworld.com;last_updated:2020-06-08;*/

// echo $_POST['query_select'];
// echo $_POST['query_where'];exit();
// echo $_POST['query_order'];
// echo $_POST['fields'];
// $host = json_decode($_SERVER, true);
// echo json_encode($_SERVER);
/* Database connection start */
// $servername = $host['server'];
// $username = $host['username'];
// $password = $host['password'];
// $dbname = $host['database'];
// $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error($conn));
/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

// getting index data link for include and index_table array data
$index_data = $_POST["index_data"];
$index_table = json_decode($_POST["index_table"], true);

// getting total number records without any search
$sql = $_POST['query_select'];
if(!empty($_POST['query_where'])){
  $sql .= " WHERE ".$_POST['query_where'];
}
$query = mysqli_query($con, $sql) or die("ajax-grid-data.php: get Total Filtered Data");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {
    // if there is a search parameter
    $sql = $_POST['query_select'];
    $sql .= " WHERE ";
    /*START edited-by:glennferio@inspiraworld.com;last_updated:2020-06-08;*/
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
    // echo $sql;exit();
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
    /*END edited-by:glennferio@inspiaworld.com;last_updated:2020-06-08;*/
    $sql .= " LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
    // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
    $query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get Data With Search"); // again run query with limit
    
} else {    
    $sql = $_POST['query_select'];
    /*START edited-by:glennferio@inspiraworld.com;last_updated:2020-06-08;*/
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
    /*END edited-by:glennferio@inspiraworld.com;last_updated:2020-06-08;*/
    $sql .= " LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
    // echo $sql;exit();
    $query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get Data Without Search");
}

/*START edited-by:glennferio@inspiraworld.com;last_updated:2020-06-08;*/
$allData = array(); 
$row = "";
$i  = 0;
$no = $requestData['start'];
$index_page["position"]  = 0;
while ($data = mysqli_fetch_array($query)) {
    $nestedData=array();
    $index_table["data"][$i]["action"] = "";
    include $index_data;
    if (!empty($index_table["data"][0]["break"]))
        echo $index_table["data"][0]["break"];
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
        $row = "<td " . $align . " " . $width . " class='col_detail_numb_" . $column_numb . " col_detail_name_" . $column["name"] . " " . $column["class"] . "'>" . $index_table["data"][$i][$column["name"]] . "</td>";
        $column_numb++;
        $nestedData[] = $row;
    }
    $i++;
    $no++;
    $allData[] = $nestedData;
}
// while( $row=mysqli_fetch_array($query) ) {  // preparing an array
//     $nestedData=array(); 
//     $nomor++;

//     $nestedData[] = $nomor;
//     for ($i=0; $i < count($columns); $i++) { 
//       $nestedData[] = $row[$columns[$i]];
//     }
//     $nestedData[] = '<td><center>
//                      '.generate_navbutton('',$features,"index",$row['nomor']).'
//                      </center></td>';        
    
//     $data[] = $nestedData;
// }
/*END edited-by:glennferio@inspiraworld.com;last_updated:2020-06-08;*/
$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $allData   // total data array
            );
echo json_encode($json_data);  // send data as json format
?>