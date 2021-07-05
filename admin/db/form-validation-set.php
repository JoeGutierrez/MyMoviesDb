<?php
// This file is needed for the add form only (not the edit form). It sets session data to local variables to initialize the form's fields, since at this point, the title and year aren't in the database.
if ( isset($_SESSION['form']['title_data']) ) { $title_data = $_SESSION['form']['title_data']; }
if ( isset($_SESSION['form']['year_']) ) { $year_ = $_SESSION['form']['year_']; }
?>
