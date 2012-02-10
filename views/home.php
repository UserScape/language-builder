<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Laravel Language Builder</title>
		<?php echo HTML::style('bundles/language-builder/css/style.css'); ?>
	</head>
	<body id="home">
		<div class="container">

			<header>
				<h1>Laravel Language Builder</h1>
			</header>

			<?php echo Form::open('language-builder/build', 'POST', array('class' => '')); ?>
				<?php echo Form::label('translate', 'To get started select the language you wish to translate'); ?>
				<?php echo Form::select('translate', Config::get('language-builder::builder.languages'), Input::get('translate'), array('id' => '')); ?>
				<p><button type="submit" class="btn">Translate</button></p>
			<?php echo Form::close(); ?>

		</div>
		<footer>
			<p>&copy; UserScape 2012</p>
		</footer>
	</body>
</html>
