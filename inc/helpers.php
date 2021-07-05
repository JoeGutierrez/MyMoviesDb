<?php
function html($text)
{
	return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function htmlout($text)
{
	echo html($text);
}

function markdown2html($text)
{
	$text = html($text);

	// strong emphasis
	$text = preg_replace('/__(.+?)__/s', '<strong>$1</strong>', $text);
	$text = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);

	// emphasis
	$text = preg_replace('/_([^_]+)_/', '<em>$1</em>', $text);
	$text = preg_replace('/\*([^\*]+)\*/', '<em>$1</em>', $text);

	// Convert Windows (\r\n) to Unix (\n)
	$text = str_replace("\r\n", "\n", $text);
	// Convert Macintosh (\r) to Unix (\n)
	$text = str_replace("\r", "\n", $text);

	// Paragraphs
	$text = '<p>' . str_replace("\n\n", '</p><p>', $text) . '</p>';
	// Line breaks
	$text = str_replace("\n", '<br>', $text);

	// [linked text](link URL)
	$text = preg_replace(
			'/\[([^\]]+)]\(([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\)/i',
			'<a href="$2">$1</a>', $text);

	return $text;
}

function markdownout($text)
{
	echo markdown2html($text);
}

// array_orderby() is an upgrade to array_multisort(), a stock PHP function for sorting multi-dimensional arrays with the downside of requiring you to create intermediate arrays before calling it. array_orderby() is a custom function that sorts multi-dimensional arrays by just calling and sending it the parameters. It sorts database-style results, notice that "order by," as in the name of this function, are keywords for sorting using MySQL queries. Source: http://www.php.net//manual/en/function.array-multisort.php (Comment by: jimpoz at jimpoz dot com.)
// Sample call: $movies = array_orderby($movies, 'title_data', SORT_ASC);
function array_orderby()
{
	$args = func_get_args(); // Enables a function to have a variable number of arguments or no arguments at all. If you do pass arguments to a function, func_get_args() will get them for you. Sources: http://php.net/manual/en/function.func-get-args.php https://stackoverflow.com/questions/5268079/what-is-the-good-example-of-using-func-get-arg-in-php (alex's answer.) Added: 05/23/2018.
	$data = array_shift($args);
	foreach ($args as $n => $field)
	{
		if (is_string($field))
		{
			$tmp = [];
			foreach ($data as $key => $row)
				$tmp[$key] = $row[$field];
			$args[$n] = $tmp;
		}
	}
	$args[] = &$data;
	call_user_func_array('array_multisort', $args);
	return array_pop($args);
}

function articles_last($str) // "Wizard, The" instead of "The Wizard."
{
	if (substr($str, 0, 4) === 'The ') // Starting at position 0, if the first 4 characters are "The "...
	{
		$str = substr($str, 4) . ", The"; // Subtract the first 4 characters and add ", The" at the end.
	}
	elseif (substr($str, 0, 3) === 'An ') // Starting at position 0, if the first 3 characters are "An "...
	{
		$str = substr($str, 3) . ", An"; // Subtract the first 3 characters and add ", An" at the end.
	}
	elseif (substr($str, 0, 2) === 'A ') // Starting at position 0, if the first 2 characters are "A "...
	{
		$str = substr($str, 2) . ", A"; // Subtract the first 2 characters and add ", A" at the end.
	}
	return $str;
} // http://en.wikipedia.org/wiki/English_articles

function articles_last_multi_arr($multi_arr) // "Wizard, The" instead of "The Wizard."
{
	foreach ($multi_arr as $i => $arr)
	{
		$multi_arr[$i]['title_data'] = articles_last($arr['title_data']);
	}
	return $multi_arr;
} // http://en.wikipedia.org/wiki/English_articles

