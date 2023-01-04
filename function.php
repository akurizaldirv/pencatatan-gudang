<?php
$db = new SQLite3($_SERVER['DOCUMENT_ROOT']."/gudang sepatu.db");
date_default_timezone_set("Asia/Jakarta");

function getData($data){
    global $db;
    $result = $db->query($data);
    $rows = [];
    while($row = $result->fetchArray()){
        $rows[] = $row;
    };

    return $rows;
}

function sessionLoginCheck($level){
    if (isset($_SESSION['login'])) {
        if ($_SESSION['level'] != 'LVL001' and $level == 'LVL001') {
            return false;
        }
        elseif ($_SESSION['level'] != 'LVL002' and $level == 'LVL002') {
            return false;
        }
    } else {
        return false;
    }
    return true;
}

function updateProfile($data){
    global $db;
    $username = $data['username'];
    $nama_admin = $data['nama_admin'];
    $notelp_admin = $data['notelp_admin'];
    $email_admin = $data['email_admin'];

    $query = "UPDATE ADMIN SET NAMA_ADMIN = '$nama_admin', NOTELP_ADMIN = '$notelp_admin', EMAIL_ADMIN = '$email_admin' WHERE USERNAME = '$username'";
    $db->exec($query);
    return $db->changes();
}

function changePass($data){
    global $db;
    $username = $data['username'];
    $newpass = base64_encode($data['passbaru']);
    $query = "UPDATE ADMIN SET PASSWORD = '$newpass' WHERE USERNAME = '$username'";
    $db->exec($query);
    return $db->changes();
}

function resetPass($user){
    global $db;
    $query = "UPDATE ADMIN SET PASSWORD = NULL WHERE USERNAME = '$user'";
    $db->exec($query);
    return $db->changes();
}

function tambahAdmin($data){
    global $db;
    $username = strtolower($data['username']);
    $notelp = $data['notelp'];
    $email = $data['email'];
    $nama = $data['nama'];
    $query = "INSERT INTO 'ADMIN' VALUES ('$username', 'LVL002', NULL, '$nama', '$notelp', '$email')";
    $db->exec($query);
    return $db->changes();
}
 
function editAdmin($data){
    global $db;
    $username = strtolower($data['username']);
    $notelp = $data['notelp'];
    $email = $data['email'];
    $nama = $data['nama'];
    $query = "UPDATE ADMIN SET NAMA_ADMIN = '$nama', NOTELP_ADMIN = '$notelp', EMAIL_ADMIN = '$email' WHERE USERNAME = '$username'";
    $db->exec($query);
    return $db->changes();
}

function deleteAdmin($username){
    global $db;
    $query = "DELETE FROM ADMIN WHERE USERNAME = '$username'";
    $db->exec($query);
    return $db->changes();
}

function tambahMerk($data){
    global $db;

    $nama = $data['nama'];
    $notelp = $data['notelp'];
    $email = $data['email'];
    $id_kota = $data['kabupaten'];
    $alamat = $data['alamat'];
    $id_merk = generateNum($id_kota, "MERK", "ID_MERK");

    $query = "INSERT INTO MERK VALUES ('$id_merk', '$id_kota', '$nama', '$notelp', '$email', '$alamat')";
    $db->exec($query);

    return $db->changes();
}

function editMerk($data){
    global $db;

    $nama = $data['nama'];
    $notelp = $data['notelp'];
    $email = $data['email'];
    $id_kota = $data['kabupaten'];
    $id_merk = $data['id_merk'];
    $id_new = $id_merk;
    $oldData = getData("SELECT * FROM MERK WHERE ID_MERK = '$id_merk'")[0];
    if ($id_kota != $oldData['ID_KOTA']) {
        $id_new = generateNum($id_kota, "MERK", "ID_MERK");
    }
    try {
        $query = "UPDATE MERK SET ID_MERK = '$id_new', NAMA_MERK = '$nama', ID_KOTA = '$id_kota', NOTELP_MERK = '$notelp', EMAIL_MERK = '$email' WHERE ID_MERK = '$id_merk'";
        $db->exec($query);
    } catch (Exception $e) {
        return 0;
    }  

    return $db->changes();
}

function deleteMerk($id_merk){
    global $db;
    $query = "DELETE FROM PENGIRIM_MERK WHERE ID_MERK = '$id_merk'";
    $db->exec($query);
    $query = "DELETE FROM MERK WHERE ID_MERK = '$id_merk'";
    $db->exec($query);
    return $db->changes();
}

function tambahPengirim($data){
    global $db;

    $nama = $data['nama'];
    $namacp = $data['namacp'];
    $notelpcp = $data['notelpcp'];
    $email = $data['email'];
    $id_kota = $data['kabupaten'];
    $alamat = $data['alamat'];
    $id_pengirim = generateNum("G".$id_kota, "PENGIRIM", "ID_PENGIRIM");
    $query = "INSERT INTO PENGIRIM VALUES ('$id_pengirim', '$id_kota', '$nama', '$email', '$notelpcp', '$namacp', '$alamat')";
    $db->exec($query);

    $query2 = "INSERT INTO PENGIRIM_MERK VALUES ";
    foreach ($data['insertMerk'] as $key) {
        $query2 .= "('$key', '$id_pengirim'), ";
    }
    $query2 = substr($query2, 0, -2);
    $db->exec($query2);

    return $db->changes();
}

