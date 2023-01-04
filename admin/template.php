<!-- Sintaks PHP -->
<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistem Pencatatan Gudang Sepatu</title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
		.sidebar{
			height: 100vh;
			position: fixed;
		} a {text-decoration: none;}
	</style>
</head>
<body>
	<header class="navbar fixed-top bg-warning flex-md-nowrap shadow-lg py-2">
		<p class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-4 text-dark fw-bold my-auto ms-5">Halaman Admin</p>
  			
  		<div class="nav">
    		<span class="nav-item text-nowrap my-auto fs-5">Selamat Datang, <b><?php echo $_SESSION['username'] ?></b></span>
    		<div class="nav-item text-nowrap">
      			<a class="nav-link mx-5" href="logout.php"><button class="btn btn-danger">Sign out</button></a>
    		</div>
  		</div>
	</header>

	<!-- Bagian Side Navigation Bar -->
	<div class="container-fluid">
	  <div class="row">
	    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
	      <div class="position-sticky pt-3 sidebar-sticky pt-5">
	        <ul class="nav flex-column mt-5">
<!-- nav-item dashboard -->
<li class="nav-item">
    <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="dashboard.php"> Dashboard </a>
</li>
<!-- nav-item daftar pencatatan -->
<li class="nav-item">
    <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="pencatatan.php"> Daftar Pencatatan </a>
</li>
<!-- nav-item daftar merk -->
<li class="nav-item">
    <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="merk.php"> Daftar Merk </a>
</li>
<!-- nav-item daftar pengirim -->
<li class="nav-item">
    <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="pengirim.php"> Daftar Pengirim </a>
</li>
<!-- nav-item daftar kategori -->
<li class="nav-item">
    <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="kategori.php"> Daftar Kategori </a>
</li>
<!-- nav-item daftar warna -->
<li class="nav-item">
    <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="warna.php"> Daftar Warna </a>
</li>
<!-- nav-item daftar barang -->
<li class="nav-item">
    <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="barang.php"> Daftar Barang </a>
</li>
<!-- nav-item sunting profil -->
<li class="nav-item">
    <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="profil.php"> Sunting Profil </a>
</li>
<!-- nav-item ubah password-->
<li class="nav-item">
    <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="password.php"> Ubah Password </a>
</li>
	        </ul>
	      </div>
	    </nav>
		<!-- Kode program content ditulis di bagian ini -->
	  </div>
	</div>
	<!-- Kode program javascript ditulis di bagian ini -->
</body>
</html>