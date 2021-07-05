<?php
if ( !isset($_SESSION['errors']) ) {
	unset($_SESSION['form']); // If this code isn't included in this part of the script and you add a movie then click "Add" again, the previous movie's title/year will still be in the form! Added: 2014-10-15.
} // Also, if you don't unset this session array, the form values will still be set if you visit another page then come back to the form! Added: 2014-10-15.
?>
