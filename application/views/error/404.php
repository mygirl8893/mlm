<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Major League Mining</title>
<link rel="stylesheet" type="text/css" href="<?php echo URL::to_asset("css/style.css"); ?>" />
</head>
<body>
	<div id="errorbox">
	<img src="<?php echo URL::to_asset("images/static/logo.png") ?>" />
	        <br>
			<hr>
			<br>
			<?php $messages = array('Stonghold not found', 'There is no wool here', 'An Enderman stole this page'); ?>
			<h1>404: <?php echo $messages[mt_rand(0, 2)]; ?></h1>
			<br>
			<hr>
			<br>
			<p>
				This page probably moved or has been dumped into the void.
				<br> 
				You can try a search below or go to back to our <?php echo HTML::link('/', 'home page'); ?>.
			</p>
            <br>
		<?php echo Form::open("search"); ?>
		<?php echo Form::text("search_term", ""); ?>
		<?php echo Form::submit("Search", array('class' => 'btn-primary')); ?>
		<?php echo Form::close(); ?>
	</div>
</body>
</html>