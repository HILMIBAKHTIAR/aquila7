<?php if($autogrid_override!=1){$autogrid["element"]="element";$autogrid["minlength"]="min_length";$autogrid["url"]="'pages/autocomplete_grid.php'";$autogrid["id"]="id";$autogrid["file"]="file";$autogrid["param_input"]="param_input";$autogrid["param_output"]="param_output";$autogrid["select_function"]=$grid_id."_selected_suggest = ui.item.all;";$autogrid_html="";if(!empty($autogrid_include))foreach($autogrid_include as $setting)include $setting;}$autogrid_html="\n<script language='javascript' type='text/javascript'>\nfunction autocomplete_grid_".$grid_id."(element,min_length,id,file,param_input,param_output){ ";$acomplete_override=1;$acomplete=$autogrid;include $config["webspira"]."codes/autocomplete.php";$autogrid_html.=$acomplete_html;$autogrid_html.="\n}\n</script>"; ?>
<?php /*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/ ?>