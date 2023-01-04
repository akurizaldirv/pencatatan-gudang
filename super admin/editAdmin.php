<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL001')){
	header("Location:	logout.php");
};

$username = $_GET['username'];
$data = getData("SELECT * FROM 'ADMIN' WHERE USERNAME = '$username'")[0];

if (isset($_POST['submit'])) {
	if (editAdmin($_POST)>0) {
		echo "<script>alert('Berhasil Menyunting Admin')</script>";
	} else {
		echo "<script>alert('Gagal Menyunting Admin')</script>";
	}
	echo "<script>window.location.replace('admin.php')</script>";
}

if (isset($_POST['reset'])){
	if (resetPass($username)>0) {
		echo "<script>alert('Berhasil mengatur ulang password')</script>";
	} else {
		echo "<script>alert('Gagal mengatur ulang password')</script>";
	}
	echo "<script>window.location.replace('admin.php')</script>";
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
			<h1 class="h2 my-5">Sunting Admin</h1>
			<div class="container w-75 py-3">
				<form method="POST" action="">
					<input type="hidden" name="username" value="<?php echo $username ?>">
					<div class="mb-3">
						<label for="nama" class="form-label">Nama</label>
						<input type="text" name="nama" class="form-control" id="nama" value="<?php echo $data['NAMA_ADMIN'] ?>" required oninput="this.value = this.value.replace(/[^A-Z a-z]/g, '').replace(/(\..*)\./g, '$1');">
					</div>
					<div class="mb-3">
						<label for="email" class="form-label">E-Mail</label>
						<input type="email" name="email" class="form-control" id="email" value="<?php echo $data['EMAIL_ADMIN'] ?>" required pattern="^[a-zA-Z0-9._-]+@[a-zA-Z]+\.[a-zA-Z]{2,4}$">
					</div>
					<div class="mb-3">
						<label for="notelp" class="form-label">No. Telepon</label>
						<input type="text" class="form-control" id="notelp" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="notelp" value="<?php echo $data['NOTELP_ADMIN'] ?>" id="notelp">
					</div>
					<div class="mb-3">
						<button type="submit" class="btn btn-primary me-1" name="submit">Sunting</button>
						<button type="submit" class="btn btn-warning me-1 text-white" name="reset">Reset Password</button>
						<a href="admin.php"><button type="button" class="btn btn-danger">Batal</button></a>
					</div>
					<div class="form-text"><em>** Reset password berfungsi untuk menghapus password akun admin</em></div>
				</form>
			</div>
			</div>
		</main>
	  </div>
	</div>
</body>
</html>