<?php
if (isset($_GET['add-form'])) {
	$_SESSION['form']['title_data'] = $_POST['title_data'];
	$_SESSION['form']['year_'] = $_POST['year_'];
}
elseif (isset($_GET['edit-form'])) {
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

	try
	{
		$sql = 'SELECT title.id, title.title_data, title.year_
				FROM title
				WHERE title.id = :id;
		';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error retrieving the movie\'s details to edit them.';
		include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
		exit();
	}

	$row = $s->fetch();

	$id = $row['id'];
	$title_data = $row['title_data'];
	$year_ = $row['year_'];
}

// Retrieve all titles and years from the Db to (later in the script) find possible duplicate movies.
include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

try {
	$result = $pdo->query('SELECT title_data, year_
							FROM title;
					');
}
catch (PDOException $e) {
	$error = 'Error fetching list of movies.';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}

foreach ($result as $row) {
	$movies[] = $row['title_data'] . $row['year_']; // Notice how each movie is stored in this format: TitleYear (no space or parenthesis, e.g.: thewizard1989).
}

// If editing, delete the movie's own title and year from $movies[]. If you don't do this, it won't let you edit any movie, saying the name and year are already in the db!
if (isset($_GET['edit-form']) and ($_POST['title_data'] . $_POST['year_'] == $title_data . $year_) ) {
	$i = array_search($_POST['title_data'] . $_POST['year_'], $movies);
	unset($movies[$i]);
}

/*
seen_it_data', $_POST['seen_it_data']);
genre_1', $_POST['genre_1']);
genre_2', $_POST['genre_2']);
genre_3', $_POST['genre_3']);
hours', $_POST['hours']);
minutes', $_POST['minutes']);
seconds', $_POST['seconds']);
user_id', $_SESSION['user_id']);
synopsis_data', $_POST['synopsis_data']);
mpaa_rating_data', $_POST['mpaa_rating_data']);
filename', $filename);
mime_type', $_FILES['upload-image']['type']);
caption', $_POST['caption']);
rating_data', $_POST['rating_data']);
source_data', $_POST['source_data']);
width', $_POST['width']);
height', $_POST['height']);
size_', $_POST['size_']);
crf', $_POST['crf']);
unit', $_POST['unit']);
codec', $_POST['codec']);
extension', $_POST['extension']);
*/

















// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

// Start looking for errors.
if (empty($_POST['title_data'])) {
	$_SESSION['errors']['title_data'] = 'A title is required.'; // Global variables don't work because they won't be initialized at this point in the script, so must use session vars. It was either that or query strings. I like to only use query strings when it's for viewing records (like the movie page), not for editing them. The query string if() would've looked like this: if ( (isset($_POST['action']) and $_POST['action'] == 'Edit') or (isset($_GET['edit']) and isset($_GET['id'])) ) {}.
	$_SESSION['form']['id'] = $_POST['id'];
	if (isset($title_data)) { $_POST['title_data'] = $title_data; }
}

if (empty($_POST['year_'])) {
	$_SESSION['errors']['year_'] = 'A year is required.';
	$_SESSION['form']['id'] = $_POST['id'];
	if (isset($year_)) { $_POST['year_'] = $year_; }
}

if (in_multi_array($_POST['title_data'] . $_POST['year_'], $movies)) { // Check if the movie is already in the database (title + year).
	$_SESSION['errors']['duplicate_movie'] = 'A movie with the same name and year is already in the database.';
	$_SESSION['form']['id'] = $_POST['id'];
	if (isset($title_data)) { $_POST['title_data'] = $title_data; }
	if (isset($year_)) { $_POST['year_'] = $year_; }
}
// End looking for errors.

if ( (isset($_GET['add-form'])) and (isset($_SESSION['errors'])) ) {
	$_SESSION['errors']['add'] = TRUE;
	header('Location: .');
	exit();
}

if ( (isset($_GET['edit-form'])) and (isset($_SESSION['errors'])) ) {
	$_SESSION['errors']['edit'] = TRUE;
	header('Location: .');
	exit();
}

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//	if (empty($title_data)) {
		$errors = 'Name is required';
//	}
/*	else {
		$name = test_input($_POST["name"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
		$nameErr = "Only letters and white space allowed";
		}
	}
	
	if (empty($_POST["email"])) {
		$emailErr = "Email is required";
	}
	else {
		$email = test_input($_POST["email"]);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailErr = "Invalid email format";
		}
	}
	
	if (empty($_POST["website"])) {
		$website = "";
	}
	else {
		$website = test_input($_POST["website"]);
		// check if URL address syntax is valid (this regular expression also allows dashes in the URL)
		if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
		$websiteErr = "Invalid URL";
		}
	}

	if (empty($_POST["comment"])) {
		$comment = "";
	}
	else {
		$comment = test_input($_POST["comment"]);
	}

	if (empty($_POST["gender"])) {
		$genderErr = "Gender is required";
	}
	else {
		$gender = test_input($_POST["gender"]);
	}
*/
//}



//if (isset($_SESSION['errors'])) {
//unset($_SERVER['QUERY_STRING']);
//	header('Location: /../');
//}



function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
