<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - Create Post</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/side-bar.css">
	<link rel="stylesheet" href="../css/richtext.min.css">
	
	<style>
		body {
			font-family: 'Segoe UI', sans-serif;
			background-color:rgb(97, 185, 212);
			transition: background-color 0.3s, color 0.3s;
		}
		body.dark-mode {
			background-color: #121212;
			color: #ffffff;
		}
		.main-table {
			max-width: 850px;
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
		textarea, input, select {
			border-radius: 8px !important;
		}
		#preview {
			background: #eeeeee;
			border-radius: 8px;
			padding: 15px;
			min-height: 100px;
			margin-top: 15px;
		}
		.dark-mode #preview {
			background: #2e2e2e;
		}
		.badge-option {
			color: white;
			padding: 2px 8px;
			border-radius: 5px;
		}
		.dark-toggle {
			float: right;
			margin-bottom: 15px;
			cursor: pointer;
			font-size: 14px;
		}
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="../js/jquery.richtext.min.js"></script>
</head>
<body>
<?php 
  $key = "hhdsfs1263z";
  include "inc/side-nav.php"; 
  include_once("data/Category.php");
  include_once("../db_conn.php");
  $categories = getAll($conn);
?>

<div class="main-table">
	<h3 class="mb-3 d-flex justify-content-between align-items-center">
		Create New Post
		<a href="post.php" class="btn btn-secondary">All Posts</a>
	</h3>

	<button class="btn btn-dark dark-toggle" onclick="toggleDarkMode()">🌓 Toggle Dark Mode</button>

	<?php if (isset($_GET['error'])) { ?>	
	<div class="alert alert-warning"><?=htmlspecialchars($_GET['error'])?></div>
	<?php } ?>

	<?php if (isset($_GET['success'])) { ?>	
	<div class="alert alert-success"><?=htmlspecialchars($_GET['success'])?></div>
	<?php } ?>

	<form class="shadow p-3" action="req/post-create.php" method="post" enctype="multipart/form-data">
		<div class="mb-3">
			<label class="form-label">Title</label>
			<input type="text" class="form-control" name="title" id="postTitle">
		</div>

		<div class="mb-3">
			<label class="form-label">Cover Image</label>
			<input type="file" class="form-control" name="cover">
		</div>

		<div class="mb-3">
			<label class="form-label">Text</label>
			<textarea class="form-control text" name="text" id="postText"></textarea>
		</div>

		<div class="mb-3">
			<label class="form-label">Live Preview</label>
			<div id="preview"></div>
		</div>

		<div class="mb-3">
			<label class="form-label">Category</label>
			<select name="category" class="form-control">
			<?php 
			$colors = ['#0d6efd', '#dc3545', '#198754', '#6f42c1', '#fd7e14'];
			$i = 0;
			foreach ($categories as $category) { 
				$color = $colors[$i % count($colors)];
				$i++;
			?>
				<option value="<?=$category['id']?>">🔸 <?=$category['category']?></option>
			<?php } ?>
			</select>
		</div>

		<button type="submit" class="btn btn-primary w-100">Create</button>
	</form>
</div>

<script>
	var navList = document.getElementById('navList').children;
	navList.item(1).classList.add("active");

	$(document).ready(function () {
		$('.text').richText();

		$('#postText').on('input', function () {
			let val = $(this).val();
			$('#preview').html(val);
		});
	});

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
