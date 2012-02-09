<?php

Router::register('GET /language-builder', function()
{
	$view = View::make('language-builder::layout');

	if ($translate = Input::get('translate'))
	{
		// First create any missing language files
		Langbuilder\Dir::create_missing(Config::get('language-builder::builder.base_lang'), $translate);

		// Now we do the comparisions
		$view->files = Langbuilder\Compare::files(Config::get('language-builder::builder.base_lang'), $translate);
	}

	if ($file = Input::get('file'))
	{
		$view->file = '';
	}

	return $view;
});
