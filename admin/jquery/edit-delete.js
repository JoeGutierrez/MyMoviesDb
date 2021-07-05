$.getScript('/admin/jquery/helpers.js'); // Added: 09/22/2014. Source: http://stackoverflow.com/questions/950087/how-to-include-a-javascript-file-in-another-javascript-file

var hideEffects = '500';

$(document).ready(function() {
	$('input[type="submit"][value="Edit"], input[type="submit"][value="Disable"], input[type="submit"][value="Enable"], input[type="submit"][value="Delete"]').button(); // jQuery UI button.
	$('div.editDeleteEnableDisableContainer form table:odd').css('background-color', 'lightgray'); // The reason this can't be done through a CSS file is because the tables are outputted dynamically through a PHP loop. If you try doing it through a CSS file using :nth-child(even), nothing happens (I tested it), and :nth-child(odd) works on ALL the selected elements, as if all of them were the first (odd) element (because the elements are outputted dynamically through PHP).
}); // End $(document).ready().

$(document).on('click', 'input[type="submit"][value="Disable"], input[type="submit"][value="Enable"]', function(event) {
	event.preventDefault();
	var form = $(this).parents('form'), name = $(this).attr('name'), value_ = $(this).attr('value');
	form.append('<input type="hidden" name="' + name + '" value="' + value_ + '">');
	$.ajax({
		url: form.attr('action'),
		type: form.attr('method'),
		data: form.serialize(),
		success: function(html) { }
	});
	form.hide(hideEffects, function() {
		//alert($('form.editDelete:visible').length);
		if ($('form.editDelete:visible').length == 0) {
			location.reload(); // To show a message that there are no records. This message is triggered by a PHP if() statement if a variable = !isset(), that's why the page needs to be refreshed in order to display it.
		}
	}); // End hide();
}); // End $(document).on('click').

$(document).on('click', 'input[type="submit"][value="Delete"]', function(event) {
	event.preventDefault();
	$(this).blur(); // Without this, the "Delete" button's CSS will remain in the "active" style state even if the user clicks "Cancel" or the background in the dialog().

	var title = $(this).parents('form').find('td').eq(3).text(); // Remember, eq()'s index starts at 0, so it's actually the 4th <td>'s text you're getting.
	title = articlesFirst(title);
	$('div.deleteMovieDialog').text('Are you sure you want to delete ' + title + '?');

	var form = $(this).parents('form'), name = $(this).attr('name'), value_ = $(this).attr('value');
	$('div.deleteMovieDialog').dialog({
		resizable: false,
		width: 302,
		height: 168,
		modal: true,
		title: 'Delete Movie',
		buttons: {
			'OK': function() {
				form.append('<input type="hidden" name="' + name + '" value="' + value_ + '">'); // It's important to execute this line of code ONLY if the user clicks OK because if you put it above, it'll be added to the <form> no matter what, thus the record will get deleted when the form is submitted, even if the user clicks another button, like "Edit."
				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					success: function(html) { }
				});
				form.hide(hideEffects, function() {
					if ($('form.editDelete:visible').length == 0) {
						location.reload(); // To show a message that there are no records. This message is triggered by a PHP if() statement if a variable = !isset(), that's why the page needs to be refreshed in order to display it.
					}
				}); // End hide();
				$(this).dialog('close'); // Notice how the "this" keyword has a different meaning after the dialog() method is called.
			},
			'Cancel': function() {
				$(this).dialog('close');
			}
		}
	});
	$('.ui-widget-overlay').on('click', function() {
		// Any line of code that executes when "Cancel" is clicked should be executed when the background of dialog() is clicked, too.
		$('div.deleteMovieDialog').dialog('close');
	});
}); // End $(document).on('click').
