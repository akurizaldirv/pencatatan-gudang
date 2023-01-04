<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
if (deletePengirim($_GET['id_pengirim']) > 0) {
    echo "<script>alert('Berhasil Menghapus Pengirim')</script>";
} else {
    echo "<script>alert('Gagal Menghapus Pengirim')</script>";
}
echo "<script>window.location.replace('pengirim.php')</script>";
?>