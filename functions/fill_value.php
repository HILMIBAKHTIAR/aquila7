<?php
function fill_value($edit, $data = [])
{
    $max = count($edit["field"]);
    for ($i = 0; $i < $max; $i++) {
        if (!isset($edit["field"][$i]["input_value"]) && !isset($edit["field"][$i]["input_attr"]["value"])) {
            $string_browse = "";
            if ($edit["field"][$i]["input_element"] == "browse")
                $string_browse = "browse|";
            $edit["field"][$i]["input_value"] = $data[$string_browse . $edit["field"][$i]["input"]];
            if (isset($number_type))
                unset($number_type);
            if (!empty($edit["field"][$i]["input_class"]))
                $number_type = search_number_type($edit["field"][$i]["input_class"]);
            if (!empty($edit["field"][$i]["input_attr"]["class"]))
                $number_type = search_number_type($edit["field"][$i]["input_attr"]["class"]);
            if (!empty($number_type))
                $edit["field"][$i]["input_value"] = number_formatting($edit["field"][$i]["input_value"], $number_type);
            if (search_picker_class($edit["field"][$i]["input_class"], "date_class_autoformat"))
                if(str_replace("\'", "'", $edit["field"][$i]["input_value"]) != $_SESSION["setting"]["default_date"])
                    $edit["field"][$i]["input_value"] = str_replace("\'", "'", $edit["field"][$i]["input_value"]);
                else 
                    $edit["field"][$i]["input_value"] = "";
            else if (search_picker_class($edit["field"][$i]["input_class"], "datetime_class_autoformat"))
                if(str_replace("\'", "'", $edit["field"][$i]["input_value"]) != $_SESSION["setting"]["default_datetime"])
                    $edit["field"][$i]["input_value"] = str_replace("\'", "'", $edit["field"][$i]["input_value"]);
                else
                    $edit["field"][$i]["input_value"] = "";
            else if (search_picker_class($edit["field"][$i]["input_class"], "month_class_autoformat"))
                if(str_replace("\'", "'", $edit["field"][$i]["input_value"]) != $_SESSION["setting"]["default_date"])
                    $edit["field"][$i]["input_value"] = str_replace("\'", "'", $edit["field"][$i]["input_value"]);
                else
                    $edit["field"][$i]["input_value"] = "";
            else if (search_picker_class($edit["field"][$i]["input_class"], "year_class_autoformat"))
                if(str_replace("\'", "'", $edit["field"][$i]["input_value"]) != $_SESSION["setting"]["default_date"])
                    $edit["field"][$i]["input_value"] = str_replace("\'", "'", $edit["field"][$i]["input_value"]);
                else
                    $edit["field"][$i]["input_value"] = "";
            else
                 $edit["field"][$i]["input_value"] = str_replace("\'", "'", $edit["field"][$i]["input_value"]);
        }
    }
    return $edit;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>