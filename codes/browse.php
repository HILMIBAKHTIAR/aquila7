<?php
if ($browse_override != 1) {
    $browse["id"]               = "";
    $browse["caption"]          = "Browse";
    $browse["state"]            = "";
    $browse["query"]            = "";
    $browse["query_limit"]      = "";
    $browse["query_order"]      = "";
    $browse["query_search"]     = array();
    $browse["param_input"]      = array();
    $browse["param_output"]     = array();
    $browse["items"]            = array();
    $browse["items_selected"]   = array();
    $browse["selected_url"]     = "";
    $browse["autocomplete_url"] = "";
    $browse["grid"]             = "";
    $browse["grid_editing"]     = "";
    $browse["grid_val"]         = "";
    $browse["grid_values"]      = array();
    $browse["call_function"]    = array();
    $browse["custom_function"]  = "";
    $browse["multiselect"]      = 0;
    $browse["debug"]            = 0;
    if (!empty($browse_include))
        foreach ($browse_include as $setting)
            include $setting;
}
$browse_id                  = "browse_" . $browse["id"];
// $string_url           = "'pages/grid.php?id=" . $browse_id . "'+'&search='+" . $browse_id . "_par_search";
$string_url                 = "'pages/grid.php?id=" . $browse_id . "'";
$string_url_parameter       = $string_url;
$script_reload_parameter    = "
    var browse_search = $('#" . $browse_id . "_search').val();
    var browse_keyword = $('#" . $browse_id . "_keyword').val();
    if(mode == 'open'){
        $('#" . $browse_id . "_keyword').val(browse_search);
    }
    else if(mode == 'edit'){
        $('#" . $browse_id . "_search').val(browse_keyword);
    }
    // if(browse_search != '')
    // {
    //     $('#" . $browse_id . "_keyword').val(browse_search);
    //     $('#" . $browse_id . "_search').val('');
    // }
    " . $browse_id . "_par_search = $('#" . $browse_id . "_keyword').val();
    if(!" . $browse_id . "_par_search)
        " . $browse_id . "_par_search = 0;";

// Multi Selecting
$multiselect_url            = "'pages/multiselect.php?id=" . $browse_id . "'";
$multiselect_url_parameter  = $multiselect_url;
$script_multiselecting      = "";

$session_parameter       = array();
if (!empty($browse["param_input"])) {
    $string_message = get_message(714);
    $i              = 0;
    foreach ($browse["param_input"] as $parameter) {
        $param   = explode("|", $parameter);
        $param_0 = str_replace(".", "", $param[0]);
        $script_reload_parameter .= "\n\t\tvar " . $browse_id . "_par_" . $param_0 . " = $('#" . $param[1] . "').val();\n\t\tif(!" . $browse_id . "_par_" . $param_0 . ")\n\t\t{ ";
        $script_multiselecting .= "\n\t\t\tvar " . $browse_id . "_par_" . $param_0 . " = $('#" . $param[1] . "').val();\n\t\t\tif(!" . $browse_id . "_par_" . $param_0 . ")\n\t\t\t{ ";
        if ($param[4] == "null")
        {
            $script_reload_parameter .= "\n\t\t\t" . $browse_id . "_par_" . $param_0 . " = 'skip';";
            $script_multiselecting .= "\n\t\t\t\t" . $browse_id . "_par_" . $param_0 . " = 'skip';";
        }
        else 
        {
            $script_reload_parameter .= "\n\t\t\t$.alert({title: 'ALERT',content: '" . $string_message . "',icon: 'fa fa-warning',theme: 'modern',type: 'red'});";
            $script_multiselecting .= "\n\t\t\t\t$.alert({title: 'ALERT',content: '" . $string_message . "',icon: 'fa fa-warning',theme: 'modern',type: 'red'});";
        }
        $script_reload_parameter .= "\n\t\t} ";
        $script_multiselecting .= "\n\t\t\t} ";
        $string_url_parameter .= "+'&" . $param_0 . "='+" . $browse_id . "_par_" . $param_0;
        $multiselect_url_parameter .= "+'&" . $param_0 . "='+" . $browse_id . "_par_" . $param_0;
        
        $session_parameter[$i] = $param[0] . "|";
        if (isset($param[2]) && !empty($param[2]))
            $session_parameter[$i] .= $param[2];
        $session_parameter[$i] .= "|";
        if (isset($param[3]) && !empty($param[3]))
            $session_parameter[$i] .= $param[3];
        $i++;
    }
}
$script_reload_parameter .= "\njQuery(" . $browse_id . "_element).jqGrid('setGridParam',\n{\n\turl:" . $string_url_parameter . ",\n\tpostData: {search:". $browse_id . "_par_search },\n\tdatatype:'json',\n\tloadComplete:function(data)\n\t{\n\t\tvar debugging_otf = '';\n\t\tif(data.debug)\n\t\t{\n\t\t\tvar data_debug = 'browse " . $browse_id . " debug : '+data.debug;\n\t\t\tconsole.log(data_debug);\n\t\t\tdebugging_otf = data_debug;\n\t\t}\n\t\tif(data.debug_error)\n\t\t{\n\t\t\tvar data_debug_error = 'browse " . $browse_id . " debug_error : '+data.debug_error;\n\t\t\tconsole.log(data_debug_error);\n\t\t\tdebugging_otf = debugging_otf+'<br /><br />'+data_debug_error;\n\t\t}\n\t\tif(data.debug_count)\n\t\t{\n\t\t\tvar data_debug_count = 'browse " . $browse_id . " debug_count : '+data.debug_count;\n\t\t\tconsole.log(data_debug_count);\n\t\t\tdebugging_otf = debugging_otf+'<br /><br />'+data_debug_count;\n\t\t}\n\t\tif(debugging_otf !== '')\n\t\t\t$('#debugging_otf').html(debugging_otf);\n\t}\n});\njQuery(" . $browse_id . "_element).trigger('reloadGrid');";
if (empty($browse["items_selected"]))
    $browse["items_selected"] = $browse["items"];
