<?php
if ($filter_override != 1) {
    $protocol          = $_SERVER["HTTPS"] == "on" ? "https" : "http";
    $filter["urlback"] = $protocol . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $filter["hide"]    = 0;
    $filter["btn-hide"]= 0;
    $filter["url"]     = $_SESSION["g.url"];
    $filter["mode"]    = "filter";
    $filter["class"]   = "";
    if (!empty($_SESSION["setting"]["form_filter_class"]))
        $filter["class"] = $_SESSION["setting"]["form_filter_class"];
    $filter["action"]    = $filter["url"] . "&sm=filtering";
    $filter["title"]     = ucfirst($filter["mode"]);
    $filter["id"]        = "filter";
    $filter["string_id"] = "";
    $filter["field"]     = array();
    $filter["keyword"]   = 0;
    if (!empty($_SESSION["setting"]["keyword_filter"]))
        $filter["keyword"] = $_SESSION["setting"]["keyword_filter"];
    $filter["auto_validate"]   = 0;
    $filter["custom_rules"]    = "";
    $filter["submit_function"] = "";
    $filter["post_dom"]        = "";
    /*START edded_by:glennferio@inspiraworld.com;last_updated:2020-05-20;*/
    $filter["btn_title"]       = "FILTER";
    $filter["btn_icon"]        = "fa fa-filter";
    /*START edded_by:glennferio@inspiraworld.com;last_updated:2020-05-20;*/
    $filter_html               = "";
    if (!empty($filter_include))
        foreach ($filter_include as $setting)
            include $setting;
}
$i = count($filter["field"]);
if ($filter["keyword"] == 1) {
    $filter["field"][$i]["label"]       = "Search";
    $filter["field"][$i]["input"]       = "keyword_filter";
    $filter["field"][$i]["input_value"] = $_SESSION["menu_" . $filtering["session_name"]]["filter_keyword_filter"];
    $i++;
}
$filter["field"][$i]["form_group_class"] = "hiding";
$filter["field"][$i]["label"]            = "URL Back";
$filter["field"][$i]["input"]            = "urlback";
$filter["field"][$i]["input_value"]      = $filter["urlback"];
$i++;
/*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-19;*/
if ($filter["btn-hide"] != 1) {
    if($index["filter_column"] == 1){
        $filter["field"][$i]["label"] = "Column";
        $filter["field"][$i]["input"] = "selected_columns";
        $str_select = "<select id='selected_columns' class='form-control' name='selected_columns[]' multiple='multiple'>";
        $str_select .= "</select>";
        $filter["field"][$i]["input_element"] = $str_select;
        $i++;
    }
    
    $filter["field"][$i]["input_col"]           = "col-sm-12";
    $filter["field"][$i]["input_element"]       = "button";
    $filter["field"][$i]["input_attr"]["id"]    = "search";
    $filter["field"][$i]["input_attr"]["class"] = "btn-filter";
    $filter["field"][$i]["input_attr"]["type"]  = "submit";
    $filter["field"][$i]["input_attr"]["value"] = "<i class='".$filter["btn_icon"]."'></i>&nbsp;".$filter["btn_title"];
    $i++;
}
/*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-19;*/
$filter_html .= "\n<script language='javascript' type='text/javascript'>\n$(document).ready(function(){ ";
if ($filter["hide"] == 1)
    $filter_html .= " hide_filter(); ";
$filter_html .= "\n});\nfunction hide_filter(){\n\t$('#form_" . $filter["id"] . "_1_collapse-link').attr('class','fa fa-chevron-down');\n\t$('#form_" . $filter["id"] . "_1_box-content').attr('style','display: none;');\n}\n</script>";
$form_override = 1;
$form          = $filter;
$form_id       = "";
include $config["webspira"] . "codes/form.php";
$filter_html .= $form_html;
if ($filter["auto_validate"] == 1) {
    $validate_override = 1;
    $validate          = $filter;
    include $config["webspira"] . "codes/validate.php";
    $filter_html .= $validate_html;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>