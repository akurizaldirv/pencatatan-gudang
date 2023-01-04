<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
$data = getData("SELECT * FROM WARNA ORDER BY ID_WARNA");
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
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
			<h1 class="h2 my-5">Daftar Warna</h1>

			<a href="tambahWarna.php" class="mx-5"><button class="btn btn-warning ">
				<img src="../assets/img/add-icon.svg" width="25px" height="25px" class="me-2"> Tambah Warna</button>
			</a>
			<div class="table-responsive mx-5 mt-3">
				<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th scope="col" class="table-dark">No.</th>
						<th scope="col" class="table-dark">ID</th>
						<th scope="col" class="table-dark">Nama Warna</th>
						<th scope="col" class="table-dark">Action</th>
					</tr>
				</thead>
				<tbody>
				<?php $i = 1; ?>
					<?php foreach($data as $row) :?>
					<tr>
						<td><?= $i ?></td>
						<td><?= $row['ID_WARNA'] ?></td>
						<td><?= $row['NAMA_WARNA'] ?></td>
						<td>
							<a href="editWarna.php?id_warna=<?= $row['ID_WARNA'] ?>" title="Sunting Data"><img alt="Sunting Data" src="../assets/img/edit3-icon.svg" width="25px" height="25px"></img></a>
							<a href="deleteWarna.php?id_warna=<?= $row['ID_WARNA'] ?>" onClick="return confirm('Hapus Data Warna ini?')" title="Hapus Data"><img alt="Hapus Data" src="../assets/img/delete2-icon.svg" width="25px" height="25px" class="ms-2"></img></a>
						</td>
					</tr>
					<?php $i++ ?>
					<?php endforeach ?>
					</tbody>
			</table>
			</div>
		</main>
	  </div>
	</div>
</body>
</html>