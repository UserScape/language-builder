<?php

Router::register('GET /language-builder', function()
{
	$view = View::make('language-builder::layout');

	if ($translate = Input::get('translate'))
	{
		// Create any missing language files
		Langbuilder\Dir::create_missing(Config::get('language-builder::builder.base_lang'), $translate);
	}

	return $view;
});
