<?php
if ($edit_override != 1) {
    $_SESSION["config"] = $config;
    $edit["url"]    = $_SESSION["g.url"];
    $edit["mode"]   = "add";
    $edit["action"] = $edit["url"] . "&sm=edit&a=save";
    if (isset($_GET["no"])) {
        $edit["mode"] = "edit";
        $edit["action"] .= "&no=" . $_GET["no"];
        if (!empty($_GET["a"]) && $_GET["a"] == "view")
            $edit["mode"] = $_GET["a"];
    }
    $edit["title"] = ucfirst($edit["mode"]);
    if (!empty($_SESSION["menu_" . $_SESSION["g.menu"]]["string"]))
        $edit["title"] .= " " . ucfirst($_SESSION["menu_" . $_SESSION["g.menu"]]["string"]);
    if (!empty($_SESSION["menu_" . $_SESSION["g.menu"]]["title"]))
        $edit["title"] = ucfirst($edit["mode"]) . " " . ucfirst($_SESSION["menu_" . $_SESSION["g.menu"]]["title"]);
    $edit["id"]                       = "edit";
    $edit["string_id"]                = "";
    $edit["field"]                    = array();
    $edit["auto_validate"]            = 1;
    $edit["custom_rules"]             = "";
    $edit["submit_function"]          = "";
    $edit["post_dom"]                 = "";
    $edit["manual_save"]              = "";
    $edit["manual_save_afterstart"]   = "";
    $edit["manual_save_beforecommit"] = "";
    $edit["unique"]                   = array();
    $edit["table"]                    = "";
    if (!empty($_SESSION["menu_" . $_SESSION["g.menu"]]["table"]))
        $edit["table"] = $_SESSION["menu_" . $_SESSION["g.menu"]]["table"];
    $edit["query"]                 = "SELECT a.* FROM " . $edit["table"] . " a WHERE a.nomor = " . $_GET["no"];
    $edit["string_code"]           = "";
    $edit["field_code"]            = $_SESSION["setting"]["field_kode"];
    $edit["detail"]                = array();
    $edit["sp_add"]                = "";
    $edit["sp_add_param"]          = array();
    $edit["sp_edit"]               = "";
    $edit["sp_edit_param"]         = array();
    $edit["sp_delete"]             = "";
    $edit["sp_delete_param"]       = array();
    $edit["sp_approve"]            = "";
    $edit["sp_approve_param"]      = array();
    $edit["sp_reject"]             = "";
    $edit["sp_reject_param"]       = array();
    $edit["sp_disapprove"]         = "";
    $edit["sp_disapprove_param"]   = array();
    $edit["sp_close"]              = "";
    $edit["sp_close_param"]        = array();
    $edit["url_success_custom"]    = "";
    $edit["url_success"]           = $edit["url"] . "&sm=edit&a=view&no=";
    $edit["url_failed"]            = $edit["url"];
    $edit["debug"]                 = 0;
    $edit_grid["id"]               = "";
    $edit_grid["tab"]              = "data";
    $edit_grid["type"]             = "grid";
    $edit_grid["var"]["grid_type"] = "'grid_default'";
    $edit_grid["var"]["load"]      = 0;
    if ($edit["mode"] == "add")
        $edit_grid["var"]["load"] = 1;
    $edit_grid["var"]["column_unique"]       = "[ ]";
    $edit_grid["var"]["column_focus"]        = 1;
    $edit_grid["var"]["column_total"]        = 0;
    $edit_grid["var"]["default_data"]        = "{ }";
    $edit_grid["var"]["before_edit_cell"]    = 0;
    $edit_grid["var"]["add_row_data_pos"]    = "'last'";
    $edit_grid["option"]["datatype"]         = "'json'";
    $edit_grid["option"]["colNames"]         = "";
    $edit_grid["option"]["gridComplete"]     = "actGridComplete";
    $edit_grid["option"]["loadComplete"]     = "actLoadComplete";
    $edit_grid["option"]["formatCell"]       = "actFormatCell";
    $edit_grid["option"]["beforeEditCell"]   = "actBeforeEditCell";
    $edit_grid["option"]["afterEditCell"]    = "actAfterEditCell";
    $edit_grid["option"]["beforeSaveCell"]   = "actBeforeSaveCell";
    $edit_grid["option"]["afterSaveCell"]    = "actAfterSaveCell";
    $edit_grid["option"]["afterRestoreCell"] = "actAfterRestoreCell";
    $edit_grid["option"]["cellEdit"]         = "true";
    $edit_grid["option"]["cellsubmit"]       = "'clientArray'";
    $edit_grid["option"]["height"]           = $_SESSION["setting"]["grid_height"];
    $edit_grid["option"]["width"]            = $_SESSION["setting"]["grid_width"];
    $edit_grid["option"]["caption"]          = "'Grid'";
    $edit_grid["option"]["multiselect"]      = "true";
    $edit_grid["option"]["rownumbers"]       = "true";
    $edit_grid["option"]["footerrow"]        = "false";
    $edit_grid["option"]["rowNum"]           = $_SESSION["setting"]["grid_rownum"];
    $edit_grid["option"]["pginput"]          = "false";
    $edit_grid["option"]["pgbuttons"]        = "false";
    $edit_grid["option"]["viewrecords"]      = "false";
    $edit_grid["column"]                     = array();
    $edit_grid["colmodel"]                   = array();
    $edit_grid["column_autoaddrow"]          = 1;
    $edit_grid["parameter"]                  = array();
    $edit_grid["query"]                      = "";
    $edit_grid["query_order"]                = "";
    $edit_grid["debug"]                      = 0;
    $edit_grid["filtertoolbar"]              = 0;
    $edit_grid["navgrid"]                    = 1;
    $edit_grid["nav_option"]["view"]         = "true";
    $edit_grid["nav_option"]["edit"]         = "false";
    $edit_grid["nav_option"]["addfunc"]      = "actAddFunc";
    $edit_grid["nav_option"]["delfunc"]      = "actDelFunc";
    $edit_grid["nav_option"]["search"]       = "false";
    $edit_grid["nav_option"]["refresh"]      = "false";
    $edit_grid["class_area"]                 = "";
    $edit_grid["additional_area"]            = "";
    $edit_grid["pre_script"]                 = "";
    $edit_grid["pre_dom"]                    = "";
    $edit_grid["post_dom"]                   = "";
    $edit_grid["post_script"]                = "";
    $edit_grid["functions_script"]           = 1;
    $edit_grid["others_script"]              = array(
        "scripts"
    );
    $edit_navbutton["mode"]                  = "add";
    $edit_navbutton["field"]                 = array();
    $edit_html                               = "";
    if (!empty($edit_include))
        foreach ($edit_include as $setting)
            include $setting;
}
if ($frame_override != 1) {
    if (!empty($_GET["a"]) && $_GET["a"] == "save") {
        if (!empty($edit["manual_save"]))
            include $edit["manual_save"];
        $save_override = 1;
        $save          = $edit;
        include $config["webspira"] . "codes/save.php";
    }
    if (($edit["mode"] == "add" && $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"]["add"] != 1) || ($edit["mode"] == "edit" && $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"]["edit"] != 1))
        set_alert(get_message(306, $edit["mode"] . " " . $_SESSION["g.menu_kode"]));
    $form_override = 1;
    $form          = $edit;
    $form_id       = "begin";
    include $config["webspira"] . "codes/form.php";
    $edit_html .= $form_html;
    $navbutton_override     = 1;
    $edit_navbutton["mode"] = $edit["mode"];
    $navbutton              = $edit_navbutton;
    include $config["webspira"] . "codes/navbutton.php";
    $edit_html .= $navbutton_html;
    $form_override = 1;
    $form          = $edit;
    $form_id       = "field";
    include $config["webspira"] . "codes/form.php";
    $edit_html .= $form_html;
    $form_id = "end";
    include $config["webspira"] . "codes/form.php";
    $edit_html .= $form_html;
    if ($edit["auto_validate"] == 1) {
        if ($edit["submit_function"] == "") {
            $edit["submit_form"] = "
                \t\tvar link = $('#form_" . $edit["id"] . "').attr('action');
                \t\tvar obj  = $.dialog({
                    \t\ticon: 'fa fa-spinner fa-spin',
                    \t\ttitle: 'Please Wait..',
                    \t\tdraggable: false,
                    \t\tanimation: 'scale',
                    \t\tcontent: '<font style=\'font-size:14px\'>Saving Data..</font>',
                    \t\tbuttons: {
                    \t\tok: {
                        \t\tisHidden: true,
                      \t\t}
                  \t\t},
                  \t\tonOpen: function () {
                        \t\t$.ajax({
                            \t\turl: link,
                            \t\ttype: 'POST',
                            \t\tdata: new FormData($('#form_" . $edit["id"] . "')[0]),
                            \t\tprocessData: false,
                            \t\tcontentType: false,
                            \t\tsuccess: function(html) {
                                \t\tobj.close();
                                \t\tvar refresh = $(html).find('meta');
                                \t\t$('meta').replaceWith(refresh);
                            \t\t}               
                        \t\t});
                    \t\t}
                \t\t});
                ";
            $edit["submit_function"] = "\n\t\t\t\tvar checked_header = checkHeader();\n\t\t\t\tvar checked_grid = checkGrid();\n\t\t\t\tvar checked_unique = checkUnique();\n\t\t\t\t\n\t\t\t\tvar checksave_exists = (typeof checkSave === 'function') ? true : false;\n\t\t\t\tif(checksave_exists == true)\n\t\t\t\t\tvar checked_save = checkSave();\n\t\t\t\telse\n\t\t\t\t\tvar checked_save = true;\n\t\t\t\t\n\t\t\t\tif(checked_header == true && checked_grid == true && checked_unique == true && checked_save == true)\n\t\t\t\t{\n\t\t\t\t";
            $count_edit_detail       = count($edit["detail"]);
            if ($count_edit_detail > 0) {
                $edit["submit_function"] .= "\tconsole.log('vgrid_comp:');\n\t\t\t\t\tconsole.log(vgrid_comp);\n\t\t\t\t\tconsole.log('vgrid_load:');\n\t\t\t\t\tconsole.log(vgrid_load);\n\t\t\t\t\t\n\t\t\t\t\tgenerateRealGrid();\n\t\t\t\t\tconsole.log('vgrid_real:');\n\t\t\t\t\tconsole.log(vgrid_real);\n\t\t\t\t\tconsole.log('vgrid_last:');\n\t\t\t\t\tconsole.log(vgrid_last);\n\t\t\t\t\t\n\t\t\t\t\tif(";
                $ied            = 0;
                $if_form_submit = "";
                foreach ($edit["detail"] as $detail) {
                    if ($ied > 0 && !empty($if_form_submit))
                        $if_form_submit .= " && ";
                    $if_form_submit .= " vgrid_real['" . $detail["grid_id"] . "'] == 'yes' ";
                    if ($edit["mode"] == "add")
                        $if_form_submit .= " && ((vgrid_last['" . $detail["grid_id"] . "'] > 0 && vgrid_comp['" . $detail["grid_id"] . "'] == 'completed') || (vgrid_last['" . $detail["grid_id"] . "'] <= 0)) ";
                    elseif ($edit["mode"] == "edit")
                        $if_form_submit .= " && vgrid_comp['" . $detail["grid_id"] . "'] == 'completed' && vgrid_load['" . $detail["grid_id"] . "'] == 'done' ";
                    $ied++;
                }
                $edit["submit_function"] .= $if_form_submit;
                $edit["submit_function"] .= ")\n\t\t\t\t\t{\n\t\t\t\t\t" . $edit["submit_form"] . "\n\t\t\t\t\t}";
            } else {
                $edit["submit_function"] .= $edit["submit_form"];
            }
            $edit["submit_function"] .= "\n\t\t\t\t}\n\t\t\t\telse if(checked_header == false)\n\t\t\t\t\t$.alert({title: 'ALERT',content: '" . get_message(712) . "',icon: 'fa fa-warning',theme: 'modern',type: 'red'});\n\t\t\t\telse if(checked_header != true && checked_header != false && checked_header != '')\n\t\t\t\t\t$.alert({title: 'ALERT',content: '" . get_message(801) . "\\n\\n'+checked_header,icon: 'fa fa-warning',theme: 'modern',type: 'red'});\n\t\t\t\telse if(checked_grid == false)\n\t\t\t\t\t$.alert({title: 'ALERT',content: '" . get_message(716) . "',icon: 'fa fa-warning',theme: 'modern',type: 'red'});\n\t\t\t\telse if(checked_grid != true && checked_grid != false && checked_grid != '')\n\t\t\t\t\t$.alert({title: 'ALERT',content: checked_grid,icon: 'fa fa-warning',theme: 'modern',type: 'red'});\n\t\t\t\telse if(checked_unique == false)\n\t\t\t\t\t$.alert({title: 'ALERT',content: '" . get_message(105) . "',icon: 'fa fa-warning',theme: 'modern',type: 'red'});\n\t\t\t\telse if(checked_unique != true && checked_unique != false && checked_unique != '')\n\t\t\t\t\t$.alert({title: 'ALERT',content: checked_unique,icon: 'fa fa-warning',theme: 'modern',type: 'red'});\n\t\t\t\telse if(checked_save != true && checked_save != false && checked_save != '')\n\t\t\t\t\t$.alert({title: 'ALERT',content: checked_save,icon: 'fa fa-warning',theme: 'modern',type: 'red'});\n\t\t\t\t";
        }
        $validate_override = 1;
        $validate          = $edit;
        include $config["webspira"] . "codes/validate.php";
        $edit_html .= $validate_html;
    }
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>