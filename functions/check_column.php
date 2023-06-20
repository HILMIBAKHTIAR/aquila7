<?php
function check_column($con, $table, $column)
{
    $query = "SHOW COLUMNS FROM " . $table . " LIKE '" . $column . "'";
    $column_check       = mysqli_num_rows(mysqli_query($con, $query));
    if ($column_check > 0)
        return true;
    
    return false;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-11-;*/
?>