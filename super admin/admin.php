<!-- Sintaks PHP -->
<?php
session_start();
require '../function.php';

if(!sessionLoginCheck('LVL001')){
	header("Location:	logout.php");
};
$data = getData('SELECT * FROM ADMIN WHERE ID_LEVEL = "LVL002"');
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
				<!-- nav-item daftar admin -->
				<li class="nav-item">
					<a class="nav-link active text-dark fw-bold rounded-3 bg-warning" aria-current="page" href="admin.php">
						Daftar Admin
					</a>
				</li>
			  <!-- nav-item sunting profil -->
	          <li class="nav-item">
	            <a class="nav-link text-light" href="profil.php">
	              Sunting Profil
	            </a>
	          </li>
			  <!-- nav-item ubah password -->
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
	      	<h1 class="h2 my-5">Daftar Admin</h1>
	      	<a href="tambahAdmin.php" class="mx-5"><button class="btn btn-warning ">
	      		<img src="../assets/img/add-icon.svg" width="25px" height="25px" class="me-2"> Tambah Admin</button>
	  		</a>
	      	<div class="table-responsive mx-5 mt-3">
	        	<table class="table table-striped table-sm">
		        <thead>
		            <tr>
			            <th scope="col" class="table-dark">No.</th>
			            <th scope="col" class="table-dark">Username</th>
			            <th scope="col" class="table-dark">Nama </th>
			            <th scope="col" class="table-dark">No Telepon</th>
			            <th scope="col" class="table-dark">E-Mail</th>
			            <th scope="col" class="table-dark">Action</th>
		            </tr>
		        </thead>
		        <tbody>
					<?php $i = 1; ?>
					<?php foreach($data as $row) :?>
		            <tr>
						<td><?= $i ?></td>
			            <td><?= $row['USERNAME'] ?></td>
			            <td><?= $row['NAMA_ADMIN'] ?></td>
			            <td><?= $row['NOTELP_ADMIN'] ?></td>
			            <td><?= $row['EMAIL_ADMIN'] ?></td>
			            <td>
			              	<a href="editAdmin.php?username=<?= $row['USERNAME'] ?>" title="Sunting Data"><img alt="Sunting Data" src="../assets/img/edit3-icon.svg" width="25px" height="25px" class="me-2"></img></a>
			              	<a href="deleteAdmin.php?username=<?= $row['USERNAME'] ?>" onClick="return confirm('Delete This account?')" title="Hapus Data"><img alt="Hapus Data" src="../assets/img/delete2-icon.svg" width="25px" height="25px" class="me-2"></img></a>
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