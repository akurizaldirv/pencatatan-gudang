<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};

$data_pencatatan = getData("SELECT FAKTUR.ID_FAKTUR, FAKTUR.ID_PENGIRIM, FAKTUR.WAKTU, PENCATATAN.ID_BARANG, PENCATATAN.UKURAN, PENCATATAN.JUMLAH FROM FAKTUR INNER JOIN PENCATATAN ON FAKTUR.ID_FAKTUR = PENCATATAN.ID_FAKTUR");
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

	<div class="container-fluid">
	  <div class="row">
	    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
	      <div class="position-sticky pt-3 sidebar-sticky pt-5">
	        <ul class="nav flex-column mt-5">
	          <li class="nav-item">
	            <a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="dashboard.php">
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
		<h1 class="h2 mt-5 mb-3">Dashboard</h1>
			<div class="row">
			<div class="col">
				<a href="merk.php">
					<div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
						<div class="card-header fs-5">Total Merk</div>
						<div class="card-body">
							<p style="font-size: 70px; margin: 0px;">
								<?php echo getData("SELECT COUNT(*) FROM MERK")[0][0]; ?>
							</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col">
				<a href="pengirim.php">
					<div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
						<div class="card-header fs-5">Total Pengirim</div>
						<div class="card-body">
							<p style="font-size: 70px; margin: 0px;">
								<?php echo getData("SELECT COUNT(*) FROM PENGIRIM")[0][0]; ?>
							</p>
						</div>
					</div>
				</a>
			</div><div class="col">
				<a href="kategori.php">
					<div class="card text-white bg-info mb-3" style="max-width: 18rem;">
						<div class="card-header fs-5">Total Kategori</div>
						<div class="card-body">
							<p style="font-size: 70px; margin: 0px;">
								<?php echo getData("SELECT COUNT(*) FROM KATEGORI")[0][0]; ?>
							</p>
						</div>
					</div>
				</a>
			</div><div class="col">
				<a href="barang.php">
					<div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
						<div class="card-header fs-5">Total Barang</div>
						<div class="card-body">
							<p style="font-size: 70px; margin: 0px;">
								<?php echo getData("SELECT COUNT(*) FROM BARANG")[0][0]; ?>
							</p>
						</div>
					</div>
				</a>
			</div>
			</div>
			<h2 class="mt-5">Daftar Pencatatan</h2>
			<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
				<tr>
					<th scope="col">ID Faktur</th>
					<th scope="col">Pengirim</th>
					<th scope="col">Waktu</th>
					<th scope="col">Barang</th>
					<th scope="col">Ukuran</th>
					<th scope="col">Jumlah</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($data_pencatatan as $row) :?>
				<tr>
					<?php  
						$id_pengirim = $row['ID_PENGIRIM'];
						$nama_pengirim = getData("SELECT NAMA_PENGIRIM FROM PENGIRIM WHERE ID_PENGIRIM = '$id_pengirim'")[0]["NAMA_PENGIRIM"];
						$id_barang = $row['ID_BARANG'];
						$data_barang = getData("SELECT * FROM BARANG WHERE ID_BARANG = '$id_barang'")[0];
						$nama_barang = $data_barang['NAMA_BARANG'];
						$id_merk = $data_barang['ID_MERK'];
						$nama_merk = getData("SELECT * FROM MERK WHERE ID_MERK = '$id_merk'")[0]['NAMA_MERK'];
					?>
					<td><?= $row['ID_FAKTUR'] ?></td>
					<td><?= $nama_pengirim ?></td>
					<td><?= $row['WAKTU'] ?></td>
					<td><?= ucwords(strtolower($nama_merk." ".$nama_barang)) ?></td>
					<td><?= $row['UKURAN'] ?></td>
					<td><?= $row['JUMLAH'] ?></td>
					<td>
						<a href="editFaktur.php?id_faktur=<?= $row['ID_FAKTUR'] ?>" title="Sunting Data"><img alt="Sunting Data" src="../assets/img/edit3-icon.svg" width="25px" height="25px"></img></a>
						<a href="deleteFaktur.php?id_faktur=<?= $row['ID_FAKTUR'] ?>" onClick="return confirm('Hapus Data Faktur ini?')" title="Hapus Data"><img alt="Hapus Data" src="../assets/img/delete2-icon.svg" width="25px" height="25px" class="ms-2"></img></a>
					</td>
				</tr>
				<?php endforeach ?>
				</tbody>
			</table>
			</div>
		</main>
	  </div>
	</div>
</body>
</html>