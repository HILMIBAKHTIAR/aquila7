<?php
date_default_timezone_set('Asia/Jakarta');
include $config["webspira"] . "functions/get_ipaddress.php";
include $config["webspira"] . "functions/check_column.php";
include $config["webspira"] . "functions/generate_menu.php";
include $config["webspira"] . "functions/generate_restriction_account.php";

if (strstr($config["webspira"], "webspira"))
    $_SESSION["login"]["framework"] = "webspira";
else 
    $_SESSION["login"]["framework"] = "pelangi";

if (isset($config["variabel"]))
    $setting_tabel  = $config["variabel"];
else 
    $setting_tabel  = "shwebspira"; 

$_SESSION["login"]["nomor"]     = $mhadmin_array["nomor"];
$_SESSION["login"]["kode"]      = $mhadmin_array["kode"];
$_SESSION["login"]["nama"]      = $mhadmin_array["nama"];
$_SESSION["login"]["ipaddress"] = get_ipaddress();
$_SESSION["login"]["grup"]      = $mhadmin_array["nomormhadmingrup"];
$_SESSION["login"]["tipe"]      = $mhadmin_array["grup_tipe"];
$_SESSION["login"]["tingkatan"] = $mhadmin_array["grup_tingkatan"];
$_SESSION["login"]["level"]     = $mhadmin_array["grup_tingkatan"];
$_SESSION["login"]["cabang"]    = $mhadmin_array["nomormhcabang"];
$_SESSION["cabang"]["nomor"]    = $mhadmin_array["nomormhcabang"];
$_SESSION["cabang"]["kode"]     = $mhadmin_array["cabang_kode"];
$_SESSION["cabang"]["nama"]     = $mhadmin_array["cabang_nama"];
$_SESSION["cabang"]["pusat"]    = $mhadmin_array["cabang_pusat"];

mysqli_query($con, "\nINSERT INTO rhaktivitasadmin (\n\tnomormhadmin,\n\tipaddress,\n\taksi_menu_kode,\n\taksi_menu_judul\n) VALUES (\n\t" . $_SESSION["login"]["nomor"] . ",\n\t'" . $_SESSION["login"]["ipaddress"] . "',\n\t'login',\n\t'Login'\n)");

$shaksesmaster_query = mysqli_query($con, "\nSELECT a.*\nFROM shaksesmaster a\nWHERE a.status_aktif = 1\nAND a.nomormhadmin = " . $_SESSION["login"]["nomor"]);
while ($shaksesmaster_array = mysqli_fetch_array($shaksesmaster_query)) 
{
    if (empty($_SESSION["akses_string"][$shaksesmaster_array["relasi_tipe"]]))
        $_SESSION["akses_string"][$shaksesmaster_array["relasi_tipe"]] = "";
    else
        $_SESSION["akses_string"][$shaksesmaster_array["relasi_tipe"]] .= ",";

    $_SESSION["akses_string"][$shaksesmaster_array["relasi_tipe"]] .= $shaksesmaster_array["relasi_nomor"];
    if (empty($_SESSION["akses_array"][$shaksesmaster_array["relasi_tipe"]]))
        $_SESSION["akses_array"][$shaksesmaster_array["relasi_tipe"]] = array();

    array_push($_SESSION["akses_array"][$shaksesmaster_array["relasi_tipe"]], $shaksesmaster_array["relasi_nomor"]);
}

$query_additional   = "";
$hak_akses_exists   = check_column($con, 'shmenu', 'hak_akses');
if($hak_akses_exists)
    $query_additional .= "b.hak_akses AS menu_hak_akses,";
$hidden_exists      = check_column($con, 'shmenu', 'hidden');
if($hidden_exists)
    $query_additional .= "b.hidden AS menu_hidden,";

