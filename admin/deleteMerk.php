<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};

if (deleteMerk($_GET['id_merk']) > 0) {
    echo "<script>alert('Berhasil Menghapus Merk')</script>";
} else {
    echo "<script>alert('Gagal Menghapus Merk')</script>";
}
echo "<script>window.location.replace('merk.php')</script>";
?>