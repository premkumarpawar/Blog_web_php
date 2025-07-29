<?php 
session_start();
$logged = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
	 $logged = true;
	 $user_id = $_SESSION['user_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Home Page</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		body {
			margin: 0;
			font-family: 'Poppins', sans-serif;
			background: #f5f7fa;
			color: #333;
		}
		.main-banner {
			height: 100vh;
			background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.6)),
			            url('images/banner.jpg') center/cover no-repeat;
			display: flex;
			align-items: center;
			justify-content: center;
			text-align: center;
			color: white;
			padding: 0 20px;
		}
		.banner-content {
			animation: fadeSlideUp 1.5s ease-out;
		}
		@keyframes fadeSlideUp {
			from {
				opacity: 0;
				transform: translateY(50px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}
		.main-banner h1 {
			font-size: 4rem;
			font-weight: bold;
			margin-bottom: 15px;
		}
		.main-banner p {
			font-size: 1.3rem;
			max-width: 700px;
			margin: auto;
		}
		.btn-hero {
			margin-top: 30px;
			padding: 12px 30px;
			font-size: 1.1rem;
			background: #00c6ff;
			border: none;
			border-radius: 8px;
			color: white;
			transition: 0.3s ease;
		}
		.btn-hero:hover {
			background: #0072ff;
			transform: scale(1.05);
		}
	</style>
</head>
<body>
	<?php include 'inc/NavBar.php'; ?>

	<div class="main-banner">
		<div class="banner-content">
			<h1>Welcome to MyBlog</h1>
			<p>Discover amazing stories, share your thoughts, and connect with a community of passionate readers and writers.</p>
			<a href="blog.php" class="btn btn-hero">Explore Blog</a>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
