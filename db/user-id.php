<?php
// Build the list of users.
include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

try
{
	$result = $pdo->query('SELECT id, name_ FROM user_info');
}
catch (PDOException $e)
{
	$error = 'Error fetching list of users.';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}

foreach ($result as $row)
{
	$users[] = [
		'id' => $row['id'],
		'name_' => $row['name_']
	];
}

$i = 1; // The reason $i is initialized at 1 here is because MySQL columns begin counting at 1, so whenever $name_[$i] is used, the $i matches the user's id in the database. Therefore, the "name_" value can be retrieved from the array where its index matches the database's id number.
foreach ($users as $user) {
	$name_[$i] = $user['name_'];
	$i++;
}
?>
