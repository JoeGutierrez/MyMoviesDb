<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/helpers.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php htmlout($page_title); ?></title>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/jquery.html.php'; ?>
		<script type="text/javascript" src="/admin/jquery/edit-delete.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/css.html.php'; ?>
	</head>
	<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-header.html.php'; ?>
		<div class="editDeleteEnableDisableContainer">
			<h1><?php htmlout($page_title); ?></h1>
<?php
if (isset($movies)):
	foreach ($movies as $movie):
?>
			<form action="" method="post">
<?php if ($detect->isMobile() or $detect->isTablet()): ?>
				<table>
					<tr>
						<td><input type="submit" name="action" value="Edit"></td>
						<td><input type="submit" name="action" value="<?php htmlout($button); ?>"></td>
						<td><input type="submit" name="action" value="Delete"></td>
					</tr>
					<tr>
						<td colspan="3"><a href="/db/?movie=<?php htmlout(url_title(articles_last($movie['title_data']), $movie['year_'])); ?>&amp;id=<?php echo $movie['id']; ?>"><?php htmlout($movie['title_data']); ?> (<?php htmlout($movie['year_']); ?>)</a></td>
					</tr>
				</table>
<?php else: ?>
				<table>
					<tr>
						<td><input type="submit" name="action" value="Edit"></td>
						<td><input type="submit" name="action" value="<?php htmlout($button); ?>"></td>
						<td><input type="submit" name="action" value="Delete"></td>
						<td><a href="/db/?movie=<?php htmlout(url_title(articles_last($movie['title_data']), $movie['year_'])); ?>&amp;id=<?php echo $movie['id']; ?>"><?php htmlout($movie['title_data']); ?> (<?php htmlout($movie['year_']); ?>)</a></td>
					</tr>
				</table>
<?php endif; ?>
				<input type="hidden" name="id" value="<?php echo $movie['id']; ?>">
			</form>
<?php
	endforeach;
elseif (!isset($movies) and $_SERVER['QUERY_STRING'] == 'disabled'):
?>
			<div class="error">There are no movies in the database to edit / delete or all of them are enabled!</div>
<?php
elseif (!isset($movies)):
?>
			<div class="error">There are no movies in the database to edit / delete or all of them are disabled!</div>
<?php
endif;
?>
			<div class="deleteMovieDialog invisible"></div>
		</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-footer.html.php'; ?>
	</body>
</html>
