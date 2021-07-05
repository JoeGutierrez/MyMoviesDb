<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/helpers.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Log In</title>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/jquery.html.php'; ?>
		<script type="text/javascript" src="/admin/jquery/login.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/css.html.php'; ?>
	</head>
	<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-header.html.php'; ?>
		<div class="loginContainer">
			<h1>Log In</h1>
<?php if (isset($_SESSION['logoutMessage'])): ?>
			<p class="text-stroke"><?php htmlout($_SESSION['logoutMessage']); unset ($_SESSION['logoutMessage']); // $_SESSION['logoutMessage'] is initialized in access.php. A $_SESSION[] variable is needed in order to pass data from a different page without using query strings or $_POST data from a <form>. I tried using a $GLOBALS[] variable but it didn't work. Added: 10/02/2014. Source: http://stackoverflow.com/questions/11803343/how-to-pass-variables-received-in-get-string-through-a-php-header-redirect ?></p>
<?php elseif (isset($loginError)): ?>
			<p class="text-stroke error"><?php htmlout($loginError); ?></p>
<?php else: ?>
			<p class="text-stroke">To proceed, please log in.</p>
<?php endif; ?>
			<form action="" method="post" class="readableBG">
				<div>
					<label for="username">Username:</label><input type="text" name="username" id="username">
				</div>
				<div>
					<label for="password_">Password:</label><input type="password" name="password_" id="password_">
				</div>
				<div>
					<input type="hidden" name="action" value="login">
					<input type="submit" value="Log In">
				</div>
			</form>
		</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-footer.html.php'; ?>
	</body>
</html>
