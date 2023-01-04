<?php
session_start();
require '../function.php';

$_SESSION['tempCatat'] = [];
$_SESSION['tempPengirim'] = "";
$_SESSION['tempFaktur'] = "";

if(!sessionLoginCheck('LVL002')){
	header("Location:	logout.php");
};
$query = "SELECT FAKTUR.ID_FAKTUR, FAKTUR.USERNAME, ADMIN.NAMA_ADMIN, FAKTUR.ID_PENGIRIM, PENGIRIM.NAMA_PENGIRIM, WAKTU FROM FAKTUR JOIN PENGIRIM ON FAKTUR.ID_PENGIRIM = PENGIRIM.ID_PENGIRIM JOIN ADMIN ON FAKTUR.USERNAME = ADMIN.USERNAME ";
if (isset($_GET['filter'])) {
	$startfrom = '';
	if ((isset($_GET['startfrom']) and $_GET['startfrom'] != "") or (isset($_GET['endbefore']) and $_GET['endbefore'] != "")) {
		if (isset($_GET['startfrom']) and $_GET['startfrom'] != "") {
			$startfrom = $_GET['startfrom'];
		}
		$query .= " AND FAKTUR.WAKTU BETWEEN '$startfrom' AND ";
		if (isset($_GET['endbefore']) and $_GET['endbefore'] != "") {
			$endbefore = $_GET['endbefore'];
			$query .= "'$endbefore'";
		} else {
			$query .= "date('now', '+1 day', 'localtime')";
		}
	}
	$query .= " ORDER BY PENGIRIM.NAMA_PENGIRIM " .$_GET['sortto'];
}
$data = getData($query);
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
			<h1 class="h2 my-5">Daftar Pencatatan</h1>
			<div class="table-responsive mx-5">
				<table class="table">
					<tr>
						<td>
							<a href="tambahPencatatan.php"><button class="btn btn-warning ">
								<img src="../assets/img/add-icon.svg" width="25px" height="25px" class="me-2"> Catat Barang Masuk</button>
							</a>
						</td>
					</tr>
					<form action="pencatatan.php" method="get">
					<tr>
						<td>
							<label for="sortto" class="form-text">Sort by Pengirim to: </label>
							<select name="sortto" id="sortto" class="form-select">
								<option value="ASC">Ascending</option>
								<option value="DESC">Descending</option>
							</select>
						</td>
						<td>
							<label for="startfrom" class="form-text">Start from:</label>
							<input type="date" name="startfrom" id="startfrom" class="form-control">
						</td>
						<td>
							<label for="endbefore" class="form-text">End before:</label>
							<input type="date" name="endbefore" id="endbefore" class="form-control">
						</td>
						<td>
							<input type="submit" name="filter" value="Filter" class="btn btn-primary mt-4">
						</td>
					</tr>
				</table>
			</form>
			</div>
			
			<div class="table-responsive mx-5 mt-3">
				<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th scope="col" class="table-dark">No.</th>
						<th scope="col" class="table-dark">ID Faktur</th>
						<th scope="col" class="table-dark">Pengirim</th>
						<th scope="col" class="table-dark">Waktu</th>
						<th scope="col" class="table-dark">Admin</th>
						<th scope="col" class="table-dark">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1 ?>
					<?php foreach($data as $row) :?>
					<tr>
						<td><?= $i ?></td>
						<td><?= $row['ID_FAKTUR'] ?></td>
						<td><?= $row['NAMA_PENGIRIM'] ?></td>
						<td><?= $row['WAKTU'] ?></td>
						<td><?= $row['NAMA_ADMIN'] ?></td>
						<td>
							<a href="editFaktur.php?id_faktur=<?= $row['ID_FAKTUR'] ?>" title="Sunting Data"><img alt="Sunting Data" src="../assets/img/edit3-icon.svg" width="25px" height="25px"></img></a>
							<a href="deleteFaktur.php?id_faktur=<?= $row['ID_FAKTUR'] ?>" onClick="return confirm('Hapus Data Faktur ini?')" title="Hapus Data"><img alt="Hapus Data" src="../assets/img/delete2-icon.svg" width="25px" height="25px" class="ms-2"></img></a>
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