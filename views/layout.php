<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Language Builder</title>
		<?php echo HTML::style('bundles/language-builder/style.css'); ?>
	</head>
	<body>
		<!-- Header -->
		<header class="container-fluid">
			<div class="row-fluid">
				<h1 class="span3">Language Builder</h1>
				<?php echo Form::open(null, 'GET', array('class' => 'form-inline span9')); ?>
					<?php echo Form::label('translate', 'Translate'); ?>
					<?php echo Form::select('translate', Config::get('language-builder::builder.languages'), Input::get('translate'), array('id' => 'translate')); ?>
					<?php echo Form::submit('Translate!', array('id' => 'start_translate')); ?>
				<?php echo Form::close(); ?>
			</div>
		</header>

		<div id="main" class="container-fluid">
			<div class="row-fluid">
				<div class="span3">
					<div class="well sidebar-nav">
						Sidebar
					</div>
				</div>
				<div class="span9">
					Content
				</div>
          	</div>
		</div>

      <hr>

      <footer>
        <p>&copy; UserScape 2012</p>
      </footer>

	</body>
</html>
