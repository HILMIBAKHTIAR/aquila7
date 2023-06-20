<?php
if ($grid_override != 1) {
    $grid["id"]                         = "";
    $grid["type"]                       = "grid";
    $grid["var"]["grid_type"]           = "'grid_default'";
    $grid["var"]["load"]                = 0;
    $grid["var"]["column_unique"]       = "[ ]";
    $grid["var"]["column_focus"]        = 1;
    $grid["var"]["column_total"]        = 0;
    $grid["var"]["default_data"]        = "{ }";
    $grid["var"]["before_edit_cell"]    = 0;
    $grid["var"]["add_row_data_pos"]    = "'last'";
    $grid["option"]["datatype"]         = "'json'";
    $grid["option"]["colNames"]         = "";
    $grid["option"]["gridComplete"]     = "actGridComplete";
    $grid["option"]["loadComplete"]     = "actLoadComplete";
    $grid["option"]["formatCell"]       = "actFormatCell";
    $grid["option"]["beforeEditCell"]   = "actBeforeEditCell";
    $grid["option"]["afterEditCell"]    = "actAfterEditCell";
    $grid["option"]["beforeSaveCell"]   = "actBeforeSaveCell";
    $grid["option"]["afterSaveCell"]    = "actAfterSaveCell";
    $grid["option"]["afterRestoreCell"] = "actAfterRestoreCell";
    $grid["option"]["cellEdit"]         = "true";
    $grid["option"]["cellsubmit"]       = "'clientArray'";
    $grid["option"]["height"]           = $_SESSION["setting"]["grid_height"];
    $grid["option"]["width"]            = $_SESSION["setting"]["grid_width"];
    $grid["option"]["caption"]          = "'Grid'";
    $grid["option"]["multiselect"]      = "true";
    $grid["option"]["rownumbers"]       = "true";
    $grid["option"]["footerrow"]        = "false";
    $grid["option"]["rowNum"]           = $_SESSION["setting"]["grid_rownum"];
    $grid["option"]["pginput"]          = "false";
    $grid["option"]["pgbuttons"]        = "false";
    $grid["option"]["viewrecords"]      = "false";
    $grid["column"]                     = array();
    $grid["search"]                     = array();
    $grid["colmodel"]                   = array();
    $grid["column_autoaddrow"]          = 1;
    $grid["parameter"]                  = array();
    $grid["query"]                      = "";
    $grid["query_order"]                = "";
    $grid["debug"]                      = 0;
    $grid["filtertoolbar"]              = 0;
    $grid["navgrid"]                    = 1;
    $grid["nav_option"]["view"]         = "true";
    $grid["nav_option"]["edit"]         = "false";
    $grid["nav_option"]["addfunc"]      = "actAddFunc";
    $grid["nav_option"]["delfunc"]      = "actDelFunc";
    $grid["nav_option"]["search"]       = "false";
    $grid["nav_option"]["refresh"]      = "false";
    $grid["class_area"]                 = "";
    $grid["additional_area"]            = "";
    $grid["pre_script"]                 = "";
    $grid["pre_dom"]                    = "";
    $grid["post_dom"]                   = "";
    $grid["post_script"]                = "";
    $grid["functions_script"]           = 1;
    $grid["others_script"]              = array(
        "scripts"
    );
    $grid_html                          = "";
    if (!empty($grid_include))
        foreach ($grid_include as $setting)
            include $setting;
}
$grid_caption   = str_replace("'", "", $grid["option"]["caption"]);
$grid_id        = $grid["id"];
$grid_id_unique = $grid["id"];
if ($grid["type"] == "grid" && !empty($_GET["no"]))
    $grid_id_unique .= $_GET["no"];
