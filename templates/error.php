<!DOCTYPE html>
 
<html>

<head>
	<title><?php echo "Ошибка" . $error_code . " &ndash; " . site_title; ?></title>
	<meta charset='utf-8'>
    <link href="/css/common.css" media="all" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="box">
		<div id="header">
			<h1><a href="/"><?php echo site_title ?></a></h1>
		</div>
		<div id="error-page">
			<h2><?php echo $error_code; ?></h2>
			<div id="content">
				<?php echo $error_description; ?>
			</div>
		</div>
		<div id="footer">
			&copy; 2014 
		</div>
	</div>
</body>

<!-- run micritime: <?php echo run_micritime ?> -->

</html>