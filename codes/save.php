<?php

if ($save_override != 1) {
    $save["manual_save_afterstart"]   = "";
    $save["manual_save_beforecommit"] = "";
    $save["unique"]                   = array();
    $save["mode"]                     = "add";
    $save["table"]                    = "";
    if (!empty($_SESSION["menu_" . $_SESSION["g.menu"]]["table"]))
        $save["table"] = $_SESSION["menu_" . $_SESSION["g.menu"]]["table"];
    $save["string_code"]         = "";
    $save["field_code"]          = $_SESSION["setting"]["field_kode"];
    /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-06-03;*/
    if(!empty($_SESSION["setting"][$save["string_code"]]["label"])){
        if($save["field_code"] != $_SESSION["setting"][$save["string_code"]]["label"]){
            $save["field_code"] = $_SESSION["setting"][$save["string_code"]]["label"];
        }
    }
    /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-06-03;*/
    $save["field"]               = array();
    $save["string_id"]           = "";
    $save["detail"]              = array();
    $save["sp_add"]              = "";
    $save["sp_add_param"]        = array();
    $save["sp_edit"]             = "";
    $save["sp_edit_param"]       = array();
    $save["sp_delete"]           = "";
    $save["sp_delete_param"]     = array();
    $save["sp_approve"]          = "";
    $save["sp_approve_param"]    = array();
    $save["sp_reject"]           = "";
    $save["sp_reject_param"]     = array();
    $save["sp_disapprove"]       = "";
    $save["sp_disapprove_param"] = array();
    $save["sp_close"]            = "";
    $save["sp_close_param"]      = array();
    $save["url"]                 = $_SESSION["g.url"];
    $save["url_success_custom"]  = "";
    $save["url_success"]         = $save["url"] . "&sm=edit&a=view&no=";
    $save["url_failed"]          = $save["url"];
    $save["debug"]               = 0;
    if (!empty($save_include))
        foreach ($save_include as $setting)
            include $setting;
}
$debug_html = "";
if (!empty($save["unique"]) && ($save["mode"] == "add" || $save["mode"] == "edit" || $save["mode"] == "approve")) {
    $debug_html .= '$save[unique] = ' . $save["unique"] . ' && $save[mode] = ' . $save["mode"] . "<br /><br />";
    $unique_query = " ( ";
    $i            = 0;
    foreach ($save["unique"] as $unique) {
        if ($i != 0)
            $unique_query .= " OR ";
        $columns = explode("|", $unique);
        $unique_query .= " ( ";
        $j = 0;
        foreach ($columns as $column) {
            if ($j != 0)
                $unique_query .= " AND ";
            $unique_query .= " a." . $column . " = '" . addslashes($_POST[$column]) . "' ";
            $j++;
        }
        $unique_query .= " ) ";
        $i++;
    }
    $unique_query .= " ) ";
    if ($save["mode"] == "edit")
        $unique_query .= " AND a." . $_SESSION["setting"]["field_nomor"] . " <> " . $_GET["no"];
    $query = "SELECT a.* FROM " . $save["table"] . " a WHERE " . $unique_query . " AND " . $_SESSION["setting"]["field_status_aktif"] . " > 0";
    $debug_html .= "mysqli_query : " . $query . "<br /><br />";
    $unique_check = mysqli_num_rows(mysqli_query($con, $query));
    $debug_html .= "mysqli_num_rows = " . $unique_check . "<br /><br /><br /><br />";
    if ($unique_check > 0) {
        $debug_html .= get_message(105);
        if ($save["debug"] == 1)
            $_SESSION["g.debug_html"] .= $debug_html;
        $_SESSION["g.debug0_html"] .= $debug_html;
        set_alert(get_message(105), "danger");
    }
}
if ($save["mode"] == "add") {
    $debug_html .= '$save[mode] = ' . $save["mode"] . "<br /><br />";
    $next_save_delay = 20;
    if (!empty($_SESSION["setting"]["next_save_delay"])) {
        $next_save_delay = $_SESSION["setting"]["next_save_delay"];
    }
    $query = "\n\tSELECT *\n\tFROM rhaktivitasadmin\n\tWHERE\n\t\tnomormhadmin = " . $_SESSION["login"]["nomor"] . " AND\n\t\tipaddress = '" . $_SESSION["login"]["ipaddress"] . "' AND\n\t\taksi_menu_kode = '" . $_SESSION["g.menu"] . "' AND\n\t\taksi_menu_judul = '" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "' AND\n\t\taksi_statement = 'insert success' AND\n\t\taksi_table = '" . $save["table"] . "' AND\n\t\tDATE_FORMAT(waktu,'%Y-%m-%d %H:%i') = DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i') AND\n\t\t(DATE_FORMAT(NOW(),'%s') - DATE_FORMAT(waktu,'%s')) < " . $next_save_delay . "\n\t";
    $debug_html .= "mysqli_query : " . $query . "<br /><br />";
    $double_check = mysqli_num_rows(mysqli_query($con, $query));
    $debug_html .= "mysqli_num_rows = " . $double_check . "<br /><br /><br /><br />";
    if ($double_check > 0) {
        $debug_html .= get_message(109);
        if ($save["debug"] == 1)
            $_SESSION["g.debug_html"] .= $debug_html;
        $_SESSION["g.debug0_html"] .= $debug_html;
        set_alert(get_message(109), "danger");
    }
}
transactions($con, "start");
$debug_html .= "transactions(start);<br /><br /><br /><br />";
if (!empty($edit["manual_save_afterstart"]))
    include $edit["manual_save_afterstart"];
