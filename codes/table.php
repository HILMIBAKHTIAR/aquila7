<?php
if ($table_override != 1) {
    $table["id"]     = "index";
    $table["state"]  = $config["state"];
    $table["url"]    = $_SESSION["g.url"];
    $table["column"] = array();
    $table["data"]   = array();
    $table["footer"] = "";
    $table_html      = "";
    if (!empty($table_include))
        foreach ($table_include as $setting)
            include $setting;
}
// HIDDEN TABLE WHEN FETCHING ALL DATA WITHOUT PAGING / AJAX
$hide_class ="";
if($index["ajax"] == 0) {
    $hide_class = "hide";
}
echo "\n<table class='table table-bordered table-striped table-hover table-datatable ".$hide_class."' id='table_" . $table["id"] . "'>\n\t<thead>\n\t\t";
$length      = count($table["column"]);
$column_numb = 0;
foreach ($table["column"] as $key => $value) {
    $table["column"][$key]["draw"]  = 0;
}
foreach ($table["colHeader"] as $key => $colHeader) {
    $key % 2 == 1 ? $rowClass = "odd" : $rowClass = "even";
    echo "<tr class= " . $rowClass . ">";
    $startSpan = 0;
    $endSpan = 0; 
    $isColspan = 0;  
    for ($i = 0; $i < sizeof($table["column"]); $i++) {
        foreach ($colHeader as $colGroup) {
            if($colGroup["name"] == $table["column"][$i]["name"]){   
                if (!isset($colGroup["class"]))
                        $colGroup["class"] = "";
                echo "<th class='group " . $colGroup["class"] . "' colspan = ". $colGroup["colspan"] .">" .$colGroup["caption"] . "</th>";
                $startSpan = $i;
                $endSpan = $i + $colGroup["colspan"] - 1;
                $isColspan = 1;
            }
        }
        if($isColspan && ($i < $startSpan || $i > $endSpan))
            $isColspan = 0; 
        if(!$isColspan){
            if(!$table["column"][$i]["draw"]){
                $isBelowColspan = 0;
                for ($r = $key + 1; $r < sizeof($table["colHeader"] ); $r++) {
                    for ($k = 0 ; $k < sizeof($table["colHeader"][$r]); $k++){
                        for ($l = 0; $l < sizeof($table["column"]); $l++) {
                            if($table["colHeader"][$r][$k]["name"] == $table["column"][$l]["name"]){
                                $startSpan = $l;
                                $endSpan = $l + $table["colHeader"][$r][$k]["colspan"] - 1;
                                if($i >= $startSpan && $i <= $endSpan){
                                    echo "<th></th>";
                                    $isBelowColspan = 1;
                                    break;
                                }

                            }
                        }
                    }
                }
                if(!$isBelowColspan){
                    $width = "";
                    if (!empty($column["width"]))
                        $width = " style='width:" . $table["column"][$i]["width"] . "px;' ";
                    if (!isset($column["class"]))
                            $table["column"][$key]["class"] = "";
                    $rowspan = sizeof($table["colHeader"]) + 1 - $key;
                    echo "<th rowspan = ".$rowspan . " " . $width . " class='col_header_numb_" . $column_numb . " col_header_name_" . $table["column"][$i]["name"] . " " . $table["column"][$i]["class"] . "'>" . $table["column"][$i]["caption"];
                    $table["column"][$i]["draw"] = 1;
                }
            }
        }
        $column_numb++;
    }
    echo "</tr>";
}
echo "<tr>";
$column_numb = 0;
foreach ($table["column"] as $column) {
    if (!$column["draw"]) {
        $width = "";
        if (!empty($column["width"]))
            $width = " style='width:" . $column["width"] . "px;' ";
        if ($table["id"] == "index_report" && $width != "")
            $width = " style='width:" . $column["width"] . "px!important;min-width:" . $column["width"] . "px!important;' ";
        echo "<th " . $width . " class='col_header_numb_" . $column_numb . " col_header_name_" . $column["name"] . " " . $column["class"] . "'>" . $column["caption"];
        if (empty($column["sort"]))
            $column["sort"] = $column["name"];
        echo "</th>";
    }
    $column_numb++;
}
echo "\n\n\t</tr>\n\t</thead>\n\t<tbody>";

if ($index_type == "report"){
    $query  = str_replace('footer','0', $query);
    $query  = str_replace('start','0', $query);
    $query  = str_replace('limit','18446744073709551615', $query);
}
if(isset($query) AND !empty($query)){
    $config["state"]= $table["state"];
    include "config/database.php";
    $mysqli         = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
    $result         = $mysqli->query($query);
    if (!$result) {
        if ($_SESSION["setting"]["environment"] != "live")
            echo "<br />Error MySQLi Query: " . $mysqli->error;
    } else {
        $i   = 0;
        $no  = 0;
        $row = $result->num_rows;
        while ($data = $result->fetch_assoc()) {
            $index_table["data"][$i]["class"] = "";
            $index_table["data"][$i]["action"] = "";
            $index_table["data"][$i]["break"] = "";
            $index_table["data"][$i]["after"] = "";
            $index_table["data"][$i]["element"] = "";
            include $index["data"];
            if (!empty($index_table["data"][$i]["element"])){
                echo $index_table["data"][$i]["element"];
            }
            else{
                if (!empty($index_table["data"][$i]["break"]))
                    echo $index_table["data"][$i]["break"];
                echo "<tr>";
                $column_numb = 0;
                foreach ($table["column"] as $column) {
                    $align = "";
                    if ($column["name"] == "action")
                        $align = "align=\"" . "center" . "\"";
                    if (!empty($column["align"]))
                        $align = "align=\"" . $column["align"] . "\"";
                    $width = "";
                    if (!empty($column["width"]))
                        $width = " style='width:" . $column["width"] . "px;' ";
                    if ($table["id"] == "index_report" && $width != "")
                        $width = " style='width:" . $column["width"] . "px!important;min-width:" . $column["width"] . "px!important;' ";
                    echo "<td " . $align . " " . $width . " class='col_detail_numb_" . $column_numb . " col_detail_name_" . $column["name"] . " " . $column["class"] . "'>" . $index_table["data"][$i][$column["name"]] . "</td>";
                    $column_numb++;
                }
                echo "</tr>";
                if (!empty($index_table["data"][$i]["after"]))
                    echo $index_table["data"][$i]["after"];
                $no++;
            }
        }
    }
}
echo "\n\t</tbody>";
if ($index["footer"] == 1 && !empty($footer))
    echo "\n\t<tfoot> " . $footer . "\t\t\n\t</tfoot>";
echo "\n</table>";
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>