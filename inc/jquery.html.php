		<script type="text/javascript" src="/jquery/min.js"></script>
<?php if (in_array($cur_path, $jquery_ui_paths) or partial_str_in_str('/db/?movie', $cur_path)): ?>
		<script type="text/javascript" src="/jquery/ui/min.js"></script>
<?php endif; ?>
<?php if (in_array($cur_path, $jquery_chosen_paths) or partial_str_in_arr('form.html.php', get_included_files())): ?>
		<script type="text/javascript" src="/jquery/chosen/min.js"></script>
<?php endif; ?>
		<script type="text/javascript" src="/jquery/big-slide/bigSlide-0.12.0.min.js"></script>
		<script type="text/javascript" src="/jquery/big-slide/bigSlide-script.js"></script>
<?php if ($cur_path == ''): ?>
		<script type="text/javascript" src="/jquery/slider/min.js"></script>
		<script type="text/javascript" src="/jquery/slider/script.js"></script>
		<link rel="stylesheet" href="/jquery/slider/style.css" type="text/css" media="screen">
		<link rel="stylesheet" href="/jquery/slider/themes/default/style.css" type="text/css" media="screen">
<?php endif; ?>
<?php if ($cur_path == ''): ?>
		<script type="text/javascript" src="/jquery/aim/min.js"></script>
		<script type="text/javascript" src="/jquery/aim/script.js"></script>
		<link rel="stylesheet" type="text/css" href="/jquery/aim/aim.css">
<?php endif; ?>
