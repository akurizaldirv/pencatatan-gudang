<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
if (deleteFaktur($_GET['id_faktur']) > 0) {
    echo "<script>alert('Berhasil Menghapus Faktur')</script>";
} else {
    echo "<script>alert('Gagal Menghapus Faktur')</script>";
}
echo "<script>window.location.replace('pencatatan.php')</script>";
?>