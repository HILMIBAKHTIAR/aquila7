<?php
function generate_navbutton($edit_navbutton, $features = "save|edit|back|reload|add|filter_column", $page = "", $no = "", $url = "")
{
    if (empty($page))
        $page = "edit";
    if ($page == "edit")
        $i = count($edit_navbutton["field"]);
    if (empty($no))
        $no = $_GET["no"];
    if (empty($url))
        $url = $_SESSION["g.url"];
    if ($page == "index") {
        $icon_class   = "fa fa-info";
        $button_class = "btn-midnight";
        $title        = "View";
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        $edit_navbutton .= "<a class='btn " . $button_class . " btn-app-sm' href='" . $url . "&sm=edit&a=view&no=" . $no . "'><i class='" . $icon_class . "' title='" . $title . "'></i></a> ";
    }
    if (strstr($features, "post")) {
        $icon_class   = "fa fa-floppy-o";
        $button_class = "btn-primary";
        $title        = "Post";
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["anti_mode"]                 = "view";
            $edit_navbutton["field"][$i]["input_element"]             = "button";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " post dim";
            $edit_navbutton["field"][$i]["input_attr"]["type"]        = "submit";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            $i++;
        }
    }
    if (strstr($features, "save")) {
        $icon_class   = "fa fa-floppy-o";
        $button_class = "btn-midnight";
        $title        = "Save";
        if (!empty($_SESSION["setting"]["navbutton_save"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_save"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["anti_mode"]                 = "view";
            $edit_navbutton["field"][$i]["input_element"]             = "button";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " save dim";
            $edit_navbutton["field"][$i]["input_attr"]["type"]        = "submit";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            $i++;
        }
    }
    if (strstr($features, "edit") && $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"]["edit"] == 1) {
        $icon_class   = "fa fa-pencil";
        $button_class = "btn-warning";
        $title        = "Edit";
        if (!empty($_SESSION["setting"]["navbutton_edit"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_edit"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["pro_mode"]                  = "view";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " edit dim";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "location.href=('" . $url . "&sm=edit&no=" . $no . "')";
            $i++;
        } elseif ($page == "index") {
            $edit_navbutton .= "<a class='btn " . $button_class . " btn-app-sm' href='" . $url . "&sm=edit&no=" . $no . "'><i class='" . $icon_class . "' title='" . $title . "'></i></a> ";
        }
    }
    if (strstr($features, "delete") && $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"]["delete"] == 1) {
        $icon_class   = "fa fa-trash";
        $button_class = "btn-danger";
        $title        = "Delete";
        if (!empty($_SESSION["setting"]["navbutton_delete"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_delete"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["pro_mode"]                  = "view";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " delete dim";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
            $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "link_confirmation('" . get_message(700) . "','" . $url . "&sm=delete&no=" . $no . "', '','" . $title . "')";
            /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
            $i++;
        } elseif ($page == "index") {
            $edit_navbutton .= "<a class='ask btn " . $button_class . " btn-app-sm' onclick=\"link_confirmation('" . get_message(700) . "','" . $url . "&sm=delete&no=" . $no . "', '','" . $title . "');\"> <i class='" . $icon_class . "' title='" . $title . "'></i></a> ";
        }
    }
    if (strstr($features, "approve") && $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"]["approve"] == 1) {
        $icon_class   = "fa fa-check";
        $button_class = "btn-primary";
        $title        = "Approve";
        if (!empty($_SESSION["setting"]["navbutton_approve"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_approve"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["pro_mode"]                  = "view";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " approve dim";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
            $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "link_confirmation('" . get_message(700) . "','" . $url . "&sm=approve&no=" . $no . "', '', '" . $title . "')";
            /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
            $i++;
        } elseif ($page == "index") {
            $edit_navbutton .= "<a class='ask btn " . $button_class . " btn-app-sm' onclick=\"link_confirmation('" . get_message(700) . "','" . $url . "&sm=approve&no=" . $no . "', '', '" . $title . "')\"><i class='" . $icon_class . "' title='" . $title . "'></i></a> ";
        }
    }
    if (strstr($features, "reject") && $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"]["reject"] == 1) {
        $icon_class   = "fa fa-ban";
        $button_class = "btn-danger";
        $title        = "Reject";
        if (!empty($_SESSION["setting"]["navbutton_reject"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_reject"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["pro_mode"]                  = "view";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " reject dim";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
            $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "link_confirmation('" . get_message(700) . "','" . $url . "&sm=reject&no=" . $no . "', '', '" . $title . "')";
            /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
            $i++;
        } elseif ($page == "index") {
            $edit_navbutton .= "<a class='ask btn " . $button_class . " btn-app-sm' onclick=\"link_confirmation('" . get_message(700) . "','" . $url . "&sm=reject&no=" . $no . "', '', '" . $title . "')\"><i class='" . $icon_class . "' title='" . $title . "'></i></a> ";
        }
    }
    if (strstr($features, "print") && $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"]["print"] == 1) {
        $icon_class   = "fa fa-print";
        $button_class = "btn-info";
        $title        = "Print";
        if (!empty($_SESSION["setting"]["navbutton_print"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_print"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["pro_mode"]                  = "view";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " invoice dim";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
            $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "link_confirmation('" . get_message(700) . "','pages/print_invoice.php" . $url . "&sm=edit&a=view&no=" . $no . "','_newtab','" . $title . "')";
            /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
            $i++;
        } elseif ($page == "index") {
            $edit_navbutton .= "<a class='ask btn " . $button_class . " btn-app-sm' href='pages/print_invoice.php" . $url . "&sm=edit&a=view&no=" . $no . "'><i class='" . $icon_class . "' title='" . $title . "'></i></a> ";
        }
    }
    if (strstr($features, "export_print")) {
        $icon_class   = "fa fa-print";
        $button_class = "btn-midnight";
        $title        = "Print";
        if (!empty($_SESSION["setting"]["navbutton_export_print"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_export_print"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " exportprint dim";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = "Print";
            /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-20;*/
            $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "setPrint()";
            // $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "window.open('pages/export_print.php" . $url . "&sm=edit&a=view&no=" . $no . "','_newtab')";
            /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-20;*/
            $i++;
        } elseif ($page == "index") {
            $edit_navbutton .= "<a class='btn " . $button_class . " btn-app-sm' href='pages/export_print.php" . $url . "&sm=edit&a=view&no=" . $no . "'><i class='" . $icon_class . "' title='" . $title . "'></i></a> ";
        }
    }
    if (strstr($features, "export_excel")) {
        $icon_class   = "fa fa-table";
        $button_class = "btn-primary";
        $title        = "Excel";
        if (!empty($_SESSION["setting"]["navbutton_export_excel"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_export_excel"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " exportexcel dim";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = "Export Excel";
            $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "window.open('pages/export_excel.php" . $url . "&sm=edit&a=view&no=" . $no . "')";
            $i++;
        } elseif ($page == "index") {
            $edit_navbutton .= "<a class='btn " . $button_class . " btn-app-sm' href='pages/export_excel.php" . $url . "&sm=edit&a=view&no=" . $no . "'><i class='" . $icon_class . "' title='" . $title . "'></i></a> ";
        }
    }
    if (strstr($features, "disapp") && $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"]["disapprove"] == 1) {
        $icon_class   = "fa fa-times";
        $button_class = "btn-danger";
        $title        = "Disapprove";
        if (!empty($_SESSION["setting"]["navbutton_disapprove"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_disapprove"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["pro_mode"]                  = "view";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " disapp dim";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
            $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "link_confirmation('" . get_message(700) . "','" . $url . "&sm=disapprove&no=" . $no . "', '', '" . $title . "')";
            /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
            $i++;
        } elseif ($page == "index") {
            $edit_navbutton .= "<a class='ask btn " . $button_class . " btn-app-sm' onclick=\"link_confirmation('" . get_message(700) . "','" . $url . "&sm=disapprove&no=" . $no . "', '', '" . $title . "')\"><i class='" . $icon_class . "' title='" . $title . "'></i></a> ";
        }
    }
    if (strstr($features, "close") && $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"]["close"] == 1) {
        $icon_class   = "fa fa-flag-checkered";
        $button_class = "btn-default";
        $title        = "Finish";
        if (!empty($_SESSION["setting"]["navbutton_close"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_close"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["pro_mode"]                  = "view";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " tutup dim";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
            $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "link_confirmation('" . get_message(700) . "','" . $url . "&sm=close&no=" . $no . "', '" . $title . "')";
            /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
            $i++;
        } elseif ($page == "index") {
            $edit_navbutton .= "<a class='ask btn " . $button_class . " btn-app-sm' onclick=\"link_confirmation('" . get_message(700) . "','" . $url . "&sm=close&no=" . $no . "', '" . $title . "')\"><i class='" . $icon_class . "' title='" . $title . "'></i></a> ";
        }
    }
    if (strstr($features, "back")) {
        $icon_class   = "fa fa-reply";
        $button_class = "btn-default";
        $title        = "Back";
        if (!empty($_SESSION["setting"]["navbutton_back"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_back"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["anti_mode"]                 = "edit";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " back dim";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            $edit_navbutton["field"][$i]["input_attr"]["href"]        = "dashboard.php" . $url;
            $i++;
            // $icon_class   = "fa fa-reply";
            $button_class = "btn-danger dim";
            $title        = "Cancel";
            if ($_SESSION["login"]["framework"] == "webspira")
                $button_title = $title;
            $edit_navbutton["field"][$i]["pro_mode"]                  = "edit";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class;
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "location.href=('" . $url . "&sm=edit&a=view&no=" . $no . "')";
            $i++;
        }
    }
    if (strstr($features, "reload")) {
        $icon_class   = "fa fa-refresh";
        $button_class = "btn-default dim";
        $title        = "Reload";
        if (!empty($_SESSION["setting"]["navbutton_reload"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_reload"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["pro_mode"]                  = "index";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " reload";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            $edit_navbutton["field"][$i]["input_attr"]["link"]        = $url . "&sm=reload";
            // $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "location.href=('" . $url . "&sm=reload')";
            $i++;
        }
    }
    if (strstr($features, "filter_column")) {
        $icon_class   = "fa fa-columns";
        $button_class = "btn-success dim";
        $title        = "Filter Column";
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["pro_mode"]                  = "index";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " filter_column";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            // $edit_navbutton["field"][$i]["input_attr"]["onclick"]     = "location.href=('" . $url . "&sm=reload')";
            $i++;
        }
    }
    if (strstr($features, "add") && $_SESSION["menu_" . $_SESSION["g.menu_kode"]]["priv"]["add"] == 1) {
        $icon_class   = "fa fa-plus";
        $button_class = "btn-midnight dim";
        $title        = "Add";
        if (!empty($_SESSION["setting"]["navbutton_add"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_add"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["pro_mode"]                  = "index|view";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " add";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = $title;
            $edit_navbutton["field"][$i]["input_attr"]["href"]        = "dashboard.php" . $url . "&sm=edit";
            $i++;
        }
    }
    if (strstr($features, "help")) {
        $icon_class   = "fa fa-question";
        $button_class = "btn-info dim";
        $title        = "Help";
        if (!empty($_SESSION["setting"]["navbutton_help"])) {
            $navbutton = explode("|", $_SESSION["setting"]["navbutton_help"]);
            if (!empty($navbutton[0]))
                $icon_class = $navbutton[0];
            if (!empty($navbutton[1]))
                $button_class = $navbutton[1];
            if (!empty($navbutton[2]))
                $title = $navbutton[2];
        }
        if ($_SESSION["login"]["framework"] == "webspira")
            $button_title = $title;
        if ($page == "edit") {
            $edit_navbutton["field"][$i]["pro_mode"]                  = "index";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class . " help";
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = "Help";
            $edit_navbutton["field"][$i]["input_attr"]["href"]        = "dashboard.php" . $url . "&sm=help_index";
            $edit_navbutton["field"][$i]["input_attr"]["target"]      = "_blank";
            $i++;
            $edit_navbutton["field"][$i]["anti_mode"]                 = "index";
            $edit_navbutton["field"][$i]["input_element"]             = "a";
            $edit_navbutton["field"][$i]["input_float"]               = "right";
            $edit_navbutton["field"][$i]["input_attr"]["class"]       = $button_class;
            $edit_navbutton["field"][$i]["input_attr"]["value"]       = "<i class='" . $icon_class . "' title='" . $title . "'></i> " . $button_title;
            $edit_navbutton["field"][$i]["input_attr"]["data-toggle"] = "tooltip";
            $edit_navbutton["field"][$i]["input_attr"]["title"]       = "Help";
            $edit_navbutton["field"][$i]["input_attr"]["href"]        = "dashboard.php" . $url . "&sm=help_edit";
            $edit_navbutton["field"][$i]["input_attr"]["target"]      = "_blank";
            $i++;
        }
    }
    return $edit_navbutton;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>