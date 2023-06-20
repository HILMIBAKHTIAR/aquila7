<?php
function generate_summary($edit, $features = "subtotal", $grid_id, $class = "", $fields = [])
{
    $i = count($edit["field"]);
    if (strstr($features, "subtotal")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]                  = "Subtotal";
        $edit["field"][$i]["input_col"]              = "col-sm-4 no-drop";
        $edit["field"][$i]["input"]                  = "subtotal";
        $edit["field"][$i]["input_class"]            = $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]       = "sum_subtotal_" . $grid_id;
        $edit["field"][$i]["input_attr"]["readonly"] = "readonly";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["subtotal"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["subtotal"]);
            if (isset($fields["subtotal"]["input_attr"]["readonly"]) && $fields["subtotal"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["subtotal"]["input_attr"]["disabled"]) && $fields["subtotal"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "diskon1")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]                   = "Diskon";
        $edit["field"][$i]["input_col"]               = "col-sm-2 no-drop";
        $edit["field"][$i]["input"]                   = "diskon_prosentase";
        $edit["field"][$i]["input_class"]             = $_SESSION["setting"]["class_percent"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]        = "sum_diskon1_" . $grid_id;
        $edit["field"][$i]["input_attr"]["maxlength"] = $_SESSION["setting"]["limit_percent"];
        $edit["field"][$i]["input_attr"]["onkeyup"]   = "calculate_summary(\"" . $grid_id . "\", \"diskon1prosentase\");";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["diskon1"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["diskon1"]);
            if (isset($fields["diskon1"]["input_attr"]["readonly"]) && $fields["diskon1"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["diskon1"]["input_attr"]["disabled"]) && $fields["diskon1"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
        $edit["field"][$i]["form_group"]             = 0;
        $edit["field"][$i]["input_col"]              = "col-sm-2 no-drop";
        $edit["field"][$i]["input"]                  = "diskon_nominal";
        $edit["field"][$i]["input_class"]            = $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]       = "sum_diskon1nominal_" . $grid_id;
        $edit["field"][$i]["input_attr"]["onkeyup"]  = "calculate_summary(\"" . $grid_id . "\", \"diskon1nominal\");";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["diskon1_nominal"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["diskon1_nominal"]);
            if (isset($fields["diskon1_nominal"]["input_attr"]["readonly"]) && $fields["diskon1_nominal"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["diskon1_nominal"]["input_attr"]["disabled"]) && $fields["diskon1_nominal"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "diskon2")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]                   = "Diskon 2";
        $edit["field"][$i]["input_col"]               = "col-sm-2 no-drop";
        $edit["field"][$i]["input"]                   = "diskon_prosentase_2";
        $edit["field"][$i]["input_class"]             = $_SESSION["setting"]["class_percent"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]        = "sum_diskon2_" . $grid_id;
        $edit["field"][$i]["input_attr"]["maxlength"] = $_SESSION["setting"]["limit_percent"];
        $edit["field"][$i]["input_attr"]["onkeyup"]   = "calculate_summary(\"" . $grid_id . "\", \"diskon2prosentase\");";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["diskon2"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["diskon2"]);
            if (isset($fields["diskon2"]["input_attr"]["readonly"]) && $fields["diskon2"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["diskon2"]["input_attr"]["disabled"]) && $fields["diskon2"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
        $edit["field"][$i]["form_group"]             = 0;
        $edit["field"][$i]["input_col"]              = "col-sm-2 no-drop";
        $edit["field"][$i]["input"]                  = "diskon_nominal_2";
        $edit["field"][$i]["input_class"]            = $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]       = "sum_diskon2nominal_" . $grid_id;
        $edit["field"][$i]["input_attr"]["onkeyup"]  = "calculate_summary(\"" . $grid_id . "\", \"diskon2nominal\");";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["diskon2_nominal"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["diskon2_nominal"]);
            if (isset($fields["diskon2_nominal"]["input_attr"]["readonly"]) && $fields["diskon2_nominal"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["diskon2_nominal"]["input_attr"]["disabled"]) && $fields["diskon2_nominal"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "diskon3")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]                   = "Diskon 3";
        $edit["field"][$i]["input_col"]               = "col-sm-2 no-drop";
        $edit["field"][$i]["input"]                   = "diskon_prosentase_3";
        $edit["field"][$i]["input_class"]             = $_SESSION["setting"]["class_percent"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]        = "sum_diskon3_" . $grid_id;
        $edit["field"][$i]["input_attr"]["maxlength"] = $_SESSION["setting"]["limit_percent"];
        $edit["field"][$i]["input_attr"]["onkeyup"]	  = "calculate_summary(\"" . $grid_id . "\", \"diskon3prosentase\");";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["diskon3"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["diskon3"]);
            if (isset($fields["diskon3"]["input_attr"]["readonly"]) && $fields["diskon3"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["diskon3"]["input_attr"]["disabled"]) && $fields["diskon3"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
        $edit["field"][$i]["form_group"]             = 0;
        $edit["field"][$i]["input_col"]              = "col-sm-2 no-drop";
        $edit["field"][$i]["input"]                  = "diskon_nominal_3";
        $edit["field"][$i]["input_class"]            = $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]       = "sum_diskon3nominal_" . $grid_id;
        $edit["field"][$i]["input_attr"]["onkeyup"]  = "calculate_summary(\"" . $grid_id . "\", \"diskon3nominal\");";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["diskon3_nominal"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["diskon3_nominal"]);
            if (isset($fields["diskon3_nominal"]["input_attr"]["readonly"]) && $fields["diskon3_nominal"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["diskon3_nominal"]["input_attr"]["disabled"]) && $fields["diskon3_nominal"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "diskontotal")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]                  = "Total Diskon";
        $edit["field"][$i]["input_col"]              = "col-sm-4 no-drop";
        $edit["field"][$i]["input"]                  = "diskon_total";
        $edit["field"][$i]["input_class"]            = $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]       = "sum_diskontotal_" . $grid_id;
        $edit["field"][$i]["input_attr"]["readonly"] = "readonly";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["diskontotal"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["diskontotal"]);
            if (isset($fields["diskontotal"]["input_attr"]["readonly"]) && $fields["diskontotal"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["diskontotal"]["input_attr"]["disabled"]) && $fields["diskontotal"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "subtotalakhir")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $hide_class = "";
        if (!strstr($features, "pembulatan"))
            $hide_class = " hide ";
        $edit["field"][$i]["label"]                  = "Subtotal Akhir";
        $edit["field"][$i]["label_class"]            = $hide_class;
        $edit["field"][$i]["input_col"]              = "col-sm-4 no-drop";
        $edit["field"][$i]["input"]                  = "subtotal_akhir";
        $edit["field"][$i]["input_div_class"]        = $hide_class;
        $edit["field"][$i]["input_class"]            = $hide_class . $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]       = "sum_subtotalakhir_" . $grid_id;
        $edit["field"][$i]["input_attr"]["readonly"] = "readonly";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["subtotalakhir"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["subtotalakhir"]);
            if (isset($fields["subtotalakhir"]["input_attr"]["readonly"]) && $fields["subtotalakhir"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["subtotalakhir"]["input_attr"]["disabled"]) && $fields["subtotalakhir"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "um1")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]            = "UM";
        $edit["field"][$i]["input_col"]        = "col-sm-4 no-drop";
        $edit["field"][$i]["input"]            = "um";
        $edit["field"][$i]["input_class"]      = $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"] = "sum_um1_" . $grid_id;
        $edit["field"][$i]["input_attr"]["readonly"] = "readonly";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["um1"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["um1"]);
            if (isset($fields["um1"]["input_attr"]["readonly"]) && $fields["um1"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["um1"]["input_attr"]["disabled"]) && $fields["um1"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "um2")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]            = "UM 2";
        $edit["field"][$i]["input_col"]        = "col-sm-4 no-drop";
        $edit["field"][$i]["input"]            = "um_2";
        $edit["field"][$i]["input_class"]      = $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"] = "sum_um2_" . $grid_id;
        $edit["field"][$i]["input_attr"]["readonly"] = "readonly";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["um2"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["um2"]);
            if (isset($fields["um2"]["input_attr"]["readonly"]) && $fields["um2"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["um2"]["input_attr"]["disabled"]) && $fields["um2"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "um3")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]            = "UM 3";
        $edit["field"][$i]["input_col"]        = "col-sm-4 no-drop";
        $edit["field"][$i]["input"]            = "um_3";
        $edit["field"][$i]["input_class"]      = $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"] = "sum_um3_" . $grid_id;
        $edit["field"][$i]["input_attr"]["readonly"] = "readonly";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["um3"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["um3"]);
            if (isset($fields["um3"]["input_attr"]["readonly"]) && $fields["um3"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["um3"]["input_attr"]["disabled"]) && $fields["um3"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "umtotal")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]                  = "Total UM";
        $edit["field"][$i]["input_col"]              = "col-sm-4 no-drop";
        $edit["field"][$i]["input"]                  = "um_total";
        $edit["field"][$i]["input_class"]            = $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]       = "sum_umtotal_" . $grid_id;
        $edit["field"][$i]["input_attr"]["readonly"] = "readonly";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["umtotal"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["umtotal"]);
            if (isset($fields["umtotal"]["input_attr"]["readonly"]) && $fields["umtotal"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["umtotal"]["input_attr"]["disabled"]) && $fields["umtotal"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "dpp")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]                  = "DPP";
        $edit["field"][$i]["label_class"]            = "ppn_section hide";
        $edit["field"][$i]["input_col"]              = "col-sm-4 no-drop";
        $edit["field"][$i]["input"]                  = "dpp";
        $edit["field"][$i]["input_div_class"]        = "ppn_section hide";
        $edit["field"][$i]["input_class"]            = "ppn_section hide " . $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]       = "sum_dpp_" . $grid_id;
        $edit["field"][$i]["input_attr"]["readonly"] = "readonly";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["dpp"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["dpp"]);
            if (isset($fields["dpp"]["input_attr"]["readonly"]) && $fields["dpp"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["dpp"]["input_attr"]["disabled"]) && $fields["dpp"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "ppn")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]                   = "PPN";
        $edit["field"][$i]["label_class"]             = "ppn_section hide";
        $edit["field"][$i]["input_col"]               = "col-sm-2 no-drop";
        $edit["field"][$i]["input"]                   = "ppn_prosentase";
        $edit["field"][$i]["input_div_class"]         = "ppn_section hide";
        $edit["field"][$i]["input_class"]             = "ppn_section hide " . $_SESSION["setting"]["class_percent"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]        = "sum_ppn_" . $grid_id;
        $edit["field"][$i]["input_attr"]["maxlength"] = $_SESSION["setting"]["limit_percent"];
        $edit["field"][$i]["input_attr"]["readonly"]  = "readonly";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = $_SESSION["setting"]["ppn"];
        if (!empty($fields["ppn"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["ppn"]);
            if (isset($fields["ppn"]["input_attr"]["readonly"]) && $fields["ppn"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["ppn"]["input_attr"]["disabled"]) && $fields["ppn"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
        $edit["field"][$i]["form_group"]             = 0;
        $edit["field"][$i]["label_class"]            = "ppn_section hide";
        $edit["field"][$i]["input_col"]              = "col-sm-2 no-drop";
        $edit["field"][$i]["input"]                  = "ppn_nominal";
        $edit["field"][$i]["input_div_class"]        = "ppn_section hide";
        $edit["field"][$i]["input_class"]            = "ppn_section hide " . $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]       = "sum_ppnnominal_" . $grid_id;
        $edit["field"][$i]["input_attr"]["readonly"] = "readonly";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["ppn_nominal"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["ppn_nominal"]);
            if (isset($fields["ppn_nominal"]["input_attr"]["readonly"]) && $fields["ppn_nominal"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["ppn_nominal"]["input_attr"]["disabled"]) && $fields["ppn_nominal"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "pembulatan")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]                  = "Pembulatan";
        $edit["field"][$i]["input_col"]              = "col-sm-4 no-drop";
        $edit["field"][$i]["input"]                  = "pembulatan";
        $edit["field"][$i]["input_class"]            = $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]       = "sum_pembulatan_" . $grid_id;
        $edit["field"][$i]["input_attr"]["onkeyup"]  = "calculate_summary(\"" . $grid_id . "\");";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["pembulatan"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["pembulatan"]);
            if (isset($fields["pembulatan"]["input_attr"]["readonly"]) && $fields["pembulatan"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["pembulatan"]["input_attr"]["disabled"]) && $fields["pembulatan"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "totalakhir")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $edit["field"][$i]["label"]                  = "Total";
        $edit["field"][$i]["input_col"]              = "col-sm-4 no-drop";
        $edit["field"][$i]["input"]                  = "total";
        $edit["field"][$i]["input_class"]            = $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]       = "sum_total_" . $grid_id;
        $edit["field"][$i]["input_attr"]["readonly"] = "readonly";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["totalakhir"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["totalakhir"]);
            if (isset($fields["totalakhir"]["input_attr"]["readonly"]) && $fields["totalakhir"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["totalakhir"]["input_attr"]["disabled"]) && $fields["totalakhir"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    if (strstr($features, "totalbayar")) {
        if (!empty($class))
            $edit["field"][$i]["form_group_class"] = $class;
        else
            $edit["field"][$i]["form_group"] = 0;
        $hide_class = "";
        if (!strstr($features, "um"))
            $hide_class = " hide ";
        $edit["field"][$i]["label"]                  = "Total Bayar";
        $edit["field"][$i]["label_class"]            = $hide_class;
        $edit["field"][$i]["input_col"]              = "col-sm-4 no-drop";
        $edit["field"][$i]["input"]                  = "total_bayar";
        $edit["field"][$i]["input_div_class"]        = $hide_class;
        $edit["field"][$i]["input_class"]            = $hide_class . $_SESSION["setting"]["class_money"] . " summary_" . $grid_id;
        $edit["field"][$i]["input_attr"]["id"]       = "sum_totalbayar_" . $grid_id;
        $edit["field"][$i]["input_attr"]["readonly"] = "readonly";
        if ($edit["mode"] == "add")
            $edit["field"][$i]["input_value"] = "0";
        if (!empty($fields["totalbayar"])) {
            $edit["field"][$i] = array_replace($edit["field"][$i], $fields["totalbayar"]);
            if (isset($fields["totalbayar"]["input_attr"]["readonly"]) && $fields["totalbayar"]["input_attr"]["readonly"] != "readonly")
                unset($edit["field"][$i]["input_attr"]["readonly"]);
            if (isset($fields["totalbayar"]["input_attr"]["disabled"]) && $fields["totalbayar"]["input_attr"]["disabled"] != "disabled")
                unset($edit["field"][$i]["input_attr"]["disabled"]);
        }
        $i++;
    }
    return $edit;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-14_22:22;*/
?>