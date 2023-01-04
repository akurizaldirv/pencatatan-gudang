<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL001')){
	header("Location:	logout.php");
};

if (deleteAdmin($_GET['username']) > 0) {
    echo "<script>alert('Berhasil Menghapus Admin')</script>";
} else {
    echo "<script>alert('Gagal Menghapus Admin')</script>";
}
echo "<script>window.location.replace('admin.php')</script>";
?>