<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/helpers.php'; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/db/user-id.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php htmlout($page_title); ?></title>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/jquery.html.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/css.html.php'; ?>
	</head>
	<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-header.html.php'; ?>
		<div class="viewAllContainer">
			<h1>View All</h1>
			<table>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Thumbnail</th>
					<th>Genres</th>
					<th>MPAA Rating</th>
				</tr>
<?php foreach ($movies as $movie): ?>
				<tr>
					<td><?php htmlout($start_at + 1); $start_at++; ?></td>
					<td><a href="/db/?movie=<?php htmlout(url_title(articles_last($movie['title_data']), $movie['year_'])); ?>&amp;id=<?php echo $movie['id']; ?>"><?php htmlout($movie['title_data']); ?> (<?php htmlout($movie['year_']); ?>)</a></td>
					<td><a href="/db/?movie=<?php htmlout(url_title(articles_last($movie['title_data']), $movie['year_'])); ?>&amp;id=<?php echo $movie['id']; ?>"><img src="<?php echo $movie['filename']; ?>" alt=""></a></td>
					<td><?php htmlout(genre_comma_list($movie['genre_1'], $movie['genre_2'], $movie['genre_3'])); ?></td>
					<td><?php htmlout($movie['mpaa_rating_data']); ?></td>
				</tr>
<?php endforeach; ?>
			</table>
<?php
echo <<< html
			<div class="pageNumbers">
				<p>Pages: $links_to_pages</p>
			</div>
html;
?>
		</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-footer.html.php'; ?>
	</body>
</html>