$script_selecting = "var " . $browse_id . "_selected = '';";
$i                = 0;
foreach ($browse["items_selected"] as $selected) {
    $sel = explode("|", $selected);
    if (!isset($sel[2])) {
        if ($i != 0)
            $script_selecting .= " " . $browse_id . "_selected += ' - '; ";
        $script_selecting .= " " . $browse_id . "_selected += $(" . $browse_id . "_element).jqGrid('getCell',id,'" . $sel[0] . "'); ";
        $i++;
    }
}
$script_selecting .= "$('#" . $browse_id . "_search').val(" . $browse_id . "_selected); nomor = $(" . $browse_id . "_element).jqGrid('getCell',id,'nomor'); $('#" . $browse_id . "_hidden').val(nomor);";
if (!empty($browse["selected_url"]))
    $script_selecting .= "$('#" . $browse_id . "_selected').html('<a href=\"" . $browse["selected_url"] . "'+nomor+'\" target=\"_blank\">'+" . $browse_id . "_selected+'</a>');";
else
    $script_selecting .= "$('#" . $browse_id . "_selected').html(" . $browse_id . "_selected);";
$script_set_output          = "";
$script_autocomplete_output = "";
if (!empty($browse["param_output"])) {
    $i = 0;
    foreach ($browse["param_output"] as $parameter) {
        $param         = explode("|", $parameter);
        $output_action = "val";
        if ($param[2] == "html") {
            $output_action = $param[2];
        }
        $script_set_output .= "\n\t\tvar " . $browse_id . "_ex_" . $param[0] . " = $(" . $browse_id . "_element).jqGrid('getCell',id,'" . $param[0] . "');\n\t\t$('#" . $param[1] . "')." . $output_action . "(" . $browse_id . "_ex_" . $param[0] . "); ";
        $script_autocomplete_output .= "\n\t\tvar " . $browse_id . "_auto_" . $param[0] . " = selected." . $browse["id"] . "." . $param[0] . ";\n\t\t$('#" . $param[1] . "')." . $output_action . "(" . $browse_id . "_auto_" . $param[0] . "); ";
        $i++;
    }
}
$script_call_custom       = $browse_id . "_afterselect(); ";
$browse_auto["element"]   = "'#" . $browse_id . "_search'";
$browse_auto["minlength"] = $_SESSION["setting"]["autocomplete_minlength"];
if (isset($browse["autocomplete_minlength"]) && $browse["autocomplete_minlength"] != "")
    $browse_auto["minlength"] = $browse["autocomplete_minlength"];
$browse_auto["url"] = "'pages/autocomplete.php'";
$browse_auto["id"]  = "'" . $browse["id"] . "'";
if (!empty($browse["autocomplete_url"]))
    $browse_auto["file"] = "'" . $browse["autocomplete_url"] . "'";
