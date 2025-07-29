<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign Up</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
	<style>
		body {
			font-family: 'Poppins', sans-serif;
			background: linear-gradient(135deg, #74ebd5, #9face6);
			margin: 0;
			color: #333;
		}
		form.shadow {
			background: #fff;
			border-radius: 15px;
			box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
			width: 100%;
			max-width: 450px;
		}
		.display-4 {
			color: #6a11cb;
			font-weight: 600;
		}
		.form-label {
			font-weight: 500;
		}
		.btn-primary {
			background-color: #6a11cb;
			border: none;
			transition: background 0.3s ease;
		}
		.btn-primary:hover {
			background-color: #2575fc;
		}
		.link-secondary {
			display: block;
			margin-top: 15px;
			text-align: center;
			color: #6a11cb;
			text-decoration: none;
		}
		.link-secondary:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<div class="d-flex justify-content-center align-items-center vh-100">
		<form class="shadow p-4" action="php/signup.php" method="post">
			<h4 class="display-4 text-center">Create Account</h4>
			<?php if(isset($_GET['error'])){ ?>
				<div class="alert alert-danger mt-3" role="alert">
					<?php echo htmlspecialchars($_GET['error']); ?>
				</div>
			<?php } ?>
			<?php if(isset($_GET['success'])){ ?>
				<div class="alert alert-success mt-3" role="alert">
					<?php echo htmlspecialchars($_GET['success']); ?>
				</div>
			<?php } ?>
			<div class="mb-3 mt-3">
				<label class="form-label">Full Name</label>
				<input type="text" class="form-control" name="fname"
					value="<?php echo (isset($_GET['fname']))? htmlspecialchars($_GET['fname']):"" ?>" required>
			</div>

			<div class="mb-3">
				<label class="form-label">Username</label>
				<input type="text" class="form-control" name="uname"
					value="<?php echo (isset($_GET['uname']))? htmlspecialchars($_GET['uname']):"" ?>" required>
			</div>

			<div class="mb-3">
				<label class="form-label">Password</label>
				<input type="password" class="form-control" name="pass" required>
			</div>

			<button type="submit" class="btn btn-primary w-100">Sign Up</button>
			<a href="login.php" class="link-secondary">Already have an account? Login</a>
		</form>
	</div>
</body>
</html>
