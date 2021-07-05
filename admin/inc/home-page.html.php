<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php htmlout($page_title); ?></title>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/jquery.html.php'; ?>
		<script type="text/javascript" src="/admin/jquery/home-page.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/css.html.php'; ?>
	</head>
	<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-header.html.php'; ?>
		<div class="adminHomePageContainer">
			<h1>My Movies CMS</h1>
			<div class="readableBG">
				<ul class="text-stroke">
					<li><a href="/db/?view-all">View All</a></li>
					<li><a href="/admin/db/?add">Add Movie</a></li>
					<li><a href="/admin/db/">Edit / Delete</a></li>
				</ul>
				<div><?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/logout.html.php'; ?></div>
			</div>
		</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-footer.html.php'; ?>
	</body>
</html>