else {
    $browse_auto["file"]                                      = "''";
    $_SESSION["acomplete_" . $browse["id"]]["state"]          = $browse["state"];
    $_SESSION["acomplete_" . $browse["id"]]["query"]          = $browse["query"];
    $_SESSION["acomplete_" . $browse["id"]]["query_limit"]    = $browse["query_limit"];
    $_SESSION["acomplete_" . $browse["id"]]["query_order"]    = $browse["query_order"];
    $_SESSION["acomplete_" . $browse["id"]]["query_search"]   = $browse["query_search"];
    $_SESSION["acomplete_" . $browse["id"]]["param_input"]    = $browse["param_input"];
    $_SESSION["acomplete_" . $browse["id"]]["items"]          = $browse["items"];
    $_SESSION["acomplete_" . $browse["id"]]["items_visible"]  = $browse["items_visible"];
    $_SESSION["acomplete_" . $browse["id"]]["items_selected"] = $browse["items_selected"];
    $_SESSION["acomplete_" . $browse["id"]]["debug"]          = $browse["debug"];
    if (isset($browse["query_sp"])) {
        $_SESSION["acomplete_" . $browse["id"]]["query_sp"] = $browse["query_sp"];
    } else {
        unset($_SESSION["acomplete_" . $browse["id"]]["query_sp"]);
    }
}
$browse_auto["param_input"] = "'";
if (!empty($browse["param_input"])) {
    foreach ($browse["param_input"] as $param_input)
        $browse_auto["param_input"] .= $param_input . ",";
}
$browse_auto["param_input"] .= "'";
$browse_auto["param_output"] = "'";
if (!empty($browse["param_output"])) {
    foreach ($browse["param_output"] as $param_output)
        $browse_auto["param_output"] .= $param_output . ",";
}
$browse_auto["param_output"] .= "'";
if (!empty($browse["selected_url"]))
    $html_selected = "'<a href=\"" . $browse["selected_url"] . "'+selected." . $browse["id"] . ".nomor+'\" target=\"_blank\">'+selected.result+'</a>'";
else
    $html_selected = "selected.result";
$browse_auto["select_function"] = "\nif(selected." . $browse["id"] . " !== undefined)\n{\n\t$('#" . $browse_id . "_hidden').val(selected." . $browse["id"] . ".nomor);\n\t$('#" . $browse_id . "_selected').html(" . $html_selected . ");\n\t" . $script_autocomplete_output . "\n\t" . $script_call_custom . "\n}";

