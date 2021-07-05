<?php
if (!isset($_GET['id']) or $_GET['id'] == '')
{
	$error = 'The movie\'s ID is not set in the URL!';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}

$id = $_GET['id'];

include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

try
{
	$result = $pdo->query('SELECT id
							FROM title;
					');
}
catch (PDOException $e)
{
	$error = 'Database error: Can\'t find the movie\'s ID in the database!<br>' . $e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}

foreach ($result as $row)
{
	$ids[] = ['id' => $row['id']];
}

try
{
	if (!in_multi_array($id, $ids))
	{
		throw new Exception('There\'s no movie in the database with an ID of ' . $id . '!');
	}
}
catch (Exception $e)
{
	$error = 'General error: ' . $e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}

try
{
	$sql = 'SELECT title.id, title.title_data, title.year_, title.user_id, synopsis.synopsis_data, mpaa_rating.mpaa_rating_data, image.filename, image.caption, genre.genre_1, genre.genre_2, genre.genre_3, source_.source_data, source_.protection, duration.hours, duration.minutes, duration.seconds, file_.size_, file_.crf, file_.unit, file_.codec, file_.extension, seen_it.seen_it_data, rating.rating_data, resolution.width, resolution.height
			FROM title
			INNER JOIN synopsis
				ON :id = synopsis.title_id
			INNER JOIN mpaa_rating
				ON :id = mpaa_rating.title_id
			INNER JOIN image
				ON :id = image.title_id
			INNER JOIN genre
				ON :id = genre.title_id
			INNER JOIN duration
				ON :id = duration.title_id
			INNER JOIN source_
				ON :id = source_.title_id
			INNER JOIN file_
				ON :id = file_.title_id
			INNER JOIN seen_it
				ON :id = seen_it.title_id
			INNER JOIN rating
				ON :id = rating.title_id
			INNER JOIN resolution
				ON :id = resolution.title_id
			WHERE title.id = :id;
	';
	$s = $pdo->prepare($sql);
	$s->bindValue(':id', $id);
	$s->execute();
}
catch (PDOException $e)
{
	$error = 'Error fetching movie details.';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}

$row = $s->fetch();

$page_title = articles_first($row['title_data']) . ' (' . $row['year_'] . ')';
$id = $row['id'];
$title_data = $row['title_data'];
$year_ = $row['year_'];
$user_id = $row['user_id'];
$synopsis_data = $row['synopsis_data'] != '' ? $row['synopsis_data'] : NULL;
$mpaa_rating_data = $row['mpaa_rating_data'];
$caption = $row['caption'];

if ($image_dir . image_filename($row['filename'], 'md') == '/img/movies/-md.jpg') { // If the movie has no image...
	$image = '/img/no-image.png';
}
elseif (file_exists($image_dir_php . image_filename($row['filename'], 'md'))) { // If the movie does have an image...
	$image = $image_dir . image_filename($row['filename'], 'md');
}
elseif (!file_exists($image_dir_php . image_filename($row['filename'], 'md'))) { // If the movie does have an image, but the original one (the source) was too small... This statement is needed because if the user uploads an image that's smaller than the dimensions of the -md.jpg, an -md.jpg won't be created, so you have to use the original instead.
	$image = $image_dir . $row['filename'];
}

$genre_comma_list = genre_comma_list($row['genre_1'], $row['genre_2'], $row['genre_3']);

if ($row['hours'] == NULL) { $row['hours'] = '00'; }
if ($row['minutes'] == NULL) { $row['minutes'] = '00'; }
if ($row['seconds'] == NULL) { $row['seconds'] = '00'; }
$duration = $hours = $row['hours'] . ':' . $minutes = $row['minutes'] . ':' . $seconds = $row['seconds'];
if ($duration == '00:00:00') { $duration = ''; }

$source_data = $row['source_data'];
$protection = $row['protection'];
$size_ = $row['size_'];
$unit = $row['unit'];
$codec = $row['codec'];
$extension = $row['extension'];
$seen_it_data = $row['seen_it_data'];

$rating_data = $row['rating_data'] != '' ? $row['rating_data'] : NULL;
$rating_data = substr($rating_data, -2) == '.0' ? $rating_data = intval($rating_data) : $rating_data; // If the last 2 characters are .0, remove them from the variable. E.g.: 6.0 becomes 6, since intval() returns the integer value. Source: http://php.net/manual/en/function.intval.php Added: 01/09/2015.
$rating_data = $rating_data ? $rating_data .= ' / 10' : $rating_data;

$crf = $row['crf'];
$crf = substr($crf, -3) == '.00' ? $crf = intval($crf) : $crf;

$width = $row['width'];
$height = $row['height'];

if ($_GET['movie'] != url_title($title_data, $year_))
{
	$error = 'Movie name and ID don\'t match!';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}

include 'movie.html.php';
?>
