<?php namespace Langbuilder; defined('DS') or die('No direct script access.');

class Compare {


	public static function files($from, $to)
	{
		$files = array('missing' => '', 'all' => '');

		// First start with the application dir
		$path = path('app').'language/';
		$from_files = Dir::read($path.$from);
		$translated = Dir::read($path.$to);

		foreach ($from_files as $key => $file)
		{
			$from_array = require $file;
			$to_array = require $translated[$key];

			// Do all our keys match?
			if (count(array_diff_key($from_array, $to_array)) > 0)
			{
				$files['missing'][] = $translated[$key];
			}
			else
			{
				// If all our keys match we need check our values aren't empty.
				if (static::values($to_array))
				{
					$files['missing'][] = $translated[$key];
				}
			}
		}

		$files['all'] = $translated;
		return $files;
	}

	protected static function values($array)
	{
		foreach ($array as $item)
		{
			if (is_array($item))
			{
				return static::values($item);
			}
			if ($item == '') return true;
		}
		return false;
	}
}