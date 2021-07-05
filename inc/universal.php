<?php
$cur_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; // Current URL, e.g.: 'http://mymoviesdb.joegutierrezdesigns.com/admin/db/' or 'http://mymoviesdb/admin/db/' (notice the trailing / [slash] unless you remove it with Apache's .htaccess). Added: 10/22/2014. Source: http://stackoverflow.com/questions/6768793/get-the-full-url-in-php (Kremchik's comment.)
$cur_dir = dirname($_SERVER ['PHP_SELF']); // Current directory, e.g.: '/admin/db' in Unix and Windows; however, the root in Unix is '/' while in Windows it's '\'. Remember, in Unix the DIRECTORY_SEPARATOR is / while in Windows it's \. Windows doesn't mind if you use /, just make sure you check for both, e.g.: if ($cur_dir == '/' or $cur_dir == '\') {}. Using the DIRECTORY_SEPARATOR constant isn't necessary in this case as Windows doesn't mind you using a forward slash and Unix prefers it. The DIRECTORY_SEPARATOR is still useful for things like explode-ing a path that the SYSTEM gave you. Added: 10/22/2014. http://stackoverflow.com/questions/625332/is-using-the-directory-separator-constant-neccessary (todofixthis's answer.)
$cur_filename = basename($_SERVER ['PHP_SELF']); // Current filename, e.g.: 'index.php'.
$query_str = $_SERVER['QUERY_STRING']; // Current query string, the text after a question mark, e.g.: 'movie=oculus-(2013)&id=1' if the URL is 'http://mymoviesdb/db/index.php?movie=oculus-(2013)&id=1' or 'http://mymoviesdb/db/?movie=oculus-(2013)&id=1'.
$cur_path = ($cur_dir == DIRECTORY_SEPARATOR ? '' : $cur_dir) . ($cur_filename == 'index.php' ? '' : $cur_filename) . (!empty($query_str) ? '/?' : '') . $query_str; // Current path, e.g.: /db/?view-all if the URL is 'http://mymoviesdb.joegutierrezdesigns.com/db/?view-all'.
substr($cur_dir, 0, 6) == '/admin' ? $in_admin = TRUE : $in_admin = FALSE; // If the first six characters of the current directory equal '/admin'...

$jquery_ui_paths = ['/admin', '/admin/db', '/admin/db/?add', '/admin/db/?disabled'];
$jquery_ui_css_paths = ['/admin', '/admin/db', '/admin/db/?add', '/admin/db/?disabled'];

$jquery_chosen_paths = ['/admin/db/?add'];
if(isset($_POST['action']) and $_POST['action'] == 'Edit') {
	$jquery_chosen_paths[] = '/admin/db';
}

$jquery_chosen_css_paths = ['/admin/db/?add'];
if(isset($_POST['action']) and $_POST['action'] == 'Edit') { // 'or (isset($_SESSION['errors']['edit']))' didn't work since it was unset, so I used the partial_str_in_arr() method in css.html.php.
	$jquery_chosen_css_paths[] = '/admin/db';
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/mobile-detect.php';
$detect = new Mobile_Detect; // Used in css.html.php.

$image_dir = '/img/movies/';
$image_dir_php = $_SERVER['DOCUMENT_ROOT'] . $image_dir;
?>
