<?php
if ($validate_override != 1) {
    $validate["mode"] = "add";
    if (isset($_GET["no"])) {
        $validate["mode"] = "edit";
        if (!empty($_GET["a"]) && $_GET["a"] == "view")
            $validate["mode"] = $_GET["a"];
    }
    $validate["id"]              = "edit";
    $validate["field"]           = array();
    $validate["custom_rules"]    = "";
    $validate["submit_function"] = "";
    $validate["post_dom"]        = "";
    $validate_html               = "";
    if (!empty($validate_include))
        foreach ($validate_include as $setting)
            include $setting;
}
$validate_html = "\n<script language='javascript' type='text/javascript'>\n$(function()\n{\n\t$('#form_" . $validate["id"] . "')";
if ($validate["id"] == "edit")
    $validate_html .= "\n\t.unbind('submit')\n\t.submit(function(e){\n\t\te.preventDefault();\n\t})";
$validate_html .= "\n\t.validate(\n\t{\n\t\trules:\n\t\t{";
$i = 0;
foreach ($validate["field"] as $field) {
    if ((empty($field["pro_mode"]) && empty($field["anti_mode"])) || (!empty($field["pro_mode"]) && strstr($field["pro_mode"], $validate["mode"])) || (!empty($field["anti_mode"]) && !strstr($field["anti_mode"], $validate["mode"]))) {
        if (!empty($field["input_validate"])) {
            if ($i != 0)
                $validate_html .= ",";
            $validate_html .= $field["input"] . ": { " . $field["input_validate"] . " }";
            $i++;
        }
    }
}
if (!empty($validate["custom_rules"]))
    $validate_html .= $validate["custom_rules"];
$validate_html .= "\n\t\t}";
if (!empty($validate["submit_function"])) {
    $validate_html .= "\n\t\t,submitHandler:function(form)\n\t\t{\n\t\t\tvar check_counter_grid = parseInt('" . count($edit["detail"]) . "');\n\t\t\tif(check_counter_grid == 0)\n\t\t\t{\n\t\t\t\tvar checkheader_exists = (typeof checkHeader === 'function') ? true : false;\n\t\t\t\tif(checkheader_exists == true)\n\t\t\t\t\tvar checked_header = checkHeader();\n\t\t\t\telse\n\t\t\t\t\tvar checked_header = true;\n\t\t\t\t\n\t\t\t\tvar checksave_exists = (typeof checkSave === 'function') ? true : false;\n\t\t\t\tif(checksave_exists == true)\n\t\t\t\t\tvar checked_save = checkSave();\n\t\t\t\telse\n\t\t\t\t\tvar checked_save = true;\n\t\t\t\t\n\t\t\t\tif(checked_header == true && checked_save == true)\n\t\t\t\t{\n\t\t\t\t\t" . $validate["submit_form"] . "\n\t\t\t\t}\n\t\t\t}\n\t\t\tif(check_counter_grid > 0)\n\t\t\t{\n\t\t\t\t" . $validate["submit_function"] . "\n\t\t\t}\n\t\t}";
}
$validate_html .= "\n\t});";
if (!empty($validate["post_dom"]))
    $validate_html .= $validate["post_dom"];
$validate_html .= "\n});\n</script>";
?>
<?php
/*created_by:patricklipesik@gmail.com;release_date:2020-05-09;*/
?>