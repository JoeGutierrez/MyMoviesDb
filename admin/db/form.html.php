<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/helpers.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php htmlout($page_title); ?></title>
		<script type="text/javascript">
			var value = <?php echo $rating_data; // Pass the value of the PHP variable "$rating_data" to the JavaScript variable "value." The reason the variable "value" is assigned here and not in form.js is because .js files can't parse PHP code unless you configure them to in an .htaccess file, which I'm avoiding to keep it simple. ?>;
		</script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/jquery.html.php'; ?>
		<script type="text/javascript" src="/admin/jquery/form.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/css.html.php'; ?>
	</head>
	<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-header.html.php'; ?>
		<div class="addEditContainer">
			<h1><?php htmlout($page_title); ?></h1>
			<div class="readableBG">
<?php if ( isset($errors['duplicate_movie']) and (!isset($errors['title_data']) and !isset($errors['year_'])) ): ?>
				<p class="error"><?php echo $errors['duplicate_movie']; ?></p>
<?php endif; ?>
				<form action="?<?php htmlout($action); ?>" method="post" enctype="multipart/form-data">
					<div>
<?php if (isset($errors['title_data'])): ?>
						<p class="error"><?php echo $errors['title_data']; ?></p>
<?php endif; ?>
						<label for="title">Title: </label><input type="text" name="title_data" id="title" value="<?php htmlout($title_data); ?>">
					</div>
					<div>
<?php if (isset($errors['year_'])): ?>
						<p class="error"><?php echo $errors['year_']; ?></p>
<?php endif; ?>
						<label for="year_">Year:</label>
						<select name="year_" id="year_" class="chosenYears">
							<option value=""></option>
<?php for ($x=date("Y"); $x > 1895; $x--): ?>
							<option value="<?php echo $x; ?>"<?php
								if ((isset($year_)) and ($x == $year_)) {
									echo ' selected';
								}
								?>><?php echo $x; ?></option>
<?php endfor; ?>
						</select>
					</div>
					<div class="seen_it_data"><!-- For: $('.seen_it_data, .source_data, .unit, .codec, .extension, .protection').buttonset(); -->
						Seen it?
						<input type="radio" id="yes" name="seen_it_data" value="Yes"<?php if (isset($seen_it_data) and ($seen_it_data == 'Yes')) echo ' checked' ?>><label for="yes">Yes</label>
						<input type="radio" id="no" name="seen_it_data" value="No"<?php if (isset($seen_it_data) and ($seen_it_data == 'No')) echo ' checked' ?>><label for="no">No</label>
					</div>
					<div>
<?php
$genres = ['Psychological', 'Thriller', 'War', 'Paranormal', 'Supernatural', 'Sport', 'Sci-Fi', 'Documentary', 'Foreign', 'Show', 'Crime', 'Bible', 'Soccer', 'Miniseries', 'Indie', 'Family', 'Racing', 'Dinosaur', 'Satanic', 'History', 'Romance', 'Video Game', 'MMA', 'Holiday', 'Sitcom', 'Zombie', 'Illegal Immigration', 'Animation', 'Wrestling', 'Found Footage', 'Sword and Sandal', 'Werewolf', 'Martial Arts', 'Christmas', 'Torture', 'Monster', 'Horror', 'Fantasy', 'Music', 'Superhero', 'Vampire', 'Slasher', 'Dance', 'Thanksgiving', 'Basketball', 'Epic', 'Survival', 'Ghost', 'Mystery', 'Drama', 'Sword and Sorcery', 'Comedy', 'Boxing', 'Musical', 'Biography', 'Baseball', 'Adventure', 'Western', 'Football', 'Action', 'Teen Scream', 'Racism', 'Conspiracy', 'Dog', 'Cat', 'Tearjerker', 'Animals', 'Halloween', 'Revenge', 'Apocalyptic', 'Christian', 'Disaster', 'Exorcism', 'Satire', 'Buddy Cop', 'Religious', 'Japan', 'Nicaragua', 'Central America', 'China'];
sort ($genres);
?>
						<label for="genre_1">Genre 1:</label>
						<select name="genre_1" id="genre_1" class="chosenGenreData">
							<option value=""></option>
<?php foreach ($genres as $genre): ?>
							<option value="<?php echo $genre; ?>"<?php if (isset($genre_1) and ($genre_1 == $genre)) echo ' selected' ?>><?php echo $genre; ?></option>
<?php endforeach; ?>
						</select>
						<br><label for="genre_2">Genre 2:</label>
						<select name="genre_2" id="genre_2" class="chosenGenreData">
							<option value=""></option>
<?php foreach ($genres as $genre): ?>
							<option value="<?php echo $genre; ?>"<?php if (isset($genre_2) and ($genre_2 == $genre)) echo ' selected' ?>><?php echo $genre; ?></option>
