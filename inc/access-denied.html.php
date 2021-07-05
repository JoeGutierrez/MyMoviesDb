<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/helpers.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Access Denied</title>
	</head>
	<body>
		<h1>Access Denied</h1>
		<p><?php htmlout($error); ?></p>
		<div><?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/logout.html.php'; ?></div>
	</body>
</html>
