<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/universal.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/magic-quotes.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/helpers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/access.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/access-check.php';

if (isset($_POST['submit']) and $_POST['submit'] == 'Cancel') // In order for the Cancel button to work, you must put it before the "add" code so it doesn't execute that part. Remember, since the cancel button is an input type="submit", the form will be submitted, which will trigger isset($_GET['add']) if you put the cancel code after it. Also, instead of using a submit button, I could've just styled a regular hyperlink and made it look exactly like a button using jQuery UI, but I left it like this because I wanted to use PHP logic for more practice.
{
	header('Location: .');
	exit();
}

if ( (isset($_GET['add'])) or (isset($_SESSION['errors']['add'])) )
{
	include 'form-validation-check.php'; // This PHP file must be included here since it'll store values from $_SESSION['form'] into local variables within the scope of this if ().

	$page_title = 'Add Movie';
	$action = 'add-form';
	$id = NULL;
	$title_data = ''; // If you don't initialize these variables you'll get a "Notice: Undefined variable" message in the source code or in text boxes when trying to add a new movie.
	$year_ = NULL;
	$seen_it_data = '';
	$mpaa_rating_data = '';
	$genre_1 = '';
	$genre_2 = '';
	$genre_3 = '';
	$hours = '';
	$minutes = '';
	$seconds = '';
	$synopsis_data = '';
	$caption = '';
	$rating_data = 0; // If you initialize it at NULL, the slider won't come out.
	$source_data = '';
	$protection = '';
	$width = NULL;
	$height = NULL;
	$size_ = NULL;
	$crf = NULL;
	$unit = '';
	$codec = '';
	$extension = '';
	$filename = '';
	$mime_type = '';
	$filename_tn = '';
	$location = '';
	$button = 'Add Movie';

	include 'form-validation-set.php';
	include 'form.html.php';
	exit();
}