<?php endforeach; ?>
						</select>
						<br><label for="genre_3">Genre 3:</label>
						<select name="genre_3" id="genre_3" class="chosenGenreData">
							<option value=""></option>
<?php foreach ($genres as $genre): ?>
							<option value="<?php echo $genre; ?>"<?php if (isset($genre_3) and ($genre_3 == $genre)) echo ' selected' ?>><?php echo $genre; ?></option>
<?php endforeach; ?>
						</select>
					</div>
					<div>
<?php
$hours_arr = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09'];
$minutes_arr = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59'];
$seconds_arr = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59'];
?>
						<label for="hours">Duration (hh:mm:ss):</label>
						<select name="hours" id="hours" class="chosenHours">
							<option value=""></option>
<?php foreach ($hours_arr as $hour): ?>
							<option value="<?php echo $hour; ?>"<?php if (isset($hours) and ($hours == $hour)) echo ' selected' ?>><?php echo $hour; ?></option>
<?php endforeach; ?>
						</select> :
						<select name="minutes" id="minutes" class="chosenMinutes">
							<option value=""></option>
<?php foreach ($minutes_arr as $minute): ?>
							<option value="<?php echo $minute; ?>"<?php if (isset($minutes) and ($minutes == $minute)) echo ' selected' ?>><?php echo $minute; ?></option>
<?php endforeach; ?>
						</select> :
						<select name="seconds" id="seconds" class="chosenSeconds">
							<option value=""></option>
<?php foreach ($seconds_arr as $second): ?>
							<option value="<?php echo $second; ?>"<?php if (isset($seconds) and ($seconds == $second)) echo ' selected' ?>><?php echo $second; ?></option>
<?php endforeach; ?>
						</select>
					</div>
					<div>
						<label for="synopsis_data">Synopsis:</label><br><textarea name="synopsis_data" id="synopsis_data"><?php htmlout($synopsis_data); ?></textarea>
					</div>
					<div>
						<label>MPAA Rating:</label>
						<select name="mpaa_rating_data" id="mpaa_rating_data" class="chosenMPAARating">
							<option value=""></option>
							<option value="NR"<?php if ((isset($mpaa_rating_data)) and ($mpaa_rating_data == "NR")) echo ' selected' ?>>NR</option>
							<option value="G"<?php if ((isset($mpaa_rating_data)) and ($mpaa_rating_data == "G")) echo ' selected' ?>>G</option>
							<option value="PG"<?php if ((isset($mpaa_rating_data)) and ($mpaa_rating_data == "PG")) echo ' selected' ?>>PG</option>
							<option value="PG-13"<?php if ((isset($mpaa_rating_data)) and ($mpaa_rating_data == "PG-13")) echo ' selected' ?>>PG-13</option>
							<option value="R"<?php if ((isset($mpaa_rating_data)) and ($mpaa_rating_data == "R")) echo ' selected' ?>>R</option>
							<option value="NC-17"<?php if ((isset($mpaa_rating_data)) and ($mpaa_rating_data == "NC-17")) echo ' selected' ?>>NC-17</option>
							<option value="UR"<?php if ((isset($mpaa_rating_data)) and ($mpaa_rating_data == "UR")) echo ' selected' ?>>UR</option>
						</select>
					</div>
					<div>
<?php if(!isset($filename) or $filename == NULL): ?>
						<label for="upload-image">Upload Image: </label><input type="file" id="upload-image" name="upload-image">
<?php else: ?>
						<img src="<?php echo $thumbnail; ?>" alt="Thumbnail"><input type="submit" class="deleteImage" name="delete-image" value="Delete Image">