$_SESSION["grid_" . $grid_id_unique]["query"]        = $grid["query"];
$_SESSION["grid_" . $grid_id_unique]["query_order"]  = $grid["query_order"];
$_SESSION["grid_" . $grid_id_unique]["query_search"] = $grid["search"];
$_SESSION["grid_" . $grid_id_unique]["param_input"]  = $grid["parameter"];
$_SESSION["grid_" . $grid_id_unique]["items"]        = $grid["column"];
$_SESSION["grid_" . $grid_id_unique]["debug"]        = $grid["debug"];
$grid["var"]["element"]                              = "'#" . $grid_id . "_grid'";
$grid["var"]["navgrid"]                              = "'#" . $grid_id . "_navgrid'";
$grid["var"]["navgrid_active"]                       = $grid["navgrid"];
$grid["var"]["new_record"]                           = 1;
$grid["var"]["allow_delete"]                         = 1;
$grid["var"]["editing_rowid"]                        = 0;
$grid["var"]["editing_cellname"]                     = "''";
$grid["var"]["editing_value"]                        = 0;
$grid["var"]["editing_iRow"]                         = 0;
$grid["var"]["editing_iCol"]                         = 0;
$grid["var"]["selected_suggest"]                     = "false";
if ($grid["type"] == "grid") {
    $grid["option"]["gridComplete"]     = "actGridComplete" . "_" . $grid_id;
    $grid["option"]["loadComplete"]     = "actLoadComplete" . "_" . $grid_id;
    $grid["option"]["formatCell"]       = "actFormatCell" . "_" . $grid_id;
    $grid["option"]["beforeEditCell"]   = "actBeforeEditCell" . "_" . $grid_id;
    $grid["option"]["afterEditCell"]    = "actAfterEditCell" . "_" . $grid_id;
    $grid["option"]["beforeSaveCell"]   = "actBeforeSaveCell" . "_" . $grid_id;
    $grid["option"]["afterSaveCell"]    = "actAfterSaveCell" . "_" . $grid_id;
    $grid["option"]["afterRestoreCell"] = "actAfterRestoreCell" . "_" . $grid_id;
    $grid["nav_option"]["addfunc"]      = "actAddFunc" . "_" . $grid_id;
    $grid["nav_option"]["delfunc"]      = "actDelFunc" . "_" . $grid_id;
}
$grid["option"]["pager"] = $grid["var"]["navgrid"];
if (!empty($grid["query"]) && empty($grid["option"]["url"]))
    $grid["option"]["url"] = "'pages/grid.php?id=" . $grid_id_unique . "'";
$grid["option"]["editurl"] = "'pages/grid_edit.php'";
if (!empty($_GET["a"]) && $_GET["a"] == "view") {
    $grid["nav_option"]["add"]  = "false";
    $grid["nav_option"]["del"]  = "false";
    $grid["option"]["cellEdit"] = "false";
}
if ($grid["column_autoaddrow"] == 1) {
    $grid["option"]["colNames"]       = "[" . $grid["option"]["colNames"] . ",'ADD']";
    $i                                = count($grid["colmodel"]);
    $grid["colmodel"][$i]["name"]     = "'add'";
    $grid["colmodel"][$i]["index"]    = "'add'";
    $grid["colmodel"][$i]["hidden"]   = "true";
    $grid["colmodel"][$i]["width"]    = "25";
    $grid["colmodel"][$i]["align"]    = "'center'";
    $grid["colmodel"][$i]["sortable"] = "false";
    $grid["colmodel"][$i]["editable"] = "true";
} else
    $grid["option"]["colNames"] = "[" . $grid["option"]["colNames"] . "]";
$grid["option"]["colModel"] = "automatic";
// $grid["option"]["shrinkToFit"] = "true";
$grid_html                  = "";
if (!empty($grid["pre_script"]))
    $grid_html .= $grid["pre_script"];
$grid_html .= "\n<script language='javascript' type='text/javascript'>";
if ($grid["type"] == "grid")
    $grid_html .= "\nvgrid_comp['" . $grid_id . "'] = 'not_ready';\nvgrid_load['" . $grid_id . "'] = 'not_ready';";
foreach($grid["var"] as $key => $val)
    $grid_html .= "var " . $grid_id . "_" . $key . " = " . $val . ";";
$grid_html .= "\n$(function()\n{";
if (!empty($grid["pre_dom"]))
    $grid_html .= $grid["pre_dom"];
$grid_html .= "\n\tjQuery(" . $grid_id . "_element).jqGrid({";
$i = 0;
foreach($grid["option"] as $key => $val) {
    if ($i != 0)
        $grid_html .= " , ";
    if ($key != "colModel")
        $grid_html .= " " . $key . " : " . $val . " ";
    elseif ($key == "colModel") {
        $grid_html .= " " . $key . " : [ ";
        $i2 = 0;
        foreach ($grid["colmodel"] as $colmodel) {
            if ($i2 != 0)
                $grid_html .= " , ";
            $grid_html .= " { ";
            $i3 = 0;
            foreach($colmodel as $key2 => $val2) {
                if ($i3 != 0)
                    $grid_html .= " , ";
                $grid_html .= " " . $key2 . " : " . $val2 . " ";
                $i3++;
            }
            $grid_html .= " } ";
            $i2++;
        }
        $grid_html .= " ] ";
    }
    $i++;
}
$grid_html .= "\n\t});";
if ($grid["filtertoolbar"] == 1)
    $grid_html .= "jQuery(" . $grid_id . "_element).jqGrid('filterToolbar',{searchOperators:true});";
