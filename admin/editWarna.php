<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
$id_warna = $_GET['id_warna'];
$data = getData("SELECT * FROM WARNA WHERE ID_WARNA = '$id_warna'")[0];
if (isset($_POST['submit'])) {
	if (editWarna($_POST)>0) {
		echo "<script>alert('Berhasil Menyunting Warna')</script>";
	} else {
		echo "<script>alert('Gagal Menyunting Warna')</script>";
	}
	echo "<script>window.location.replace('warna.php')</script>";
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
	            <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="warna.php">
	              Daftar Warna
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="barang.php">
	              Daftar Barang
	            </a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link text-light" href="profil.php">
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
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5">
			<h1 class="h2 my-5">Edit Warna</h1>
			<div class="container w-75 py-3">
				<form method="POST" action="">
					<input type="hidden" value="<?php echo $id_warna ?>" name="id_warna">
					<div class="mb-3">
						<label for="nama" name="nama" class="form-label">Nama Warna</label>
						<input type="text" name="nama" class="form-control" id="nama" value="<?php echo $data['NAMA_WARNA'] ?>" required>
					</div>
					<div class="mb-3">
						<button type="submit" class="btn btn-primary" name="submit">Sunting</button>
						<a href="warna.php"><button type="button" class="btn btn-danger" name="cancel">Batal</button></a>
					</div>
				</form>
			</div>
			</div>
		</main>
	  </div>
	</div>
</body>
</html>