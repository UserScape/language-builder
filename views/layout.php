<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Laravel Language Builder</title>
		<?php echo HTML::style('bundles/language-builder/css/style.css'); ?>
	</head>
	<body>
		<!-- Header -->
		<header class="container-fluid">
			<div class="row-fluid">
				<h1 class="span12">Laravel Language Builder</h1>
			</div>
		</header>

		<div id="main" class="container-fluid">
			<div class="row-fluid">
				<div class="span3">
					<div class="well sidebar-nav">

						<?php if (isset($files)): ?>

						<ul class="nav nav-list">
							<li class="nav-header">Missing Translations <i class="icon-asterisk"></i></li>
							<?php foreach ($files['app']['missing'] as $file): ?>
								<?php echo '<li>'.Langbuilder\Utilities::link($file).'</li>'; ?>
							<?php endforeach ?>
							<?php foreach ($files['bundles']['missing'] as $file): ?>
								<?php echo '<li>'.Langbuilder\Utilities::link($file).'</li>'; ?>
							<?php endforeach ?>
						</ul>

						<hr>

						<ul class="nav nav-list">
							<li class="nav-header">All Translation Files</li>
							<?php foreach ($files['app']['all'] as $file): ?>
								<?php echo '<li>'.Langbuilder\Utilities::link($file).'</li>'; ?>
							<?php endforeach ?>
							<?php foreach ($files['bundles']['all'] as $file): ?>
								<?php echo '<li>'.Langbuilder\Utilities::link($file).'</li>'; ?>
							<?php endforeach ?>
						</ul>

						<?php endif ?>

					</div>
				</div>

				<?php if (isset($edit)): ?>
					<div class="span4">
						<form class="form-horizontal">
							<fieldset>
								<legend>Base File (For Comparision) <a href="#" id="toggle">Toggle</a></legend>
								<?php foreach ($edit['from'] as $key => $string): ?>
									<?php if (is_array($string) && ! empty($string)): ?>

										<?php foreach ($string as $sub_key => $sub_value): ?>
											<div class="control-group<?php echo (isset($edit['to'][$key][$sub_key]) && $edit['to'][$key][$sub_key] != '') ? ' hide' : ''; ?>">
												<label class="control-label" for="<?php echo $sub_key ?>"><?php echo $lang_file.'.'.$key.'.'.$sub_key ?></label>
												<div class="controls">
													<input type="text" name="lang[<?php echo $key ?>][<?php echo $sub_key ?>]" class="input-xlarge" id="<?php echo $sub_key ?>" value="<?php echo $sub_value ?>">
												</div>
											</div>
										<?php endforeach ?>

									<?php elseif ( ! empty($string)): ?>

									<div class="control-group<?php echo (isset($edit['to'][$key]) && $edit['to'][$key] != '') ? ' hide' : ''; ?>">
										<label class="control-label" for="<?php echo $key ?>"><?php echo $lang_file.'.'.$key ?></label>
										<div class="controls">
											<input type="text" name="lang[<?php echo $key ?>]" class="input-xlarge" id="<?php echo $key ?>" value="<?php echo $string ?>">
										</div>
									</div>
									<?php endif ?>

								<?php endforeach ?>

							</fieldset>
						</form>
					</div>
					<div class="span4">
						<?php echo Form::open('language-builder/edit', 'POST', array('class' => 'form-horizontal border-left')); ?>
							<?php echo Form::hidden('location', Input::get('location')) ?>
							<?php echo Form::hidden('name', Input::get('name')) ?>
							<?php echo Form::hidden('translate', Input::get('translate')) ?>
							<fieldset>
								<legend>Translated File</legend>
								<?php foreach ($edit['from'] as $key => $string): ?>
									<?php if (is_array($string) && ! empty($string)): ?>

										<?php foreach ($string as $sub_key => $sub_value): ?>
											<div class="control-group<?php echo (isset($edit['to'][$key][$sub_key]) && $edit['to'][$key][$sub_key] != '') ? ' hide' : ''; ?>">
												<label class="control-label" for="<?php echo $sub_key ?>"><?php echo $lang_file.'.'.$key.'.'.$sub_key ?></label>
												<div class="controls">
													<input type="text" name="lang[<?php echo $key ?>][<?php echo $sub_key ?>]" class="input-xlarge" id="<?php echo $sub_key ?>" value="<?php echo $edit['to'][$key][$sub_key] ?>">
												</div>
											</div>
										<?php endforeach ?>

									<?php elseif ( ! empty($string)): ?>
									<div class="control-group<?php echo (isset($edit['to'][$key]) && $edit['to'][$key] != '') ? ' hide' : ''; ?>">
										<label class="control-label" for="<?php echo $key ?>"><?php echo $lang_file.'.'.$key ?></label>
										<div class="controls">
											<input type="text" name="lang[<?php echo $key ?>]" class="input-xlarge" id="<?php echo $key ?>" value="<?php echo $edit['to'][$key] ?>">
										</div>
									</div>
									<?php endif ?>

								<?php endforeach ?>

								<div class="form-actions">
									<button type="submit" class="btn btn-primary">Save changes</button>
								</div>
							</fieldset>
						</form>
					</div>

				<?php else: ?>
				<div class="span9">

					<div class="callout">
						<h2>Please select a file to translate</h2>
					</div>

				</div>
				<?php endif ?>
          	</div>
		</div>

      <hr>

      <footer>
        <p>&copy; UserScape 2012</p>
      </footer>

      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
      <?php echo HTML::script('bundles/language-builder/js/main.js'); ?>
	</body>
</html>
