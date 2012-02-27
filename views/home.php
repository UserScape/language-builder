<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo __('language-builder::builder.title') ?></title>
		<?php echo HTML::style('bundles/language-builder/css/style.css'); ?>
	</head>
	<body id="home">
		<div class="container">

			<header>
				<h1><?php echo __('language-builder::builder.title') ?></h1>
			</header>

			<?php echo Form::open('language-builder/build', 'POST', array('class' => '')); ?>
				<?php echo Form::label('translate', __('language-builder::builder.intro_message')); ?>
				<?php echo Form::select('translate', $languages, Input::get('translate'), array('id' => '')); ?>
				<p><button type="submit" class="btn"><?php echo __('language-builder::builder.translate') ?></button></p>
			<?php echo Form::close(); ?>

		</div>
		<footer>
			<p>&copy; UserScape 2012</p>
		</footer>
	</body>
</html>
