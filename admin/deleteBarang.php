<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
if (deleteBarang($_GET['id_barang']) > 0) {
    echo "<script>alert('Berhasil Menghapus Barang')</script>";
} else {
    echo "<script>alert('Gagal Menghapus Barang')</script>";
}
echo "<script>window.location.replace('barang.php')</script>";
?>