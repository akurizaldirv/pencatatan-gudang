<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL001')){
	header("Location:	logout.php");
};

if (isset($_POST['submit'])) {
    $username = strtolower($_POST['username']);
    $searchUsername = getData("SELECT * FROM ADMIN WHERE USERNAME = '$username'");
    if (count($searchUsername) == 0) {
        if (tambahAdmin($_POST)>0) {
            echo "<script>alert('Berhasil Menambah Admin')</script>";
        } else {
            echo "<script>alert('Gagal Menambah Admin')</script>";
        }
        echo "<script>window.location.replace('admin.php')</script>";
    } else {
        echo "<script>alert('Username Sudah Tersedia')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistem Pencatatan Gudang Sepatu</title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome icons (free version)-->
    <!-- <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script> -->

    <style type="text/css">
    	.sidebar{
    		height: 100vh;
    		position: fixed;
    	}
    </style>
</head>
<body>
<header class="navbar fixed-top bg-warning flex-md-nowrap shadow-lg py-2">
		<p class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-3 text-dark fw-bold my-auto ms-5">Halaman Super Admin</p>      			
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
	            <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="admin.php">
	              Daftar Admin
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

	    <!-- Menu -->
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5">
			<h1 class="h2 my-5">Tambah Admin</h1>
			<div class="container w-75 py-3">
				<form method="POST" action="">
					<div class="mb-3">
						<label for="nama" class="form-label">Nama</label>
						<input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama Admin" required oninput="this.value = this.value.replace(/[^A-Z a-z]/g, '').replace(/(\..*)\./g, '$1');">
					</div>
					<div class="mb-3">
						<label for="email" class="form-label">E-Mail</label>
						<input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email Admin" required pattern="^[a-zA-Z0-9._-]+@[a-zA-Z]+\.[a-zA-Z]{2,4}$">
					</div>
					<div class="mb-3">
						<label for="notelp" class="form-label">No. Telepon</label>
						<input type="text" class="form-control" id="notelp" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Nomor Telepon" name="notelp" id="notelp">
					</div>
					<div class="mb-3">
						<label for="username" class="form-label">Username</label>
						<input type="text" name="username" class="form-control" id="username" placeholder="Masukkan Username Admin" required oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g, '').replace(/(\..*)\./g, '$1');">
					</div>
					<div class="mb-3">
						<button type="submit" class="btn btn-primary me-1" name="submit">Tambah</button>
						<a href="admin.php"><button type="button" class="btn btn-danger">Batal</button></a>
					</div>
				</form>
			</div>
			</div>
		</main>
	  </div>
	</div>
</body>
</html>