if ($save["mode"] == "add") {
    $debug_html .= '$save[mode] == add' . "<br /><br />";
    if ($_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"][$save["mode"]] != 1)
        set_alert(get_message(306, $save["mode"] . " " . $_SESSION["g.menu_kode"]));
    if (!empty($save["string_code"])) {
        $debug_html .= '$save[string_code] = ' . $save["string_code"] . "<br /><br />";
        $_POST[$save["field_code"]] = "AUTOCODE/" . date("Y/m/d/H/i/s/") . rand(1, 99999);
        $debug_html .= '$_POST[autocode] = ' . $_POST[$save["field_code"]] . "<br /><br />";
    }
    $insert_fields = "";
    $insert_values = "";
    $i             = 0;
    foreach ($save["field"] as $field) {
        if ((empty($field["pro_mode"]) && empty($field["anti_mode"])) || (!empty($field["pro_mode"]) && strstr($field["pro_mode"], $save["mode"])) || (!empty($field["anti_mode"]) && !strstr($field["anti_mode"], $save["mode"]))) {
            if (!empty($field["input"]) && $field["input_save"] != "skip" && (!empty($_POST[$field["input"]]) || $_POST[$field["input"]] == 0)) {
                if ($i != 0) {
                    $insert_fields .= ",";
                    $insert_values .= ",";
                }
                $number_type = "";
                if (!empty($field["input_class"]))
                    $number_type = search_number_type($field["input_class"]);
                if (!empty($field["input_attr"]["class"]))
                    $number_type = search_number_type($field["input_attr"]["class"]);
                if (!empty($_SESSION["setting"]["date_class_autoformat"]) && (search_date_class($field["input_class"]) || search_date_class($field["input_attr"]["class"]))) {
                    $_POST[$field["input"]] = DateTime::createFromFormat($_SESSION["setting"]["date"], $_POST[$field["input"]])->format("Y-m-d");
                }
                /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-20;*/
                if (!empty($_SESSION["setting"]["datetime_class_autoformat"]) && (search_datetime_class($field["input_class"]) || search_datetime_class($field["input_attr"]["class"]))) {
                    $_POST[$field["input"]] = DateTime::createFromFormat($_SESSION["setting"]["datetime"], $_POST[$field["input"]])->format("Y-m-d H:i:s");
                }
                /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-20;*/

                /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-06-01;*/
                if (!empty($_SESSION["setting"]["period_class_autoformat"]) && (search_period_class($field["input_class"]) || search_period_class($field["input_attr"]["class"]))) {
                    $_POST[$field["input"]] = DateTime::createFromFormat($_SESSION["setting"]["period"], $_POST[$field["input"]])->format("Y-m-01");
                }
                /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-06-01;*/
                if (!empty($number_type))
                    $value = number_recovering($_POST[$field["input"]]);
                else
                    $value = "'" . addslashes(str_replace("\t", " ", $_POST[$field["input"]])) . "'";
                if (!empty($field["input_attr"]["date_format"])) {
                    $format_date = $field["input_attr"]["date_format"];
                    $value       = "STR_TO_DATE(" . $value . ",'" . $format_date . "')";
                }
                $insert_fields .= $field["input"];
                $insert_values .= $value;
                $i++;
            }
        }
    }
    if (!empty($save["string_id"])) {
        $debug_html .= '$save[string_id] = ' . $save["string_id"] . "<br /><br />";
        $insert_fields .= "," . $_SESSION["setting"]["field_nomor"];
        $insert_values .= "," . $_POST[$_SESSION["setting"]["field_nomor"]];
        $nomor = $_POST[$_SESSION["setting"]["field_nomor"]];
    }
    $query = "\n\tINSERT INTO " . $save["table"] . "\n\t(" . $insert_fields . "," . $_SESSION["setting"]["field_dibuat_oleh"] . "," . $_SESSION["setting"]["field_dibuat_pada"] . ")\n\tVALUES\n\t(" . $insert_values . "," . $_SESSION["login"]["nomor"] . ",now())";
    $debug_html .= "mysqli_query : " . $query . "<br /><br />";
    $save_action = mysqli_query($con, $query);
    if (!$save_action)
        $debug_html .= "mysqli_query ERROR : " . mysqli_error($con) . "<br /><br />";
    if (empty($nomor)) {
        $nomor = mysqli_insert_id($con);
        $debug_html .= "mysqli_insert_id() = " . $nomor . "<br /><br />";
    }
    $statement = "insert";
    foreach ($save["detail"] as $detail) {
        $debug_html .= 'foreach($save[detail] as $detail)' . "<br /><br />" . '$_POST[' . $detail["grid_id"] . '_detail_totalrow] = ' . $_POST[$detail["grid_id"] . "_detail_totalrow"] . "<br /><br />";
        if ($_POST[$detail["grid_id"] . "_detail_totalrow"] == "") {
            $debug_html .= "variable post failed, transactions(rollback);<br />" . get_message(703, ucfirst($save["mode"]));
            if ($save["debug"] == 1)
                $_SESSION["g.debug_html"] .= $debug_html;
            $_SESSION["g.debug0_html"] .= $debug_html;
            transactions($con, "rollback");
            set_alert(get_message(703, ucfirst($save["mode"])), "danger");
        } elseif ($_POST[$detail["grid_id"] . "_detail_totalrow"] > 0) {
            for ($i = 0; $i < $_POST[$detail["grid_id"] . "_detail_totalrow"]; $i++) {
                $insert_fields = "";
                $insert_values = "";
                $j             = 0;
                foreach ($detail["field_name"] as $field_name) {
                    if (!empty($_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $field_name]) || $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $field_name] == 0) {
                        if ($j != 0) {
                            $insert_fields .= ",";
                            $insert_values .= ",";
                        }
                        $data_format = explode("|", $field_name);
                        if (sizeof($data_format) == 3 && $data_format[1] == "date") {
                            /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-06-01;*/
                            if(!empty($_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]])){
                                if (!empty($_SESSION["setting"]["date_class_autoformat"]) && search_date_class($data_format[2], "coltemplate_date_class_autoformat")) {
                                $data_value = DateTime::createFromFormat($_SESSION["setting"]["coltemplate_date"], $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]])->format("Y-m-d");
                                }
                                if (!empty($_SESSION["setting"]["datetime_class_autoformat"]) && search_datetime_class($data_format[2], "coltemplate_datetime_class_autoformat")) {
                                    $data_value = DateTime::createFromFormat($_SESSION["setting"]["coltemplate_datetime"], $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]])->format("Y-m-d H:i:s");
                                }
                                if (!empty($_SESSION["setting"]["period_class_autoformat"]) && search_period_class($data_format[2], "coltemplate_period_class_autoformat")) {
                                    $data_value = DateTime::createFromFormat($_SESSION["setting"]["coltemplate_period"], $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]])->format("Y-m-01");
                                }
                            }
                            else{
                                $data_value = $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]]; 
                            }
                            /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-06-01;*/
                            $insert_fields .= $data_format[0];
                            $insert_values .= "'" . addslashes(str_replace("\t", " ", $data_value)) . "'";
                        } else {
                            $insert_fields .= $field_name;
                            $data_value = $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $field_name];
                            $insert_values .= "'" . addslashes(str_replace("\t", " ", $data_value)) . "'";
                        }
                        $j++;
                    }
                }
                if (!empty($detail["foreign_key"])) {
                    $debug_html .= '$detail[foreign_key] = ' . $detail["foreign_key"] . "<br /><br />";
                    $insert_fields .= "," . $detail["foreign_key"];
                    $insert_values .= "," . $nomor;
                }
                if (!empty($detail["string_id"])) {
                    $debug_html .= '$detail[string_id] = ' . $detail["string_id"] . "<br /><br />";
                    $insert_fields .= "," . $_SESSION["setting"]["field_nomor"];
                    $insert_values .= "," . create_id($detail["string_id"]);
                }
                $query = "\n\t\t\t\tINSERT INTO " . $detail["table_name"] . "\n\t\t\t\t(" . $insert_fields . "," . $_SESSION["setting"]["field_dibuat_oleh"] . "," . $_SESSION["setting"]["field_dibuat_pada"] . ")\n\t\t\t\tVALUES\n\t\t\t\t(" . $insert_values . "," . $_SESSION["login"]["nomor"] . ",now())";
                $debug_html .= "mysqli_query : " . $query . "<br /><br />";
                $insert_detail = mysqli_query($con, $query);
                if (!$insert_detail) {
                    $debug_html .= "mysqli_query failed : " . mysqli_error($con) . "<br />transactions(rollback);<br />" . get_message(703, ucfirst($save["mode"]));
                    if ($save["debug"] == 1)
                        $_SESSION["g.debug_html"] .= $debug_html;
                    $_SESSION["g.debug0_html"] .= $debug_html;
                    transactions($con, "rollback");
                    set_alert(get_message(703, ucfirst($save["mode"])), "danger");
                }
            }
        }
    }

    transactions($con, "commit");
    $debug_html .= "<br />transactions(commit);<br />";
    transactions($con, "start");
    $debug_html .= "<br />transactions(start);<br />";

    if (!empty($save["string_code"])) {
        $debug_html .= '$save[string_code] = ' . $save["string_code"] . "<br /><br />";
        if (!empty($_POST[$_SESSION["setting"]["field_tanggal"]])) {
            if (!empty($save["string_code_plus"]))
                $finalcode = formatting_code($con, $save["string_code"], $_POST[$_SESSION["setting"]["field_tanggal"]], $save["string_code_plus"]);
            else
                $finalcode = formatting_code($con, $save["string_code"], $_POST[$_SESSION["setting"]["field_tanggal"]]);
        } else {
            if (!empty($save["string_code_plus"]))
                $finalcode = formatting_code($con, $save["string_code"], "", $save["string_code_plus"]);
            else
                $finalcode = formatting_code($con, $save["string_code"]);
        }
        $duplicatecode = mysqli_num_rows(mysqli_query($con, "SELECT a." . $save["field_code"] . " FROM " . $save["table"] . " a WHERE a." . $_SESSION["setting"]["field_nomor"] . " <> 0 AND a." . $save["field_code"] . " LIKE '" . $finalcode . "%' FOR UPDATE"));
        while ($duplicatecode > 0) {
            $debug_html .= "Loop Generate Code <br /> <br />";
            $_SESSION["g.debug0_html"] .= $debug_html;
            $finalcode     = formatting_code($save["string_code"]);
            $duplicatecode = mysqli_num_rows(mysqli_query($con, "SELECT a." . $save["field_code"] . " FROM " . $save["table"] . " a WHERE a." . $_SESSION["setting"]["field_nomor"] . " <> 0 AND a." . $save["field_code"] . " LIKE '" . $finalcode . "%' FOR UPDATE"));
        }
        $query = "\n\t\tUPDATE " . $save["table"] . "\n\t\tSET " . $save["field_code"] . " = '" . $finalcode . "'\n\t\tWHERE " . $_SESSION["setting"]["field_nomor"] . " = " . $nomor;
        $debug_html .= "mysqli_query : " . $query . "<br /><br />";
        $update_finalcode = mysqli_query($con, $query);
        if (!$update_finalcode){
            $debug_html .= "mysqli_query failed : " . mysqli_error($con) . "<br />transactions(rollback);<br />" . get_message(703, ucfirst($save["mode"]));
            if ($save["debug"] == 1)
                $_SESSION["g.debug_html"] .= $debug_html;
            $finalcode = formatting_code($con, $save["string_code"]);
            $query = "\n\t\tUPDATE " . $save["table"] . "\n\t\tSET " . $save["field_code"] . " = '" . $finalcode . "'\n\t\tWHERE " . $_SESSION["setting"]["field_nomor"] . " = " . $nomor;
            $debug_html .= "mysqli_query : " . $query . "<br /><br />";
            $update_finalcode = mysqli_query($con, $query);
        }
    }
    if (!empty($save["sp_add"]) && !empty($save["sp_add_param"])) {
        $debug_html .= '$save[sp_add] = ' . $save["sp_add"] . ' && $save[sp_add_param] = ' . $save["sp_add_param"] . "<br />" . "transactions(commit);<br /><br />";
        transactions($con, "commit");
        $parameters = "";
        $i          = 0;
        foreach ($save["sp_add_param"] as $parameter) {
            $param = explode("|", $parameter);
            $value = addslashes(str_replace("\t", " ", $_POST[$param[0]]));
            if ($param[1] == 1)
                $value = "'" . $value . "'";
            if ($i != 0)
                $parameters .= ",";
            $parameters .= $value;
            $i++;
        }
        $query = "CALL " . $save["sp_add"] . "(" . $nomor . "," . $parameters . ")";
        $debug_html .= '$mysqli->query > ' . $query . "<br /><br />";
        $mysqli = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
        $result = $mysqli->query($query);
        if (!$result) {
            if ($_SESSION["setting"]["environment"] != "live")
                echo "<br />" . $query . "<br />Error MySQLi Query: " . $mysqli->error;
        }
        while ($data = $result->fetch_assoc()) {
            $debug_html .= '$data[' . $_SESSION["setting"]["field_flag"] . '] = ' . $data[$_SESSION["setting"]["field_flag"]] . "<br /><br />";
            if ($data[$_SESSION["setting"]["field_flag"]] != 1) {
                $debug_html .= get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]];
                if ($save["debug"] == 1)
                    $_SESSION["g.debug_html"] .= $debug_html;
                $_SESSION["g.debug0_html"] .= $debug_html;
                mysqli_query($con, "\n\t\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\t\tnomormhadmin,\n\t\t\t\t\tipaddress,\n\t\t\t\t\taksi_menu_kode,\n\t\t\t\t\taksi_menu_judul,\n\t\t\t\t\taksi_statement,\n\t\t\t\t\taksi_table,\n\t\t\t\t\taksi_nomor,\n\t\t\t\t\tcatatan\n\t\t\t\t)\n\t\t\t\tVALUES (\n\t\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t\t'sp_add failed',\n\t\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t\t'" . $nomor . "',\n\t\t\t\t\t\"" . $debug_html . "\"\n\t\t\t\t)");
                set_alert(get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]], "danger", "", $save["url_success"] . "&no=" . $_GET["no"]);
            }
            mysqli_query($con, "\n\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\tnomormhadmin,\n\t\t\t\tipaddress,\n\t\t\t\taksi_menu_kode,\n\t\t\t\taksi_menu_judul,\n\t\t\t\taksi_statement,\n\t\t\t\taksi_table,\n\t\t\t\taksi_nomor,\n\t\t\t\tcatatan\n\t\t\t)\n\t\t\tVALUES (\n\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t'sp_add success',\n\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t'" . $nomor . "',\n\t\t\t\t\"" . $debug_html . "\"\n\t\t\t)");
        }
        $save_action = TRUE;
    }
} elseif ($save["mode"] == "edit") {
    $debug_html .= '$save[mode] == edit' . "<br /><br />";
    if ($_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"][$save["mode"]] != 1)
        set_alert(get_message(306, $save["mode"] . " " . $_SESSION["g.menu_kode"]));
    if ($_SERVER["REQUEST_METHOD"] != "POST")
        set_alert(get_message(703, ucfirst($save["mode"])), "danger");
    $update_query = "";
    $i            = 0;
    foreach ($save["field"] as $field) {
        if ((empty($field["pro_mode"]) && empty($field["anti_mode"])) || (!empty($field["pro_mode"]) && strstr($field["pro_mode"], $save["mode"])) || (!empty($field["anti_mode"]) && !strstr($field["anti_mode"], $save["mode"]))) {
            if (!empty($field["input"]) && $field["input_save"] != "skip" && (!empty($_POST[$field["input"]]) || $_POST[$field["input"]] == 0)) {
                if ($i != 0)
                    $update_query .= ",";
                $number_type = "";
                if (!empty($field["input_class"]))
                    $number_type = search_number_type($field["input_class"]);
                if (!empty($field["input_attr"]["class"]))
                    $number_type = search_number_type($field["input_attr"]["class"]);
                if (!empty($_SESSION["setting"]["date_class_autoformat"]) && (search_date_class($field["input_class"]) || search_date_class($field["input_attr"]["class"]))) {
                    $_POST[$field["input"]] = DateTime::createFromFormat($_SESSION["setting"]["date"], $_POST[$field["input"]])->format("Y-m-d");
                }
                /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-20;*/
                if (!empty($_SESSION["setting"]["datetime_class_autoformat"]) && (search_datetime_class($field["input_class"]) || search_datetime_class($field["input_attr"]["class"]))) {
                    $_POST[$field["input"]] = DateTime::createFromFormat($_SESSION["setting"]["datetime"], $_POST[$field["input"]])->format("Y-m-d H:i:s");
                }
                /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-20;*/

                /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-06-01;*/
                if (!empty($_SESSION["setting"]["period_class_autoformat"]) && (search_period_class($field["input_class"]) || search_period_class($field["input_attr"]["class"]))) {
                    $_POST[$field["input"]] = DateTime::createFromFormat($_SESSION["setting"]["period"], $_POST[$field["input"]])->format("Y-m-01");
                }
                /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-06-01;*/

                if (!empty($number_type))
                    $value = number_recovering($_POST[$field["input"]]);
                else
                    $value = "'" . addslashes(str_replace("\t", " ", $_POST[$field["input"]])) . "'";
                if (!empty($field["input_attr"]["date_format"])) {
                    $format_date = $field["input_attr"]["date_format"];
                    $value       = "STR_TO_DATE(" . $value . ",'" . $format_date . "')";
                }
                $update_query .= $field["input"] . " = " . $value;
                $i++;
            }
        }
    }
    $query = "\n\tUPDATE " . $save["table"] . "\n\tSET " . $update_query . ",\n\t" . $_SESSION["setting"]["field_diubah_oleh"] . " = " . $_SESSION["login"]["nomor"] . ",\n\t" . $_SESSION["setting"]["field_diubah_pada"] . " = now()\n\tWHERE " . $_SESSION["setting"]["field_nomor"] . " = " . $_GET["no"];
    $debug_html .= "mysqli_query : " . $query . "<br /><br />";
    $save_action = mysqli_query($con, $query);
    if (!$save_action)
        $debug_html .= "mysqli_query ERROR : " . mysqli_error($con) . "<br /><br />";
    $nomor     = $_GET["no"];
    $statement = "update";
    foreach ($save["detail"] as $detail) {
        $debug_html .= 'foreach($save[detail] as $detail)' . "<br /><br />";
        $old_data_action = "";
        if (!isset($detail["old_data"]) || empty($detail["old_data"])) {
            if (isset($_SESSION["setting"]["detail_old_data_action"]) && !empty($_SESSION["setting"]["detail_old_data_action"])) {
                $old_data_action = $_SESSION["setting"]["detail_old_data_action"];
            } else {
                $old_data_action = "update";
            }
        } else {
            $old_data_action = $detail["old_data"];
        }
        $debug_html .= '$old_data_action = ' . $old_data_action . "<br /><br />";
        $additional_where = "";
        if (!empty($detail["additional_where"])) {
            $additional_where = " AND " . $detail["additional_where"];
            $debug_html .= '$additional_where = ' . $additional_where . "<br /><br />";
        }
        $debug_html .= '$_POST[' . $detail["grid_id"] . '_detail_totalrow] = ' . $_POST[$detail["grid_id"] . "_detail_totalrow"] . "<br /><br />";
        if ($_POST[$detail["grid_id"] . "_detail_totalrow"] == "") {
            $debug_html .= "variable post failed, transactions(rollback);<br />" . get_message(703, ucfirst($save["mode"]));
            if ($save["debug"] == 1)
                $_SESSION["g.debug_html"] .= $debug_html;
            $_SESSION["g.debug0_html"] .= $debug_html;
            transactions($con, "rollback");
            set_alert(get_message(703, ucfirst($save["mode"])), "danger");
        } elseif ($_POST[$detail["grid_id"] . "_detail_totalrow"] > 0) {
            $delete_values = "";
            $insert_fields = "";
            $insert_values = "";
            $h             = 0;
            for ($i = 0; $i < $_POST[$detail["grid_id"] . "_detail_totalrow"]; $i++) {
                if (!empty($_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $_SESSION["setting"]["field_nomor"]])) {
                    if ($i != 0)
                        $delete_values .= ",";
                    $delete_values .= $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $_SESSION["setting"]["field_nomor"]];
                    $query = "UPDATE " . $detail["table_name"] . " SET ";
                    $j     = 0;
                    foreach ($detail["field_name"] as $field_name) {
                        if ($j != 0)
                            $query .= ",";
                        $data_format = explode("|", $field_name);
                        /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-06-01;*/
                        if (sizeof($data_format) == 3 && $data_format[1] == 'date') {
                            if(!empty($_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]])){
                                if (!empty($_SESSION["setting"]["date_class_autoformat"]) && search_date_class($data_format[2], "coltemplate_date_class_autoformat")) {
                                    $data_value = DateTime::createFromFormat($_SESSION["setting"]["coltemplate_date"], $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]])->format("Y-m-d");
                                }
                                if (!empty($_SESSION["setting"]["datetime_class_autoformat"]) && search_datetime_class($data_format[2], "coltemplate_datetime_class_autoformat")) {
                                    $data_value = DateTime::createFromFormat($_SESSION["setting"]["coltemplate_datetime"], $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]])->format("Y-m-d H:i:s");
                                }
                                if (!empty($_SESSION["setting"]["period_class_autoformat"]) && search_period_class($data_format[2], "coltemplate_period_class_autoformat")) {
                                    $data_value = DateTime::createFromFormat($_SESSION["setting"]["coltemplate_period"], $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]])->format("Y-m-01");
                                }
                            }
                            else{
                                $data_value = $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]];
                            }
                            /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-06-01;*/
                            $query .= $data_format[0] . " = '" . addslashes(str_replace("\t", " ", $data_value)) . "'";
                        } else {
                            $query .= $field_name . " = '" . addslashes(str_replace("\t", " ", $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $field_name])) . "'";
                        }
                        $j++;
                    }
                    $query .= "WHERE " . $_SESSION["setting"]["field_nomor"] . " = " . $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $_SESSION["setting"]["field_nomor"]];
                    $debug_html .= "mysqli_query : " . $query . "<br /><br />";
                    $update_detail = mysqli_query($con, $query);
                    if (!$update_detail) {
                        $debug_html .= "mysqli_query failed : " . mysqli_error($con) . "<br />transactions(rollback);<br />" . get_message(703, ucfirst($save["mode"]));
                        if ($save["debug"] == 1)
                            $_SESSION["g.debug_html"] .= $debug_html;
                        $_SESSION["g.debug0_html"] .= $debug_html;
                        transactions($con, "rollback");
                        set_alert(get_message(703, ucfirst($save["mode"])), "danger");
                    }
                } else {
                    if ($h == 0)
                        $insert_fields = "(";
                    if ($h != 0)
                        $insert_values .= ",";
                    $insert_values .= "(";
                    $j = 0;
                    foreach ($detail["field_name"] as $field_name) {
                        $data_format = explode("|", $field_name);
                        if ($j != 0) {
                            if ($h == 0)
                                $insert_fields .= ",";
                            $insert_values .= ",";
                        }
                        if ($h == 0){
                            if (sizeof($data_format) == 3 && $data_format[1] == 'date') {
                                /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-06-01;*/
                                if (!empty($_SESSION["setting"]["date_class_autoformat"]) && search_date_class($data_format[2], "coltemplate_date_class_autoformat")) {
                                    $data_value = DateTime::createFromFormat($_SESSION["setting"]["coltemplate_date"], $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]])->format("Y-m-d");
                                }
                                if (!empty($_SESSION["setting"]["datetime_class_autoformat"]) && search_datetime_class($data_format[2], "coltemplate_datetime_class_autoformat")) {
                                    $data_value = DateTime::createFromFormat($_SESSION["setting"]["coltemplate_datetime"], $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]])->format("Y-m-d H:i:s");
                                }
                                if (!empty($_SESSION["setting"]["period_class_autoformat"]) && search_period_class($data_format[2], "coltemplate_period_class_autoformat")) {
                                    $data_value = DateTime::createFromFormat($_SESSION["setting"]["coltemplate_period"], $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $data_format[0]])->format("Y-m-01");
                                }
                                /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-06-01;*/
                                $insert_fields .= $data_format[0];
                                $insert_values .= "'" . addslashes(str_replace("\t", " ", $data_value)) . "'";   
                            }
                            else{
                                $insert_fields .= $field_name;
                                $insert_values .= "'" . addslashes(str_replace("\t", " ", $_POST[$detail["grid_id"] . "_detail_" . $i . "_" . $field_name])) . "'";
                            }
                        }
                        $j++;
                    }
                    if (!empty($detail["foreign_key"])) {
                        if ($h == 0)
                            $insert_fields .= "," . $detail["foreign_key"];
                        $insert_values .= "," . $nomor;
                    }
                    if (!empty($detail["string_id"])) {
                        if ($h == 0)
                            $insert_fields .= "," . $_SESSION["setting"]["field_nomor"];
                        $insert_values .= "," . create_id($con, $detail["string_id"]);
                    }
                    $insert_values .= "," . $_SESSION["login"]["nomor"] . ",now())";
                    if ($h == 0)
                        $insert_fields .= "," . $_SESSION["setting"]["field_dibuat_oleh"] . "," . $_SESSION["setting"]["field_dibuat_pada"] . ")";
                    $h++;
                }
            }
            $debug_html .= $delete_values . " NOT IN (" . $delete_values . ")<br /><br />";
            if (!empty($delete_values))
                $delete_values = " AND " . $_SESSION["setting"]["field_nomor"] . " NOT IN (" . $delete_values . ")";
            if ($old_data_action == "delete") {
                $query = "\n\t\t\t\tDELETE FROM " . $detail["table_name"] . "\n\t\t\t\tWHERE " . $detail["foreign_key"] . " = " . $_GET["no"] . $delete_values . $additional_where;
            } else {
                $query = "\n\t\t\t\tUPDATE " . $detail["table_name"] . " SET\n\t\t\t\t" . $_SESSION["setting"]["field_status_aktif"] . " = 0,\n\t\t\t\t" . $_SESSION["setting"]["field_dihapus_oleh"] . " = " . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t" . $_SESSION["setting"]["field_dihapus_pada"] . " = now()\n\t\t\t\tWHERE " . $detail["foreign_key"] . " = " . $_GET["no"] . $delete_values . $additional_where;
            }
            $debug_html .= "mysqli_query : " . $query . "<br /><br />";
            $delete_detail = mysqli_query($con, $query);
            if (!$delete_detail) {
                $debug_html .= "mysqli_query failed : " . mysqli_error($con) . "<br />transactions(rollback);<br />" . get_message(703, ucfirst($save["mode"]));
                if ($save["debug"] == 1)
                    $_SESSION["g.debug_html"] .= $debug_html;
                $_SESSION["g.debug0_html"] .= $debug_html;
                transactions($con, "rollback");
                set_alert(get_message(703, ucfirst($save["mode"])), "danger");
            }
            if (!empty($insert_fields) && !empty($insert_values)) {
                $query = "INSERT INTO " . $detail["table_name"] . " " . $insert_fields . " VALUES " . $insert_values . ";";
                $debug_html .= "mysqli_query : " . $query . "<br /><br />";
                $insert_detail = mysqli_query($con, $query);
                if (!$insert_detail) {
                    $debug_html .= "mysqli_query failed : " . mysqli_error($con) . "<br />transactions(rollback);<br />" . get_message(703, ucfirst($save["mode"]));
                    if ($save["debug"] == 1)
                        $_SESSION["g.debug_html"] .= $debug_html;
                    $_SESSION["g.debug0_html"] .= $debug_html;
                    transactions($con, "rollback");
                    set_alert(get_message(703, ucfirst($save["mode"])), "danger");
                }
            }
        } elseif ($_POST[$detail["grid_id"] . "_detail_totalrow"] == 0) {
            if ($old_data_action == "delete") {
                $query = "\n\t\t\t\tDELETE FROM " . $detail["table_name"] . "\n\t\t\t\tWHERE " . $detail["foreign_key"] . " = " . $_GET["no"] . $additional_where;
            } else {
                $query = "\n\t\t\t\tUPDATE " . $detail["table_name"] . " SET\n\t\t\t\t" . $_SESSION["setting"]["field_status_aktif"] . " = 0,\n\t\t\t\t" . $_SESSION["setting"]["field_dihapus_oleh"] . " = " . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t" . $_SESSION["setting"]["field_dihapus_pada"] . " = now()\n\t\t\t\tWHERE " . $detail["foreign_key"] . " = " . $_GET["no"] . $additional_where;
            }
            $debug_html .= "mysqli_query : " . $query . "<br /><br />";
            $delete_detail = mysqli_query($con, $query);
            if (!$delete_detail) {
                $debug_html .= "mysqli_query failed : " . mysqli_error($con) . "<br />transactions(rollback);<br />" . get_message(703, ucfirst($save["mode"]));
                if ($save["debug"] == 1)
                    $_SESSION["g.debug_html"] .= $debug_html;
                $_SESSION["g.debug0_html"] .= $debug_html;
                transactions($con, "rollback");
                set_alert(get_message(703, ucfirst($save["mode"])), "danger");
            }
        }
    }
    if (!empty($save["sp_edit"]) && !empty($save["sp_edit_param"])) {
        $debug_html .= '$save[sp_edit] = ' . $save["sp_edit"] . ' && $save[sp_edit_param] = ' . $save["sp_edit_param"] . "<br />" . "transactions(commit);<br /><br />";
        transactions($con, "commit");
        $parameters = "";
        $i          = 0;
        foreach ($save["sp_edit_param"] as $parameter) {
            $param = explode("|", $parameter);
            $value = addslashes(str_replace("\t", " ", $_POST[$param[0]]));
            if ($param[1] == 1)
                $value = "'" . $value . "'";
            if ($i != 0)
                $parameters .= ",";
            $parameters .= $value;
            $i++;
        }
        $query = "CALL " . $save["sp_edit"] . "(" . $nomor . "," . $parameters . ")";
        $debug_html .= '$mysqli->query > ' . $query . "<br /><br />";
        $mysqli = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
        $result = $mysqli->query($query);
        if (!$result) {
            if ($_SESSION["setting"]["environment"] != "live")
                echo "<br />" . $query . "<br />Error MySQLi Query: " . $mysqli->error;
        }
        while ($data = $result->fetch_assoc()) {
            $debug_html .= '$data[' . $_SESSION["setting"]["field_flag"] . '] = ' . $data[$_SESSION["setting"]["field_flag"]] . "<br /><br />";
            if ($data[$_SESSION["setting"]["field_flag"]] != 1) {
                $debug_html .= get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]];
                if ($save["debug"] == 1)
                    $_SESSION["g.debug_html"] .= $debug_html;
                $_SESSION["g.debug0_html"] .= $debug_html;
                mysqli_query($con, "\n\t\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\t\tnomormhadmin,\n\t\t\t\t\tipaddress,\n\t\t\t\t\taksi_menu_kode,\n\t\t\t\t\taksi_menu_judul,\n\t\t\t\t\taksi_statement,\n\t\t\t\t\taksi_table,\n\t\t\t\t\taksi_nomor,\n\t\t\t\t\tcatatan\n\t\t\t\t)\n\t\t\t\tVALUES (\n\t\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t\t'sp_edit failed',\n\t\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t\t'" . $nomor . "',\n\t\t\t\t\t\"" . $debug_html . "\"\n\t\t\t\t)");
                set_alert(get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]], "danger", "", $save["url_success"] . "&no=" . $_GET["no"]);
            }
            mysqli_query($con, "\n\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\tnomormhadmin,\n\t\t\t\tipaddress,\n\t\t\t\taksi_menu_kode,\n\t\t\t\taksi_menu_judul,\n\t\t\t\taksi_statement,\n\t\t\t\taksi_table,\n\t\t\t\taksi_nomor,\n\t\t\t\tcatatan\n\t\t\t)\n\t\t\tVALUES (\n\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t'sp_edit success',\n\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t'" . $nomor . "',\n\t\t\t\t\"" . $debug_html . "\"\n\t\t\t)");
        }
        $save_action = TRUE;
    }
} elseif ($save["mode"] == "delete") {
    $debug_html .= '$save[mode] == delete' . "<br /><br />";
    if ($_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"][$save["mode"]] != 1)
        set_alert(get_message(306, $save["mode"] . " " . $_SESSION["g.menu_kode"]));
    $query = "\n\tUPDATE " . $save["table"] . " SET\n\t" . $_SESSION["setting"]["field_status_aktif"] . " = 0,\n\t" . $_SESSION["setting"]["field_dihapus_oleh"] . " = " . $_SESSION["login"]["nomor"] . ",\n\t" . $_SESSION["setting"]["field_dihapus_pada"] . " = now()\n\tWHERE " . $_SESSION["setting"]["field_status_disetujui"] . " = 0\n\tAND " . $_SESSION["setting"]["field_nomor"] . " = " . $_GET["no"];
    $debug_html .= "mysqli_query : " . $query . "<br /><br />";
    $save_action = mysqli_query($con, $query);
    if (!$save_action)
        $debug_html .= "mysqli_query ERROR : " . mysqli_error($con) . "<br /><br />";
    $nomor     = $_GET["no"];
    $statement = "delete";
    if (!empty($save["sp_delete"]) && !empty($save["sp_delete_param"])) {
        $debug_html .= '$save[sp_delete] = ' . $save["sp_delete"] . ' && $save[sp_delete_param] = ' . $save["sp_delete_param"] . "<br />" . "transactions(commit);<br /><br />";
        transactions($con, "commit");
        $parameters = "";
        $i          = 0;
        foreach ($save["sp_delete_param"] as $parameter) {
            $param = explode("|", $parameter);
            $value = addslashes(str_replace("\t", " ", $_POST[$param[0]]));
            if ($param[1] == 1)
                $value = "'" . $value . "'";
            if ($i != 0)
                $parameters .= ",";
            $parameters .= $value;
            $i++;
        }
        $query = "CALL " . $save["sp_delete"] . "(" . $nomor . "," . $parameters . ")";
        $debug_html .= '$mysqli->query > ' . $query . "<br /><br />";
        $mysqli = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
        $result = $mysqli->query($query);
        if (!$result) {
            if ($_SESSION["setting"]["environment"] != "live")
                echo "<br />" . $query . "<br />Error MySQLi Query: " . $mysqli->error;
        }
        while ($data = $result->fetch_assoc()) {
            $debug_html .= '$data[' . $_SESSION["setting"]["field_flag"] . '] = ' . $data[$_SESSION["setting"]["field_flag"]] . "<br /><br />";
            if ($data[$_SESSION["setting"]["field_flag"]] != 1) {
                $debug_html .= get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]];
                if ($save["debug"] == 1)
                    $_SESSION["g.debug_html"] .= $debug_html;
                $_SESSION["g.debug0_html"] .= $debug_html;
                mysqli_query($con, "\n\t\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\t\tnomormhadmin,\n\t\t\t\t\tipaddress,\n\t\t\t\t\taksi_menu_kode,\n\t\t\t\t\taksi_menu_judul,\n\t\t\t\t\taksi_statement,\n\t\t\t\t\taksi_table,\n\t\t\t\t\taksi_nomor,\n\t\t\t\t\tcatatan\n\t\t\t\t)\n\t\t\t\tVALUES (\n\t\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t\t'sp_delete failed',\n\t\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t\t'" . $nomor . "',\n\t\t\t\t\t\"" . $debug_html . "\"\n\t\t\t\t)");
                set_alert(get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]], "danger", "", $save["url_success"] . "&no=" . $_GET["no"]);
            }
            mysqli_query($con, "\n\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\tnomormhadmin,\n\t\t\t\tipaddress,\n\t\t\t\taksi_menu_kode,\n\t\t\t\taksi_menu_judul,\n\t\t\t\taksi_statement,\n\t\t\t\taksi_table,\n\t\t\t\taksi_nomor,\n\t\t\t\tcatatan\n\t\t\t)\n\t\t\tVALUES (\n\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t'sp_delete success',\n\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t'" . $nomor . "',\n\t\t\t\t\"" . $debug_html . "\"\n\t\t\t)");
        }
        $save_action = TRUE;
        $nomor       = $data[$_SESSION["setting"]["field_nomor"]];
        $statement   = "delete";
    }
} elseif ($save["mode"] == "approve") {
    $debug_html .= '$save[mode] == approve' . "<br /><br />";
    if ($_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"][$save["mode"]] != 1)
        set_alert(get_message(306, $save["mode"] . " " . $_SESSION["g.menu_kode"]));
    if (!empty($save["sp_approve"]) && !empty($save["sp_approve_param"])) {
        $parameters = "";
        $i          = 0;
        foreach ($save["sp_approve_param"] as $parameter) {
            $param = explode("|", $parameter);
            $value = addslashes(str_replace("\t", " ", $_POST[$param[0]]));
            if ($param[1] == 1)
                $value = "'" . $value . "'";
            if ($i != 0)
                $parameters .= ",";
            $parameters .= $value;
            $i++;
        }
        $query = "CALL " . $save["sp_approve"] . "(" . $parameters . ")";
        $debug_html .= '$mysqli->query > ' . $query . "<br /><br />";
        $mysqli = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
        $result = $mysqli->query($query);
        if (!$result) {
            if ($_SESSION["setting"]["environment"] != "live")
                echo "<br />" . $query . "<br />Error MySQLi Query: " . $mysqli->error;
        }
        while ($data = $result->fetch_assoc()) {
            $debug_html .= '$data[' . $_SESSION["setting"]["field_flag"] . '] = ' . $data[$_SESSION["setting"]["field_flag"]] . "<br /><br />";
            if ($data[$_SESSION["setting"]["field_flag"]] != 1) {
                $debug_html .= get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]];
                if ($save["debug"] == 1)
                    $_SESSION["g.debug_html"] .= $debug_html;
                $_SESSION["g.debug0_html"] .= $debug_html;
                mysqli_query($con, "\n\t\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\t\tnomormhadmin,\n\t\t\t\t\tipaddress,\n\t\t\t\t\taksi_menu_kode,\n\t\t\t\t\taksi_menu_judul,\n\t\t\t\t\taksi_statement,\n\t\t\t\t\taksi_table,\n\t\t\t\t\taksi_nomor,\n\t\t\t\t\tcatatan\n\t\t\t\t)\n\t\t\t\tVALUES (\n\t\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t\t'sp_approve failed',\n\t\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t\t'" . $nomor . "',\n\t\t\t\t\t\"" . $debug_html . "\"\n\t\t\t\t)");
                set_alert(get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]], "danger", "", $save["url_success"] . "&no=" . $_GET["no"]);
            }
            mysqli_query($con, "\n\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\tnomormhadmin,\n\t\t\t\tipaddress,\n\t\t\t\taksi_menu_kode,\n\t\t\t\taksi_menu_judul,\n\t\t\t\taksi_statement,\n\t\t\t\taksi_table,\n\t\t\t\taksi_nomor,\n\t\t\t\tcatatan\n\t\t\t)\n\t\t\tVALUES (\n\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t'sp_approve success',\n\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t'" . $nomor . "',\n\t\t\t\t\"" . $debug_html . "\"\n\t\t\t)");
        }
        $save_action = TRUE;
        $nomor       = $_GET["no"];
        $statement   = "approve";
    } else {
        $query = "\n\t\tUPDATE " . $save["table"] . " SET\n\t\t" . $_SESSION["setting"]["field_status_disetujui"] . " = 1,\n\t\t" . $_SESSION["setting"]["field_disetujui_oleh"] . " = " . $_SESSION["login"]["nomor"] . ",\n\t\t" . $_SESSION["setting"]["field_disetujui_pada"] . " = now()\n\t\tWHERE " . $_SESSION["setting"]["field_nomor"] . " = " . $_GET["no"] . "\n\t\tAND " . $_SESSION["setting"]["field_status_aktif"] . " = 1\n\t\tAND " . $_SESSION["setting"]["field_status_disetujui"] . " = 0";
        $debug_html .= "mysqli_query : " . $query . "<br /><br />";
        $save_action = mysqli_query($con, $query);
        if (!$save_action)
            $debug_html .= "mysqli_query ERROR : " . mysqli_error($con) . "<br /><br />";
        $nomor     = $_GET["no"];
        $statement = "approve";
    }
} elseif ($save["mode"] == "reject") {
    $debug_html .= '$save[mode] == reject' . "<br /><br />";
    if ($_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"][$save["mode"]] != 1)
        set_alert(get_message(306, $save["mode"] . " " . $_SESSION["g.menu_kode"]));
    if (!empty($save["sp_reject"]) && !empty($save["sp_reject_param"])) {
        $parameters = "";
        $i          = 0;
        foreach ($save["sp_reject_param"] as $parameter) {
            $param = explode("|", $parameter);
            $value = addslashes(str_replace("\t", " ", $_POST[$param[0]]));
            if ($param[1] == 1)
                $value = "'" . $value . "'";
            if ($i != 0)
                $parameters .= ",";
            $parameters .= $value;
            $i++;
        }
        $query = "CALL " . $save["sp_reject"] . "(" . $parameters . ")";
        $debug_html .= '$mysqli->query > ' . $query . "<br /><br />";
        $mysqli = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
        $result = $mysqli->query($query);
        if (!$result) {
            if ($_SESSION["setting"]["environment"] != "live")
                echo "<br />" . $query . "<br />Error MySQLi Query: " . $mysqli->error;
        }
        while ($data = $result->fetch_assoc()) {
            $debug_html .= '$data[' . $_SESSION["setting"]["field_flag"] . '] = ' . $data[$_SESSION["setting"]["field_flag"]] . "<br /><br />";
            if ($data[$_SESSION["setting"]["field_flag"]] != 1) {
                $debug_html .= get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]];
                if ($save["debug"] == 1)
                    $_SESSION["g.debug_html"] .= $debug_html;
                $_SESSION["g.debug0_html"] .= $debug_html;
                mysqli_query($con, "\n\t\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\t\tnomormhadmin,\n\t\t\t\t\tipaddress,\n\t\t\t\t\taksi_menu_kode,\n\t\t\t\t\taksi_menu_judul,\n\t\t\t\t\taksi_statement,\n\t\t\t\t\taksi_table,\n\t\t\t\t\taksi_nomor,\n\t\t\t\t\tcatatan\n\t\t\t\t)\n\t\t\t\tVALUES (\n\t\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t\t'sp_reject failed',\n\t\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t\t'" . $nomor . "',\n\t\t\t\t\t\"" . $debug_html . "\"\n\t\t\t\t)");
                set_alert(get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]], "danger", "", $save["url_success"] . "&no=" . $_GET["no"]);
            }
            mysqli_query($con, "\n\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\tnomormhadmin,\n\t\t\t\tipaddress,\n\t\t\t\taksi_menu_kode,\n\t\t\t\taksi_menu_judul,\n\t\t\t\taksi_statement,\n\t\t\t\taksi_table,\n\t\t\t\taksi_nomor,\n\t\t\t\tcatatan\n\t\t\t)\n\t\t\tVALUES (\n\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t'sp_reject success',\n\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t'" . $nomor . "',\n\t\t\t\t\"" . $debug_html . "\"\n\t\t\t)");
        }
        $save_action = TRUE;
        $nomor       = $_GET["no"];
        $statement   = "reject";
    } else {
        /*edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
        $query = "\n\t\tUPDATE " . $save["table"] . " SET\n\t\t" . $_SESSION["setting"]["field_status_disetujui"] . " = -1,\n\t\t" . $_SESSION["setting"]["field_ditolak_oleh"] . " = " . $_SESSION["login"]["nomor"] . ",\n\t\t" . $_SESSION["setting"]["field_ditolak_pada"] . " = now()\n\t\tWHERE " . $_SESSION["setting"]["field_nomor"] . " = " . $_GET["no"] . "\n\t\tAND " . $_SESSION["setting"]["field_status_aktif"] . " = 1\n\t\tAND " . $_SESSION["setting"]["field_status_disetujui"] . " = 0";
        /*edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
        $debug_html .= "mysqli_query : " . $query . "<br /><br />";
        $save_action = mysqli_query($con, $query);
        if (!$save_action)
            $debug_html .= "mysqli_query ERROR : " . mysqli_error($con) . "<br /><br />";
        $nomor     = $_GET["no"];
        $statement = "reject";
    }
} elseif ($save["mode"] == "disapprove") {
    $debug_html .= '$save[mode] == disapprove' . "<br /><br />";
    if ($_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"][$save["mode"]] != 1)
        set_alert(get_message(306, $save["mode"] . " " . $_SESSION["g.menu_kode"]));
    if (!empty($save["sp_disapprove"]) && !empty($save["sp_disapprove_param"])) {
        $parameters = "";
        $i          = 0;
        foreach ($save["sp_disapprove_param"] as $parameter) {
            $param = explode("|", $parameter);
            $value = addslashes(str_replace("\t", " ", $_POST[$param[0]]));
            if ($param[1] == 1)
                $value = "'" . $value . "'";
            if ($i != 0)
                $parameters .= ",";
            $parameters .= $value;
            $i++;
        }
        $query = "CALL " . $save["sp_disapprove"] . "(" . $parameters . ")";
        $debug_html .= '$mysqli->query > ' . $query . "<br /><br />";
        $mysqli = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
        $result = $mysqli->query($query);
        if (!$result) {
            if ($_SESSION["setting"]["environment"] != "live")
                echo "<br />" . $query . "<br />Error MySQLi Query: " . $mysqli->error;
        }
        while ($data = $result->fetch_assoc()) {
            $debug_html .= '$data[' . $_SESSION["setting"]["field_flag"] . '] = ' . $data[$_SESSION["setting"]["field_flag"]] . "<br /><br />";
            if ($data[$_SESSION["setting"]["field_flag"]] != 1) {
                $debug_html .= get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]];
                if ($save["debug"] == 1)
                    $_SESSION["g.debug_html"] .= $debug_html;
                $_SESSION["g.debug0_html"] .= $debug_html;
                mysqli_query($con, "\n\t\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\t\tnomormhadmin,\n\t\t\t\t\tipaddress,\n\t\t\t\t\taksi_menu_kode,\n\t\t\t\t\taksi_menu_judul,\n\t\t\t\t\taksi_statement,\n\t\t\t\t\taksi_table,\n\t\t\t\t\taksi_nomor,\n\t\t\t\t\tcatatan\n\t\t\t\t)\n\t\t\t\tVALUES (\n\t\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t\t'sp_disapprove failed',\n\t\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t\t'" . $nomor . "',\n\t\t\t\t\t\"" . $debug_html . "\"\n\t\t\t\t)");
                set_alert(get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]], "danger", "", $save["url_success"] . "&no=" . $_GET["no"]);
            }
            mysqli_query($con, "\n\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\tnomormhadmin,\n\t\t\t\tipaddress,\n\t\t\t\taksi_menu_kode,\n\t\t\t\taksi_menu_judul,\n\t\t\t\taksi_statement,\n\t\t\t\taksi_table,\n\t\t\t\taksi_nomor,\n\t\t\t\tcatatan\n\t\t\t)\n\t\t\tVALUES (\n\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t'sp_disapprove success',\n\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t'" . $nomor . "',\n\t\t\t\t\"" . $debug_html . "\"\n\t\t\t)");
        }
        $save_action = TRUE;
        $nomor       = $_GET["no"];
        $statement   = "disapprove";
    } else {
        /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
        $query = "\n\t\tUPDATE " . $save["table"] . " SET\n\t\t" . $_SESSION["setting"]["field_status_disetujui"] . " = IF(" . $_SESSION["setting"]["field_status_disetujui"] . " = 2, 1, 0),\n\t\t" . $_SESSION["setting"]["field_dibatalkan_oleh"] . " = " . $_SESSION["login"]["nomor"] . ",\n\t\t" . $_SESSION["setting"]["field_dibatalkan_pada"] . " = now()\n\t\tWHERE " . $_SESSION["setting"]["field_nomor"] . " = " . $_GET["no"] . "\n\t\tAND " . $_SESSION["setting"]["field_status_aktif"] . " = 1\n\t\tAND " . $_SESSION["setting"]["field_status_disetujui"] . " != 0";
        /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
        $debug_html .= "mysqli_query : " . $query . "<br /><br />";
        $save_action = mysqli_query($con, $query);
        if (!$save_action)
            $debug_html .= "mysqli_query ERROR : " . mysqli_error($con) . "<br /><br />";
        $nomor     = $_GET["no"];
        $statement = "disapprove";
    }
} elseif ($save["mode"] == "close") {
    $debug_html .= '$save[mode] == close' . "<br /><br />";
    if ($_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"][$save["mode"]] != 1)
        set_alert(get_message(306, $save["mode"] . " " . $_SESSION["g.menu_kode"]));
    if (!empty($save["sp_close"]) && !empty($save["sp_close_param"])) {
        $parameters = "";
        $i          = 0;
        foreach ($save["sp_close_param"] as $parameter) {
            $param = explode("|", $parameter);
            $value = addslashes(str_replace("\t", " ", $_POST[$param[0]]));
            if ($param[1] == 1)
                $value = "'" . $value . "'";
            if ($i != 0)
                $parameters .= ",";
            $parameters .= $value;
            $i++;
        }
        $query = "CALL " . $save["sp_close"] . "(" . $parameters . ")";
        $debug_html .= '$mysqli->query > ' . $query . "<br /><br />";
        $mysqli = new mysqli($mysql["server"], $mysql["username"], $mysql["password"], $mysql["database"]);
        $result = $mysqli->query($query);
        if (!$result) {
            if ($_SESSION["setting"]["environment"] != "live")
                echo "<br />" . $query . "<br />Error MySQLi Query: " . $mysqli->error;
        }
        while ($data = $result->fetch_assoc()) {
            $debug_html .= '$data[' . $_SESSION["setting"]["field_flag"] . '] = ' . $data[$_SESSION["setting"]["field_flag"]] . "<br /><br />";
            if ($data[$_SESSION["setting"]["field_flag"]] != 1) {
                $debug_html .= get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]];
                if ($save["debug"] == 1)
                    $_SESSION["g.debug_html"] .= $debug_html;
                $_SESSION["g.debug0_html"] .= $debug_html;
                mysqli_query($con, "\n\t\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\t\tnomormhadmin,\n\t\t\t\t\tipaddress,\n\t\t\t\t\taksi_menu_kode,\n\t\t\t\t\taksi_menu_judul,\n\t\t\t\t\taksi_statement,\n\t\t\t\t\taksi_table,\n\t\t\t\t\taksi_nomor,\n\t\t\t\t\tcatatan\n\t\t\t\t)\n\t\t\t\tVALUES (\n\t\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t\t'sp_close failed',\n\t\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t\t'" . $nomor . "',\n\t\t\t\t\t\"" . $debug_html . "\"\n\t\t\t\t)");
                set_alert(get_message(703, ucfirst($save["mode"])) . "<br />" . $data[$_SESSION["setting"]["field_message"]], "danger", "", $save["url_success"] . "&no=" . $_GET["no"]);
            }
            mysqli_query($con, "\n\t\t\tINSERT INTO rhaktivitasadmin (\n\t\t\t\tnomormhadmin,\n\t\t\t\tipaddress,\n\t\t\t\taksi_menu_kode,\n\t\t\t\taksi_menu_judul,\n\t\t\t\taksi_statement,\n\t\t\t\taksi_table,\n\t\t\t\taksi_nomor,\n\t\t\t\tcatatan\n\t\t\t)\n\t\t\tVALUES (\n\t\t\t\t" . $_SESSION["login"]["nomor"] . ",\n\t\t\t\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t\t\t\t'" . $_SESSION["g.menu"] . "',\n\t\t\t\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t\t\t\t'sp_close success',\n\t\t\t\t'" . $save["table"] . "',\n\t\t\t\t'" . $nomor . "',\n\t\t\t\t\"" . $debug_html . "\"\n\t\t\t)");
        }
        $save_action = TRUE;
        $nomor       = $_GET["no"];
        $statement   = "close";
    } else {
        $query = "\n\t\tUPDATE " . $save["table"] . " SET\n\t\t" . $_SESSION["setting"]["field_status_disetujui"] . " = 2,\n\t\t" . $_SESSION["setting"]["field_ditutup_oleh"] . " = " . $_SESSION["login"]["nomor"] . ",\n\t\t" . $_SESSION["setting"]["field_ditutup_pada"] . " = now()\n\t\tWHERE " . $_SESSION["setting"]["field_nomor"] . " = " . $_GET["no"] . "\n\t\tAND " . $_SESSION["setting"]["field_status_aktif"] . " = 1\n\t\tAND " . $_SESSION["setting"]["field_status_disetujui"] . " = 1";
        $debug_html .= "mysqli_query : " . $query . "<br /><br />";
        $save_action = mysqli_query($con, $query);
        if (!$save_action)
            $debug_html .= "mysqli_query ERROR : " . mysqli_error($con) . "<br /><br />";
        $nomor     = $_GET["no"];
        $statement = "close";
    }
}
if (!empty($edit["manual_save_beforecommit"]))
    include $edit["manual_save_beforecommit"];
if ($save_action) {
    $statement .= " success";
    $debug_html .= '$save_action = success, transactions(commit);' . "<br />" . get_message(702, ucfirst($save["mode"]));
} else {
    $statement .= " failed_attempt";
    $debug_html .= '$save_action = failed_attempt, transactions(rollback);' . "<br />" . get_message(703, ucfirst($save["mode"]));
}
mysqli_query($con, "\nINSERT INTO rhaktivitasadmin (\n\tnomormhadmin,\n\tipaddress,\n\taksi_menu_kode,\n\taksi_menu_judul,\n\taksi_statement,\n\taksi_table,\n\taksi_nomor,\n\tcatatan\n)\nVALUES (\n\t" . $_SESSION["login"]["nomor"] . ",\n\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t'" . $_SESSION["g.menu"] . "',\n\t'" . $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["judul"] . "',\n\t'" . $statement . "',\n\t'" . $save["table"] . "',\n\t'" . $nomor . "',\n\t\"" . $debug_html . "\"\n)");
if ($save["debug"] == 2) {
    $update_catatan_debug = "\n\tUPDATE " . $save["table"] . "\n\tSET catatan = \"" . $debug_html . "\"\n\tWHERE " . $_SESSION["setting"]["field_nomor"] . " = " . $nomor;
    mysqli_query($con, $update_catatan_debug);
    unset($_SESSION["g.debug2_html"]);
    $_SESSION["g.debug2_html"] .= $debug_html;
}
if ($save_action) {
    transactions($con,"commit");
    if (!empty($save["url_success_custom"]))
        set_alert(get_message(702, ucfirst($save["mode"])), "success", "", $save["url_success_custom"]);
    else
        set_alert(get_message(702, ucfirst($save["mode"])), "success", "", $save["url_success"] . "&no=" . $nomor);
} else {
    if ($save["debug"] == 1)
        $_SESSION["g.debug_html"] .= $debug_html;
    $_SESSION["g.debug0_html"] .= $debug_html;
    transactions($con, "rollback");
    set_alert(get_message(703, ucfirst($save["mode"])), "danger");
}
die("<meta http-equiv='refresh' content='0;URL=" . $save["url_failed"] . "'>");
?>
<?php
/*created_by:patricklipesik@gmail.com;release_date:2020-05-09;*/
?>