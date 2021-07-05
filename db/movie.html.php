<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/helpers.php'; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/db/user-id.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php htmlout($page_title); ?></title>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/jquery.html.php'; ?>
		<script type="text/javascript" src="/jquery/movie.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/css.html.php'; ?>
	</head>
	<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-header.html.php'; ?>
		<div class="movieContainer">
			<h1><?php htmlout($page_title); ?></h1>
<?php if ($loggedIn and $hasRole): ?>
			<form action="../admin/db/" method="post">
				<input type="hidden" name="id" value="<?php htmlout($id); ?>">
				<input type="submit" name="action" value="Edit">
			</form>
<?php endif; ?>
			<div>
				<img src="<?php echo $image; ?>" alt="">
<?php if (isset($caption)): ?>
				<p><?php htmlout($caption); ?></p>
<?php endif;
if (isset($synopsis_data)): ?>
				<p><?php htmlout($synopsis_data); ?></p>
<?php endif; ?>
			</div>
			<div>
				<table>
					<tr>
						<th>ID</th>
					</tr>
					<tr>
						<td><?php htmlout($id); ?></td>
					</tr>
					<tr>
						<th>Title</th>
					</tr>
					<tr>
						<td><?php htmlout(articles_first($title_data)); ?></td>
					</tr>
					<tr>
						<th>Year Released</th>
					</tr>
					<tr>
						<td><?php htmlout($year_); ?></td>
					</tr>
					<tr>
						<th>MPAA Rating</th>
					</tr>
					<tr>
						<td><?php htmlout($mpaa_rating_data); ?></td>
					</tr>
					<tr>
						<th>Duration</th>
					</tr>
					<tr>
						<td><?php htmlout($duration); ?></td>
					</tr>
					<tr>
						<th>Seen It?</th>
					</tr>
					<tr>
						<td><?php htmlout($seen_it_data); ?></td>
					</tr>
					<tr>
						<th>Rating</th>
					</tr>
					<tr>
						<td><?php htmlout($rating_data); ?></td>
					</tr>
					<tr>
						<th>Genres</th>
					</tr>
					<tr>
						<td><?php htmlout($genre_comma_list); ?></td>
					</tr>
					<tr>
						<th>Source</th>
					</tr>
					<tr>
						<td><?php htmlout($source_data); ?></td>
					</tr>
					<tr>
						<th>Size</th>
					</tr>
					<tr>
						<td><?php htmlout($size_); echo ' '; htmlout($unit); ?></td>
					</tr>
					<tr>
						<th>Width</th>
					</tr>
					<tr>
						<td><?php htmlout($width); ?></td>
					</tr>

					<tr>
						<th>Height</th>
					</tr>
					<tr>
						<td><?php htmlout($height); ?></td>
					</tr>
					<tr>
						<th>Protection</th>
					</tr>
					<tr>
						<td><?php htmlout($protection); ?></td>
					</tr>
					<tr>
						<th>CRF</th>
					</tr>
					<tr>
						<td><?php htmlout($crf); ?></td>
					</tr>
					<tr>
						<th>Codec</th>
					</tr>
					<tr>
						<td><?php htmlout($codec); ?></td>
					</tr>
					<tr>
						<th>Extension</th>
					</tr>
					<tr>
						<td><?php htmlout($extension); ?></td>
					</tr>
					<tr>
						<th>Submitted By</th>
					</tr>
					<tr>
						<td><?php $i = $user_id; htmlout($name_[$i]); // Print the name of the user rather than his/her ID number. user-id.php is used to get all the names from the database. ?></td>
					</tr>
				</table>
			</div>
		</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-footer.html.php'; ?>
	</body>
</html>