if ($_SESSION["login"]["nomor"] != 1) 
{
    $shaksesmenu_query = mysqli_query($con, "\n\tSELECT a.*,\n\tb.kode AS menu_kode, b.nama AS menu_nama, b.judul AS menu_judul, b.ikon AS menu_ikon,\n\tb.daftar_cabang AS menu_daftar_cabang, " . $query_additional . " b.daftar_header AS menu_daftar_header, b.keterangan AS menu_keterangan\n\tFROM shaksesmenu a\n\tJOIN shmenu b ON a.nomorshmenu = b.nomor AND b.status_aktif > 0\n\tWHERE a.status_aktif = 1\n\tAND a.nomormhadmingrup = " . $_SESSION["login"]["grup"]);

    $priv_view_all_exists   = check_column($con, 'shaksesmenu', 'priv_view_all');
    $priv_backdate_exists   = check_column($con, 'shaksesmenu', 'priv_backdate');
    
    while ($shaksesmenu_array = mysqli_fetch_array($shaksesmenu_query)) 
    {
        if($hak_akses_exists)
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["hak_akses"]        = $shaksesmenu_array["menu_hak_akses"];
        else 
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["hak_akses"]        = 1;

        if($hidden_exists)
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["hidden"]           = $shaksesmenu_array["menu_hidden"];
        else 
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["hidden"]           = 0;

        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["kode"]                 = $shaksesmenu_array["menu_kode"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["nama"]                 = $shaksesmenu_array["menu_nama"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["judul"]                = $shaksesmenu_array["menu_judul"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["keterangan"]           = $shaksesmenu_array["menu_keterangan"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["ikon"]                 = $shaksesmenu_array["menu_ikon"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["daftar_cabang"]        = $shaksesmenu_array["menu_daftar_cabang"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["daftar_header"]        = $shaksesmenu_array["menu_daftar_header"];
    
        if($_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["hak_akses"] == 1)
        {   
            if($priv_view_all_exists)
                $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["view_all"] = $shaksesmenu_array["priv_view_all"];
            else
                $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["view_all"] = 1;
            if($priv_backdate_exists)
                $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["backdate"] = $shaksesmenu_array["priv_backdate"];
            else
                $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["backdate"] = 1;
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["open"]         = $shaksesmenu_array["priv_open"];
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["add"]          = $shaksesmenu_array["priv_add"];
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["edit"]         = $shaksesmenu_array["priv_edit"];
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["delete"]       = $shaksesmenu_array["priv_delete"];
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["print"]        = $shaksesmenu_array["priv_print"];
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["approve"]      = $shaksesmenu_array["priv_approve"];
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["disapprove"]   = $shaksesmenu_array["priv_disapprove"];
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["skipapproval"] = $shaksesmenu_array["priv_skipapproval"];
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["reject"]       = $shaksesmenu_array["priv_reject"];
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["close"]        = $shaksesmenu_array["priv_close"];
        }
        else
        {
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["open"]         = 1;
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["view_all"]     = 1;
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["add"]          = 1;
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["edit"]         = 1;
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["delete"]       = 1;
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["print"]        = 1;
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["approve"]      = 1;
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["disapprove"]   = 1;
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["skipapproval"] = 1;
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["backdate"]     = 1;
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["reject"]       = 1;
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["close"]        = 1;
        }
    }
} 
elseif ($_SESSION["login"]["nomor"] == 1) 
{
    $shaksesmenu_query = mysqli_query($con, "\n\tSELECT b.kode AS menu_kode, b.nama AS menu_nama, b.judul AS menu_judul, b.ikon AS menu_ikon,\n\tb.daftar_cabang AS menu_daftar_cabang, " . $query_additional . " b.daftar_header AS menu_daftar_header, b.keterangan AS menu_keterangan\n\tFROM shmenu b \n\tWHERE b.status_aktif > 0");
    while ($shaksesmenu_array = mysqli_fetch_array($shaksesmenu_query)) 
    {
        if($hak_akses_exists)
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["hak_akses"]        = $shaksesmenu_array["menu_hak_akses"];
        else 
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["hak_akses"]        = 1;

        if($hidden_exists)
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["hidden"]           = $shaksesmenu_array["menu_hidden"];
        else 
            $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["hidden"]           = 0;

        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["kode"]                 = $shaksesmenu_array["menu_kode"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["nama"]                 = $shaksesmenu_array["menu_nama"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["judul"]                = $shaksesmenu_array["menu_judul"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["keterangan"]           = $shaksesmenu_array["menu_keterangan"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["ikon"]                 = $shaksesmenu_array["menu_ikon"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["daftar_cabang"]        = $shaksesmenu_array["menu_daftar_cabang"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["daftar_header"]        = $shaksesmenu_array["menu_daftar_header"];
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["open"]         = 1;
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["view_all"]     = 1;
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["add"]          = 1;
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["edit"]         = 1;
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["delete"]       = 1;
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["print"]        = 1;
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["approve"]      = 1;
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["disapprove"]   = 1;
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["skipapproval"] = 1;
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["backdate"]     = 1;
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["reject"]       = 1;
        $_SESSION["menu_" . $shaksesmenu_array["menu_kode"]]["priv"]["close"]        = 1;
    }
}

$shmenu_akses = "";
$shmenu_akses_additional = "";
if($hak_akses_exists)
    $shmenu_akses_additional .= "OR a.hak_akses = 0";
if ($_SESSION["login"]["nomor"] != 1)
    $shmenu_akses = "\n\tAND (a.nomor IN (\n\t\tSELECT DISTINCT z.nomorshmenu\n\t\tFROM shaksesmenu z\n\t\tWHERE z.status_aktif = 1\n\t\tAND (z.priv_open > 0\n\t\tAND z.nomormhadmingrup = " . $_SESSION["login"]["grup"] . ") ".$shmenu_akses_additional . ")\n\t)";

$shmenu_query_additional = "";
if($hidden_exists)
    $shmenu_query_additional .= "AND a.hidden = 0";
$shmenu_query            = mysqli_query($con, "\nSELECT a.*\nFROM shmenu a\nWHERE a.status_aktif = 1 " . $shmenu_query_additional . "\n" . $shmenu_akses . "\nORDER BY a.urutan");
$_SESSION["g.menu_html"] = "";
if (!empty($shmenu_query)) 
{
    while ($shmenu_object = mysqli_fetch_object($shmenu_query))
        $menu[$shmenu_object->nomorshmenu][] = $shmenu_object;
    if (!empty($menu))
        $_SESSION["g.menu_html"] = generate_menu($menu);
}

$_SESSION["setting"]["environment"] = "Development";
$shwebspira_query = mysqli_query($con, "\nSELECT a.*\nFROM " . $setting_tabel . " a\nWHERE a.status_aktif = 1");
while ($shwebspira_array = mysqli_fetch_array($shwebspira_query))
    $_SESSION["setting"][$shwebspira_array["kode"]] = $shwebspira_array["nilai"];
$shvariabel_query = mysqli_query($con, "\nSELECT b.*\nFROM shvariabel b\nWHERE b.status_aktif = 1");
while ($shvariabel_array = mysqli_fetch_array($shvariabel_query))
{
    $_SESSION["setting"][$shvariabel_array["kode"]]["nilai"] = $shvariabel_array["nilai"];
    $_SESSION["setting"][$shvariabel_array["kode"]]["label"] = $shvariabel_array["label"];
}

// DEFAULT PREFERENCE
$_SESSION["fonts_size"]     = $_SESSION["setting"]["fonts_size"];
$_SESSION["bg_sidebar"]     = $_SESSION["setting"]["bg_sidebar"];
$_SESSION["active_menu"]    = $_SESSION["setting"]["active_menu"];
$_SESSION["bgimg_sidebar"]  = $_SESSION["setting"]["bgimg_sidebar"];
$_SESSION["menu_position"]  = $_SESSION["setting"]["menu_position"];
$_SESSION["toogle_sidebar"] = $_SESSION["setting"]["toogle_sidebar"];

// PREFERENCE
$preference_rows = mysqli_num_rows(mysqli_query($con, " SELECT * FROM shpreference WHERE nomormhadmin = ".$mhadmin_array["nomor"]));
if($preference_rows > 0) 
{
    $preference = mysqli_fetch_array(mysqli_query($con, " SELECT * FROM shpreference WHERE nomormhadmin = ".$mhadmin_array["nomor"]));
    $_SESSION["fonts_size"]     = $preference["fonts_size"];
    $_SESSION["bg_sidebar"]     = $preference["bg_sidebar"];
    $_SESSION["toogle_sidebar"] = $preference["toogle_sidebar"];
    $_SESSION["active_menu"]    = $preference["active_menu"];
    $_SESSION["bgimg_sidebar"]  = $preference["bgimg_sidebar"];
    $_SESSION["menu_position"]  = $preference["menu_position"];
}
// END PREFERENCE

$_SESSION["setting"]["restriction_account"] = generate_restriction_account($con);
$_SESSION["setting"]["logout"]              = "index.php";
if (!empty($_POST["url"]))
    $_SESSION["setting"]["logout"] = "pages/" . $_POST["url"];
die("<meta http-equiv='refresh' content='0;URL=dashboard.php'>");
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>