function editPengirim($data){
    global $db;

    $id_pengirim = $data['id_pengirim'];
    $nama = $data['nama'];
    $namacp = $data['namacp'];
    $notelpcp = $data['notelpcp'];
    $email = $data['email'];
    $id_kota = $data['kabupaten'];
    try {
        $daftar_insertMerk =  getData("SELECT * FROM 'PENGIRIM_MERK' WHERE ID_PENGIRIM = '$id_pengirim'");
        $daftar_idMerk = [];
        foreach ($daftar_insertMerk as $key) {
            $daftar_idMerk[] = $key['ID_MERK'];
        }
        $insertMerk = $data['insertMerk'];
        $delMerk = array_diff($daftar_idMerk, $insertMerk);
        $addMerk = array_diff($insertMerk, $daftar_idMerk);
        $id_new = $id_pengirim;
        $oldData = getData("SELECT * FROM PENGIRIM WHERE ID_PENGIRIM = '$id_pengirim'")[0];
        if ($id_kota != $oldData['ID_KOTA']) {
            $id_new = generateNum("G".$id_kota, "PENGIRIM", "ID_PENGIRIM");
        }
        $query = "UPDATE PENGIRIM SET ID_PENGIRIM = '$id_new', NAMA_PENGIRIM = '$nama', ID_KOTA = '$id_kota', NOTELP_CP = '$notelpcp', NAMA_CP = '$namacp', EMAIL_PENGIRIM = '$email' WHERE ID_PENGIRIM = '$id_pengirim'";
        $db->exec($query);
        foreach ($delMerk as $key) {
            $query = "DELETE FROM PENGIRIM_MERK WHERE ID_MERK = '$key' AND ID_PENGIRIM = 'id_pengirim'";
            $db->exec($query);    
        }
        foreach ($addMerk as $key) {
            $query = "INSERT INTO PENGIRIM_MERK VALUES('$key', '$id_pengirim')";
            $db->exec($query);    
        }
    } catch (Exception $e) {
        return 0;
    }
    return $db->changes();
}

function deletePengirim($id_pengirim){
    global $db;
    $query = "DELETE FROM PENGIRIM WHERE ID_PENGIRIM = '$id_pengirim'";
    $db->exec($query);
    $query = "DELETE FROM PENGIRIM_MERK WHERE ID_PENGIRIM = '$id_pengirim'";
    $db->exec($query);
    return $db->changes();
}

function tambahKategori($data){
    global $db;

    $nama = $data['nama'];
    $id_kategori = formatID("KTG", "", 6, "KATEGORI", "ID_KATEGORI");
    $query = "INSERT INTO KATEGORI VALUES ('$id_kategori', '$nama')";
    $db->exec($query);

    return $db->changes();
}

function editKategori($data){
    global $db;

    $id_kategori = $data['id_kategori'];
    $nama = $data['nama'];

    $query = "UPDATE KATEGORI SET NAMA_KATEGORI = '$nama' WHERE ID_KATEGORI = '$id_kategori'";
    $db->exec($query);

    return $db->changes();
}

function deleteKategori($id_kategori){
    global $db;
    $query = "DELETE FROM KATEGORI WHERE ID_KATEGORI = '$id_kategori'";
    $db->exec($query);
    return $db->changes();
}

function tambahWarna($data){
    global $db;

    $nama = $data['nama'];
    $id_warna = formatID("W", "", 4, "WARNA", "ID_WARNA");
    $query = "INSERT INTO WARNA VALUES ('$id_warna', '$nama')";
    $db->exec($query);

    return $db->changes();
}

function editWarna($data){
    global $db;

    $id_warna = $data['id_warna'];
    $nama = $data['nama'];
    $query = "UPDATE WARNA SET NAMA_WARNA = '$nama' WHERE ID_WARNA = '$id_warna'";
    $db->exec($query);

    return $db->changes();
}

function deleteWarna($id_warna){
    global $db;
    $query = "DELETE FROM WARNA_BARANG WHERE ID_WARNA = '$id_warna'";
    $db->exec($query);
    $query = "DELETE FROM WARNA WHERE ID_WARNA = '$id_warna'";
    $db->exec($query);
    return $db->changes();
}

function tambahBarang($data){
    global $db;

    $nama = $data['nama'];
    $merk = $data['merk'];
    $kategori = $data['kategori']; 
    $nama_merk = getData("SELECT NAMA_MERK FROM MERK WHERE ID_MERK = '$merk'")[0]['NAMA_MERK'];
    $id_barang = formatID("", $nama_merk, 6, "BARANG", 'ID_BARANG');

    $query = "INSERT INTO BARANG VALUES ('$id_barang', '$kategori', '$merk', '$nama')";
    $db->exec($query);
    $query2 = "INSERT INTO WARNA_BARANG VALUES ";
    foreach ($data['insertWarna'] as $key) {
        $query2 .= "('$id_barang', '$key'), ";
    }
    $query2 = substr($query2, 0, -2);
    $db->exec($query2);

    return $db->changes();
}

