<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/helpers.php'; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/db/user-id.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php htmlout($page_title); ?></title>
		<link rel="shortcut icon" href="/img/favicon.ico">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/jquery.html.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/css.html.php'; ?>
	</head>
	<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-header.html.php'; ?>
		<div class="homePageContainer">
			<h1>Welcome to the Database</h1>
			<div class="sliderContainer theme-default">
				<div id="slider" class="nivoSlider">
					<a href="/db/?view-all"><img src="/img/hp-slide-1.jpg" alt="" title="View All"></a>
					<a href="/db/?view-all"><img src="/img/hp-slide-2.jpg" alt="" title="Add Movie"></a>
					<a href="/admin/"><img src="/img/3.jpg" alt="" title="Login"></a>
				</div>
			</div>
			<div id="aim" style="margin: 10px auto;">
				<a href="/db/?view-all"><span>View All</span><img src="/img/hp-slide-1.jpg" alt="" width="900" height="400"></a><br>
				<a href="/db/?view-all"><span>Add Movie</span><img src="/img/hp-slide-2.jpg" alt="" width="900" height="400"></a><br>
				<a href="/admin/"><span>Login</span><img src="/img/3.jpg" alt="" width="900" height="400"></a><br>
			</div>
		</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-footer.html.php'; ?>
	</body>
</html>