function articles_first($str) // "The Wizard" instead of "Wizard, The."
{
		if (substr($str, -5) === ', The') // If the last 5 characters are ", The"...
		{
			$str = 'The ' . substr($str, 0, -5); // Add 'The ' at the start and subtract the last 5 characters.
		}
		if (substr($str, -4) === ', An') // If the last 4 characters are ", An"...
		{
			$str = 'An ' . substr($str, 0, -4); // Add 'An ' at the start and subtract the last 4 characters.
		}
		if (substr($str, -3) === ', A') // If the last 3 characters are ", A"...
		{
			$str = 'A ' . substr($str, 0, -3); // Add 'A ' at the start and subtract the last 3 characters.
		}
	return $str;
} // http://en.wikipedia.org/wiki/English_articles

function url_title($title_data, $year_) // the-wizard-(1989) instead of The Wizard (1989).
{
	$title_data = str_replace(': ', '_-_', $title_data); // Colons can be used for filenames and folders in Unix, which HostGator uses to host the site, but in Windows they can't, so replace them with an underscore, dash and another underscore.
	$title_data = str_replace(':', '-', $title_data); // The above handles titles with a colon and a space, this one handles just a colon. You have to handle both cases because if you just check for a colon, the resulting URL will be like: 300_-_-rise-of-an-empire-(2014) (The colon will be replaced by _-_ and the space that follows it by -)
	$title_data = str_replace(' - ', '_-_', $title_data); // Change "hobbit_-_an-unexpected-journey---extended-edition,-the-(2012).jpg" into "hobbit_-_an-unexpected-journey_-_extended-edition,-the-(2012).jpg".
	$title_data = str_replace(' ', '-', $title_data);
	$title_data = str_replace('&', 'and', $title_data); // Ampersands can't be passed in query strings (even using &amp;) because they represent the start of another variable, e.g.: "tango-and-cash-(1989)&id=1" (the var. "id" in this case). So "tango-&-cash-(1989)" becomes "tango-". You can echo the results of urlencode() then urldecode(), but the resulting URL will contain the ugly "tango-+%26+-cash-(1989)". If I can't have "&" in the URL, I'd rather have "and" instead of the ugly "+%26+".
	$title_data = strtolower($title_data);

	if (substr($title_data, -3) === ',-a') // If the last 3 characters are ",-a"...
	{
		$title_data = substr($title_data, 0, -3); // Subtract the last 3 characters. /db/?movie=charlie-brown-christmas-(1965)&id=63 instead of /db/?movie=charlie-brown-christmas,-a-(1965)&id=63
	}
	elseif (substr($title_data, -4) === ',-an') // If the last 4 characters are ",-an"...
	{
		$title_data = substr($title_data, 0, -4); // Subtract the last 4 characters.
	}
	elseif (substr($title_data, -5) === ',-the') // If the last 5 characters are ",-the"...
	{
		$title_data = substr($title_data, 0, -5); // Subtract the last 5 characters.
	}

	$url = $title_data . '-(' . $year_ . ')';
	return $url;
}

function url_image($title_data, $year_, $mime_type) // wizard,-the-(1989).jpg instead of The Wizard (1989).jpg.
{
	if ($mime_type == 'image/jpeg') { $ext = '.jpg'; }
	elseif ($mime_type == 'image/png') { $ext = '.png'; }

	return $filename = url_title(articles_last($title_data), $year_) . $ext;
}

// The stock PHP function in_array() does not work for multi-dimensional arrays. The custom, recursive function below does. If the $strict parameter is set to "TRUE," it'll make the function data type-sensitive. Source: http://stackoverflow.com/questions/4128323/in-array-and-multidimensional-array (Comment by: elusive.)
function in_multi_array($needle, $haystack, $strict = FALSE)
{
	foreach ($haystack as $item)
	{
		if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_multi_array($needle, $item, $strict)))
		{
			return TRUE;
		}
	}
	return FALSE;
}