function editBarang($data){
    global $db;

    $nama = $data['nama'];
    $merk = $data['merk'];
    $kategori = $data['kategori']; 
    $id_barang = $data['id_barang'];
    $insertWarna = $data['insertWarna'];
    $daftar_insertWarna =  getData("SELECT * FROM 'WARNA_BARANG' WHERE ID_BARANG = '$id_barang'");
    $daftar_idWarna = [];
    foreach ($daftar_insertWarna as $key) {
        $daftar_idWarna[] = $key['ID_WARNA'];
    }

    $delWarna = array_diff($daftar_idWarna, $insertWarna);
    $addWarna = array_diff($insertWarna, $daftar_idWarna);
    foreach ($delWarna as $key) {
        $query = "DELETE FROM WARNA_BARANG WHERE ID_WARNA = '$key' AND ID_BARANG = '$id_barang'";
        $db->exec($query);    
    }
    foreach ($addWarna as $key) {
        $query = "INSERT INTO WARNA_BARANG VALUES('$id_barang', '$key')";
        $db->exec($query);    
    }

    $query = "UPDATE BARANG SET NAMA_BARANG = '$nama', ID_MERK = '$merk', ID_KATEGORI = '$kategori' WHERE ID_BARANG = '$id_barang'";
    $db->exec($query);

    return $db->changes();
}

function deleteBarang($id_barang){
    global $db;
    $query = "DELETE FROM BARANG WHERE ID_BARANG = '$id_barang'";
    $db->exec($query);
    $query = "DELETE FROM WARNA_BARANG WHERE ID_BARANG = '$id_barang'";
    $db->exec($query);
    return $db->changes();
}

function catat($data, $pengirim, $pencatat){
    global $db;
    $id_faktur = catatFaktur($pengirim, $pencatat);
    if ($id_faktur == null) {
        return 0;
    }
    $query2 = "INSERT INTO PENCATATAN VALUES ";
    foreach ($data as $key) {
        $query2 .= "('$id_faktur', '$key[1]', '$key[2]', '$key[3]', '$key[4]'),";
    }
    $query2 = substr($query2, 0, -1);
    $db->exec($query2);
    if ($db->changes() == null) {
        $delQuery = "DELETE FROM FAKTUR WHERE ID_FAKTUR = '$id_faktur'";
        $db->exec($delQuery);
        return 0;
    }
    return $db->changes();
}

function catatFaktur($pengirim, $pencatat){
    global $db;
    
    $id_faktur = generateNum("F".date("dmy"), "FAKTUR", "ID_FAKTUR");
    $query = "INSERT INTO FAKTUR VALUES ('$id_faktur', '$pencatat', '$pengirim', datetime('now', 'localtime'))";
    $db->exec($query);
    if ($db->changes() != 0) {
        return $id_faktur;
    } return 0;
}

function editCatat($data, $pengirim, $pencatat, $id_faktur){
    global $db;
    try {
        $db->exec("DELETE FROM PENCATATAN WHERE ID_FAKTUR = '$id_faktur'");
        $query2 = "INSERT INTO PENCATATAN VALUES ";
        foreach ($data as $key) {
            $query2 .= "('$id_faktur', '$key[1]', '$key[2]', '$key[3]', '$key[4]'),";
        }
        $query2 = substr($query2, 0, -1);
        $db->exec($query2);
        $db->exec("UPDATE FAKTUR SET USERNAME = '$pencatat', WAKTU = datetime('now', 'localtime') WHERE ID_FAKTUR = '$id_faktur'");
    } catch (Exception $e) {
        return 0;
    }
    return $db->changes();
}

function deleteFaktur($id_faktur){
    global $db;
    $db->exec("DELETE FROM PENCATATAN WHERE ID_FAKTUR = '$id_faktur'");
    $db->exec("DELETE FROM FAKTUR WHERE ID_FAKTUR = '$id_faktur'");
    return $db->changes();
}

function generateNum($code, $table, $column){
    global $db;
    $a = $code.'%';
    $data = getData("SELECT * FROM $table WHERE $column LIKE '$a' ORDER BY $column DESC ");
    if (count($data) == 0) {
        $num = 1;
    } else {
        $num = (int)str_replace($code, "", $data[0][$column]) + 1;
    }
    $newCode = $code.sprintf("%03d", $num);
    return $newCode;
}

function formatID($a, $char, $lenght, $table, $column){
    $formattedText = strtoupper($a.substr($char, 0, 1));
    $newChar = str_replace(array("(", ")", "-", " "), "", $char);
    $newChar = substr($newChar, 1);
    $newChar = str_replace("NG", "G", strtoupper($newChar));
    $newChar = str_replace(array("E", "I", "A", "U", "O"), "", $newChar);
    $formattedText .= substr($newChar, 0, 2);

    $result = generateNum($formattedText, $table, $column);
    return $result;
}
?>