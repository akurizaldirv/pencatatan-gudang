<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
if (deleteWarna($_GET['id_warna']) > 0) {
    echo "<script>alert('Berhasil Menghapus Warna')</script>";
} else {
    echo "<script>alert('Gagal Menghapus Warna')</script>";
}
echo "<script>window.location.replace('warna.php')</script>";
?>