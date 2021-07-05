<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/universal.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/helpers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/access.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/access-check.php';

if (isset($_GET['movie'])) {
	include 'movie.php';
}
elseif (isset($_GET['genre'])) {
	include 'genre.php';
}
else {
	include 'view-all.php';
}
?>
