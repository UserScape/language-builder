<?php
/**
 * Default route
 */
Route::get('(:bundle)', function()
{
	$languages = array_merge(
		array('' => __('language-builder::builder.please_select')),
		Config::get('language-builder::builder.languages')
	);
	return View::make('language-builder::home')->with('languages', $languages);
});

/**
 * Build any missingn any files and redirect
 */
Route::post('(:bundle)/build', function()
{
	if ($translate = Input::get('translate'))
	{
		// First create any missing language files
		Langbuilder\Dir::create_missing(Config::get('language-builder::builder.base_lang'), $translate);
		return Redirect::to('/language-builder/edit?translate='.$translate);
	}
	return Redirect::to('/language-builder');
});

/**
 * Edit a language file.
 */
Route::get('(:bundle)/edit', function()
{
	$view = View::make('language-builder::layout');

	if ( ! $translate = Input::get('translate'))
	{
		return Redirect::to('/language-builder');
	}

	// Now we do the comparisions
	$view->files = Langbuilder\Compare::files(Config::get('language-builder::builder.base_lang'), $translate);

	if ($location = Input::get('location') and $name = Input::get('name'))
	{
		$view->edit = Langbuilder\Utilities::get_files($name, $location, $translate);
		$view->lang_file = $name;
	}

	return $view;
});

/**
 * Handle the posted edit form.
 */
Route::post('(:bundle)/edit', function()
{
	$location = Input::get('location');
	$name = Input::get('name');
	$translate = Input::get('translate');

	$file = Bundle::path($location).'language/'.$translate.'/'.$name.'.php';
	if (is_file($file))
	{
		$array = Langbuilder\Utilities::make_array($_POST['lang']);
		File::put($file, $array);
		return Redirect::to('/language-builder/edit?location='.$location.'&name='.$name.'&translate='.$translate);
	}
	die('Something is horribly wrong');
});