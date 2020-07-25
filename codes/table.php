<?php
if ($table_override != 1) {
    $table["id"]     = "index";
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
echo "\n<table class='table table-bordered table-striped table-hover table-datatable ".$hide_class."' id='table_" . $table["id"] . "'>\n\t<thead>\n\t\t<tr>";
$length      = count($table["column"]);
$column_numb = 0;
foreach ($table["column"] as $column) {
    $width = "";
    if (!empty($column["width"]))
        $width = " style='width:" . $column["width"] . "px;' ";
    if ($table["id"] == "index_report" && $width != "")
        $width = " style='width:" . $column["width"] . "px!important;min-width:" . $column["width"] . "px!important;' ";
    echo "<th " . $width . " class='col_header_numb_" . $column_numb . " col_header_name_" . $column["name"] . " " . $column["class"] . "'>" . $column["caption"];
    if (empty($column["sort"]))
        $column["sort"] = $column["name"];
    if ($column["sort"] != "empty")
        echo "<a href='" . $table["url"] . "&ob=" . $column["sort"] . "&ad=desc'><img src='" . $config["webspira"] . "assets_dashboard/img/sort-desc.png' style='float:right; width:16px;'></a><a href='" . $table["url"] . "&ob=" . $column["sort"] . "&ad=asc'><img src='" . $config["webspira"] . "assets_dashboard/img/sort-asc.png' style='float:right; width:16px;'></a>";
    echo "</th>";
    $column_numb++;
}
echo "\n\t\t</tr>\n\t</thead>\n\t<tbody>";

if(isset($index["query_from"]) AND !empty($index["query_from"])){
    $mysqli = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
    $result = $mysqli->query($query);
    if (!$result) {
        if ($_SESSION["setting"]["environment"] != "live")
            echo "<br />Error MySQLi Query: " . $mysqli->error;
    } else {
        $i  = 0;
        $no = 0;
        while ($data = $result->fetch_assoc()) {
            $index_table["data"][0]["action"] = "";
            include $index["data"];
            if (!empty($index_table["data"][0]["break"]))
                echo $index_table["data"][0]["break"];
            echo "<tr>";
            $column_numb = 0;
            foreach ($table["column"] as $column) {
                $align = "";
                if (!empty($column["align"]))
                    $align = "align=\"" . $column["align"] . "\"";
                $width = "";
                if (!empty($column["width"]))
                    $width = " style='width:" . $column["width"] . "px;' ";
                if ($table["id"] == "index_report" && $width != "")
                    $width = " style='width:" . $column["width"] . "px!important;min-width:" . $column["width"] . "px!important;' ";
                echo "<td " . $align . " " . $width . " class='col_detail_numb_" . $column_numb . " col_detail_name_" . $column["name"] . " " . $column["class"] . "'>" . $index_table["data"][0][$column["name"]] . "</td>";
                $column_numb++;
            }
            echo "</tr>";
            $no++;
        }
    }
}
echo "\n\t</tbody>";
if ($index["footer"] == 1 && !empty($footer))
    echo "\n\t<tfoot> " . $footer . "\t\t\n\t</tfoot>";
echo "\n</table>";
?>
<?php
/*created_by:patricklipesik@gmail.com;release_date:2020-05-09;*/
?>