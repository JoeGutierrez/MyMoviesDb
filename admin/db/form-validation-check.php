<?php
if (isset($_SESSION['errors'])) {
	// Set the session error messages to a local array to display on the form. This is needed since you will be using unset($_SESSION['errors']).
	if (isset($_SESSION['errors']['title_data'])) { $errors['title_data'] = $_SESSION['errors']['title_data']; }
	if (isset($_SESSION['errors']['year_'])) { $errors['year_'] = $_SESSION['errors']['year_']; }
	if (isset($_SESSION['errors']['duplicate_movie'])) { $errors['duplicate_movie'] = $_SESSION['errors']['duplicate_movie']; }
	unset($_SESSION['errors']);

	if (isset($_SESSION['form']['id'])) {
		$_POST['id'] = $_SESSION['form']['id']; // Get the movie's id so the index.php's "edit" section can use it to load the movie's data from the database.
	} // For the edit page, don't bother trying to put all of the form's values in $_SESSION['form']. In this case, it's better to get the values from the Db because if a user leaves the edit page, the values in the Db will still be there. Use $_SESSION['form'] only to store values for the add page, since at that point the values still haven't been added to the Db. Added: 10/18/2014.
}

/* You might think it'd be better to have $_SESSION['form']['errors'], but then it'd be confusing having $_SESSION['form']['errors']['title_data'] and $_SESSION['form']['title_data'].
Just keep the errors and form separate. */
?>