if (isset($_GET['add-form']))
{
	include 'form-validation.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

	try
	{
		$sql = 'INSERT INTO status_
				SET
					status_data = \'Enabled\';

				INSERT INTO title
				SET
					title_data = :title_data,
					year_ = :year_,
					date_added = CURDATE(),
					time_added = CURTIME(),
					user_id = :user_id;

				INSERT INTO seen_it
				SET
					seen_it_data = :seen_it_data;

				INSERT INTO genre
				SET
					genre_1 = :genre_1,
					genre_2 = :genre_2,
					genre_3 = :genre_3;

				INSERT INTO duration
				SET
					hours = :hours,
					minutes = :minutes,
					seconds = :seconds;

				INSERT INTO synopsis
				SET
					synopsis_data = :synopsis_data;

				INSERT INTO mpaa_rating
				SET
					mpaa_rating_data = :mpaa_rating_data;

				INSERT INTO image
				SET
					filename = :filename,
					mime_type = :mime_type,
					caption = :caption;

				INSERT INTO rating
				SET
					rating_data = :rating_data;

				INSERT INTO source_
				SET
					source_data = :source_data,
					protection = :protection;

				INSERT INTO resolution
				SET
					width = :width,
					height = :height;

				INSERT INTO file_
				SET
					size_ = :size_,
					crf = :crf,
					unit = :unit,
					codec = :codec,
					extension = :extension;
		';
		$s = $pdo->prepare($sql);
		$s->bindValue(':title_data', $_POST['title_data']);
		$s->bindValue(':year_', $_POST['year_']);
		if ($_POST['seen_it_data'] == NULL) { $_POST['seen_it_data'] = ''; }
		$s->bindValue(':seen_it_data', $_POST['seen_it_data']);
		$s->bindValue(':genre_1', $_POST['genre_1']);
		$s->bindValue(':genre_2', $_POST['genre_2']);
		$s->bindValue(':genre_3', $_POST['genre_3']);
		$s->bindValue(':hours', $_POST['hours']);
		$s->bindValue(':minutes', $_POST['minutes']);
		$s->bindValue(':seconds', $_POST['seconds']);
		$s->bindValue(':user_id', $_SESSION['user_id']);
		$s->bindValue(':synopsis_data', $_POST['synopsis_data']);
		$s->bindValue(':mpaa_rating_data', $_POST['mpaa_rating_data']);
		if (isset($_FILES['upload-image']['name']) and $_FILES['upload-image']['name'] != '') {
			$filename = url_image($_POST['title_data'], $_POST['year_'], $_FILES['upload-image']['type']); // $filename will be used to rename the image later in the script.
			move_uploaded_file($_FILES['upload-image']['tmp_name'], $image_dir_php . $filename); // Rename the image from whatever filename was uploaded to $filename.
			image_resize($image_dir_php . $filename, $image_dir_php . image_filename($filename, 'md'), 350, 500, 0, 80);
			image_resize($image_dir_php . $filename, $image_dir_php . image_filename($filename, 'tn'), 100, 100, 0, 75);
		}
		else {
			$filename = ''; // Even if the user DIDN'T upload an image, we still need to initialize the filename in the DB to maintain a sync with the AUTO_INCREMENT in the other tables of the same record. This is the one, key difference between the add and edit sections of the form logic. In the edit section, the filename doesn't need to be initialized, because by the time the script gets there, it already has been initialized by the add section.
		}
		$s->bindValue(':filename', $filename);
		$s->bindValue(':mime_type', $_FILES['upload-image']['type']);
		$s->bindValue(':caption', $_POST['caption']);
		if ($_POST['rating_data'] == 0) { $_POST['rating_data'] = NULL; }
		$s->bindValue(':rating_data', $_POST['rating_data']);
		if ($_POST['source_data'] == NULL) { $_POST['source_data'] = ''; } // Since $_POST['source_data'] comes from an input type="radio", the blank value is NULL instead of '', as it would be for an input type="text". Since the variable here deals with strings (e.g., 'Blu-ray,' 'DVD', etc.) I want to set the empty value to '' instead of NULL.
		$s->bindValue(':source_data', $_POST['source_data']);
		if ($_POST['protection'] == NULL) { $_POST['protection'] = ''; }
		$s->bindValue(':protection', $_POST['protection']);
		if ($_POST['width'] == '') { $_POST['width'] = NULL; } // Prevent $_POST['width'] = 0 if the $_POST['width'] input field was left empty (blank). The data type of $_POST['width'] is "smallint," not "string." So if you try to input an empty string, '', it defaults to 0 instead of NULL.
		$s->bindValue(':width', $_POST['width']);
		if ($_POST['height'] == '') { $_POST['height'] = NULL; }
		$s->bindValue(':height', $_POST['height']);
		if ($_POST['size_'] == '') { $_POST['size_'] = NULL; } // Prevent $_POST['size_'] = 0.00 if the $_POST['size_'] input field was left empty (blank). The data type of $_POST['size_'] is "decimal," not "string." So if you try to input an empty string, '', it defaults to 0.00 instead of NULL.
		$s->bindValue(':size_', $_POST['size_']);
		if ($_POST['crf'] == '') { $_POST['crf'] = NULL; }
		$s->bindValue(':crf', $_POST['crf']);
		if ($_POST['unit'] == NULL) { $_POST['unit'] = ''; }
		$s->bindValue(':unit', $_POST['unit']);
		if ($_POST['codec'] == NULL) { $_POST['codec'] = ''; }
		$s->bindValue(':codec', $_POST['codec']);
		if ($_POST['extension'] == NULL) { $_POST['extension'] = ''; }
		$s->bindValue(':extension', $_POST['extension']);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error adding submitted movie.';
		include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

if ( (isset($_POST['action']) and $_POST['action'] == 'Edit') or (isset($_SESSION['errors']['edit'])) )
{
	include 'form-validation-check.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

	try
	{
		$sql = 'SELECT title.id, title.title_data, title.year_, seen_it.seen_it_data, genre.genre_1, genre.genre_2, genre.genre_3,
					duration.hours, duration.minutes, duration.seconds, synopsis.synopsis_data,
					mpaa_rating.mpaa_rating_data, image.filename, image.mime_type, image.caption, rating.rating_data,
					source_.source_data, source_.protection, resolution.width, resolution.height, file_.size_, file_.crf, file_.unit, file_.codec, file_.extension
				FROM title
				INNER JOIN seen_it
					ON :id = seen_it.title_id
				INNER JOIN genre
					ON :id = genre.title_id
				INNER JOIN duration
					ON :id = duration.title_id
				INNER JOIN synopsis
					ON :id = synopsis.title_id
				INNER JOIN mpaa_rating
					ON :id = mpaa_rating.title_id
				INNER JOIN image
					ON :id = image.title_id
				INNER JOIN rating
					ON :id = rating.title_id
				INNER JOIN source_
					ON :id = source_.title_id
				INNER JOIN resolution
					ON :id = resolution.title_id
				INNER JOIN file_
					ON :id = file_.title_id
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

	$page_title = 'Edit Movie';
	$action = 'edit-form';
	$id = $row['id'];
	$title_data = $row['title_data'];
	$year_ = $row['year_'];
	$seen_it_data = $row['seen_it_data'];
	$genre_1 = $row['genre_1'];
	$genre_2 = $row['genre_2'];
	$genre_3 = $row['genre_3'];
	$hours = $row['hours'];
	$minutes = $row['minutes'];
	$seconds = $row['seconds'];
	$synopsis_data = $row['synopsis_data'];
	$mpaa_rating_data = $row['mpaa_rating_data'];
	$caption = $row['caption'];
	if ($row['rating_data'] == NULL) { $row['rating_data'] = 0; } // If you initialize it at NULL, the slider won't come out.
	$rating_data = $row['rating_data'];
	$source_data = $row['source_data'];
	$protection = $row['protection'];
	$width = $row['width'];
	$height = $row['height'];
	$size_ = $row['size_'];
	$crf = $row['crf'];
	$unit = $row['unit'];
	$codec = $row['codec'];
	$extension = $row['extension'];
	$button = 'Update Movie';

	if (isset($row['filename']) and $row['filename'] != '') // Notice how $row['mime_type'] is not checked to see if it is set. That's because if $row['filename'] is set, then $row['mime_type'] is automatically set and vise versa.
	{
		$filename = $row['filename'];
		$mime_type = $row['mime_type'];
		$filename_tn = image_filename($filename, 'tn');
		$thumbnail = $image_dir . image_filename($filename, 'tn');
	}

	if ( isset($_GET['disabled']) ) {
		$location = '?disabled';
	}
	else {
		$location = '.';
	}

	include 'form.html.php';
	exit();
}

if ( (isset($_GET['edit-form'])) )
{
	include 'form-validation.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

	if (isset($_POST['delete-image']))
	{
		try
		{
			$sql = 'UPDATE image
					SET
						filename = NULL,
						mime_type = NULL,
						caption = NULL
					WHERE title_id = :id;
			';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_POST['id']);
			$s->execute();

			if (file_exists($image_dir_php . $_POST['filename'])) { unlink($image_dir_php . $_POST['filename']); }
			if (file_exists($image_dir_php . image_filename($_POST['filename'], 'md'))) { unlink($image_dir_php . image_filename($_POST['filename'], 'md')); }
			if (file_exists($image_dir_php . $_POST['filename_tn'])) { unlink($image_dir_php . $_POST['filename_tn']); }
		}
		catch (PDOException $e)
		{
			$error = 'Error deleting the image!';
			include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
			exit();
		}
	}
	elseif (isset($_POST['submit']))
	{
		try
		{
			$sql = 'UPDATE title
					SET
						title_data = :title_data,
						year_ = :year_
					WHERE id = :id;

					UPDATE seen_it
					SET
						seen_it_data = :seen_it_data
					WHERE title_id = :id;

					UPDATE genre
					SET
						genre_1 = :genre_1,
						genre_2 = :genre_2,
						genre_3 = :genre_3
					WHERE title_id = :id;

					UPDATE duration
					SET
						hours = :hours,
						minutes = :minutes,
						seconds = :seconds
					WHERE title_id = :id;

					UPDATE synopsis
					SET
						synopsis_data = :synopsis_data
					WHERE title_id = :id;

					UPDATE mpaa_rating
					SET
						mpaa_rating_data = :mpaa_rating_data
					WHERE title_id = :id;

					UPDATE image
					SET
						caption = :caption
					WHERE title_id = :id;

					UPDATE rating
					SET
						rating_data = :rating_data
					WHERE title_id = :id;

					UPDATE source_
					SET
						source_data = :source_data,
						protection = :protection
					WHERE title_id = :id;

					UPDATE resolution
					SET
						width = :width,
						height = :height
					WHERE title_id = :id;

					UPDATE file_
					SET
						size_ = :size_,
						crf = :crf,
						unit = :unit,
						codec = :codec,
						extension = :extension
					WHERE title_id = :id;
			';
			if (isset($_FILES['upload-image']['name']) and $_FILES['upload-image']['name'] != '')
			{
				$sql .= 'UPDATE image
						SET
							filename = :filename,
							mime_type = :mime_type
						WHERE title_id = :id;
				';
			}
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $_POST['id']);
			$s->bindValue(':title_data', $_POST['title_data']);
			$s->bindValue(':year_', $_POST['year_']);
			if ($_POST['seen_it_data'] == NULL) { $_POST['seen_it_data'] = ''; }
			$s->bindValue(':seen_it_data', $_POST['seen_it_data']);
			$s->bindValue(':genre_1', $_POST['genre_1']);
			$s->bindValue(':genre_2', $_POST['genre_2']);
			$s->bindValue(':genre_3', $_POST['genre_3']);
			$s->bindValue(':hours', $_POST['hours']);
			$s->bindValue(':minutes', $_POST['minutes']);
			$s->bindValue(':seconds', $_POST['seconds']);
			$s->bindValue(':synopsis_data', $_POST['synopsis_data']);
			$s->bindValue(':mpaa_rating_data', $_POST['mpaa_rating_data']);
			if (isset($_FILES['upload-image']['name']) and $_FILES['upload-image']['name'] != '')
			{
				$filename = url_image($_POST['title_data'], $_POST['year_'], $_FILES['upload-image']['type']);
				$s->bindValue(':filename', $filename);
				$s->bindValue(':mime_type', $_FILES['upload-image']['type']);
				move_uploaded_file($_FILES['upload-image']['tmp_name'], $image_dir_php . $filename);
				image_resize($image_dir_php . $filename, $image_dir_php . image_filename($filename, 'md'), 350, 500, 0, 80);
				image_resize($image_dir_php . $filename, $image_dir_php . image_filename($filename, 'tn'), 100, 100, 0, 75);
			}
			$_POST['caption'] = $_POST['caption'] == '' ? NULL : $_POST['caption']; // Ternary expression. If $_POST['caption'] = '', then $_POST['caption'] = NULL, else, $_POST['caption'] = $_POST['caption'].
			$s->bindValue(':caption', $_POST['caption']);
			if ($_POST['rating_data'] == 0) { $_POST['rating_data'] = NULL; }
			$s->bindValue(':rating_data', $_POST['rating_data']);
			if ($_POST['source_data'] == NULL) { $_POST['source_data'] = ''; }
			$s->bindValue(':source_data', $_POST['source_data']);
			if ($_POST['protection'] == NULL) { $_POST['protection'] = ''; }
			$s->bindValue(':protection', $_POST['protection']);
			if ($_POST['width'] == '') { $_POST['width'] = NULL; }
			$s->bindValue(':width', $_POST['width']);
			if ($_POST['height'] == '') { $_POST['height'] = NULL; }
			$s->bindValue(':height', $_POST['height']);
			if ($_POST['size_'] == '') { $_POST['size_'] = NULL; }
			$s->bindValue(':size_', $_POST['size_']);
			if ($_POST['crf'] == '') { $_POST['crf'] = NULL; }
			$s->bindValue(':crf', $_POST['crf']);
			if ($_POST['unit'] == NULL) { $_POST['unit'] = ''; }
			$s->bindValue(':unit', $_POST['unit']);
			if ($_POST['codec'] == NULL) { $_POST['codec'] = ''; }
			$s->bindValue(':codec', $_POST['codec']);
			if ($_POST['extension'] == NULL) { $_POST['extension'] = ''; }
			$s->bindValue(':extension', $_POST['extension']);
			$s->execute();
		}
		catch (PDOException $e)
		{
			$error = 'Error updating submitted title.';
			include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
			exit();
		}
	}

	header('Location: ' . $_POST['location']);
	exit();
}

if (isset($_POST['action']) and ($_POST['action'] == 'Disable' or $_POST['action'] == 'Enable')) // Start "set status."
{
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

	try
	{
		$sql = "UPDATE status_
				SET status_data = '" . $_POST['action'] . "d'
				WHERE title_id = :id;
		";
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = "Error $err the movie!";
		include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
		exit();
	}

	if ($_POST['action'] == 'Disable') {
		$err = 'disabling';
		$location = '.';
	}
	elseif ($_POST['action'] == 'Enable') {
		$err = 'enabling';
		$location = '?disabled';
	}

	header('Location: $location');
	exit();
} // End "set status."

if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

	// Delete the movie.
	try
	{ // You should not delete from multiple tables in one query, that's why the DELETE statements below are split into several queries. Source: http://stackoverflow.com/questions/3331992/how-to-delete-from-multiple-tables-in-mysql. Added: 4/29/2013.
		$sql = 'DELETE FROM title WHERE id = :id;
				DELETE FROM seen_it WHERE title_id = :id;
				DELETE FROM genre WHERE title_id = :id;
				DELETE FROM duration WHERE title_id = :id;
				DELETE FROM synopsis WHERE title_id = :id;
				DELETE FROM mpaa_rating WHERE title_id = :id;
				DELETE FROM rating WHERE title_id = :id;
				DELETE FROM source_ WHERE title_id = :id;
				DELETE FROM resolution WHERE title_id = :id;
				DELETE FROM file_ WHERE title_id = :id;
				DELETE FROM status_ WHERE title_id = :id;
		';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error deleting the movie!';
		include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
		exit();
	}

	try
	{ // Before deleting the image's info from the database, its filename is selected so that it can be used to delete the image files further down.
		$sql = 'SELECT filename
				FROM image
				WHERE title_id = :id;

				DELETE FROM image WHERE title_id = :id;
		';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error retrieving the image\'s filename!';
		include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
		exit();
	}

	$row = $s->fetch();

	$filename = $row['filename'];

	if (file_exists($image_dir_php . $filename)) { unlink($image_dir_php . $filename); }
	if (file_exists($image_dir_php . image_filename($filename, 'md'))) { unlink($image_dir_php . image_filename($filename, 'md')); }
	if (file_exists($image_dir_php . image_filename($filename, 'tn'))) { unlink($image_dir_php . image_filename($filename, 'tn')); }

	header('Location: .');
	exit();
}

if (isset($_GET['disabled']))
{
	$page_title = 'Disabled';
	$button = 'Enable';

	include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

	try
	{
		$result = $pdo->query('SELECT id, title_data, year_, status_.status_data
								FROM title
								INNER JOIN status_
									ON title.id = status_.title_id
								WHERE status_.status_data = \'Disabled\';
						');
	}
	catch (PDOException $e)
	{
		$error = 'Error fetching disabled movies from the database!';
		include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
		exit();
	}

	foreach ($result as $row) // $result must be convert to an array, or you'll get: "Fatal error: Cannot use object of type PDOStatement as array." Remember, $result is a variable of the type: MySQL result set.
	{
		$movies[] = [
			'id' => $row['id'],
			'title_data' => $row['title_data'],
			'year_' => $row['year_']
		];
	}

	if (isset($movies)) {
		$movies = array_orderby($movies, 'title_data', SORT_ASC); // Helper function for sorting multi-dimensional arrays.
	}

	include 'edit-delete.html.php';
	exit();
}

// Display the movie list.
$page_title = 'Edit / Delete Movie';
$button = 'Disable';

include 'form-validation-unset.php'; // It's not necessary to include this file in every page since after adding or editing a movie, the user gets taken to this very same script--the edit page in index.php--thus the unset() in this file gets triggered as soon as a movie is added or edited. Added: 2014/10/17.
include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

try
{
	$result = $pdo->query('SELECT id, title_data, year_, status_.status_data
							FROM title
							INNER JOIN status_
								ON title.id = status_.title_id
							WHERE status_.status_data = \'Enabled\';
					');
}
catch (PDOException $e)
{
	$error = 'Error fetching movies from the database!';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}

foreach ($result as $row) // $result must be convert to an array, or you'll get: "Fatal error: Cannot use object of type PDOStatement as array." Remember, $result is a variable of the type: MySQL result set.
{
	$movies[] = [
		'id' => $row['id'],
		'title_data' => $row['title_data'],
		'year_' => $row['year_']
	];
}

if (isset($movies)) {
	$movies = array_orderby($movies, 'title_data', SORT_ASC); // Helper function for sorting multi-dimensional arrays.
}

include 'edit-delete.html.php';
?>
