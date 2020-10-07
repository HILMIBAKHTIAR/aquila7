<?php /*START created_by:glennferio@inspiraworld.com;release_date:2020-05-24;*/ ?>
<?php
	ini_set('max_execution_time', '0');
	ini_set("memory_limit",-1);
	session_start();

	$config = $_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["config"];
	include "../functions/number_formatting.php";
	include "../../".$config["project"]."config/config.php";
	include "../../".$config["project"]."config/database.php";
	include "../config/connection.php";

	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["company_mode"]=$_POST["company_mode"];
	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["company_logo"]=$_POST["company_logo"];
	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["company_name"]=$_POST["company_name"];
	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["company_address"]=$_POST["company_address"];
	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["company_contact"]=$_POST["company_contact"];
	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["title"]=$_POST["title"];
	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["periode"]=$_POST["periode"];
	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["header"]=$_POST["header"];
	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["table_header"]=$_POST["table_header"];
	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["table_body"]=$_POST["table_body"];
	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["table_footer"]=$_POST["table_footer"];
	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["total_column"]=$_POST["total_column"];

	$ajax 		= $_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["ajax"];
	if($ajax == 1){
		$index_type = $_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["index_type"];
		if ($index_type == "report"){
			$mysqli = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
			if ($mysqli->connect_error) { die("Connection failed: " . $mysqli->connect_error); }

			$sql = $_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["query_select"];
		    $sql = str_replace('start','0', $sql);
		    $sql = str_replace('limit','18446744073709551615', $sql);
		    $query = $mysqli->query($sql);

		    $i  = 0;
	        $no = 0;
	        $index_data  = $_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["index_data"];
	        $index_table = $_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["index_table"];
	        $_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["table_body"] = "";
	        while ($data = $query->fetch_array()) {
	            $index_table["data"][$i]["class"] 	= "";
	            $index_table["data"][$i]["action"] 	= "";
	            $index_table["data"][$i]["break"] 	= "";
	            $index_table["data"][$i]["summary"] = "";
	            include $index_data;
	            $_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["table_body"] .= "<tr>";
	            if (!empty($index_table["data"][$i]["element"])){
	            	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["table_body"] .= $index_table["data"][$i]["element"];
	            }
	            else{
	            	if (!empty($index_table["data"][$i]["break"]))
	                	$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["table_body"] .= $index_table["data"][$i]["break"];
		            $column_numb = 0;
		            foreach ($index_table["column"] as $column) {
		                $align = "";
		                if (!empty($column["align"]))
		                    $align = "align=\"" . $column["align"] . "\"";
		                $width = "";
		                if (!empty($column["width"]))
		                    $width = " style='width:" . $column["width"] . "px;' ";
		                if ($table["id"] == "index_report" && $width != "")
		                    $width = " style='width:" . $column["width"] . "px!important;min-width:" . $column["width"] . "px!important;' ";
		                $_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["table_body"] .= "<td " . $align . " " . $width . " class='col_detail_numb_" . $column_numb . " col_detail_name_" . $column["name"] . " " . $column["class"] . "'>" . $index_table["data"][$i][$column["name"]] . "</td>";
		                $column_numb++;
		            }
		            if (!empty($index_table["data"][$i]["summary"]))
		                $_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["table_body"] .= $index_table["data"][$i]["summary"];
		            $no++;
	            }
	            $_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["table_body"] .= "</tr>";
	        }
		}
	}
	
?>
<?php /*END created_by:glennferio@inspiraworld.com;release_date:2020-05-24;*/ ?>