$(document).ready(function() {
	// jQuery UI button() styles.
	$('input[type="submit"][value="Add Movie"], input[type="submit"][value="Update Movie"], input[type="submit"][value="Cancel"]').button();

	// jQuery UI buttonset() styles.
	$('.seen_it_data, .source_data, .unit, .codec, .extension, .protection').buttonset();

	// If on the "Add" page, focus the first input.
	var queryString = window.location.search; // Source: http://stackoverflow.com/questions/8920930/jquery-check-if-url-has-a-querystring (Cory's answer). Added: 08/17/2014.
	if (queryString == '?add') {
		$('input[type="text"]').first().focus(); // Source: http://stackoverflow.com/questions/20467802/set-focus-on-input-after-page-loading-in-jquery (яша's answer). Added: 08/17/2014.
	}

	// Chosen styles.
	$('.chosenYears').chosen({placeholder_text_single: 'Select', allow_single_deselect: true});
	$('.chosenMPAARating').chosen({placeholder_text_single: 'Select', allow_single_deselect: true});
	$('.chosenGenreData').chosen({placeholder_text_single: 'Select', allow_single_deselect: true});
	$('.chosenHours').chosen({placeholder_text_single: 'hh', allow_single_deselect: true});
	$('.chosenMinutes').chosen({placeholder_text_single: 'mm', allow_single_deselect: true});
	$('.chosenSeconds').chosen({placeholder_text_single: 'ss', allow_single_deselect: true});
	$('.chosenCRF').chosen({placeholder_text_single: 'Select', allow_single_deselect: true});

	// Remove an option from a drop down select menu when that option is already selected in another drop down select menu with the same class name. Source: http://stackoverflow.com/questions/25345587/jquery-chosen-multiple-select-menus-show-hide-options (user26409021's answer). Added: 08/16/2014.
	function resetOptions() {
		$('.chosenGenreData').each(function() {
			$(this).children('option').show();
		});
	}
	$('.chosenGenreData').change(function() {
		resetOptions();
		$('.chosenGenreData').each(function() {
			var selectedVal = $(this).val();
			var attrID = $(this).prop('id');
			$('.chosenGenreData').each(function() {
				if($(this).prop('id') != attrID) {
					if(selectedVal != '') {
						$(this).children('option[value="' + selectedVal + '"]').hide();
						$('.chosenGenreData').trigger('chosen:updated'); // If Chosen wasn't used, this wouldn't be needed. Source: http://stackoverflow.com/questions/8336112/how-do-i-dynamically-change-a-chosen-select-box (Christian Varga's answer). Added: 07/27/2014.
					}
				}
			});
		});
	});

	// jQuery UI dialog() (used as a confirmation button) and jQuery AJAX.
	$('input[type="submit"][name="delete-image"]').on('click', function(event) { // http://www.codeofaninja.com/2013/10/ui-dialog-example.html (Example 2.)
		event.preventDefault(); // Prevents a page from loading when a form is submitted.
		$('div.deleteImageDialog').text('Pressing OK will delete the image.');
		var name = $('[name="delete-image"]').attr('name'), value_ = $('[name="delete-image"]').attr('value');
		$('div.deleteImageDialog').dialog({ // Select the div you want to work with dialog().
			resizable: false,
			width: 302,
			height: 168,
			modal: true,
			title: "Delete Image",
			buttons: {
				"OK": function() {
					$('div.addEditContainer form').append('<input type="hidden" name="' + name + '" value="' + value_ + '">'); // No submit button value is serialized since the form was not submitted using a button (it was submitted using jQuery AJAX). In order for PHP to be able to pick up input[name="delete-image"], we append a hidden input since serialize() DOES send those values. Sources: http://stackoverflow.com/questions/25008665/php-not-picking-up-post-data-from-jquery-ajax-form-submit (Ivan's answer), http://stackoverflow.com/questions/2408043/jquery-create-hidden-form-element-on-the-fly (Mark Bell's answer), http://api.jquery.com/serialize/ Added: 7/28/2014.
					$.ajax({ // Source: http://stackoverflow.com/questions/15358298/jquery-send-a-form-by-staying-on-the-same-page (Siva Charan's answer.)
						url: $('div.addEditContainer form').attr('action'), // Notice how I can't use (this) instead of ('div.addEditContainer form') here because I'm triggering AJAX .on() a button click instead of .on() a form submit.
						type: $('div.addEditContainer form').attr('method'),
						data: $('div.addEditContainer form').serialize(), // The serialize() method pulls out and sends (in this example) via jQuery AJAX all the data (variables) contained in the form, EXCEPT the button click since the form was not submitted using a button (it was submitted using jQuery AJAX). Examples of how to retrieve the variables in PHP: either $_POST['filename_tn'] or $_GET['filename_tn'], depending on which form submit "method" was used (e.g., "post" or "get").
						success: function(html) { }
					});
					$('img[alt="Thumbnail"]').attr('src', '/img/thumbnail-deleted.png');
					$('input.deleteImage').hide(); // Since the image has been deleted, hide it to show visual confirmation.
					$(this).dialog('close');
				},
				"Cancel": function() {
					$(this).dialog('close');
				}
			}
		});
		$('.ui-widget-overlay').on('click', function() { // Close jQuery UI Dialog Modal Confirmation when a user clicks outside of the box. Added: 08/02/2014. Source: http://stackoverflow.com/questions/25091287/ui-dialog-close-when-click-outside/ (Answer by Kevin Turner.)
				$('div.deleteImageDialog').dialog('close');
		});
	});

	// jQuery UI slider() for the rating input. The value of the variable "value" is echoed by PHP in the <head> section of form.html.php. It contains the value of the variable "$rating_data" from the main index.php file.
	$('#rating').slider( { value: value, min: 0, max: 10, step: .5, slide: function(event, ui) {
		$('#rating_data').val(ui.value);
	}
	});
	$('#rating_data').val($('#rating').slider('value'));
	// To get the new value of the slider:
	//alert($('#rating').slider('value'));
	//alert($('#rating_data').val());

}); // End $(document).ready().
