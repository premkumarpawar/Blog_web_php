<?php 
session_start();

if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - Users</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/side-bar.css">
	<link rel="stylesheet" href="../css/style.css">

	<style>
		body {
			background:rgb(97, 185, 212);
			font-family: 'Segoe UI', sans-serif;
		}
		.main-table {
			padding: 40px;
			background: #fff;
			margin: 40px auto;
			border-radius: 10px;
			box-shadow: 0 0 20px rgba(0,0,0,0.1);
			max-width: 1100px;
		}
		h3 {
			font-weight: bold;
			color: #2c3e50;
		}
		.table th, .table td {
			vertical-align: middle;
		}
		.table thead {
			background-color: #3498db;
			color: white;
		}
		.table-striped > tbody > tr:nth-of-type(odd) {
			background-color:rgb(86, 177, 194);
		}
		.btn-success {
			background-color: #2ecc71;
			border-color: #27ae60;
		}
		.btn-danger {
			background-color: #e74c3c;
			border-color: #c0392b;
		}
		.alert {
			margin-top: 20px;
		}
	</style>
</head>
<body>
	<?php 
      $key = "hhdsfs1263z";
	  include "inc/side-nav.php"; 
      include_once("data/User.php");
      include_once("../db_conn.php");
      $users = getAll($conn);
	?>
               
	<div class="main-table">
		<h3 class="mb-4">All Users 
	 		<a href="../signup.php" class="btn btn-success float-end">+ Add New</a>
	 	</h3>

	 	<?php if (isset($_GET['error'])) { ?>	
	 	<div class="alert alert-warning">
			<?=htmlspecialchars($_GET['error'])?>
		</div>
	    <?php } ?>

        <?php if (isset($_GET['success'])) { ?>	
	 	<div class="alert alert-success">
			<?=htmlspecialchars($_GET['success'])?>
		</div>
	    <?php } ?>

	 	<?php if ($users != 0) { ?>
	 	<table class="table table-striped table-bordered">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Full Name</th>
		      <th scope="col">Username</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php foreach ($users as $user) { ?>
		    <tr>
		      <th scope="row"><?=$user['id'] ?></th>
		      <td><?=$user['fname'] ?></td>
		      <td><?=$user['username'] ?></td>
		      <td>
		      	<a href="user-delete.php?user_id=<?=$user['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
		      </td>
		    </tr>
		    <?php } ?>
		  </tbody>
		</table>
	<?php } else { ?>
		<div class="alert alert-warning">
			No users found!
		</div>
	<?php } ?>
	</div>

	<script>
		var navList = document.getElementById('navList').children;
		navList.item(0).classList.add("active");
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

<?php } else {
	header("Location: ../admin-login.php");
	exit;
} ?>