if ($grid["navgrid"] == 1) {
    $grid_html .= "\n\tjQuery(" . $grid_id . "_element).jqGrid('navGrid'," . $grid_id . "_navgrid,\n\t{";
    $i = 0;
    foreach($grid["nav_option"] as $key => $val) {
        if ($i != 0)
            $grid_html .= " , ";
        $grid_html .= " " . $key . " : " . $val . " ";
        $i++;
    }
    $grid_html .= "\n\t}, {}, {}, {}, {});";
}
$i = 0;
$group_header_var = "";
if (array_key_exists('colHeader', $grid)) {
    $i = 0;
    $group_header_var .= "[";
    foreach($grid["colHeader"] as $colHeader) {
        if ($i != 0)
            $group_header_var .= " , ";
        $group_header_var .= "{";
        $i1 = 0;
        foreach($colHeader as $key => $val) {
            if ($i1 != 0)
                $group_header_var .= " , ";
            if ($key != "groupHeaders")
                $group_header_var .= " '" . $key . "' : " . $val . " ";
            elseif ($key == "groupHeaders") {
                $group_header_var .= " '" . $key . "' : [ ";
                $i2 = 0;
                foreach($colHeader["groupHeaders"] as $groupHeaders) {
                    if ($i2 != 0)
                        $group_header_var .= " , ";
                    $group_header_var .= " { ";
                    $i3 = 0;
                    foreach($groupHeaders as $key => $val) {
                        if ($i3 != 0)
                            $group_header_var .= " , ";
                        $group_header_var .= " '" . $key . "' : " . $val . " ";
                        $i3++;
                    }
                    $group_header_var .= " } ";
                    $i2++;
                }
                $group_header_var .= " ] ";
            }
            $i1++;
        }
        $i++;
        $group_header_var .= " }";
    }
    $group_header_var .= "]";

    $grid_html .= "\nvar groupHeaders = " . $group_header_var .";";
    $grid_html .= "\nfor (var iRow = 0; iRow < groupHeaders.length; iRow++) {";
    $grid_html .= "\n\tjQuery(" . $grid_id . "_element).jqGrid('setGroupHeaders', groupHeaders[iRow]);";    
    $grid_html .= "\n}";
}
if (!empty($grid["post_dom"]))
    $grid_html .= $grid["post_dom"];
$grid_html .= "\n});\nfunction " . $grid_id . "_cleargrid()\n{\n\t$(function()\n\t{\n\t\tjQuery(" . $grid_id . "_element).jqGrid('clearGridData');\n\t\t" . $grid_id . "_load = 0;\n\t\tactGridComplete_" . $grid_id . "();\n\t\t" . $grid_id . "_allow_delete = 1;\n\t\tafter_delete_" . $grid_id . "();\n\t});\n}\n</script>";
if (!empty($grid["post_script"]))
    $grid_html .= $grid["post_script"];
$grid_html .= "\n<div id='" . $grid_id . "_area' class='" . $grid["class_area"] . "'>";
if (!empty($grid["input_search"]))
    $grid_html .= $grid["input_search"];
$grid_html .= "\n\t<table id='" . $grid_id . "_grid'></table>\n\t<div id='" . $grid_id . "_navgrid'></div>\n\t<span id='" . $grid_id . "_realgrid' class='hiding'></span>";
if (!empty($grid["additional_area"]))
    $grid_html .= $grid["additional_area"];
$grid_html .= "\n</div>";
if ($grid["functions_script"] == 1) {
    include $config["webspira"] . "codes/grid_functions.php";
    $grid_html .= $grid_functions_html;
}
if (!empty($grid["others_script"])) {
    ob_start();
    foreach ($grid["others_script"] as $script) {
        $dir = $config["webspira"];
        include "contents/grid/" . $grid_id . "-" . $script . ".php";
    }
    $gridjs_html = ob_get_contents();
    ob_end_clean();
    $grid_html .= $gridjs_html;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>