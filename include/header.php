<head>
	<link rel="stylesheet" href="./css/header.css">
	<link rel="stylesheet" href="./css/default.css">
</head>
<header class="header">
	<div class="title">Fox Wildlife <br>
		Conservatory
	</div>
	<div class="mainbar">
		<div class="rotate">
			<a href="./">Home</a>
		</div>
		<div class="rotate">
			<a href="browse.php">Browse </a>  
		</div>
		<div class="rotate">
			<a href="track.php">Track Order</a>
		</div>
		<div class="rotate">
			<a href="cart.php">Cart</a>  
		</div>
		<div class="padding"></div>
		<div class="profileinfo">
			
			<?php
				if (session_status() == PHP_SESSION_NONE) {
					// Start a session if there is none
					session_start();
				}
				if (isset($_SESSION["loggedin"])) {
					$user = $_SESSION["username"];
					echo "<p>You're logged in as <span class='username'>$user</span></p>";
					echo "<p><a href='login/?logout=1'>Log out</a></p>";
				} else {
					echo "<p>You are not logged in</p>";
					echo "<p><a href='login/'>Log in here</a></p>";
				}
			?>
			
		</div>
	</div>
</header>
