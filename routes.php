<?php

Router::register('GET /language-builder', function()
{
	return View::make('language-builder::layout');
});