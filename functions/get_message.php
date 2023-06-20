<?php
function get_message($no, $additional = "")
{   
    $err_icon = ' <span style="color:#e74c3c">&#10008;</span>';
    if (empty($no))
        $no = 100;
    $message[100] = "";
    $message[101] = "Masih Ada Required Field yang Belum Terisi" . $err_icon;
    $message[103] = "Detail Transaksi Belum Didefinisikan". $err_icon;
    $message[105] = "Terjadi Penginputan Data Kembar";
    $message[106] = "Detail Telah Terisi". $err_icon;
    $message[107] = "Kode Telah Terpakai Pada Record Sebelumnya". $err_icon;
    $message[108] = "Barang Penyusun Belum Didefinisikan". $err_icon;
    $message[109] = "Terjadi penginputan data yang sama pada waktu yang sama". $err_icon;
    $message[201] = "Record Sudah Terpakai dan Tidak Dapat Dihapus";
    $message[202] = "Record Sudah Terpakai dan Tidak Dapat Diedit";
    $message[203] = "Record Sudah Terposting dan Tidak Dapat Dihapus";
    $message[204] = "Record Sudah Terposting dan Tidak Dapat Diedit";
    $message[205] = "Record Sudah Tidak Berlaku dan Tidak Dapat Dihapus";
    $message[206] = "Record Sudah Tidak Berlaku dan Tidak Dapat Diedit";
    $message[207] = "Record Sudah Terpakai dan Tidak Dapat Dibatalkan". $err_icon;
    $message[301] = "Password yang dimasukkan salah. Periksa apakah tombol Caps Lock sudah dimatikan sebelum mengetikkan password". $err_icon;
    $message[302] = "Password Lama Salah". $err_icon;
    $message[303] = "Password Baru dan Konfirmasi Password Salah". $err_icon;
    $message[304] = "Username tidak ditemukan". $err_icon;
    $message[305] = "Login gagal, periksa username atau password". $err_icon;
    $message[306] = "Otorisasi user tidak mencakup menu <b>%add%</b>";
    $message[307] = "Backup Database Berhasil". $err_icon;
    $message[308] = "Restore Database Berhasil". $err_icon;
    $message[309] = "User ID / Password Salah". $err_icon;
    $message[310] = "Otorisasi cabang aktif tidak mencakup menu <b>%add%</b>, silahkan ganti cabang terlebih dahulu";
    $message[401] = "Konversi Satuan Tidak Boleh Nol". $err_icon;
    $message[402] = "Stok Gudang Tidak Cukup". $err_icon;
    $message[501] = "Tanggal Transaksi Lebih Besar dari Tanggal Saldo Awal". $err_icon;
    $message[502] = "Cek Kode Valuta / Kurs";
    $message[503] = "Cek Koneksi Header";
    $message[504] = "Nilai Tranksaksi Melebihi Limit". $err_icon;
    $message[505] = "Uang Muka Harus Terbayar Lunas". $err_icon;
    $message[506] = "Cek Koneksi Header dengan Detail". $err_icon;
    $message[507] = "Alokasi Melebihi Sisa yang Harus Dibayar". $err_icon;
    $message[700] = "Apakah Anda yakin?";
    $message[701] = "Error yang tidak diketahui, segera hubungi administrator untuk bantuan". $err_icon;
    $message[702] = "<b>%add%</b> berhasil";
    $message[703] = "<b>%add%</b> belum berhasil". $err_icon;
    $message[704] = "Error database transactions, segera hubungi administrator untuk bantuan". $err_icon;
    $message[705] = "Error generate kode, segera hubungi administrator untuk bantuan". $err_icon;
    $message[709] = "Biarkan password kosong jika tidak ingin mengubah";
    $message[710] = "Selesaikan proses penginputan terlebih dahulu agar baris transaksi dapat dihapus". $err_icon;
    $message[711] = "Grid belum valid, mohon periksa kembali data detail transaksi yang diinputkan". $err_icon;
    $message[712] = "Data header transaksi belum valid". $err_icon;
    $message[713] = "Data tidak ditemukan";
    $message[714] = "Data penunjang belum lengkap". $err_icon;
    $message[715] = "Keyword masih kosong". $err_icon;
    $message[716] = "Data detail transaksi belum valid". $err_icon;
    $message[717] = "Cabang yang sedang aktif tidak sesuai dengan data yang ingin ditambahkan atau diubah";
    $message[718] = "Periode Akuntansi sudah ditutup";
    $message[719] = "Data transaksi sudah diapprove";
    $message[720] = "Total Debet tidak sama dengan Total Kredit". $err_icon;
    $message[721] = "Ditemukan penambahan/perubahan pada menu Master Account yang belum sinkron terhadap menu Setting Laporan.<br />Segera hubungi administrator untuk bantuan.";
    $message[722] = "User Anda diblokir.<br />Segera hubungi administrator untuk bantuan.". $err_icon;
    $message[801] = "Isi field berikut ini belum valid: <br>";
    $message[802] = "Data grid <b>%add%</b> belum valid: <br>";
    $message[803] = "Baris ke - ";
    $message[804] = " Kolom ";
    $message[805] = $err_icon;
    if (!empty($additional))
        $message[$no] = str_replace("%add%", $additional, $message[$no]);
    return $message[$no];
}
?>
<?php
/*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/
?>