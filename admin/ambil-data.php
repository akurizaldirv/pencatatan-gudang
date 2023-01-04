<?php

require '../function.php';

if (isset($_POST['provinsi'])) {
    $id_provinsi = $_POST["provinsi"];

    $data = getData("SELECT * FROM 'KOTA/KAB' WHERE ID_PROVINSI = '$id_provinsi'");
    foreach ($data as $key) {
        ?>
        <option value="<?= $key['ID_KOTA'] ?>"><?= ucwords(strtolower($key['NAMA_KOTA'])) ?></option>
        <?php
    }
}

if (isset($_POST['merk'])) {
    $id_merk = $_POST['merk'];

    $data = getData("SELECT * FROM BARANG WHERE ID_MERK = '$id_merk'");
    foreach ($data as $key) {
        ?>
        <option value="<?= $key['ID_BARANG'] ?>"><?= ucwords(strtolower($key['NAMA_BARANG'])) ?></option>
        <?php
    }
}

if (isset($_POST['barang'])) {
    $id_barang = $_POST['barang'];

    $data = getData("SELECT WARNA.ID_WARNA, WARNA.NAMA_WARNA FROM WARNA INNER JOIN WARNA_BARANG WHERE WARNA.ID_WARNA = WARNA_BARANG.ID_WARNA AND ID_BARANG = '$id_barang'");
    foreach ($data as $key) {
        ?>
        <option value="<?= $key['ID_WARNA'] ?>"><?= ucwords(strtolower($key['NAMA_WARNA'])) ?></option>
        <?php
    }
}

?>