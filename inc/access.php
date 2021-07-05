<?php
function userIsLoggedIn()
{
	if (isset($_POST['action']) and $_POST['action'] == 'login')
	{
		if (!isset($_POST['username']) or $_POST['username'] == '' or
			!isset($_POST['password_']) or $_POST['password_'] == '')
		{
			$GLOBALS['loginError'] = 'Please fill in both fields.';
			return FALSE;
		}

		$password_ = md5($_POST['password_'] . 'mymoviesdb_joegutierrez_ninja');

		if (databaseContainsAuthor($_POST['username'], $password_))
		{
			session_start();
			$_SESSION['loggedIn'] = TRUE;
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password_'] = $password_;

		// Get the user ID.
		// Remember, $_SESSION variables are created when you log in (session_start();), so log out then log in again to see a new $_SESSION variable take effect.
		include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';
		try
		{
			$sql = 'SELECT id FROM user_info WHERE username = :username';
			$s = $pdo->prepare($sql);
			$s->bindValue(':username', $_SESSION['username']);
			$s->execute();
		}
		catch (PDOException $e)
		{
			$error = 'Error searching for user ID.';
			include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
			exit();
		}
		$row = $s->fetch();
		$_SESSION['user_id'] = $row['id'];

			return TRUE;
		}
		else
		{
			session_start();
			unset($_SESSION['loggedIn']);
			unset($_SESSION['username']);
			unset($_SESSION['password_']);
			$GLOBALS['loginError'] = 'The specified username or password was incorrect.';
			return FALSE;
		}
	}

	if (isset($_POST['action']) and $_POST['action'] == 'logout')
	{
		session_start();
		unset($_SESSION['loggedIn']);
		unset($_SESSION['username']);
		unset($_SESSION['password_']);
		$_SESSION['logoutMessage'] = 'You have logged out.';
		header('Location: ' . $_POST['goto']);
		exit();
	}

	session_start();
	if (isset($_SESSION['loggedIn']))
	{
		return databaseContainsAuthor($_SESSION['username'], $_SESSION['password_']);
	}
}

function databaseContainsAuthor($username, $password_)
{
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

	try
	{
		$sql = 'SELECT COUNT(*) FROM user_info
				WHERE username = :username AND password_ = :password_';
		$s = $pdo->prepare($sql);
		$s->bindValue(':username', $username);
		$s->bindValue(':password_', $password_);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error searching for user.';
		include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
		exit();
	}

	$row = $s->fetch();

	if ($row[0] > 0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

function userHasRole($role)
{
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

	try
	{
		$sql = "SELECT COUNT(*) FROM user_info
				INNER JOIN user_role ON user_info.id = user_id
				INNER JOIN role ON role_id = role.id
				WHERE username = :username AND role.id = :role_id";
		$s = $pdo->prepare($sql);
		$s->bindValue(':username', $_SESSION['username']);
		$s->bindValue(':role_id', $role);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error searching for user roles.';
		include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
		exit();
	}

	$row = $s->fetch();

	if ($row[0] > 0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}
?>
