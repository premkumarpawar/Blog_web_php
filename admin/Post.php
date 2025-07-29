<?php 
session_start();

if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - Posts</title>
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
			max-width: 1200px;
		}
		h3 {
			font-weight: bold;
			color: #2c3e50;
		}
		.table th, .table td {
			vertical-align: middle;
		}
		.table thead {
			background-color: #2980b9;
			color: white;
		}
		.table-striped > tbody > tr:nth-of-type(odd) {
			background-color:rgb(131, 207, 201);
		}
		.btn-success {
			background-color: #2ecc71;
			border-color: #27ae60;
		}
		.btn-danger {
			background-color: #e74c3c;
			border-color: #c0392b;
		}
		.btn-warning {
			background-color: #f39c12;
			border-color: #e67e22;
			color: #fff;
		}
		.btn-link {
			font-weight: bold;
			color: #3498db;
			text-decoration: none;
		}
		.alert {
			margin-top: 20px;
		}
		td a {
			margin-right: 8px;
		}
	</style>
</head>
<body>
	<?php 
      $key = "hhdsfs1263z";
	  include "inc/side-nav.php"; 
      include_once("data/Post.php");
      include_once("data/Comment.php");
      include_once("../db_conn.php");
      $posts = getAllDeep($conn);
	?>
               
	<div class="main-table">
		<h3 class="mb-4">All Posts 
	 		<a href="post-add.php" class="btn btn-success float-end">+ Add New</a>
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

	 	<?php if ($posts != 0) { ?>
	 	<table class="table table-striped table-bordered">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th>Title</th>
		      <th>Category</th>
		      <th>Comments</th>
		      <th>Likes</th>
		      <th>Action</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php foreach ($posts as $post) {
		  	$category = getCategoryById($conn, $post['category']); 
		  	?>
		    <tr>
		      <th scope="row"><?=$post['post_id'] ?></th>
		      <td><a href="single_post.php?post_id=<?=$post['post_id'] ?>"><?=$post['post_title'] ?></a></td>
		      <td><?=$category['category']?></td>
		      <td>
		      	<i class="fa fa-comment" aria-hidden="true"></i> 
		        <?=CountByPostID($conn, $post['post_id'])?>
		      </td>
		      <td>
		      	<i class="fa fa-thumbs-up" aria-hidden="true"></i> 
		        <?=likeCountByPostID($conn, $post['post_id'])?>
		      </td>
		      <td>
		      	<a href="post-delete.php?post_id=<?=$post['post_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
		      	<a href="post-edit.php?post_id=<?=$post['post_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <?php if ($post['publish'] == 1) { ?>
		      	<a href="post-publish.php?post_id=<?=$post['post_id'] ?>&publish=1" class="btn btn-link disabled">Public</a>
		      	<a href="post-publish.php?post_id=<?=$post['post_id'] ?>&publish=0" class="btn btn-link">Private</a>
		        <?php } else { ?>
		      	<a href="post-publish.php?post_id=<?=$post['post_id'] ?>&publish=1" class="btn btn-link">Public</a>
		      	<a href="post-publish.php?post_id=<?=$post['post_id'] ?>&publish=0" class="btn btn-link disabled">Private</a>
		        <?php } ?>
		      </td>
		    </tr>
		    <?php } ?>
		  </tbody>
		</table>
	<?php } else { ?>
		<div class="alert alert-warning">
			No posts found!
		</div>
	<?php } ?>
	</div>

	<script>
		var navList = document.getElementById('navList').children;
		navList.item(1).classList.add("active");
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

<?php } else {
	header("Location: ../admin-login.php");
	exit;
} ?>