<?php endif; ?>
					</div>
					<div>
						<label for="caption">Caption: </label><input type="text" id="caption" name="caption" value="<?php htmlout($caption); ?>">
					</div>
					<div>
						<label for="rating_data">Rating:</label>
						<input type="text" id="rating_data" name="rating_data" readonly>
						<div id="rating">
							<div>
								<div>|</div>
								<div>1</div>
								<div>|</div>
								<div>2</div>
								<div>|</div>
								<div>3</div>
								<div>|</div>
								<div>4</div>
								<div>|</div>
								<div>5</div>
								<div>|</div>
								<div>6</div>
								<div>|</div>
								<div>7</div>
								<div>|</div>
								<div>8</div>
								<div>|</div>
								<div>9</div>
								<div>|</div>
								<div>10</div>
							</div>
						</div>
					</div>
					<div class="source_data"><!-- For: $('.seen_it_data, .source_data, .unit, .codec, .extension, .protection').buttonset(); -->
						Source:
						<input type="radio" id="blu-ray" name="source_data" value="Blu-ray"<?php if (isset($source_data) and ($source_data == 'Blu-ray')) echo ' checked' ?>><label for="blu-ray">Blu-ray</label>
						<input type="radio" id="dvd" name="source_data" value="DVD"<?php if (isset($source_data) and ($source_data == 'DVD')) echo ' checked' ?>><label for="dvd">DVD</label>
						<input type="radio" id="download" name="source_data" value="Download"<?php if (isset($source_data) and ($source_data == 'Download')) echo ' checked' ?>><label for="download">Download</label>
					</div>
					<div class="protection"><!-- For: $('.seen_it_data, .source_data, .unit, .codec, .extension, .protection').buttonset(); -->
						Protection:
						<input type="radio" id="none" name="protection" value="None"<?php if (isset($protection) and ($protection == 'None')) echo ' checked' ?>><label for="none">None</label>
						<input type="radio" id="cinavia" name="protection" value="Cinavia"<?php if (isset($protection) and ($protection == 'Cinavia')) echo ' checked' ?>><label for="cinavia">Cinavia</label>
					</div>
					<div>
						<label for="width">Width: </label><input type="text" id="width" name="width" value="<?php htmlout($width); ?>"><span class="widthXheight"> x </span><label for="height">Height: </label><input type="text" id="height" name="height" value="<?php htmlout($height); ?>">
					</div>
					<div class="unit"><!-- For: $('.seen_it_data, .source_data, .unit, .codec, .extension, .protection').buttonset(); -->
						<label for="size_">File size: </label><input type="text" id="size_" name="size_" value="<?php htmlout($size_); ?>">
						<input type="radio" id="gb" name="unit" value="GB"<?php if (isset($unit) and ($unit == 'GB')) echo ' checked' ?>><label for="gb">GB</label>
						<input type="radio" id="mb" name="unit" value="MB"<?php if (isset($unit) and ($unit == 'MB')) echo ' checked' ?>><label for="mb">MB</label>
					</div>
					<div>
<?php
$crfs = [26, 25.75, 25.5, 25.25, 25, 24.75, 24.5, 24.25, 24, 23.75, 23.5, 23.25, 23, 22.75, 22.5, 22.25, 22, 21.75, 21.5, 21.25, 21, 20.75, 20.5, 20.25, 20, 19.75, 19.5, 19.25, 19, 18.75, 18.5, 18.25, 18, 17.75, 17.5, 17.25, 17, 16.75, 16.5, 16.25, 16, 15.75, 15.5, 15.25, 15];
sort ($crfs);
?>
						<label for="crf">CRF:</label>
						<select name="crf" id="crf" class="chosenCRF">
							<option value=""></option>
<?php foreach ($crfs as $crf_here): ?>
							<option value="<?php echo $crf_here; ?>"<?php if (isset($crf) and ($crf == $crf_here)) echo ' selected' ?>><?php echo $crf_here; ?></option>
<?php endforeach; ?>
						</select>
					</div>
					<div class="codec"><!-- For: $('.seen_it_data, .source_data, .unit, .codec, .extension, .protection').buttonset(); -->
						Codec:
						<input type="radio" id="h265" name="codec" value="H.265"<?php if (isset($codec) and ($codec == 'H.265')) echo ' checked' ?>><label for="h265">H.265</label>
						<input type="radio" id="h264" name="codec" value="H.264"<?php if (isset($codec) and ($codec == 'H.264')) echo ' checked' ?>><label for="h264">H.264</label>
					</div>
					<div class="extension"><!-- For: $('.seen_it_data, .source_data, .unit, .codec, .extension, .protection').buttonset(); -->
						Extension:
						<input type="radio" id="mkv" name="extension" value="MKV"<?php if (isset($extension) and ($extension == 'MKV')) echo ' checked' ?>><label for="mkv">MKV</label>
						<input type="radio" id="mp4" name="extension" value="MP4"<?php if (isset($extension) and ($extension == 'MP4')) echo ' checked' ?>><label for="mp4">MP4</label>
					</div>
					<div>
						<input type="hidden" name="id" value="<?php htmlout($id); ?>">
						<input type="hidden" name="filename" value="<?php echo $filename; ?>">
						<input type="hidden" name="mime_type" value="<?php echo $mime_type; ?>">
						<input type="hidden" name="filename_tn" value="<?php echo $filename_tn; ?>">
						<input type="hidden" name="location" value="<?php echo $location; ?>">
					</div>
					<div>
						<input type="submit" name="submit" value="<?php htmlout($button); ?>">
						<input type="submit" name="submit" value="Cancel">
					</div>
				</form>
				<div class="deleteImageDialog invisible"></div>
			</div>
		</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/global-footer.html.php'; ?>
	</body>
</html>
