<?php
function formatting_code($con, $string_code = "", $string_date = "", $string_plus = [], $string_cabang = [], $string_pt = [])
{    
    if (empty($string_code))
        return false;
    $formatcode     = mysqli_fetch_array(mysqli_query($con, "SELECT a.* FROM shvariabel a WHERE a.status_aktif = 1 AND a.kode = '" . $string_code . "'"));
    $format         = explode("|", $formatcode["nilai"]);
    $inisial        = $format[0];
    $max_digit      = $format[1];
    $date_format    = $format[2];
    $header         = $format[3];
    $detail         = $format[4];
    $mode           = $format[5];
    $tipe           = $format[6];
    if(isset($format[7]))
        $separator  = $format[7];
    else 
        $separator  = $_SESSION["setting"]["separator_code"];
    $formatted_code = $inisial;
    // if (!empty($date_format)) {
        if (empty($string_date)) 
            $date  = date("Y-m-d");
        else 
            $date  = $string_date;
        $date_part = explode("-", $date);
        $year      = $date_part[0];
        $month     = $date_part[1];
        $day       = $date_part[2];
        $ym        = "";
        if ($date_format == "ym") {
            $y  = substr($year, 2, 2);
            $ym = $y . $month;
        } elseif ($date_format == "my") {
            $y  = substr($year, 2, 2);
            $ym = $month . $y;
        } elseif ($date_format == "Y/m") {
            $ym = $year . "/" . $month;
        }
        $branch = $_SESSION["cabang"]["kode"];
        $pt     = $_SESSION["usaha"]["kode"];
        if(!empty($string_cabang["kode"]))
            $branch = $string_cabang["kode"];
        if(!empty($string_pt["kode"]))
            $pt = $string_pt["kode"];
        if (!empty($tipe)) {
            if ($tipe == "str-cab-tgl")
                $formatted_code = $inisial . $separator . $branch . $separator . $ym . $separator;
            else if ($tipe == "str-cab-otf-tgl")
                $formatted_code = $inisial . $separator . $branch . $separator . $string_plus["otf"] . $separator . $ym . $separator;
            else if ($tipe == "str-otf-tgl")
                $formatted_code = $inisial . $separator . $string_plus["otf"] . $separator . $ym . $separator;
            else if ($tipe == "str-tgl-otf")
                $formatted_code = $inisial . $separator . $ym . $separator . $string_plus["otf"] . $separator;
            else if ($tipe == "str-otf")
                $formatted_code = $inisial . $separator . $string_plus["otf"] . $separator;
            else if ($tipe == "str-tgl")
                $formatted_code = $inisial . $separator . $ym . $separator;
            else if ($tipe == "cab-str")
                $formatted_code = $branch . $separator . $inisial . $separator;
            else if ($tipe == "cab-otf")
                $formatted_code = $branch . $separator . $string_plus["otf"] . $separator;
            else if ($tipe == "cab-str-tgl")
                $formatted_code = $branch . $separator . $inisial . $separator . $ym . $separator;
            else if ($tipe == "cab-str-otf-tgl")
                $formatted_code = $branch . $separator . $inisial . $separator . $string_plus["otf"] . $separator . $ym . $separator;
            else if ($tipe == "cab-tgl-otf")
                $formatted_code = $branch . $separator . $ym . $separator . $string_plus["otf"] . $separator;
            else if ($tipe == "otf-cab-tgl")
                $formatted_code = $string_plus["otf"] . $separator . $branch . $separator . $ym . $separator;
            else if ($tipe == "otf-str-tgl")
                $formatted_code = $string_plus["otf"] . $separator . $inisial . $separator . $ym . $separator;
            else if ($tipe == "otf-str")
                $formatted_code = $string_plus["otf"] . $separator . $inisial . $separator;
            else if ($tipe == "otf-tgl")
                $formatted_code = $string_plus["otf"] . $separator . $ym . $separator;
            else if ($tipe == "str-cab-gud-tgl")
                $formatted_code = $inisial . $separator . $branch . $separator . $string_plus["gudang"] . $separator . $ym . $separator;
            else if ($tipe == "str-gud")
                $formatted_code = $string_plus["gudang"] . $separator . $inisial . $separator;
            else if ($tipe == "cab")
                $formatted_code = $branch . $separator;
            else if ($tipe == "str")
                $formatted_code = $inisial . $separator;
            else if ($tipe == "otf")
                $formatted_code = $string_plus["otf"] . $separator;
        } else if (!empty($date_format)) 
            $formatted_code =  $branch . $separator . $inisial . $separator . $ym . $separator;
    // }
    if (!empty($mode) && $mode == "last") {
        $last        = mysqli_fetch_array(mysqli_query($con, "SELECT a." . $formatcode["label"] . " AS kode FROM " . $header . " a WHERE a." . $_SESSION["setting"]["field_nomor"] . " <> 0 AND a." . $formatcode["label"] . " LIKE '" . $formatted_code . "%' ORDER BY a." . $formatcode["label"] . " DESC LIMIT 0,1"));
        $code        = explode($formatted_code, $last["kode"]);
        $last_number = $code[1] * 1;
    } else
        $last_number = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(a." . $formatcode["label"] . ") AS last_number FROM " . $header . " a WHERE a." . $_SESSION["setting"]["field_nomor"] . " <> 0 AND a." . $formatcode["label"] . " LIKE '" . $formatted_code . "%'"));
    $new_number       = $last_number["last_number"] + 1;
    $new_number_digit = strlen($new_number);
    if ($new_number_digit == 0)
        $new_number_digit = 1;
    $number = "";
    for ($i = $new_number_digit; $i < $max_digit; $i++)
        $number .= "0";
    $formatted_code .= $number . $new_number;
    return $formatted_code;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>