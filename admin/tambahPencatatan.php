<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
$daftar_pengirim = getData("SELECT * FROM PENGIRIM");
if (isset($_POST['tambahPengirim'])) {
    $_SESSION['tempPengirim'] = $_POST['pengirim'];
	echo "<script>window.location.replace('catat.php')</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistem Pencatatan Gudang Sepatu</title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style type="text/css">
    	.sidebar{
    		height: 100vh;
    		position: fixed;
    	}
    </style>
</head>
<body>
	<header class="navbar fixed-top bg-warning flex-md-nowrap shadow-lg py-2">
		<p class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-4 text-dark fw-bold my-auto ms-5">Halaman Admin</p>
  			
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
	            <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="pencatatan.php">
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
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
			<h1 class="h2 my-5">Pilih Pengirim</h1>

			<div class="table-responsive mx-5 mt-3">
				<form action="" method="post">
					<select class="form-select mb-3" name="pengirim" id="pengirim" required>
					<?php foreach ($daftar_pengirim as $row) :?>
						<option value="<?= $row['ID_PENGIRIM']?>" <?= ($_SESSION['tempPengirim'] == $row['ID_PENGIRIM']) ? 'selected' : '' ?>><?=ucwords(strtolower($row['NAMA_PENGIRIM']))?></option>
					<?php endforeach ?>
					</select>
					<button name="tambahPengirim" id="tambahPengirim" type="submit" class="btn btn-primary text-light">Simpan</button>
					<a href="pencatatan.php"><button name="tambahPengirim" id="tambahPengirim" type="button" class="btn btn-danger">Batal</button></a>
				</form>
			</table>
			</div>
		</main>
	  </div>
	</div>
</body>
</html>