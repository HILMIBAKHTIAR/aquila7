<?php
if ($form_override != 1) {
    $form_id        = "";
    $form["url"]    = $_SESSION["g.url"];
    $form["mode"]   = "add";
    $form["action"] = $form["url"] . "&sm=edit&a=save";
    if (isset($_GET["no"])) {
        $form["mode"] = "edit";
        $form["action"] .= "&no=" . $_GET["no"];
        if (!empty($_GET["a"]) && $_GET["a"] == "view")
            $form["mode"] = $_GET["a"];
    }
    $form["title"] = ucfirst($form["mode"]);
    if (!empty($_SESSION["menu_" . $_SESSION["g.menu"]]["string"]))
        $form["title"] .= " " . ucfirst($_SESSION["menu_" . $_SESSION["g.menu"]]["string"]);
    if (!empty($_SESSION["menu_" . $_SESSION["g.menu"]]["title"]))
        $form["title"] = ucfirst($form["mode"]) . " " . ucfirst($_SESSION["menu_" . $_SESSION["g.menu"]]["title"]);
    $form["id"]        = "edit";
    $form["class"]     = "";
    $form["string_id"] = "";
    $form["field"]     = array();
    $form_html         = "";
    $ko_binding_html   = "";
    if (!empty($form_include))
        foreach ($form_include as $setting)
            include $setting;
}
$form_html = "";
if (empty($form_id) || $form_id == "begin") {
    $form_autocomplete = "";
    if (!empty($_SESSION["setting"]["form_autocomplete"]))
        $form_autocomplete = " autocomplete='" . $_SESSION["setting"]["form_autocomplete"] . "'";
    $form_html .= "\n\t<form action='" . $form["action"] . "' class='form-horizontal " . $form["class"] . "' id='form_" . $form["id"] . "' \n\t\tmethod='post' enctype='multipart/form-data' " . $form_autocomplete . " >";
    if ($form["mode"] == "add" && !empty($form["string_id"])) {
        $new_id = create_id($con, $form["string_id"]);
        $form_html .= "\n\t\t<input type='hidden' class='form-control' name='" . $_SESSION["setting"]["field_nomor"] . "' value='" . $new_id . "' />";
    }
}
if (empty($form_id) || $form_id == "field") {
    $i_field            = 1;
    $box_col_id         = "";
    $last_box_row       = "";
    $last_box_col       = "";
    $last_box_tabs      = "";
    $last_box_tab       = "";
    $last_form_fieldset = "";
    $last_form_group    = "";
    foreach ($form["field"] as $field) {
        if ((empty($field["pro_mode"]) && empty($field["anti_mode"]) && empty($field["level"])) || (!empty($field["pro_mode"]) && strstr($field["pro_mode"], $form["mode"])) || (!empty($field["anti_mode"]) && !strstr($field["anti_mode"], $form["mode"])) || (!empty($input["level"]) && $input["level"] >= $_SESSION["login"]["tingkatan"])) {
            if (!isset($field["form_group"]) || $field["form_group"] != 0)
                $field["form_group"] = 1;
            if ($i_field > 1) {
                if (!empty($last_form_group) && (!empty($field["form_group"]) || !empty($field["form_fieldset"]) || !empty($field["box_tab"]) || !empty($field["box_tabs"]) || !empty($field["box_tabs_close"]) || !empty($field["box_col"]) || !empty($field["box_row"]))) {
                    $form_html .= "</div><span name='div_H_" . $last_form_group . "'></span>";
                    $last_form_group = "";
                }
                if (!empty($last_form_fieldset) && (!empty($field["form_fieldset"]) || !empty($field["box_tab"]) || !empty($field["box_tabs"]) || !empty($field["box_tabs_close"]) || !empty($field["box_col"]) || !empty($field["box_row"]))) {
                    $form_html .= "</fieldset><span name='fieldset_G_" . $last_form_fieldset . "'></span>";
                    $last_form_fieldset = "";
                }
                if (!empty($last_box_tab) && (!empty($field["box_tab"]) || !empty($field["box_tabs"]) || !empty($field["box_tabs_close"]) || !empty($field["box_col"]) || !empty($field["box_row"]))) {
                    $form_html .= "</div><span name='div_F_" . $last_box_tab . "'></span>";
                    $last_box_tab = "";
                }
                if (!empty($last_box_tabs) && (!empty($field["box_tabs"]) || !empty($field["box_tabs_close"]) || !empty($field["box_col"]) || !empty($field["box_row"]))) {
                    $form_html .= "</div><span name='div_E_" . $last_box_tabs . "'></span>";
                    $last_box_tabs = "";
                }
                if (!empty($last_box_col) && (!empty($field["box_col"]) || !empty($field["box_row"]))) {
                    $form_html .= "</div><span name='div_D_" . $last_box_col . "'></span>\n\t\t\t\t\t\t</div><span name='div_C_" . $last_box_col . "'></span>\n\t\t\t\t\t</div><span name='div_B_" . $last_box_col . "'></span>";
                    $last_box_col = "";
                }
                if (!empty($last_box_row) && !empty($field["box_row"])) {
                    $form_html .= "</div><span name='div_A_" . $last_box_row . "'></span>";
                    $last_box_row = "";
                }
            }
            if ($i_field == 1 || !empty($field["box_row"])) {
                $last_box_row = "i" . $i_field;
                /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-24;*/
                $hide_class = '';
                if(!empty($field["box_tabs"])){
                	$hide_class = 'hide';
                }
                $form_html .= "<div class='row animated fadeInRight form_content ".$hide_class."' name='div_A_" . $last_box_row . "'>";
                /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-24;*/
            }
            if (!isset($field["box_row_class"]))
                $field["box_row_class"] = "col-xs-12";
            if (!isset($field["box_col_class"]))
                $field["box_col_class"] = "col-sm-12";
            if ($i_field == 1 || !empty($field["box_col"])) {
                $last_box_col = "i" . $i_field;
                if (!isset($field["box_name_icon"]))
                    $field["box_name_icon"] = "fa fa-file-text-o";
                if (!isset($field["box_name_title"]))
                    $field["box_name_title"] = $form["title"];
                $box_col_id = $form["id"] . "_" . $i_field;
                $form_html .= "\n\t\t\t\t<div class='" . $field["box_row_class"] . " " . $field["box_col_class"] . "' name='div_B_" . $last_box_col . "'>\n\t\t\t\t\t<div class='box' name='div_C_" . $last_box_col . "'>";
                if (empty($field["box_col_header"]) || $field["box_col_header"] != "none") {
                    $form_html .= "\n\t\t\t\t\t<div class='box-header'>\n\t\t\t\t\t\t<div class='box-name'>\n\t\t\t\t\t\t\t<i class='" . $field["box_name_icon"] . "'></i>\n\t\t\t\t\t\t\t<span>" . $field["box_name_title"] . "</span>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class='box-icons'>\n\t\t\t\t\t\t\t<a class='collapse-link'>\n\t\t\t\t\t\t\t\t<i class='fa fa-chevron-up' id='form_" . $box_col_id . "_collapse-link'></i>\n\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t<!--<a class='expand-link'>\n\t\t\t\t\t\t\t\t<i class='fa fa-expand' id='form_" . $box_col_id . "_expand-link'></i>\n\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t<a class='close-link'>\n\t\t\t\t\t\t\t\t<i class='fa fa-times' id='form_" . $box_col_id . "_close-link'></i>\n\t\t\t\t\t\t\t</a>-->\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class='no-move'></div>\n\t\t\t\t\t</div>";
                }
                $form_html .= "\n\t\t\t\t<div class='box-content' id='form_" . $box_col_id . "_box-content' name='div_D_" . $last_box_col . "'>";
            }
            if (!empty($field["box_tabs"])) {
                $last_box_tabs = "i" . $i_field;
                $form_html .= "\n\t\t\t\t<div class='tabs' id='tabs_" . $last_box_tabs . "' name='div_E_" . $last_box_tabs . "'><ul>";
                foreach ($field["box_tabs"] as $tab) {
                    $li = explode("|", $tab);
                    $form_html .= "\n\t\t\t\t\t<li><a href='#tab_" . $last_box_tabs . "_" . $li[0] . "'>" . $li[1] . "</a></li>";
                }
                $form_html .= "</ul>";
            }
            if (!empty($field["box_tab"])) {
                $last_box_tab = $field["box_tab"];
                $form_html .= "\n\t\t\t\t<div id='tab_" . $last_box_tabs . "_" . $last_box_tab . "' name='div_F_" . $last_box_tab . "'>";
            }
            if ($i_field == 1 || !empty($field["form_fieldset"])) {
                $last_form_fieldset = "i" . $i_field;
                $form_html .= "\n\t\t\t\t<fieldset name='fieldset_G_" . $last_form_fieldset . "'>";
            }
            if (!empty($field["form_legend"])) {
                if (!empty($field["form_legend_class"]))
                    $form_legend_class .= $field["form_legend_class"];
                $form_html .= "<legend class='" . $form_legend_class . "'>" . $field["form_legend"] . "</legend>";
            }
            if ($i_field == 1 || !empty($field["form_group"])) {
                $last_form_group  = "i" . $i_field;
                $form_group_class = "form-group ";
                if ($field["input_element"] == "iframe")
                    $form_group_class = "row ";
                if (!empty($field["form_group_class"]))
                    $form_group_class .= $field["form_group_class"];
                $form_html .= "\n\t\t\t\t<div class='" . $form_group_class . "' name='div_H_" . $last_form_group . "'>";
            }
            if (!empty($field["label"])) {
                if (!isset($field["label_attr"]["for"]))
                    $field["label_attr"]["for"] = $field["label"];
                if (!isset($field["label_attr"]["form"]))
                    $field["label_attr"]["form"] = "form_" . $form["id"];
                if (!isset($field["label_attr"]["class"]))
                    $field["label_attr"]["class"] = "";
                if (!empty($field["label_class"]))
                    $field["label_attr"]["class"] = $field["label_class"];
                if (!isset($field["label_col"]))
                    $field["label_col"] = "col-sm-2";
                if (isset($field["label_style"])  && !empty($field["label_style"]))
                    $field["label_attr"]["style"] .= $field["label_style"];
                $field["label_attr"]["class"] = "control-label field_group_" . $i_field . " " . $field["label_col"] . " " . $field["label_attr"]["class"];
                $form_html .= " <label";
                foreach($field["label_attr"] as $key => $val)
                    $form_html .= " " . $key . "='" . $val . "' ";
                $form_html .= ">" . $field["label"] . "</label> ";
            }
            if (!isset($field["input_col"])) {
                if ($field["input_element"] == "iframe")
                    $field["input_col"] = "col-sm-12";
                else
                    $field["input_col"] = "col-sm-4";
            }
            $form_html .= "\n\t\t\t<div class='" . $field["input_col"] . " " . $field["input_div_class"] . " field_group_" . $i_field . "' name='div_I_" . $i_field . "'>";
            if ($edit["uppercase"] == 1 && strpos($field["input_element"], "select") === false)
                if (isset($field["input_attr"]["oninput"]) && !empty($field["input_attr"]["oninput"]))
                    $field["input_attr"]["oninput"] = "upper(this);" . $field["input_attr"]["oninput"];
                else
                    $field["input_attr"]["oninput"] = "upper(this);";
            if (!isset($field["input_attr"]["class"]) && $field["input_element"] != "iframe")
                $field["input_attr"]["class"] = "form-control";
            if (!empty($field["input_class"]))
                $field["input_attr"]["class"] .= " " . $field["input_class"];
            if (!isset($field["input_attr"]["id"]) && !empty($field["input"]))
                $field["input_attr"]["id"] = $field["input"];
            if (!isset($field["input_attr"]["name"]) && !empty($field["input"]))
                $field["input_attr"]["name"] = $field["input"];
            if (!isset($field["input_attr"]["value"]) && isset($field["input_value"]))
                $field["input_attr"]["value"] = $field["input_value"];
            if (isset($field["input_label"]) && !empty($field["input_label"]))
                $field["input_attr"]["style"] = " width:auto; display:inline-block;text-transform:capitalize;";
            if (isset($field["input_style"])  && !empty($field["input_style"]))
                $field["input_attr"]["style"] .= $field["input_style"];
            if ($form["mode"] == "view" && !strstr($field["input_attr"]["class"], "btn-") && $field["input_element"] != "button") {
                $field["input_attr"]["readonly"] = "readonly";
                if (strstr($field["input_attr"]["class"], "date_")) {
                    $field["input_attr"]["class"] = str_replace("date_", "dateoff_", $field["input_attr"]["class"]);
                }
            }
            if ($form["mode"] != "view" && $field["input_attr"]["readonly"] != "readonly" && !strstr($field["input_attr"]["class"], "date_") && $_SESSION["g.autofocus"] == 0) {
                $field["input_attr"]["autofocus"] = "autofocus";
                $_SESSION["g.autofocus"]++;
            }
            if (!isset($field["input_element"]))
                $field["input_element"] = "input";
            if ($field["input_element"] == "input") {
                if (strstr($field["input_attr"]["class"], "date_1") && empty($field["input_attr"]["value"]))
                    $field["input_attr"]["value"] = date($_SESSION["setting"]["date"]);
                if (strstr($field["input_attr"]["class"], "datetime_1") && empty($field["input_attr"]["value"]))
                    $field["input_attr"]["value"] = date($_SESSION["setting"]["datetime"]);
                if (strstr($field["input_attr"]["class"], "month_1") && empty($field["input_attr"]["value"]))
                    $field["input_attr"]["value"] = date($_SESSION["setting"]["month"]);
                if (strstr($field["input_attr"]["class"], "year_1") && empty($field["input_attr"]["value"]))
                    $field["input_attr"]["value"] = date($_SESSION["setting"]["year"]);
                if (strstr($field["input_attr"]["class"], "jqmonth_1"))
                {
                    $picker_class = "jqmonth_1_" . $field["input"];
                    $field["input_attr"]["data-bind"] = "daterangepicker: " . $picker_class . ", daterangepickerFormat: \"" . $_SESSION["setting"]["jqmonth_1"] . "\", daterangepickerOptions: { periods: [\"month\"], forceUpdate:true, minDate:\"" . $_SESSION["setting"]["start_date"] . "\", maxDate:\"" . date('Y-m-d', strtotime('+10 years')) . "\", startDate: \"" . $field["input_attr"]["value"] . "\", single: true }";
                    if(empty($ko_binding_html))
                        $ko_binding_html = $picker_class . ": ko.observable([]),";
                    else
                        $ko_binding_html .= $picker_class . ": ko.observable([]),";
                }
                if (strstr($field["input_attr"]["class"], "jqyear_1"))
                {
                    $picker_class = "jqyear_1_" . $field["input"];
                    $field["input_attr"]["data-bind"] = "daterangepicker: " . $picker_class . ", daterangepickerFormat: \"" . $_SESSION["setting"]["jqyear_1"] . "\", daterangepickerOptions: { periods: [\"year\"], forceUpdate:true, minDate:\"" . $_SESSION["setting"]["start_date"] . "\", maxDate:\"" . date('Y-m-d', strtotime('+10 years')) . "\", startDate: \"" . $field["input_attr"]["value"] . "\", single: true }";
                    if(empty($ko_binding_html))
                        $ko_binding_html = $picker_class . ": ko.observable([]),";
                    else
                        $ko_binding_html .= $picker_class . ": ko.observable([]),";
                }
                $form_html .= " <" . $field["input_element"];
                foreach($field["input_attr"] as $key => $val)
                    $form_html .= " " . $key . "='" . $val . "' ";
                $form_html .= " /> ";
            } else if ($field["input_element"] == "iframe") {
                $form_html .= " <" . $field["input_element"];
                foreach($field["input_attr"] as $key => $val)
                    $form_html .= " " . $key . "='" . $val . "' ";
                $form_html .= " scrolling='no' onload='resizeIframe(this)' ></" . $field["input_element"] . ">";
            } else if ($field["input_element"] == "checkbox") {
                $form_html .= "<input type='checkbox' id='checkbox_" . $field["input"] . "' ";
                if ($field["input_attr"]["value"] == "1")
                    $form_html .= " checked ";
                if ($edit["mode"] == "view")
                    $form_html .= " disabled ";
                $field["input_attr"]["class"] = str_replace("form-control", "", $field["input_attr"]["class"]);
                foreach($field["input_attr"] as $key => $val)
                    $form_html .= " " . $key . "='" . $val . "' ";
                $form_html .= ">";
                $form_html .= "<input class='checkbox_value form-control hidden' id='" . $field["input"] . "' name='" . $field["input"] . "' value='" . $field["input_attr"]["value"] . "'";
                if ($edit["mode"] == "view")
                    $form_html .= " disabled ";
                $form_html .= ">";
            } else if ($field["input_element"] == "radiobutton") {
                foreach ($field["input_option"] as $option) {
                    if (!empty($option)) {
                        $val = explode("|", $option);
                        $form_html .= "<input type='radio' id='radiobtn_" . $field["input"] . "_" . $val[0] . "' name='radiobtn_" . $field["input"] . "' ";
                        if ($val[0] == $field["input_attr"]["value"])
                            $form_html .= " checked ";
                        if ($edit["mode"] == "view")
                            $form_html .= " disabled ";
                        $form_html .= " onchange='change_radiobutton_data(\"" . $field["input"] . "','" . $val[0] . "\")'><label>" . $val[1] . "</label>";
                    }
                }
                $form_html .= "<input class='form-control' id='" . $field["input"] . "' name='" . $field["input"] . "' value='" . $field["input_attr"]["value"] . "'";
                if ($edit["mode"] == "view")
                    $form_html .= " disabled ";
                $form_html .= " style='display:none;'>";
            } else if ($field["input_element"] == "select1") {
                if ($field["input_attr"]["readonly"] == "readonly")
                    $field["input_attr"]["disabled"] = "disabled";
                $form_html .= " <select";
                foreach($field["input_attr"] as $key => $val)
                    $form_html .= " " . $key . "='" . $val . "' ";
                $form_html .= ">";
                foreach ($field["input_option"] as $option) {
                    if (!empty($option)) {
                        $val = explode("|", $option);
                        $form_html .= "<option value='" . $val[0] . "' ";
                        if ($val[0] == $field["input_attr"]["value"])
                            $form_html .= " selected ";
                        $form_html .= ">" . $val[1] . "</option>";
                    }
                }
                $form_html .= "</select> ";
            } else if ($field["input_element"] == "select") {
                $field["input_attr"]["class"] = "select2 ";
                if ($field["input_attr"]["readonly"] == "readonly")
                    $field["input_attr"]["disabled"] = "disabled";
                $form_html .= " <" . $field["input_element"];
                foreach($field["input_attr"] as $key => $val)
                    $form_html .= " " . $key . "='" . $val . "' ";
                $form_html .= ">";
                foreach ($field["input_option"] as $option) {
                    if (!empty($option)) {
                        $val = explode("|", $option);
                        $form_html .= "<option value='" . $val[0] . "' ";
                        if ($val[0] == $field["input_attr"]["value"])
                            $form_html .= " selected ";
                        $form_html .= ">" . $val[1] . "</option>";
                    }
                }
                $form_html .= "</" . $field["input_element"] . "> ";
            } else if ($field["input_element"] == "textarea") {
                $form_html .= " <" . $field["input_element"];
                foreach($field["input_attr"] as $key => $val) {
                    if ($key != "value")
                        $form_html .= " " . $key . "='" . $val . "' ";
                }
                $form_html .= ">";
                if (isset($field["input_attr"]["value"]))
                    $form_html .= $field["input_attr"]["value"];
                $form_html .= "</" . $field["input_element"] . "> ";
            } else if ($field["input_element"] == "a" || $field["input_element"] == "button") {
                $field["input_attr"]["class"] = "btn " . $field["input_attr"]["class"];
                $form_html .= " <" . $field["input_element"];
                foreach($field["input_attr"] as $key => $val) {
                    if ($key != "value" && $key != "disabled" && $key != "readonly")
                        $form_html .= " " . $key . "='" . $val . "' ";
                }
                $form_html .= ">";
                if (isset($field["input_attr"]["value"]))
                    $form_html .= $field["input_attr"]["value"];
                $form_html .= "</" . $field["input_element"] . "> ";
            } else if ($field["input_element"] == "browse") {
                $browse = array();
                if (!empty($field["browse_setting"]))
                    include "contents/browse/" . $field["browse_setting"] . ".php";
                if (!empty($field["browse_set"]))
                    $browse = array_merge($browse, $field["browse_set"]);
                if (!isset($browse["id"]))
                    $browse["id"] = $field["browse_setting"];
                if ($form["mode"] != "view") {
                    $browse_override = 1;
                    include $config["webspira"] . "codes/browse.php";
                }
                $value  = array("","");
                $search = "";
                if (isset($field["input_value"])){
                    $value  = explode("|", $field["input_value"]);
                    $search = implode("|", array_slice($value, 0, -1));
                }
                $autofocus = "";
                if ($field["input_attr"]["autofocus"] == "autofocus")
                    $autofocus = " autofocus='" . $field["input_attr"]["autofocus"] . "' ";
                $form_html .= "<input " . $autofocus . " class='cst-txt-browse " . $field["input_attr"]["class"] . " browse_" . $browse["id"] . "_clear' id='browse_" . $browse["id"] . "_search' name='browse_" . $browse["id"] . "_search' placeholder='search' type='text' value='" . $search . "' " . $field["input_attr"]["readonly"] . " />";
                $nbsp3 = "";
                if ($_SESSION["login"]["framework"] == "webspira")
                    $nbsp3 = "&nbsp;&nbsp;&nbsp;";
                $field["additional"] = "";
                $selected_off_class = "";
                if ($browse["selected_mode"] == "off")
                    $selected_off_class = "off";
                if (isset($field['input_size']))
                    $field["additional"] .= "<span class='cst-btn-browse " . $selected_off_class . "' style='left:" . $field['input_size'] . "%'>";
                else
                    $field["additional"] .= "<span class='cst-btn-browse " . $selected_off_class . "'>";
                if ($field["input_attr"]["disabled"] != "disabled" && $field["input_attr"]["readonly"] != "readonly") {
                    $field["additional"] .= "\n\t\t\t\t\t<a class='btn btn-info btn-app-sm browse_btn_open' id='browse_" . $browse["id"] . "_open'>\n\t\t\t\t\t\t<i class='fa fa-search-plus'></i>\n\t\t\t\t\t</a>" . $nbsp3;
                    if (!empty($browse["new_url"]))
                        $field["additional"] .= "\n\t\t\t\t\t\t<a class='btn btn-primary btn-app-sm browse_btn_new' id='browse_" . $browse["id"] . "_new' onclick='window.open(\"" . $browse["new_url"] . "\")'>\n\t\t\t\t\t\t\t<i class='fa fa-plus'></i>\n\t\t\t\t\t\t</a>" . $nbsp3;
                    if ($form["mode"] != "view")
                        $field["additional"] .= "\n\t\t\t\t\t\t<a class='btn btn-default btn-app-sm browse_btn_reset' id='browse_" . $browse["id"] . "_reset' onclick='browse_clear(\"" . $browse["id"] . "\", browse_".$browse["id"]."_element);'>\n\t\t\t\t\t\t\t<i class='fa fa-refresh'></i>\n\t\t\t\t\t\t</a>" . $nbsp3;
                }
                $span_selected = $search;
                if (!empty($browse["selected_url"]))
                    $span_selected = "<a href='" . $browse["selected_url"] . $value[sizeOf($value) - 1] . "' target='_blank'>" . $search . "</a>";
                if (empty($browse["selected_mode"]) || $browse["selected_mode"] != "off") {
                    if ($browse["selected_mode"] == "simple") {
                        $field["additional"] .= "\n\t\t\t\t\t\t<input id='browse_" . $browse["id"] . "_selected_url' type='hidden' value='" . $browse["selected_url"] . "' />\n\t\t\t\t\t\t<a class='btn btn-default btn-app-sm browse_btn_chosen' id='browse_" . $browse["id"] . "_chosen' onclick='browse_selected_open(\"" . $browse["id"] . "\");'>\n\t\t\t\t\t\t\t<i class='fa fa-external-link'></i>\n\t\t\t\t\t\t</a>" . $nbsp3;
                    } else {
                        $field["additional"] .= "\n\t\t\t\t\t\t<span class='browse_span_selected' id='browse_" . $browse["id"] . "_selected_span'>\n\t\t\t\t\t\t\tSelected : <span class='browse_" . $browse["id"] . "_clear' id='browse_" . $browse["id"] . "_selected'>" . $span_selected . "</span>\n\t\t\t\t\t\t</span>";
                    }
                }
                $field["additional"] .= "\n\t\t\t\t<input class='" . $field["input_class"] . " browse_" . $browse["id"] . "_clear' id='browse_" . $browse["id"] . "_hidden' name='" . $field["input"] . "' type='hidden' value='" . $value[sizeOf($value) - 1] . "' readonly='readonly' />";
                $field["additional"] .= "</span>";
            } else if ($field["input_element"] == "grid") {
                $grid_override = 1;
                $grid          = $field["grid_set"];
                include $config["webspira"] . "codes/grid.php";
                if ($_SESSION["login"]["framework"] == "webspira")
                    $form_html .= "<br />";
                $form_html .= $grid_html;
            } else
                $form_html .= " " . $field["input_element"] . " ";
            if (!empty($field["input_label"])) {
                if (!isset($field["input_label_attr"]["form"]))
                    $field["input_label_attr"]["form"] = "form_" . $form["id"];
                if (!isset($field["input_label_attr"]["class"]))
                    $field["input_label_attr"]["class"] = "";
                if (!empty($field["input_label_class"]))
                    $field["input_label_attr"]["class"] = $field["input_label_class"];
                $field["input_label_attr"]["style"] = "width:auto; margin-left:5px;text-transform:capitalize;";
                if (isset($field["input_label_style"]) && !empty($field["input_label_style"]))
                    $field["input_label_attr"]["style"] .= $field["input_label_style"];
                $field["input_label_attr"]["class"] = "control-label field_group_" . $i_field . " " . $field["input_label_attr"]["class"];
                $form_html .= " <label";
                foreach($field["input_label_attr"] as $key => $val)
                    $form_html .= " " . $key . "='" . $val . "' ";
                $form_html .= ">" . $field["input_label"] . "</label> ";
            }
            if (!empty($field["additional"]))
                $form_html .= " " . $field["additional"] . " ";
            $form_html .= "\n\t\t\t</div><span name='div_I_" . $i_field . "'></span>";
        }
        $i_field++;
    }
    $form_html .= "\n\t</div><span name='div_Hz_" . $last_form_group . "'></span>\n\t</fieldset><span name='fieldset_Gz_" . $last_form_fieldset . "'></span>";
    if (!empty($last_box_tab)) {
        $form_html .= "\n\t\t</div><span name='div_Fz_" . $last_box_tab . "'></span>";
    }
    if (!empty($last_box_tabs)) {
        $form_html .= "\n\t\t</div><span name='div_Ez_" . $last_box_tabs . "'></span>";
    }
    $form_html .= "\n\t</div><span name='div_Dz_" . $last_box_col . "'></span>\n\t</div><span name='div_Cz_" . $last_box_col . "'></span>\n\t</div><span name='div_Bz_" . $last_box_col . "'></span>\n\t</div><span name='div_Az_" . $last_box_row . "'></span>";
    if ($edit["uppercase"] == 1)
        $form_html .= "\n\t<style>input:not([autocomplete]), textarea { text-transform:uppercase }</style>";
}
if (empty($form_id) || $form_id == "end") {
    $form_html .= "
    </form>
    <script type='text/javascript'>
        function change_checkbox_data(obj)
        {
            if(obj.prop('checked'))
                obj.nextAll('input.checkbox_value').first().val(1);
            else
                obj.nextAll('input.checkbox_value').first().val(0);
        }
        function upper(text)
        {
            var str     = text.selectionStart;
            text.value  = text.value.toUpperCase();
            text.setSelectionRange(str, str);
        }
        function get_position(string, subString, index) {
          return string.split(subString, index).join(subString).length;
        }
        $(document).ready(function()
        {
            $('.tabs').tabs();
            
            $( \"a[href*='#tab_i'][href*='" . $_SESSION["setting"]["tab_info"] . "']\" ).click(function() 
            {
                $(this).closest('.tabs').siblings().hide();
                $(this).closest('[name*=\"div_B\"]').siblings().hide();
            });
            
            $( \"a:not([href*='#tab_i'][href*='" . $_SESSION["setting"]["tab_info"] . "'])[href*='#tab_i']\" ).click(function() 
            {
                var key = $(this).attr('href').slice(get_position($(this).attr('href'), '_', 2) + 1);

                $(this).closest('.tabs').siblings().show();
                $(this).closest('[name*=\"div_B\"]').siblings().show();
            });

            $('input[type=\"checkbox\"]').change(function()
            {
                change_checkbox_data($(this));
            });
        
            ko.applyBindings({
              ".$ko_binding_html."
            });
        });
    </script>";
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>