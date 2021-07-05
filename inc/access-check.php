<?php
$cur_dir = dirname ($_SERVER ['PHP_SELF']); // Current directory.
$admin_dirs = ['/admin', '/admin/db'];

if (!userIsLoggedIn()) {
	$loggedIn = FALSE;

	if (in_array($cur_dir, $admin_dirs)) {
		include $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/login.html.php';
		exit();
	}
}
else {
	$loggedIn = TRUE;
}

if ($loggedIn and !userHasRole('Account Administrator')) {
	$hasRole = FALSE;

	if (in_array($cur_dir, $admin_dirs)) {
		$error = 'Only Account Administrators may access this page.';
		include $_SERVER['DOCUMENT_ROOT'] . '/inc/access-denied.html.php';
		exit();
	}
}
else {
	$hasRole = TRUE;
}

/*
Notes
-----
- You can only make one call to userIsLoggedIn(), if you try making two, you get the following PHP error: 

	Notice: A session had already been started - ignoring session_start() in C:\Websites\mymovies\admin\inc\access.php on line 65

So, instead of checking if the user is logged in by: "if (userIsLoggedIn()) {}," I created the variables "$loggedIn = FALSE;" and "$loggedIn = TRUE;" to check if the user is
logged in or not.

Added: 09/25/2014.

- The reason you have to check for both "if ($loggedIn and !userHasRole('Account Administrator')) {}" instead of just "if (!userHasRole('Account Administrator')) {}" like it
was in Kevin Yank's original code, is because the very first if() statement, "if (!userIsLoggedIn()) {}" would exit() if true. Now, with my additions, the script keeps on
executing so the $loggedIn variable can be initialized. Therefore, there needed to be a way for "if (!userHasRole('Account Administrator')) {}" to fail if the user wasn't
logged in. That's where the new $loggedIn variable comes into play in the modified if() statement.

Added: 09/26/2014.

*/
?>
