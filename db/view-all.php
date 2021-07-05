<?php
$page_title = 'View All';

include $_SERVER['DOCUMENT_ROOT'] . '/inc/db.php';

$page = isset($_GET['page']) ? htmlspecialchars($_GET['page'], ENT_QUOTES, 'UTF-8') : '1';

if( !is_numeric($page) ) {
	$error = 'The page number is not numeric.';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}

$number_of_movies_per_page = 20;
$start_at = ($page * $number_of_movies_per_page) - $number_of_movies_per_page;
$end_at = ($page * $number_of_movies_per_page) - 1;

// Start page links. Added: 03/06/2018. //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
try
{
	$total_number_of_movies_obj = $pdo->query("SELECT COUNT(*) FROM title;"); // Sorting and getting a range of rows. In order for the sorting to work via the database, articles must be put last in the title by default. Sources: http://stackoverflow.com/questions/3599297/how-do-i-sort-the-top-10-entries-in-descending-order-in-mysql http://stackoverflow.com/questions/16699734/mysql-query-for-table-row-range Added: 07/25/2016.
}
catch (PDOException $e)
{
	$error = 'Error fetching the total number of movies.';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}

$total_number_of_movies = $total_number_of_movies_obj->fetch()[0]; // Source: https://stackoverflow.com/questions/31527781/printing-pdo-query-results (Jessica's answer.) Added: 03/06/2018.
$pages_whole = floor( $total_number_of_movies / $number_of_movies_per_page ) - 1; // Source: https://stackoverflow.com/questions/5797625/how-to-divide-numbers-without-remainder-in-php (KingCrunch's answer.) Added: 03/06/2018. Updated: 07/05/2021 (needed to add - 1 to reduce the number of pages from five to four after disabling several movies).
$page_remainder = $total_number_of_movies % $number_of_movies_per_page; // E.g.: If there's 86 movies, the result would be 6.
$links_to_pages = '';
$valid_pages = [];

for ( $page_number = 1; $page_number <= $pages_whole; $page_number++ ) {
	$links_to_pages .= '<a href="/db/?view-all&page=' . $page_number . '">' . $page_number . '</a> ';
	$valid_pages[] = $page_number; // Add the current page number to the valid pages array.
}

if ( $page_remainder > 0 ) { // Add an extra page page. For example, if there's 86 movies and it's displaying 20 per page, this would create a link to page showing the last six.
	$links_to_pages .= '<a href="/db/?view-all&page=' . $page_number . '">' . $page_number . '</a> ';
	$valid_pages[] = $page_number;
}

if( !in_array($page, $valid_pages) ) {
	$error = 'Invalid page number.';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}
// End page links. //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

try
{
	$result = $pdo->query("SELECT title.id, title.title_data, title.year_, title.date_added, genre.genre_1, genre.genre_2, genre.genre_3, mpaa_rating.mpaa_rating_data, status_.status_data, image.filename
							FROM title
							INNER JOIN genre
								ON title.id = genre.title_id
							INNER JOIN mpaa_rating
								ON title.id = mpaa_rating.title_id
							INNER JOIN status_
								ON title.id = status_.title_id
							INNER JOIN image
								ON title.id = image.title_id
							WHERE status_.status_data = 'Enabled'
							ORDER BY title_data ASC
							LIMIT $start_at, $number_of_movies_per_page;
					"); // Sorting and getting a range of rows. In order for the sorting to work via the database, articles must be put last in the title by default. Sources: http://stackoverflow.com/questions/3599297/how-do-i-sort-the-top-10-entries-in-descending-order-in-mysql http://stackoverflow.com/questions/16699734/mysql-query-for-table-row-range Added: 07/25/2016.
}
catch (PDOException $e)
{
	$error = 'Error fetching list of movies.';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}

foreach ($result as $row)
{
	$movies[] = [
		'id' => $row['id'], // The title's ID is needed for the hyperlink to the movie page, since the movie page queries the database using the title's ID.
		'title_data' => $row['title_data'],
		'year_' => $row['year_'],
		'genre_1' => $row['genre_1'],
		'genre_2' => $row['genre_2'],
		'genre_3' => $row['genre_3'],
		'mpaa_rating_data' => $row['mpaa_rating_data'],
		'filename' => $row['filename']
	];
}

for ($i = 0; isset($movies[$i]); $i++)
{
	$movies[$i]['filename'] = $image_dir . image_filename($movies[$i]['filename'], 'tn');
	if ($movies[$i]['filename'] == '/img/movies/-tn.jpg') { $movies[$i]['filename'] = '/img/no-image-tn.png'; }
}

if (!isset($movies))
{
	$error = 'There are no movies in the database!';
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/error.html.php';
	exit();
}

/* The following lines were commented out because the sorting and limiting is done in the query now (07/30/2016).
$count = 1; // This variable will keep count of how many movies there are.
$movies = articles_last_multi_arr($movies);
$movies = array_orderby($movies, 'title_data', SORT_ASC); // Helper function for sorting multi-dimensional arrays.
*/

include 'view-all.html.php';
exit();
?>