// Multi Selecting
$multiselect_query     = trim(preg_replace('/\s\s+/', ' ',  $browse["query"]));
$script_multiselecting .= "  
            var " . $browse_id . "_multi_nomor = '';
            var " . $browse_id . "_multi_selected = '';
            var " . $browse_id . "_multi_selected_url = '';
            var length_ids = ids.length;
            var currentPage = jQuery(" . $browse_id . "_element).getGridParam('page').toString();
            var selected_row = jQuery(" . $browse_id . "_element).getGridParam('selectedNomor').toString();
            $('#" . $browse_id . "_hidden').val(jQuery(" . $browse_id . "_element).data(currentPage)); 
            var multiselect_query = \"" . $multiselect_query . "\";
            var multiselect_nomor = \"". $browse["multiselect_nomor"] . "\";
            var selected_data = [];
            var obj=$.dialog({
              icon: 'fa fa-spinner fa-spin',
              title: 'Please Wait..',
              draggable: false,
              animation: 'scale',
              content: '<font style=\"font-size:14px\">Retreiving Data..</font>',
              buttons: {
                ok: {
                    isHidden: true,
                  }
              },
              onOpen: function () {
                    $.ajax({
                        url : " . $multiselect_url_parameter . ",
                        type: 'POST',
                        data: { multiselect_nomor: multiselect_nomor,
                                multiselect_query: multiselect_query, 
                                selected_row: selected_row 
                            },
                        success: function(data) {
                            obj.close();
                            selected_data = JSON.parse(data);
                            for(var c = 0; c < selected_data.length; c++)
                            {
                                var id = selected_data[c];
                                if(c > 0)
                                {
                                    " . $browse_id . "_multi_nomor += ',';
                                    " . $browse_id . "_multi_selected += ' | ';
                                    " . $browse_id . "_multi_selected_url += ' | ';
                                }
                                var nomor = selected_data[c]['nomor'];
                                " . $browse_id . "_multi_nomor += nomor;";
if (!empty($browse["selected_url"]))
    $script_multiselecting .= "\n\t\t\t\t\t\t\t\t\t" . $browse_id . "_multi_selected_url += '<a href=\"" . $browse["selected_url"] . "'+nomor+'\" target=\"_blank\">'";
$i = 0;
foreach ($browse["items_selected"] as $selected) {
    $sel = explode("|", $selected);
    if (!isset($sel[2])) {
        if ($i != 0)
            $script_multiselecting .= "\n\t\t\t\t\t\t\t\t\t" . $browse_id . "_multi_selected += ' - ';\n\t\t\t\t\t\t" . $browse_id . "_multi_selected_url += ' - ';";
        $script_multiselecting .= "\n\t\t\t\t\t\t\t\t\t" . $browse_id . "_multi_selected += selected_data[c]['" . $sel[0] . "'];\n\t\t\t\t\t\t\t\t\t" . $browse_id . "_multi_selected_url += selected_data[c]['" . $sel[0] . "'];";
        $i++;
    }
}
if (!empty($browse["selected_url"]))
    $script_multiselecting .= "\n\t\t\t\t\t\t\t\t\t" . $browse_id . "_multi_selected_url += '</a>'";
$script_multiselecting .= "\n\t\t\t\t\t\t\t\t}\n\t\t\t\t\t\t\t$('#" . $browse_id . "_hidden').val(" . $browse_id . "_multi_nomor);\n\t\t\t\t\t\t\t$('#" . $browse_id . "_search').val(" . $browse_id . "_multi_selected);";
if (!empty($browse["selected_url"]))
    $script_multiselecting .= "\n\t\t\t\t\t\t\t$('#" . $browse_id . "_selected').html(" . $browse_id . "_multi_selected_url);";
else
    $script_multiselecting .= "\n\t\t\t\t\t\t\t$('#" . $browse_id . "_selected').html(" . $browse_id . "_multi_selected);";
$script_multiselecting .= "\n\n\t\t\t\t\t\t\t" . $script_call_custom;
$script_multiselecting .= "\n\t\t\t\t\t\t}\n\t\t\t\t\t});\n\t\t\t\t}\n\t\t\t});";

$acomplete_override             = 1;
$acomplete                      = $browse_auto;
include $config["webspira"] . "codes/autocomplete.php";
$browse_grid["id"]                = $browse_id;
$browse_grid["type"]              = "browse";
$browse_grid["var"]["par_search"] = 0;
$browse_grid["pre_script"]        = "
    <script language='javascript' type='text/javascript'>
        function " . $browse_id . "_reload(mode = 'open')
        {
            " . $script_reload_parameter . "
        }
        function " . $browse_id . "_reloadopen()
        {
            " . $browse_id . "_reload();
            browse_open('" . $browse["id"] . "');
        }
        function " . $browse_id . "_selectclose(id)
        {
            " . $script_selecting . "
            " . $script_set_output . "
            " . $script_call_custom . "
            $.unblockUI({});
            $('#" . $browse_id . "_area').attr('class','hiding');
        }
        function " . $browse_id . "_multiselectclose()
        {
            var ids = jQuery(" . $browse_id . "_element).jqGrid('getGridParam','selarrrow');
            " . $script_multiselecting . "
            $.unblockUI({});
            $('#" . $browse_id . "_area').attr('class','hiding');
        }
     </script>";
$browse_grid["pre_dom"]           = "\n" . $acomplete_html . "\n$('#" . $browse_id . "_open').click(function()\n{\n\t" . $browse_id . "_reloadopen();\n});\n$('#" . $browse_id . "_search').on('keyup',function(e)\n{\n\tif(e.which === " . $_SESSION["setting"]["browse_key"] . ")\n\t{\n\t\t" . $browse_id . "_reloadopen();\n\t}\n});\n$('#" . $browse_id . "_keyword').change(function()\n{\n\t" . $browse_id . "_reload('edit');\n});\n$('#" . $browse_id . "_area').on('keyup',function(e)\n{\n\tif(e.which === " . $_SESSION["setting"]["browse_key"] . ")\n\t{\n\t\tbrowse_closing('" . $browse["id"] . "');\n\t}\n});";
if (empty($browse["caption"]))
    $browse["caption"] = "Browse " . ucfirst($browse["id"]);
$browse_grid["option"]["caption"]  = "'" . $browse["caption"] . "'";
$session_column                    = array();
$browse_grid["option"]["colNames"] = "";
$browse_grid["colmodel"]           = array();
$i                                 = 0;
foreach ($browse["items"] as $items) {
    if ($i > 0)
        $browse_grid["option"]["colNames"] .= ",";
    $item = explode("|", $items);
    if (empty($item[1]))
        $item[1] = ucfirst($item[0]);
    if (empty($item[2]) || $item[2] != "true")
        $item[2] = "false";
    if (empty($item[3]))
        $item[3] = "coltemplate_browsedefault";
    $session_column[$i] = $item[0];
    $browse_grid["option"]["colNames"] .= "'" . $item[1] . "'";
    $browse_grid["colmodel"][$i]["name"]     = "'" . $item[0] . "'";
    $browse_grid["colmodel"][$i]["index"]    = "'" . $item[0] . "'";
    $browse_grid["colmodel"][$i]["hidden"]   = $item[2];
    $browse_grid["colmodel"][$i]["template"] = $item[3];
    if (!empty($item[4]))
        $browse_grid["colmodel"][$i]["width"] = $item[4];
    $i++;
}
$browse_grid["option"]["selectedNomor"] = "''";
$browse_grid["option"]["datatype"]      = "'local'";
$browse_grid["option"]["gridview"]      = "true";
$browse_grid["option"]["height"]        = $_SESSION["setting"]["browse_height"];
$browse_grid["option"]["ondblClickRow"] = "function(id){ " . $browse_id . "_selectclose(id); }";
if ($browse["multiselect"] == 1){
    $browse_grid["option"]["multiselect"] = "true";
    $browse_grid["option"]["ondblClickRow"] = "null";
    $browse_grid["option"]["gridComplete"] = "function(id){   
        //retrieve any previously stored rows for this page and re-select them
        var retrieveSelectedRows = $(this).getGridParam('selectedNomor');
        var saveSelectedRows = '0';
        
        if(typeof retrieveSelectedRows !== 'undefined'){
            var retrieveSelectedRows = String(retrieveSelectedRows).split(',');
            var ids = $(this).jqGrid('getDataIDs');
            var allRowNomor = []; 
            for (var j = 0; j < ids.length; j++) 
            {
                var rowId = ids[j];
                var rowData = $(this).jqGrid ('getRowData', rowId);
                if(retrieveSelectedRows.includes(rowData.nomor)){
                    $(this).jqGrid('setSelection', rowId, true);
                }
                allRowNomor[j] = rowData.nomor;
            }

            for (var j = 0; j < retrieveSelectedRows.length; j++) 
            {
                if(!allRowNomor.includes(retrieveSelectedRows[j]) && typeof retrieveSelectedRows[j] !== 'undefined' && retrieveSelectedRows[j] != '' && retrieveSelectedRows[j] != '0'){
                    saveSelectedRows += ',' + retrieveSelectedRows[j];
                }
            }
        }
        else{
            // Set Default Selected On First Time
            var defaultSelectedNomor = $('#" . $browse_id . "_hidden').val(); 
            if(defaultSelectedNomor != ''){
                saveSelectedRows = defaultSelectedNomor;
                var defaultSelectedNomor = String(defaultSelectedNomor).split(',');
            
                var ids = $(this).jqGrid('getDataIDs');
                for (var j = 0; j < ids.length; j++) 
                {
                    var rowId = ids[j];
                    var rowData = $(this).jqGrid ('getRowData', rowId);
                    if(defaultSelectedNomor.includes(rowData.nomor)){
                        $(this).jqGrid('setSelection', rowId, true);
                    }
                }
            }
        }

        var selectedRows = $(this).getGridParam('selarrrow');
        var totalPage = $(this).getGridParam('lastpage'); 

        if(selectedRows != ''){
            selectedRows = String(selectedRows).split(',');
            for(var i = 0; i < selectedRows.length; i++){
                var rowData = $(this).jqGrid ('getRowData', selectedRows[i]);
                var selectedArray = String(saveSelectedRows).split(',');
                if(!selectedArray.includes(rowData.nomor) && typeof rowData.nomor !== 'undefined' && rowData.nomor != ''){
                    saveSelectedRows += ',' + rowData.nomor;
                }
            }  
        }

        $(this).setGridParam({selectedNomor: saveSelectedRows});
    }";
    // $browse_grid["option"]["onPaging"] = "function(id){  
    // }";
    $browse_grid["option"]["onSelectAll"] = "function(id){
        //retrieve any previously stored rows for this page and re-select them
        var retrieveSelectedRows = $(this).getGridParam('selectedNomor');
        var saveSelectedRows = '0';
        
        if(typeof retrieveSelectedRows !== 'undefined'){
            var retrieveSelectedRows = String(retrieveSelectedRows).split(',');
            var ids = $(this).jqGrid('getDataIDs');
            var allRowNomor = []; 
            for (var j = 0; j < ids.length; j++) 
            {
                var rowId = ids[j];
                var rowData = $(this).jqGrid ('getRowData', rowId);
                // if(retrieveSelectedRows.includes(rowData.nomor)){
                //     $(this).jqGrid('setSelection', rowId, true);
                // }
                allRowNomor[j] = rowData.nomor;
            }

            for (var j = 0; j < retrieveSelectedRows.length; j++) 
            {
                if(!allRowNomor.includes(retrieveSelectedRows[j]) && typeof retrieveSelectedRows[j] !== 'undefined' && retrieveSelectedRows[j] != '' && retrieveSelectedRows[j] != '0'){
                    saveSelectedRows += ',' + retrieveSelectedRows[j];
                }
            }
        }

        var selectedRows = $(this).getGridParam('selarrrow');
        var totalPage = $(this).getGridParam('lastpage'); 
        
        if(selectedRows != ''){
            selectedRows = String(selectedRows).split(',');
            for(var i = 0; i < selectedRows.length; i++){
                var rowData = $(this).jqGrid ('getRowData', selectedRows[i]);
                var selectedArray = String(saveSelectedRows).split(',');
                if(!selectedArray.includes(rowData.nomor) && typeof rowData.nomor !== 'undefined' && rowData.nomor != ''){
                    saveSelectedRows += ',' + rowData.nomor;
                }
            }
        }

        $(this).setGridParam({selectedNomor: saveSelectedRows});    
    }";
    $browse_grid["option"]["onSelectRow"] = "function(id){
        //retrieve any previously stored rows for this page
        var retrieveSelectedRows = $(this).getGridParam('selectedNomor');
        var saveSelectedRows = '0';
        
        if(typeof retrieveSelectedRows !== 'undefined'){
            var retrieveSelectedRows = String(retrieveSelectedRows).split(',');
            var ids = $(this).jqGrid('getDataIDs');
            var allRowNomor = []; 
            for (var j = 0; j < ids.length; j++) 
            {
                var rowId = ids[j];
                var rowData = $(this).jqGrid ('getRowData', rowId);
                allRowNomor[j] = rowData.nomor;
            }

            for (var j = 0; j < retrieveSelectedRows.length; j++) 
            {
                if(!allRowNomor.includes(retrieveSelectedRows[j]) && typeof retrieveSelectedRows[j] !== 'undefined' && retrieveSelectedRows[j] != '' && retrieveSelectedRows[j] != '0'){
                    saveSelectedRows += ',' + retrieveSelectedRows[j];
                }
            }
        }

        var selectedRows = $(this).getGridParam('selarrrow');
        var totalPage = $(this).getGridParam('lastpage'); 
        
        if(selectedRows != ''){
            selectedRows = String(selectedRows).split(',');
            for(var i = 0; i < selectedRows.length; i++){
                var rowData = $(this).jqGrid ('getRowData', selectedRows[i]);
                var selectedArray = String(saveSelectedRows).split(',');
                if(!selectedArray.includes(rowData.nomor) && typeof rowData.nomor !== 'undefined' && rowData.nomor != ''){
                    saveSelectedRows += ',' + rowData.nomor;
                }
            }
        }

        $(this).setGridParam({selectedNomor: saveSelectedRows});
    }";
}
$browse_grid["option"]["rownumbers"]  = "true";
$browse_grid["option"]["rowNum"]      = $_SESSION["setting"]["browse_rownum"];
$browse_grid["option"]["rowList"]     = $_SESSION["setting"]["browse_rowlist"];
$browse_grid["option"]["url"]         = $string_url;
$browse_grid["option"]["viewrecords"] = "true";
$browse_grid["option"]["width"]       = $_SESSION["setting"]["browse_width"];
// $browse_grid["option"]["autowidth"]   = "true";
// $browse_grid["option"]["shrinkToFit"] = "true";
$browse_grid["column_autoaddrow"]     = 0;
$browse_grid["filtertoolbar"]         = 0;
$browse_grid["navgrid"]               = 0;
$browse_grid["class_area"]            = "hiding";
$browse_grid["additional_area"]       = "";
if ($browse["multiselect"] == 1)
    $browse_grid["additional_area"] .= "<input type='button' class='btn-default' style='position:inherit' value='Choose Checked' onclick='" . $browse_id . "_multiselectclose()' />";
$browse_grid["additional_area"] .= "";
$browse_grid["query"]       = $browse["query"];
$browse_grid["query_order"] = $browse["query_order"];
$browse_grid["debug"]       = $browse["debug"];
$browse_grid["parameter"]   = $session_parameter;
$browse_grid["column"]      = $session_column;
$browse_grid["search"]      = $browse["query_search"];
if (!empty($script_call_custom)) {
    $browse_grid["post_script"] = "\n\t<script language='javascript' type='text/javascript'>\n\tfunction " . $browse_id . "_afterselect()\n\t{";
    if (!empty($browse["grid"])) {
        if (!empty($browse["grid_editing"]))
            $browse_grid["post_script"] .= "\n\t\t\tvar " . $browse_id . "_search = $('#" . $browse_id . "_search').val();\n\t\t\t$('#'+" . $browse["grid"] . "_editing_iRow+'_" . $browse["grid_editing"] . "').val(" . $browse_id . "_search);\n\t\t\t$('#" . $browse_id . "_search').val('');";
        if (!empty($browse["grid_val"]))
            $browse_grid["post_script"] .= "\n\t\t\tvar " . $browse_id . "_hidden = $('#" . $browse_id . "_hidden').val();\n\t\t\tjQuery(" . $browse["grid"] . "_element).jqGrid('setCell'," . $browse["grid"] . "_editing_rowid,'" . $browse["grid_val"] . "'," . $browse_id . "_hidden);";
        if (!empty($browse["grid_values"])) {
            foreach ($browse["grid_values"] as $values) {
                $value = explode("|", $values);
                if (empty($value[1]))
                    $value[1] = $value[0];
                $browse_grid["post_script"] .= "\n\t\t\t\tvar " . $value[1] . " = $('#" . $value[1] . "').val();\n\t\t\t\tjQuery(" . $browse["grid"] . "_element).jqGrid('setCell'," . $browse["grid"] . "_editing_rowid,'" . $value[0] . "'," . $value[1] . ");";
            }
        }
    }
    if (!empty($browse["call_function"])) {
        foreach ($browse["call_function"] as $function) {
            $func     = explode("|", $function);
            $func_par = "()";
            if (!empty($func[1]))
                $func_par = "(" . $func[1] . ")";
            $browse_grid["post_script"] .= "\n\t\t\t" . $func[0] . $func_par . ";";
        }
    }
    if (!empty($browse["custom_function"])) {
        ob_start();
        include "contents/browse/" . $browse["custom_function"];
        $custom_function_html = ob_get_contents();
        ob_end_clean();
        $browse_grid["post_script"] .= $custom_function_html;
    }
    $browse_grid["post_script"] .= "\n\t}\n\t</script>";
}
$browse_grid["input_search"] = "\n<div class='box-content'>\n\t<div class='col-sm-6 text-left'>\n\t\t<div id='' class='dataTables_filter' style='width: 100% !important;padding-right: 12%'>\n\t\t\t<label style='width: 100% !important'>\n\t\t\t\t<input class='' id='" . $browse_id . "_keyword' name='" . $browse_id . "_keyword' placeholder='browse search' value='' />\n\t\t\t</label>\n\t\t</div>\n\t</div>\n\t<div class='col-sm-1 col-sm-offset-5 text-right' style='padding-top: 7px'>\n\t\t<button class='btn btn-default btn-app-sm' id='" . $browse_id . "_close'><i class='fa fa-times'></i></button>\n\t</div>\n\t<div class='clearfix'></div>\n</div>";
$grid_override               = 1;
$grid                        = $browse_grid;
include $config["webspira"] . "codes/grid.php";
array_push($_SESSION["g.browse_html"], $grid_html);
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>