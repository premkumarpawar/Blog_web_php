<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>User Login</title>

	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

	<style>
		:root {
			--bg-light: linear-gradient(to right, #00c6ff, #0072ff);
			--bg-dark: #121212;
			--text-dark: #fff;
			--card-light: #fff;
			--card-dark: #1e1e1e;
			--primary-color: #0072ff;
		}

		body {
			margin: 0;
			font-family: 'Poppins', sans-serif;
			background: var(--bg-light);
			color: #fff;
			transition: background 0.4s, color 0.4s;
		}
		.shadow {
			background: var(--card-light);
			color: #333;
			border-radius: 15px;
			box-shadow: 0 8px 16px rgba(0,0,0,0.3);
			width: 100%;
			max-width: 450px;
		}
		.dark-mode body {
			background: var(--bg-dark);
			color: var(--text-dark);
		}
		.dark-mode .shadow {
			background: var(--card-dark);
			color: var(--text-dark);
		}
		.form-label {
			font-weight: 600;
		}
		.btn-primary {
			background-color: var(--primary-color);
			border: none;
		}
		.link-secondary {
			color: var(--primary-color);
			display: inline-block;
			margin: 5px;
		}
		.alert-danger {
			background-color: #ff4d4d;
			color: white;
		}
		.toggle-password, .toggle-dark {
			cursor: pointer;
			font-size: 0.9rem;
			color: var(--primary-color);
			display: inline-block;
			margin-top: 5px;
		}
		.avatar {
			width: 60px;
			height: 60px;
			background: var(--primary-color);
			color: #fff;
			font-size: 24px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 20px;
			text-transform: uppercase;
		}
		.top-right {
			position: absolute;
			top: 20px;
			right: 30px;
		}
	</style>
</head>
<body>
	<!-- Admin Login Top Right -->
	<div class="top-right">
		<a href="admin-login.php" class="btn btn-light">👮‍♂️ Administrator</a>
	</div>

	<!-- Login Form -->
	<div class="d-flex justify-content-center align-items-center vh-100">
		<form class="shadow p-4" action="php/login.php" method="post">
			<h4 class="display-6 text-center">👤 User Login</h4>

			<!-- Avatar Preview -->
			<div id="avatar" class="avatar">U</div>

			<?php if(isset($_GET['error'])){ ?>
			<div class="alert alert-danger" role="alert">
				<?php echo htmlspecialchars($_GET['error']); ?>
			</div>
			<?php } ?>

			<div class="mb-3">
				<label class="form-label">Username</label>
				<input type="text" class="form-control" id="uname" name="uname"
					value="<?php echo isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : '' ?>" required
					oninput="updateAvatar()" />
			</div>

			<div class="mb-3">
				<label class="form-label">Password</label>
				<input type="password" class="form-control" id="passInput" name="pass" required />
				<span class="toggle-password" onclick="togglePassword()">👁 Show Password</span>
			</div>

			<button type="submit" class="btn btn-primary w-100">Login</button>

			<div class="text-center mt-3">
				<a href="blog.php" class="link-secondary">Blog</a>
				|
				<a href="signup.php" class="link-secondary">Sign Up</a>
			</div>

			<div class="text-center mt-2">
				<span class="toggle-dark" onclick="toggleDarkMode()">🌙 Toggle Dark Mode</span>
			</div>
		</form>
	</div>

	<!-- Script -->
	<script>
		function togglePassword() {
			const passInput = document.getElementById("passInput");
			const toggle = document.querySelector(".toggle-password");
			if (passInput.type === "password") {
				passInput.type = "text";
				toggle.textContent = "🙈 Hide Password";
			} else {
				passInput.type = "password";
				toggle.textContent = "👁 Show Password";
			}
		}

		function toggleDarkMode() {
			document.documentElement.classList.toggle("dark-mode");
		}

		function updateAvatar() {
			const name = document.getElementById("uname").value;
			const initial = name ? name[0].toUpperCase() : "U";
			document.getElementById("avatar").textContent = initial;
		}

		window.onload = updateAvatar;
	</script>
</body>
</html>
