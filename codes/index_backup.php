<div id="modal_filter_column" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User's Template Filter Column</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>User</label>
                    <select id="user_filter_column" name="user_filter_column">
                    </select>
                    <input type="text" id="menu_filter_column" name="menu" value="<?= $_SESSION["g.menu_kode"] ?>" hidden>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="reload_selected_column()" class="btn btn-success">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
$sql_filtered_column = "SELECT columns
FROM shfiltercolumnmenu a 
WHERE a.kodeshmenu= '".$_SESSION["g.menu_kode"]."' 
AND a.nomormhadmin = ".$_SESSION["login"]["nomor"];
$result = mysqli_query($con, $sql_filtered_column);
while ($row = $result->fetch_array()) {
    $_SESSION["menu_".$_SESSION["g.menu_kode"]]["filter_selected_columns"] = explode("|", $row["columns"]);
}
ini_set('max_execution_time', '0');
ini_set("memory_limit",-1);
$paging = new Paging;
if ($index_override != 1) {
    $_SESSION["config"] = $config;
    $index["query_order"] = "";
    if (!empty($_GET["ob"]) && !empty($_GET["ad"]))
        $index["query_order"] = $_GET["ob"] . " " . $_GET["ad"];
    $index["query_where"] = " a." . $_SESSION["setting"]["field_status_aktif"] . " " . $_SESSION["setting"]["deleted_operator"] . " 0 ";
    $index["keyword"]     = "";
    if (!empty($_SESSION["menu_" . $_SESSION["g.menu"]]["keyword"]))
        $index["keyword"] = $_SESSION["menu_" . $_SESSION["g.menu"]]["keyword"];
    $index["keyword_filter"] = "";
    if (!empty($_SESSION["menu_" . $_SESSION["g.menu"]]["keyword_filter"]))
        $index["keyword_filter"] = $_SESSION["menu_" . $_SESSION["g.menu"]]["keyword_filter"];
    $index["query_filter"] = "";
    if (!empty($_SESSION["menu_" . $_SESSION["g.menu"]]["filter_query"]))
        $index["query_filter"] = $_SESSION["menu_" . $_SESSION["g.menu"]]["filter_query"];
    $index["query_from"] = "";
    if (!empty($_SESSION["menu_" . $_SESSION["g.menu"]]["table"]))
        $index["query_from"] = $_SESSION["menu_" . $_SESSION["g.menu"]]["table"];
    $index["query_select"] = "";
    if (!empty($index["query_from"]))
        $index["query_select"] = "SELECT a.* FROM " . $index["query_from"] . " a ";
    $index_title = "";
    if ($index_type == "index")
        $index_title = "List ";
    if (!empty($_SESSION["menu_" . $_SESSION["g.menu"]]["string"]))
        $index["title"] = $index_title . ucfirst($_SESSION["menu_" . $_SESSION["g.menu"]]["string"]);
    if (!empty($_SESSION["menu_" . $_SESSION["g.menu"]]["title"]))
        $index["title"] = $index_title . ucfirst($_SESSION["menu_" . $_SESSION["g.menu"]]["title"]);
    $index["default_order"] = "";
    $index["debug"]         = 0;
    $index["footer"]        = 0;
    $index["after_table"]   = "";
    $index["url"]           = $_SESSION["g.url"];
    $index["state"]         = $config["state"];
    $data                   = explode(".", $index_include[0]);
    $index["data"]          = $data[0] . "_data." . $data[1];
    // PARAM AJAX FOR LOAD USING AJAX OR NOT -> 1 USING AJAX 
    $index["ajax"]          = 0; // (SET DEFAULT TO 0)
    if ($index_type == "report")
        $index["search"] = 0;
    else
        $index["search"] = 1;
    $index["filter"]         = 0;
    $protocol                = $_SERVER["HTTPS"] == "on" ? "https" : "http";
    $index_filter["urlback"] = $protocol . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $index_filter["hide"]    = 1;
    $index_filter["url"]     = $_SESSION["g.url"];
    $index_filter["mode"]    = "filter";
    $index_filter["action"]  = $index_filter["url"] . "&sm=filtering";
    $index_filter["title"]   = ucfirst($index_filter["mode"]);
    $index_filter["id"]      = "filter";
    $index_filter["class"]   = "";
    if (!empty($_SESSION["setting"]["form_filter_class"]))
        $index_filter["class"] = $_SESSION["setting"]["form_filter_class"];
    $index_filter["string_id"] = "";
    $index_filter["field"]     = array();
    $index_filter["keyword"]   = 0;
    if (!empty($_SESSION["setting"]["keyword_filter"]) && $index_type != "report")
        $index_filter["keyword"] = $_SESSION["setting"]["keyword_filter"];
    $index_filter["auto_validate"]   = 1;
    $index_filter["custom_rules"]    = "";
    $index_filter["submit_function"] = "";
    $index_filter["post_dom"]        = "";
    $index_filter["btn_title"]       = "FILTER";
    $index_filter["btn_icon"]        = "fa fa-filter";
    if ($index_type == "index") {
        $index_navbutton["generate"] = "reload|add";
        if (!empty($_SESSION["setting"]["navbutton_index"]))
            $index_navbutton["generate"] = $_SESSION["setting"]["navbutton_index"];
    } else {
        $index_navbutton["generate"] = "reload|export_print|export_excel";
        if (!empty($_SESSION["setting"]["navbutton_report"]))
            $index_navbutton["generate"] = $_SESSION["setting"]["navbutton_report"];
    }
    $index_navbutton["mode"]  = "index";
    $index_navbutton["field"] = array();
    $index_navbutton["url"]   = "";
    if ($index_type == "report")
        $index_table["id"] = "index_report";
    else
        $index_table["id"] = "index";
    $index_table["url"]           = $index["url"];
    $index_table["column"]        = array();
    $index_table["column_export"] = array();
    $index_table["data"]          = array();
    $index_table["footer"]        = "";
    $index_page["total"]          = 0;
    $index_page["row"]            = $_SESSION["setting"]["index_row"];
    $index_page["now"]            = 0;
    if (!empty($_GET["p"]))
        $index_page["now"] = $_GET["p"];
    $index_page["position"]                 = 0;
    $index_datatable["order"]               = "[]";
    $index_datatable["scrollX"]             = "true";
    $index_datatable["scrollY"]             = "'35vw'";
    $index_datatable["scrollCollapse"]      = "true";
    if ($index_type == "report")
    {
        $index_datatable["lengthMenu"]      = '[ [100, 250, 500, 1000, -1], [100, 250, 500, 1000, "All"] ]';
        $index_datatable["pageLength"]      = 100;
    }
    if(!empty($_SESSION["setting"]["index_lengthmenu"]))
        $index_datatable["lengthMenu"]      = $_SESSION["setting"]["index_lengthmenu"];
    if(!empty($_SESSION["setting"]["index_pagelength"]))
        $index_datatable["pageLength"]      = $_SESSION["setting"]["index_pagelength"];
    $index_datatable["stateSave"]           = "true";
    $index_datatable["dom"]                 = " \"<'row'<'col-sm-12 col-md-6 dt-left-button'lB><'col-sm-12 col-md-6'f>>\" +
                                                \"<'row'<'col-sm-12'tr>>\" +
                                                \"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>\"";
    $index_datatable["buttons"]             = "
    [
        {         
            extend  : 'colvis',
            name    : 'colvis',
            attr:  {
                title: 'Visibility'
            },
            title:'" . strtoupper($_SESSION["menu_".$_GET["m"]]["title"]) . "',
            text: '<i class=\"fa fa-eye\"></i>',
            filename: '" . strtoupper($_SESSION["menu_".$_GET["m"]]["title"]) . "',
            className: 'btn btn-export btn-colvis'
        }
    ]";
    if($index_type == "report"){
        $index_datatable["paging"]          = "false";
        $index_datatable["dom"]             = " \"<'row'<'col-sm-12 col-md-6 dt-left-button'lB><'col-sm-12 col-md-6'f>>\" +
                                                \"<'row'<'col-sm-12'tr>>\" +
                                                \"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>\"";
        if($index["ajax"])
            $index_datatable["dom"]         = " \"<'row'<'col-sm-12 col-md-6 dt-left-button'lB><'col-sm-12 col-md-6'>>\" +
                                                \"<'row'<'col-sm-12'tr>>\" +
                                                \"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>\"";
        $index_datatable["buttons"]         = "
        [
            {         
                extend  : 'copy',
                name    : 'copy',
                attr:  {
                    title: 'Copy'
                },
                title:'" . strtoupper($_SESSION["menu_".$_GET["m"]]["title"]) . "',
                text: '<i class=\"fa fa-copy\"></i>',
                filename: '" . strtoupper($_SESSION["menu_".$_GET["m"]]["title"]) . "',
                className: 'btn btn-export btn-copy',
            }, 
            {         
                extend  : 'excel',
                name    : 'excel',
                attr:  {
                    title: 'Excel'
                },
                title: '" . strtoupper($_SESSION["menu_".$_GET["m"]]["title"]) . "',
                text: '<i class=\"fa fa-file-excel-o\"></i>',
                filename: '" . strtoupper($_SESSION["menu_".$_GET["m"]]["title"]) . "',
                className: 'btn btn-export btn-excel',
            }, 
            {         
                extend  : 'colvis',
                name    : 'colvis',
                attr:  {
                    title: 'Visibility'
                },
                title:'" . strtoupper($_SESSION["menu_".$_GET["m"]]["title"]) . "',
                text: '<i class=\"fa fa-eye\"></i>',
                filename: '" . strtoupper($_SESSION["menu_".$_GET["m"]]["title"]) . "',
                className: 'btn btn-export btn-colvis',
            }
        ]";
    }
    $index_datatable["stateSaveParams"]     = "
    function ( settings, data ) {
      for ( var i = 0, ien = data.columns.length ; i < ien ; i++ ) {
        delete data.columns[i].visible;
      }
    }";
    $index_datatable["initComplete"]        = "
    function( settings ) {
        hideLoader();
        $( '.table-datatable' ).removeClass( 'hide' );
        $( $.fn.dataTable.tables(true) ).DataTable().columns.adjust();
        $( '.dataTables_filter' ).append('<span class=\"bt-search\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></span>');
        var search = $(\".dataTables_filter input[type=search]\").val();
        if(search != ''){
             $(\".dataTables_filter input[type=search]\").css(\"width\", \"300px\");
        }
    }";
    $index_print["function"] = "defaultPrint()";
    $index_html = "";
    if (!empty($index_include))
        foreach ($index_include as $setting)
            include $setting;
    if($index["ajax"] == 1)
    {
        $index_datatable["processing"] = "true";
        $index_datatable["serverSide"] = "true";
        $index_datatable["paging"]     = "true";
    }
}
$query = $index["query_select"];
$query_select = $index["query_select"];
$query_where = "";
if ($index_type == "report" && !empty($index["query_filter"])){
    $query = $index["query_filter"];
    $query_select = $index["query_filter"];
}
if ($index_type == "index") {
    $query_search = generate_search_query($index["keyword"], $index_table["column"]);
    if (!empty($query_search)){
        $index["query_where"] .= " AND ( " . $query_search . " ) ";
        $query_where .= $index["query_where"];
    }
    if (!empty($index["query_where"])){
        $query .= " WHERE " . $index["query_where"];
        $query_where .= $index["query_where"];
    }
    if (!empty($index["query_filter"])){
        $query .= $index["query_filter"];
        $query_where .= $index["query_filter"];
    }
    $query_filter_search = generate_search_query($index["keyword_filter"], $index_table["column"]);
    if (!empty($query_filter_search)){
        $query .= " AND ( " . $query_filter_search . " ) ";
        $query_where .= " AND ( " . $query_filter_search . " ) ";
    }
    if (!empty($index["query_order"])){
        $query .= " ORDER BY " . $index["query_order"];
        $query_order = $index["query_order"];
    }
    elseif (!empty($index["default_order"])){
        $query .= " ORDER BY " . $index["default_order"];
        $query_order = $index["default_order"];
    }
}
if ($index["debug"] == 1)
    echo "<br />Debugging Query Index #1 :<br />" . $query . "<br /><br />";
elseif ($_SESSION["setting"]["environment"] != "live")
    echo "\n\t<!--\n\t-- BEGIN DEBUGGING QUERY INDEX #1 :\n\t\n\t~~ " . $query . " ~~\n\t\n\t-- END DEBUGGING QUERY INDEX #1\n\t-->";
$_SESSION["menu_" . $_SESSION["g.menu"]]["export_title"]  = $index["title"];
$_SESSION["menu_" . $_SESSION["g.menu"]]["export_query"]  = $query;
$_SESSION["menu_" . $_SESSION["g.menu"]]["export_column"] = $index_table["column"];
if (!empty($index_table["column_export"]))
    $_SESSION["menu_" . $_SESSION["g.menu"]]["export_column"] = $index_table["column_export"];
if ($_SESSION["login"]["framework"] == "webspira") {
    if ($index_type == "index") {
        $query_count = "SELECT COUNT(aqtotal." . $_SESSION["setting"]["field_nomor"] . ") AS total FROM (" . $query . ") aqtotal";
        if ($index["debug"] > 1)
            echo "<br />Debugging Query Index COUNT :<br />" . $query_count . "<br /><br />";
        elseif ($_SESSION["setting"]["environment"] != "live")
            echo "\n\t\t\t<!--\n\t\t\t-- BEGIN DEBUGGING QUERY INDEX COUNT :\n\t\t\t\n\t\t\t~~ " . $query_count . " ~~\n\t\t\t\n\t\t\t-- END DEBUGGING QUERY INDEX COUNT\n\t\t\t-->";
        $index_page["total"] = 0;
        $result_count        = mysql_fetch_array(mysql_query($query_count));
        if (!$result_count) {
        } else {
            $index_page["total"] = $result_count["total"];
        }
        $index_page["position"] = $paging->getPosition($index_page["row"]);
        $query .= " LIMIT " . $index_page["position"] . ", " . $index_page["row"] . " ";
    }
}

$navbutton_override = 1;
$index_navbutton    = generate_navbutton($index_navbutton, $index_navbutton["generate"], "", "", $index_navbutton["url"]);
$navbutton          = $index_navbutton;
include $config["webspira"] . "codes/navbutton.php";
echo $navbutton_html;
if ($index["filter"] == 1) {
    $filter_override = 1;
    $index_filter    = fill_filter($index_filter);
    $filter          = $index_filter;
    include $config["webspira"] . "codes/filter.php";
    echo $filter_html;
}
if ($index_type == "index") {
    if (!empty($index["query_filter"]))
        echo "\n\t\t<script language='javascript' type='text/javascript'>\n\t\t$(document).ready(function(){\n\t\t\tshow_filter();\n\t\t});\n\t\tfunction show_filter(){\n\t\t\t$('#form_" . $filter["id"] . "_1_collapse-link').attr('class','fa fa-chevron-up');\n\t\t\t$('#form_" . $filter["id"] . "_1_box-content').attr('style','');\n\t\t}\n\t\t</script>";
    if ($_SESSION["login"]["framework"] == "webspira") {
        include $config["webspira"] . "codes/search.php";
        $page_override = 1;
        $page          = $index_page;
        include $config["webspira"] . "codes/page.php";
    }
}

// HIDDEN LOADER WHEN USING AJAX
$hide_class ="";
if($index["ajax"] == 1) 
    $hide_class = "hide";
echo "\n<script type='text/javascript'> url = window.location.href.split('?')[0]; url += '?m=".$_SESSION["g.menu"]."&f=".$_SESSION["g.frame"]."&';window.history.replaceState({}, '', url )</script><div class='row animated fadeInRight index_box_content " . $index_type . "'>\n\t<div class='col-xs-12'>\n\t\t<div class='box'>\n\t\t\t<div class='box-header'>\n\t\t\t\t<div class='box-name'>\n\t\t\t\t\t<i class='fa fa-files-o'></i>\n\t\t\t\t\t<span>" . $index["title"] . "</span>\n\t\t\t\t</div>\n\t\t\t<!--<div class='box-icons'>\n\t\t\t\t\t<a class='collapse-link'>\n\t\t\t\t\t\t<i class='fa fa-chevron-up'></i>\n\t\t\t\t\t</a>\n\t\t\t\t\t<a class='expand-link'>\n\t\t\t\t\t\t<i class='fa fa-expand'></i>\n\t\t\t\t\t</a>\n\t\t\t\t\t<a class='close-link'>\n\t\t\t\t\t\t<i class='fa fa-times'></i>\n\t\t\t\t\t</a>\n\t\t\t\t</div>-->\n\t\t\t\t<div class='no-move'></div>\n\t\t\t</div>\n\t\t\t<div class='box-content no-padding' id='index_content'><div class=\"lds-ellipsis " . $hide_class . "\"><div></div><div></div><div></div><div></div></div>";
if ($_SESSION["login"]["framework"] == "webspira") {
    if ($index_type == "index") {
        echo "\n\t\t\t\t<div class='box-content'>";
        if ($index["search"] == 1)
            echo $search_html;
        else
            echo "\n\t\t\t\t\t<div class=\"col-sm-6\">&nbsp;</div>";
        echo $page_html . "\n\t\t\t\t</div>";
    }
} else
    echo "<br /><br />";

// DIVIDE BETWEEN 2 METHOD LOAD
// PASSING AND GENERATE TABLE
$table_override = 1;
$table          = $index_table;
if($index["ajax"] == 1) {
    $fields = array();
    for ($i = 1; $i < (count($index_table["column"]) - 1); $i++) { 
       array_push($fields,$index_table["column"][$i]["name"]);
    }
    $query_select = trim(preg_replace('/\s\s+/', ' ', $query_select));
    $query_where = trim(preg_replace('/\s\s+/', ' ', $query_where));
    $query_order = trim(preg_replace('/\s\s+/', ' ', $query_order));

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
    echo "\n<table class='table table-bordered table-striped table-hover table-datatable' id='table_" . $table["id"] . "'>\n\t<thead>\n\t\t";
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
    echo "\n\t\t</tr>\n\t</thead>\n\t<tbody>";
    echo "\n\t</tbody>";
    if(isset($query) AND !empty($query)) {
        $config["state"]= $index["state"];
        include "config/database.php";
        $mysqli         = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
        $sqlfooter      = $query;
        if ($index_type == "report") {
            $sqlfooter  = str_replace('footer','1', $sqlfooter);
            $sqlfooter  = str_replace('start','0', $sqlfooter);
            $sqlfooter  = str_replace('limit','18446744073709551615', $sqlfooter);
        }
        $result = $mysqli->query($sqlfooter);
        if (!$result) {
            if ($_SESSION["setting"]["environment"] != "live")
                echo "<br />Error MySQLi Query: " . $mysqli->error;
        } else {
            $i  = 0;
            $no = 0;
            $data = $result->fetch_assoc();
            include $index["data"];
            $_SESSION["menu_".$_SESSION["g.menu"]]["filter_total"] = $data["footer_total_data"];
            unset($index_table['data']);
        }
    }
    if($index["footer"] == 1 && !empty($footer))
        echo "\n\t<tfoot>". $footer ."</tfoot>";
    echo "\n</table>";
}
else {
    include $config["webspira"] . "codes/table.php";
}
if ($_SESSION["login"]["framework"] == "webspira") {
    if ($index_type == "index")
        echo "\n\t\t\t\t<div class=\"box-content\">\n\t\t\t\t\t<div class=\"col-sm-6\">&nbsp;</div>\n\t\t\t\t\t" . $page_html . "\n\t\t\t\t</div>";
}
$br3 = "";
if ($_SESSION["login"]["framework"] == "webspira")
    $br_br_br = "<br /><br /><br />";
echo "<div class=\"box-content no-padding\" id=\"index_after_table\">\n\t\t\t\t\t" . $index["after_table"] . "\n\t\t\t\t</div>\n\t\t\t\t" . $br3 . "\n\t\t\t</div>\n\t\t</div>\n\t</div>\n</div>";

// PRINT
$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["config"]       = $config;
$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["ajax"]         = $index["ajax"];   
$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["index_type"]   = $index_type;
$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["index_data"]   = '../../'.$config["project"].$index["data"];
$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["index_table"]  = $table;
$_SESSION["menu_" . $_SESSION["g.menu"]]["print"]["query_select"] = $query_select;
if ($_SESSION["login"]["framework"] == "pelangi") { ?>
    <script type="text/javascript">
        function setDataTable(){
            <?php 
                if($index["ajax"] == 1){
                    echo " 
                        var query_select = '".addslashes($query_select)."';
                        var query_where  = '".addslashes($query_where)."';
                        var query_order  = '".addslashes($query_order)."';
                        var fields       = '".addslashes(json_encode($fields))."';
                        var server       = '".addslashes(json_encode($mysql))."';
                        var state        = '".$index["state"]."';
                        var index_type   = '".addslashes($index_type)."';
                        var index_table  = '".addslashes(json_encode($index_table))."';
                        var index_data   = '../../".$config["project"].$index["data"]."';
                        var database     = '../../".$config["project"]."config/database.php';
                    ";
                }
            ?>
            var table = $(".table-datatable").DataTable({ 
                <?php 
                    foreach($index_datatable as $key => $val)
                        echo " " . $key . ":" . $val . ", ";

                    echo "\"columnDefs\": [" ;
                    foreach($index_table["column"] as $key => $val){
                        $orderable = 'true';
                        if($index["ajax"] == 1){
                            if($index_type =='index' && $key == 0){
                                $orderable = 'true';
                            }
                            else{
                                $index_table["column"][$key]["search"] == 1 ? $orderable = 'true' : $orderable = 'false';
                            }
                        }
                        $align = $index_table["column"][$key]["align"];
                        $index_table["column"][$key]["name"] == "action" && empty($align) ? $align = 'center' : $align;
                        empty($index_table["column"][$key]["width"]) ? $width = 0 : $width = $index_table["column"][$key]["width"];
                        isset($index_table["column"][$key]["visible"]) ? $visible = $index_table["column"][$key]["visible"] : $visible = 'true';
                        echo "{ \"targets\": " . $key . ", \"className\": '" . $align . "', \"visible\": " . $visible . ", \"orderable\":" . $orderable . ", \"width\": " . $width . "},";
                    }
                    echo "],";

                    if($index["ajax"] == 1){
                        echo "ajax:{
                                url :'".$config["webspira"]."codes/ajax_grid.php',
                                type: 'post',
                                data: {
                                        query_select:query_select,
                                        query_where:query_where,
                                        query_order:query_order,
                                        fields:fields,
                                        server:server,
                                        state:state,
                                        index_type:index_type,
                                        index_table:index_table,
                                        index_data:index_data,
                                        database:database
                                    },
                                error: function(){
                                    $('.table_index-error').html('');
                                    $('#table_index tbody').html(\"<tr><td colspan='".(count($fields) + 2)."'><center>No data available in table</center></td></tr>\");
                                    $('#table_index_processing').css('display','none');
                                }
                             },
                             createdRow: function(row, data, dataIndex){
                                var obj = this;
                                if(typeof data.find(cell => cell.includes('colspan')) !== 'undefined'){
                                    this.api().cells().every( function () {
                                      var td        = data[this.index().column];
                                      var colspan   = $(td).attr('colspan');
                                      if(colspan)
                                        $('td:eq('+ this.index().column +')', row).attr('colspan', colspan);

                                      var align     = $(td).attr('align');
                                      if(align)
                                        $('td:eq('+ this.index().column +')', row).css('text-align', align);

                                      var hide      = $(td).hasClass('hide');
                                      if(hide)
                                        $('td:eq('+ this.index().column +')', row).css('display', 'none');

                                    });
                                }
                            }";
                    }
                ?>
            });
            table.on( 'buttons-action', function ( e, buttonApi, dataTable, node, config ) {
                if(config.name == 'colvis'){
                    $( '.dt-button-collection:empty').remove();
                    $( node ).unwrap( '<div class="dt-colvis"></div' );
                    $( node ).add( $( node ).nextAll( '.dt-button-background, .dt-button-collection' ) ).wrapAll( '<div class="dt-colvis"></div' );
                    $( '.buttons-columnVisibility:has(span:empty)' ).css('display', 'none');
                }
            });
    };
    function reDrawDataTable(){
        $(".table-datatable").DataTable().columns.adjust().draw(false);
    }
    function setPrint(){
        <?php echo $index_print["function"] ?>
    }
    $(document).ready(function(){
        setDataTable(); 
    });
    </script>
<?php } ?>
<?php 
?>
<?php
/*created_by:glennferio@inspiraworld.com,release_date:2019-12-16*/
?>