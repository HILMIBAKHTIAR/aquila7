<?php
function visible_index_column($name)
{
    if(isset($_SESSION["menu_".$_SESSION["g.menu"]]["filter_selected_columns"])){
        if(count($_SESSION["menu_".$_SESSION["g.menu"]]["filter_selected_columns"]) > 0){
            if(in_array($name, $_SESSION["menu_".$_SESSION["g.menu"]]["filter_selected_columns"])){
                return "true";
            }else{
                return "false";
            }
        }else{
            return "true";
        }
    }else{
        return "true";
    }
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-11-;*/
?>