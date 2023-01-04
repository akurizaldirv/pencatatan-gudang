<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
$username = $_SESSION['username'];
$data = getData("SELECT * FROM ADMIN WHERE USERNAME = '$username'")[0];

if (isset($_POST['submit'])) {
	if(updateProfile($_POST)>0){
	   echo "<script>alert('Berhasil Mengubah Data')</script>";
	} else {
	   echo "<script>alert('Gagal Mengubah Data')</script>";
	};
	echo "<script>window.location.replace('profil.php')</script>";
}
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
		}
	</style>
</head>
<body>
	<header class="navbar fixed-top bg-warning flex-md-nowrap shadow-lg py-2">
		<p class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-3 text-dark fw-bold my-auto ms-5">Halaman Admin</p>      			
  		<div class="nav">
    		<span class="nav-item text-nowrap my-auto fs-5">Selamat Datang, <b><?php echo $_SESSION['username'] ?>!</b></span>
    		<div class="nav-item text-nowrap">
      			<a class="nav-link mx-5" href="logout.php"><button class="btn btn-danger">Sign out</button></a>
    		</div>
  		</div>
	</header>

	<div class="container-fluid">
	  <div class="row">

	  	<!-- Sidebar -->
	    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
	      <div class="position-sticky pt-3 sidebar-sticky pt-5">
	        <ul class="nav flex-column mt-5">
	          <li class="nav-item">
	            <a class="nav-link text-light" href="dashboard.php">
	              Dashboard
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="pencatatan.php">
	              Daftar Pencatatan
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="merk.php">
	              Daftar Merk
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="pengirim.php">
	              Daftar Pengirim
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="kategori.php">
	              Daftar Kategori
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="warna.php">
	              Daftar Warna
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="barang.php">
	              Daftar Barang
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="profil.php">
	              Sunting Profil
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="password.php">
	              Ubah Password
	            </a>
	          </li>
	        </ul>
	      </div>
	    </nav>

	    <!-- Menu -->
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
			<h1 class="h2 my-5">Sunting Profil</h1>
			<div class="container w-50 pt-3">
				<form method="POST" action="">
					<input type="hidden" name="username" value="<?php echo $username ?>">
					<div class="mb-3">
						<label for="nama" class="form-label">Nama</label>
						<input type="text" name="nama_admin" value="<?php echo $data['NAMA_ADMIN'] ?>" class="form-control" id="nama" required oninput="this.value = this.value.replace(/[^A-Z a-z]/g, '').replace(/(\..*)\./g, '$1');">
					</div>
					<div class="mb-3">
						<label for="notelp" class="form-label">No. Telepon</label>
						<input type="tel" name="notelp_admin" value="<?php echo $data['NOTELP_ADMIN']?>" class="form-control" id="notelp" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
					</div>
					<div class="mb-3">
						<label for="email" class="form-label">E-Mail</label>
						<input type="email" name="email_admin" value="<?php echo $data['EMAIL_ADMIN'] ?>" class="form-control" id="email" required pattern="^[a-zA-Z0-9._-]+@[a-zA-Z]+\.[a-zA-Z]{2,4}$">
					</div>
					<div class="mb-3">
						<button type="submit" name="submit" class="btn btn-primary">Sunting</button>
					</div>
				</form>
			</div>
			</div>
		</main>
	  </div>
	</div>
</body>
</html>