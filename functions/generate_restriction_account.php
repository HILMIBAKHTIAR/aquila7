<?php
function generate_restriction_account($con)
{
    $start      = mysqli_query($con, "SELECT distinct b.kode FROM mhaccountsetting a JOIN mhaccount b ON a.nomormhaccountawal = b.nomor WHERE a.status_aktif = 1 ORDER BY b.kode");
    $finish     = mysqli_query($con, "SELECT distinct b.kode FROM mhaccountsetting a JOIN mhaccount b ON a.nomormhaccountakhir = b.nomor WHERE a.status_aktif = 1 ORDER BY b.kode");
    $diff       = mysqli_query($con, "\n\tSELECT b.kode AS awal, c.kode AS akhir\n\tFROM mhaccountsetting a\n\tJOIN mhaccount b ON a.nomormhaccountawal = b.nomor\n\tJOIN mhaccount c ON a.nomormhaccountakhir = c.nomor\n\tWHERE a.status_aktif = 1\n\tAND a.nomormhaccountawal <> a.nomormhaccountakhir\n\tORDER BY b.kode");
    $accounts   = array();
    $rows_start = @mysqli_num_rows($start);
    if ($rows_start > 0)
        while ($account = mysqli_fetch_array($start))
            if (!in_array($account["kode"], $accounts))
                array_push($accounts, $account["kode"]);
    $rows_finish = @mysqli_num_rows($finish);
    if ($rows_finish > 0)
        while ($account = mysqli_fetch_array($finish))
            if (!in_array($account["kode"], $accounts))
                array_push($accounts, $account["kode"]);
    $rows_diff = @mysqli_num_rows($diff);
    if ($rows_diff > 0) {
        while ($account = mysqli_fetch_array($diff)) {
            $range      = mysqli_query($con, "SELECT a.kode FROM mhaccount a WHERE a.status_aktif = 1 AND a.kode BETWEEN " . $account["awal"] . " AND " . $account["akhir"]);
            $rows_range = mysqli_num_rows($range);
            if ($rows_range > 0)
                while ($acc = mysqli_fetch_array($range))
                    if (!in_array($acc["kode"], $accounts))
                        array_push($accounts, $acc["kode"]);
        }
    }
    $restricted = "";
    if (count($accounts) > 0)
        foreach ($accounts as $account)
            $restricted .= $account . ", ";
    // $restricted .= $account;
    return $restricted;
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>