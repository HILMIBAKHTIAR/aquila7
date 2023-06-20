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
// if ($validate["id"] == "edit")
    $validate_html .= "\n\t.unbind('submit')\n\t.submit(function(e){\n\t\te.preventDefault();\n\t})";
$validate_html .= "\n\t.validate(\n\t{\n\t\tignore: '',\n\t\trules:\n\t\t{";
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
if (!empty($validate["submit_function"]) && $validate["id"] == "edit") {
    $validate_html .= "\n\t\t,submitHandler:function(form)\n\t\t{\n\t\t\tvar check_counter_grid = parseInt('" . count($edit["detail"]) . "');\n\t\t\tif(check_counter_grid == 0)\n\t\t\t{\n\t\t\t\tvar checkheader_exists = (typeof checkHeader === 'function') ? true : false;\n\t\t\t\tif(checkheader_exists == true)\n\t\t\t\t\tvar checked_header = checkHeader();\n\t\t\t\telse\n\t\t\t\t\tvar checked_header = true;\n\t\t\t\t\n\t\t\t\tvar checksave_exists = (typeof checkSave === 'function') ? true : false;\n\t\t\t\tif(checksave_exists == true)\n\t\t\t\t\tvar checked_save = checkSave();\n\t\t\t\telse\n\t\t\t\t\tvar checked_save = true;\n\t\t\t\t\n\t\t\t\tif(checked_header == true && checked_save == true)\n\t\t\t\t{\n\t\t\t\t" . $validate["submit_form"] . "\n\t\t\t\t}\n\t\t\t\telse if(checked_header == false)\n\t\t\t\t\t$.alert({title: 'ALERT',content: '" . get_message(712) . "',icon: 'fa fa-warning',theme: 'modern',type: 'red'});\n\t\t\t\telse if(checked_header != true && checked_header != false && checked_header != '')\n\t\t\t\t\t$.alert({title: 'ALERT',content: '" . get_message(801) . "\\n\\n'+checked_header,icon: 'fa fa-warning',theme: 'modern',type: 'red'});\n\t\t\t\telse if(checked_save != true && checked_save != false && checked_save != '')\n\t\t\t\t\t$.alert({title: 'ALERT',content: checked_save,icon: 'fa fa-warning',theme: 'modern',type: 'red'});\n\t\t\t}\n\t\t\tif(check_counter_grid > 0)\n\t\t\t{\t\t\t\t" . $validate["submit_function"] . "\n\t\t\t}\n\t\t}";
}
else {
    $validate_html .= "\n\t\t,submitHandler:function(form)\n\t\t{\n\t\t\t$('.table-datatable').DataTable().state.clear();\n\t\t\tvar obj=$.dialog({\n\t\t\t\ticon: 'fa fa-spinner fa-spin',\n\t\t\t\ttitle: 'Please Wait..',\n\t\t\t\tdraggable: false,\n\t\t\t\tanimation: 'scale',\n\t\t\t\tcontent: '<font style=\"font-size:14px\">Requesting Data..</font>',\n\t\t\t\tbuttons: {\n\t\t\t\t\tok: {\n\t\t\t\t\t\tisHidden: true,\n\t\t\t\t\t}\n\t\t\t\t},\n\t\t\t\tonOpen: function () {\n\t\t\t\t\t$.ajax({\n\t\t\t\t\t\turl: form.action,\n\t\t\t\t\t\ttype: 'POST',\n\t\t\t\t\t\tdata: $(form).serialize(),\n\t\t\t\t\t\tsuccess: function(msg) {\n\t\t\t\t\t\t\tobj.close();\n\t\t\t\t\t\t\tlocation.reload();\n\t\t\t\t\t\t}\n\t\t\t\t\t});\n\t\t\t\t}\n\t\t\t});\n\t\t\t}";
}
$validate_html .= "\n\t});";
// USING LEAVE CONFIRMATION 
// if ($validate["mode"] == "add" || $validate["mode"] == "edit")
//     $validate_html .="\n\n\tvar form_changed = false;\n\t$( document ).ready(function()\n\t{\n\t\t$(\"form :input\").change(function() { form_changed = true; });\n\t});\n\twindow.onbeforeunload = function ()\n\t{\n\t\tif (form_changed)\n\t\t\treturn true;\n\t};";
if (!empty($validate["post_dom"]))
    $validate_html .= $validate["post_dom"];
$validate_html .= "\n});\n</script>";
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>