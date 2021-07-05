		<header>
			<div id="mobileNav">
				<div>
					<a href="#menu" class="menu-link"><img src="/img/menu.png" alt="Menu"></a>
					<a href="/"><img src="/img/my-movies-header.png" alt="My Movies Db"></a>
				</div>
				<nav id="menu" class="panel" role="navigation">
					<ul>
						<li><a href="#menu" class="menu-link closeMenu" style="text-align: right;">&#10006;</a></li><?php // Source: https://stackoverflow.com/questions/5353461/unicode-character-for-x-cancel-close#9201092 Added: 01/07/2020. ?>
						<li><a href="/">Home</a></li>
						<li><a href="/db/?view-all">View All</a></li>
						<li><a href="/admin/">Admin Home</a></li>
						<li><a href="/admin/db/?add">Add Movie</a></li>
						<li><a href="/admin/db/">Edit / Delete</a></li>
<!--					<li><a href="/admin/db/?disabled">Disabled</a></li> -->
<?php if (!$loggedIn): ?>
						<li><a href="/admin/">Login</a></li>
<?php endif;
if ($loggedIn): ?>
						<li><a><div class="noButton"><?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/logout.html.php'; ?></div></a></li>
<?php endif; // The div above is wrapped in an anchor since it works as a container div using CSS display: block;. ?>
					</ul>
				</nav>
			</div>
			<div id="desktopNav">
				<div>
					<a href="/" class="globalHeaderImg"><img src="/img/my-movies-header.png" alt="My Movies Db"></a>
					<a href="/">Home</a>
					<a href="/db/?view-all">View All</a>
<?php // if ($loggedIn and $hasRole): ?>
					<a href="/admin/">Admin Home</a>
					<a href="/admin/db/?add">Add Movie</a>
					<a href="/admin/db/">Edit / Delete</a>
<?php // endif;
if (!$loggedIn): ?>
					<a href="/admin/">Login</a>
<?php
else: ?>
					<a><div class="noButton"><?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/logout.html.php'; ?></div></a>
<?php endif; // The div above is wrapped in an anchor since it works as a container div using CSS display: block;. ?>
				</div>
			</div>
		</header>
