<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - Create Category</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- External CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/side-bar.css">

	<style>
		body {
			background-color: #f8f9fa;
			font-family: 'Segoe UI', sans-serif;
			transition: background-color 0.3s, color 0.3s;
		}
		body.dark-mode {
			background-color: #121212;
			color: white;
		}
		.main-table {
			max-width: 700px;
			margin: 40px auto;
			background: #ffffff;
			border-radius: 12px;
			padding: 30px;
			box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
		}
		.dark-mode .main-table {
			background: #1e1e1e;
		}
		label.form-label {
			font-weight: 600;
		}
		input.form-control {
			border-radius: 8px;
		}
		.toggle-dark {
			float: right;
			cursor: pointer;
			font-size: 14px;
		}
	</style>
</head>
<body>

<?php 
  $key = "hhdsfs1263z";
  include "inc/side-nav.php"; 
?>

<div class="main-table">
	<h3 class="mb-3 d-flex justify-content-between align-items-center">
		Create New Category
		<a href="Category.php" class="btn btn-success">All Categories</a>
	</h3>

	

	<?php if (isset($_GET['error'])) { ?>	
	<div class="alert alert-warning"><?=htmlspecialchars($_GET['error'])?></div>
	<?php } ?>

	<?php if (isset($_GET['success'])) { ?>	
	<div class="alert alert-success"><?=htmlspecialchars($_GET['success'])?></div>
	<?php } ?>

	<form class="shadow p-3" action="req/Category-create.php" method="post">
		<div class="mb-3">
			<label class="form-label">Category Name</label>
			<input type="text" class="form-control" name="category" required>
		</div>
		<button type="submit" class="btn btn-primary w-100">Create</button>
	</form>
</div>

<script>
	// Activate sidebar nav
	var navList = document.getElementById('navList').children;
	navList.item(2).classList.add("active");

	// Dark Mode Toggle
	function toggleDarkMode() {
		document.body.classList.toggle('dark-mode');
	}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php } else {
	header("Location: ../admin-login.php");
	exit;
} ?>
