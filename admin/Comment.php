<?php 
session_start();

if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - Comments</title>
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
			background-color: #2c3e50;
			color: white;
		}
		.table-striped > tbody > tr:nth-of-type(odd) {
			background-color: #f9f9f9;
		}
		.btn-danger {
			background-color: #e74c3c;
			border-color: #c0392b;
		}
		.alert {
			margin-top: 20px;
		}
		a {
			text-decoration: none;
		}
	</style>
</head>
<body>
	<?php 
	  $key = "hhdsfs1263z";
	  include "inc/side-nav.php"; 
      include_once("data/Comment.php");
      include_once("data/Post.php");
      include_once("../db_conn.php");
      $comments = getAllComment($conn);
	?>
               
	<div class="main-table">
		<h3 class="mb-4">All Comments</h3>

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

	 	<?php if ($comments != 0) { ?>
	 	<table class="table table-striped table-bordered">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Post Title</th>
		      <th scope="col">Comment</th>
		      <th scope="col">User</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php foreach ($comments as $comment) { ?>
		    <tr>
		      <th scope="row"><?=$comment['comment_id'] ?></th>
		      <td>
		      	<a href="single_post.php?post_id=<?=$comment['post_id']?>" target="_blank">
		      		<?php 
		      			$p = getByIdDeep($conn, $comment['post_id']);
		      			echo htmlspecialchars($p['post_title']);
		      		?>
		      	</a>
		      </td>
		      <td><?=htmlspecialchars($comment['comment'])?></td>
		      <td>
		      	<?php 
		      		$u = getUserByID($conn, $comment['user_id']);
		      		echo '@'.htmlspecialchars($u['username']); 
		      	?>
		      </td>
		      <td>
		      	<a href="comment-delete.php?comment_id=<?=$comment['comment_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
		      </td>
		    </tr>
		    <?php } ?>
		  </tbody>
		</table>
	<?php } else { ?>
		<div class="alert alert-warning">
			No comments found!
		</div>
	<?php } ?>
	</div>

	<script>
		var navList = document.getElementById('navList').children;
		navList.item(3).classList.add("active");
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

<?php } else {
	header("Location: ../admin-login.php");
	exit;
} ?>
