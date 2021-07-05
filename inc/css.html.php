<?php if (in_array($cur_path, $jquery_chosen_css_paths) or partial_str_in_arr('form.html.php', get_included_files())): ?>
		<link rel="stylesheet" type="text/css" href="/jquery/chosen/min.css">
<?php endif; ?>
<?php if (in_array($cur_path, $jquery_ui_css_paths) or partial_str_in_str('/db/?movie', $cur_path)): ?>
		<link rel="stylesheet" type="text/css" href="/jquery/ui/smoothness.min.css"><?php // Deleted the word "theme" from the filename. The original filename was: jquery-ui.smoothness.min.css. ?>
<?php endif; ?>
		<link rel="stylesheet" type="text/css" href="/css/default.css">
<?php if ($in_admin): ?>
		<link rel="stylesheet" type="text/css" href="/admin/css/admin.css">
<?php endif; ?>
<?php // Originally, the following <meta> tag was shown only on mobile or tablet. ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"><?php // This allows the page to automatically zoom to 100% when changed from portrait to landscape mode and vice versa. The "viewport" is the current width of the browser window. ?>
