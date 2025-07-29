<!-- Do NOT put any PHP logic at top here -->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Login</title>

	<!-- Bootstrap CDN -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

	<!-- Embedded Dynamic CSS -->
	<style>
		body {
			background: linear-gradient(to right, #667eea, #764ba2);
			font-family: 'Poppins', sans-serif;
			color: #fff;
			height: 100vh;
			margin: 0;
		}
		.shadow {
			background: #fff;
			color: #333;
			border-radius: 15px;
			box-shadow: 0 8px 16px rgba(0,0,0,0.3);
			width: 100%;
			max-width: 450px;
		}
		.form-label {
			font-weight: 600;
			color: #333;
		}
		.btn-primary {
			background-color: #764ba2;
			border: none;
			transition: background 0.3s ease-in-out;
		}
		.btn-primary:hover {
			background-color: #5a3791;
		}
		.link-secondary {
			display: block;
			margin-top: 10px;
			text-align: center;
			color: #764ba2;
		}
		.alert-danger {
			background-color: #ff6b6b;
			color: white;
			border: none;
		}
		.toggle-password {
			cursor: pointer;
			font-size: 0.9rem;
			color: #764ba2;
			margin-top: -10px;
			display: inline-block;
		}
	</style>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
    	<form class="shadow p-4" action="admin/admin-login.php" method="post">
    		<h4 class="display-6 text-center">👮‍♂️ Admin Login</h4>
    		<p class="text-center text-muted mb-4">Only for Administrator</p>

    		<?php if (isset($_GET['error'])) { ?>
    		<div class="alert alert-danger" role="alert">
			  <?php echo htmlspecialchars($_GET['error']); ?>
			</div>
		    <?php } ?>

		    <div class="mb-3">
		    	<label class="form-label">Username</label>
		    	<input type="text" class="form-control" name="uname"
		    	    value="<?php echo isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : '' ?>" required>
		    </div>

		    <div class="mb-3">
		    	<label class="form-label">Password</label>
		    	<input type="password" class="form-control" id="passInput" name="pass" required>
		    	<span class="toggle-password" onclick="togglePassword()">👁 Show Password</span>
		    </div>
		      
		    <button type="submit" class="btn btn-primary w-100">Login</button>
		    <a href="login.php" class="link-secondary">Switch to User Login</a>
		</form>
    </div>

    <!-- JavaScript to toggle password -->
    <script>
    	function togglePassword() {
    		const passInput = document.getElementById("passInput");
    		const toggleBtn = document.querySelector(".toggle-password");

    		if (passInput.type === "password") {
    			passInput.type = "text";
    			toggleBtn.innerHTML = "🙈 Hide Password";
    		} else {
    			passInput.type = "password";
    			toggleBtn.innerHTML = "👁 Show Password";
    		}
    	}
    </script>
</body>
</html>
    