// $quality can be from 0 to 100. Source http://php.net/manual/en/function.imagecopyresampled.php (Comment by promaty.)
// Sample call: image_resize($_SERVER['DOCUMENT_ROOT'] . '/img/movies/' . $_FILES['upload']['name'], $_SERVER['DOCUMENT_ROOT'] . '/img/movies/' . substr($_FILES['upload']['name'], 0, -4) . '_small.jpg', 100, 100, 0, 75);
function image_resize($src, $dst, $width, $height, $crop, $quality) {
	if(!list($w, $h) = getimagesize($src)) return "Unsupported picture type!";

	$type = strtolower(substr(strrchr($src,"."),1));
	if($type == 'jpeg') $type = 'jpg';
	switch($type) {
		case 'bmp': $img = imagecreatefromwbmp($src); break;
		case 'gif': $img = imagecreatefromgif($src); break;
		case 'jpg': $img = imagecreatefromjpeg($src); break;
		case 'png': $img = imagecreatefrompng($src); break;
		default : return "Unsupported picture type!";
	}

	// Resize.
	if($crop) {
		if($w < $width or $h < $height) return "Picture is too small!";
		$ratio = max($width/$w, $height/$h);
		$h = $height / $ratio;
		$x = ($w - $width / $ratio) / 2;
		$w = $width / $ratio;
	}
	else {
		if($w < $width and $h < $height) return "Picture is too small!";
		$ratio = min($width/$w, $height/$h);
		$width = $w * $ratio;
		$height = $h * $ratio;
		$x = 0;
	}

	$new = imagecreatetruecolor($width, $height);

	// Preserve transparency.
	if($type == "gif" or $type == "png") {
		imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
		imagealphablending($new, FALSE);
		imagesavealpha($new, TRUE);
	}

	imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

	switch($type) {
		case 'bmp': imagewbmp($new, $dst, $quality); break;
		case 'gif': imagegif($new, $dst, $quality); break;
		case 'jpg': imagejpeg($new, $dst, $quality); break;
		case 'png': imagepng($new, $dst, $quality); break;
	}

	return TRUE;
}

function image_filename($filename, $type)
{
	return substr($filename, 0, -4) . '-' . $type . '.jpg';
}

// partial_str_in_arr() will return TRUE if a partial match of a string is found in an array. in_array() doesn't work with partial matches. Added: 10/22/2014. Source: http://forums.whirlpool.net.au/archive/1870136 (gregdev's post.)
function partial_str_in_arr($needle, $haystack)
{
	foreach($haystack as $piece_of_hay) {
		if(strpos($piece_of_hay, $needle) !== FALSE) return TRUE;
	}
	return FALSE;
}

// partial_str_in_str() will return TRUE if a partial match of a string is found in another string. Added: 10/27/2014. Source: http://www.thetechrepo.com/main-articles/451-php-check-if-a-string-contains-a-substring.html
function partial_str_in_str($substring, $string)
{
	$pos = strpos($string, $substring);

	if($pos === FALSE) {
		return FALSE; // String needle NOT found in haystack.
	}
	else {
		return TRUE; // String needle found in haystack.
	}
}

// genre_comma_list() takes 3 strings (the genres) and returns a single, comma-separated string. Added: 01/04/2015 (Taken from the movie.php script and made into a function).
// Sample call: htmlout(genre_comma_list($movie['genre_1'], $movie['genre_2'], $movie['genre_3']));
function genre_comma_list($str1, $str2, $str3)
{
	$arr = [ $str1, $str2, $str3 ];
	$genres_comma_list = implode(', ', $arr); // Separate the strings in the array with a comma and space, e.g.: Genre 1, Genre 2, Genre 3 (note: implode() won't add a ", " after the last string in the array).
	$genres_comma_list = ltrim($genres_comma_list, ', '); // Delete ", " from the start of the string (left trim). Instead of ", Adventure" it'll be "Adventure".
	$genres_comma_list = rtrim($genres_comma_list, ', '); // Delete ", " from the end of the string (right trim). Instead of "Adventure, " it'll be "Adventure". Added: 10/05/2014. Source: http://stackoverflow.com/questions/2435216/how-to-create-comma-separated-list-from-array-in-php
	$genres_comma_list = str_replace(' , ', ' ', $genres_comma_list); // Replace "Action, , Boxing" with "Action, Boxing".
	return $genres_comma_list;
}
?>
