<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};

if (deleteKategori($_GET['id_kategori']) > 0) {
    echo "<script>alert('Berhasil Menghapus Kategori')</script>";
} else {
    echo "<script>alert('Gagal Menghapus Kategori')</script>";
}
echo "<script>window.location.replace('kategori.php')</script>";
?>