<!DOCTYPE html>

<html>

<head>
	<title><?php echo  $page_title . " &ndash; " . site_title; ?></title>
	<meta charset='utf-8'>
    <link href="/css/common.css" media="all" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="box">
		<div id="header">
			<h1><a href="/"><?php echo site_title ?></a></h1>
		</div>
		<div id="user_panel">
			<?php echo $page_user_panel; ?>
		</div>
		<div id="page">
			<h2><?php echo $page_title; ?></h2>
			<div id="content">
				<?php echo $page_content; ?>
			</div>
		</div>
		<div id="footer">
			&copy; 2014 
		</div>
	</div>
</body>

<!-- run micritime: <?php echo run_micritime ?> -->

</html>