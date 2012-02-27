<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo __('language-builder::builder.title') ?></title>
		<?php echo HTML::style('bundles/language-builder/css/style.css'); ?>
	</head>
	<body>
		<!-- Header -->
		<header class="container-fluid">
			<div class="row-fluid">
				<h1 class="span12"><?php echo __('language-builder::builder.title') ?></h1>
			</div>
		</header>

		<div id="main" class="container-fluid">
			<div class="row-fluid">
				<div class="span3">
					<div class="well sidebar-nav">

						<?php if (isset($files)): ?>

						<ul class="nav nav-list">
							<li class="nav-header"><i class="icon-asterisk"></i> <?php echo __('language-builder::builder.missing_translations') ?></li>
							<?php foreach ($files['app']['missing'] as $file): ?>
								<?php echo '<li>'.Langbuilder\Utilities::link($file).'</li>'; ?>
							<?php endforeach ?>
							<?php if (isset($files['bundles']['missing'])): ?>
								<?php foreach ($files['bundles']['missing'] as $file): ?>
									<?php echo '<li>'.Langbuilder\Utilities::link($file).'</li>'; ?>
								<?php endforeach ?>
							<?php endif ?>
						</ul>

						<hr>

						<ul class="nav nav-list">
							<li class="nav-header"><?php echo __('language-builder::builder.all_translation_files') ?></li>
							<?php if (isset($files['app']['all'])): ?>
								<?php foreach ($files['app']['all'] as $file): ?>
									<?php echo '<li>'.Langbuilder\Utilities::link($file).'</li>'; ?>
								<?php endforeach ?>
							<?php endif ?>

							<?php if (isset($files['bundles']['all'])): ?>
								<?php foreach ($files['bundles']['all'] as $file): ?>
									<?php echo '<li>'.Langbuilder\Utilities::link($file).'</li>'; ?>
								<?php endforeach ?>
							<?php endif; ?>
						</ul>

						<?php endif ?>

					</div>
				</div>

				<?php if (isset($edit)): ?>
					<div class="span8">
						<a href="#" class="btn pull-right" id="toggle"><i class="icon-folder-close"></i> <?php echo __('language-builder::builder.toggle_translated') ?></a>
						<?php echo Form::open('language-builder/edit', 'POST', array('class' => 'form-horizontal')); ?>
							<?php echo Form::hidden('location', Input::get('location')) ?>
							<?php echo Form::hidden('name', Input::get('name')) ?>
							<?php echo Form::hidden('translate', Input::get('translate')) ?>


								<?php foreach ($edit['from'] as $key => $string): ?>

									<?php if (is_array($string) && ! empty($string)): ?>

										<?php foreach ($string as $sub_key => $sub_value): ?>
											<fieldset class="<?php echo (isset($edit['to'][$key][$sub_key]) && $edit['to'][$key][$sub_key] != '') ? ' hide' : ''; ?>">
												<legend><?php echo $lang_file.'.'.$key.'.'.$sub_key ?></legend>

												<div class="control-group<?php echo (isset($edit['to'][$key][$sub_key]) && $edit['to'][$key][$sub_key] != '') ? ' hide' : ''; ?>">
													<label class="control-label"><?php echo Config::get('language-builder::builder.base_lang') ?></label>
													<div class="controls">
														<input type="text" name="placeholder" class="span7 disabled" value="<?php echo $edit['from'][$key][$sub_key] ?>">
													</div>
												</div>

												<div class="control-group<?php echo (isset($edit['to'][$key][$sub_key]) && $edit['to'][$key][$sub_key] != '') ? ' hide' : ''; ?>">
													<label class="control-label" for="<?php echo $key ?>"><?php echo Input::get('translate') ?></label>
													<div class="controls">
														<input type="text" name="lang[<?php echo $key ?>][<?php echo $sub_key ?>]" class="span7" id="<?php echo $sub_key ?>" value="<?php echo isset($edit['to'][$key][$sub_key]) ? $edit['to'][$key][$sub_key] : '' ?>">
													</div>
												</div>
											</fieldset>
										<?php endforeach ?>

									<?php elseif ( ! empty($string)): ?>

									<fieldset class="<?php echo (isset($edit['to'][$key]) && $edit['to'][$key] != '') ? ' hide' : ''; ?>">
										<legend><?php echo $lang_file.'.'.$key ?></legend>

										<div class="control-group">
											<label class="control-label"><?php echo Config::get('language-builder::builder.base_lang') ?></label>
											<div class="controls">
												<input class="disabled span7" type="text" name="placeholder" value="<?php echo $string ?>">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="<?php echo $key ?>"><?php echo Input::get('translate') ?></label>
											<div class="controls">
												<input type="text" name="lang[<?php echo $key ?>]" class="span7" id="<?php echo $key ?>" value="<?php echo isset($edit['to'][$key]) ? $edit['to'][$key] : ''; ?>">
											</div>
										</div>

									</fieldset>
									<?php endif ?>

								<?php endforeach ?>

							</fieldset>
							<div class="form-actions">
								<button type="submit" class="btn btn-primary"><?php echo __('language-builder::builder.save_changes') ?></button>
							</div>
						</form>
					</div>

				<?php else: ?>
				<div class="span9">

					<div class="callout">
						<h2><?php echo __('language-builder::builder.select_file'); ?></h2>
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
