<?php namespace Langbuilder; defined('DS') or die('No direct script access.');

class Compare {

	/**
	 * Generate a list of files
	 *
	 * @param array $from
	 * @param array $to
	 * @return array
	 */
	public static function files($from, $to)
	{
		$files['app'] = static::app($from, $to);
		$files['bundles'] = static::bundles($from, $to);
		return $files;
	}

	/**
	 * Generate a list of app language files
	 *
	 * @param array $from
	 * @param array $to
	 * @return array
	 */
	protected static function app($from, $to)
	{
		$path = path('app').'language/';
		$from_files = Dir::read($path.$from);
		$translated = Dir::read($path.$to);

		foreach ($from_files as $key => $file)
		{
			$from_array = require $file;
			$to_array = (is_file($translated[$key])) ? require $translated[$key] : array();

			$files['all'][] = array(
				'location' => 'application',
				'name' => str_replace(path('app'), '', basename($translated[$key], '.php'))
			);

			// Do all our keys match?
			if (static::keys($from_array, $to_array))
			{
				$files['missing'][] = array(
					'location' => 'application',
					'name' => str_replace(path('app'), '', basename($translated[$key], '.php'))
				);
			}
			else
			{
				// If all our keys match we need check our values aren't empty.
				if (static::values($to_array))
				{
					$files['missing'][] = array(
						'location' => 'application',
						'name' => str_replace(path('app'), '', basename($translated[$key], '.php'))
					);
				}
			}
		}

		return $files;
	}

	/**
	 * Generate a list of bundle language files
	 *
	 * @param array $from
	 * @param array $to
	 * @return array
	 */
	protected static function bundles($from, $to)
	{
		// First start with the application dir
		$from_files = Dir::bundles($from);

		foreach ($from_files as $bundle)
		{
			$bundle_files = Dir::read($bundle['path'].$from);

			foreach ($bundle_files as $key => $file)
			{
				$from_array = require $file;
				$to_file = str_replace($from, $to, $file);
				$to_array = (is_file($to_file)) ? require $to_file : array();

				$files['all'][] = array(
					'location' => $bundle['name'],
					'name' => str_replace(path('bundles'), '', basename($to_file, '.php'))
				);

				// Do all our keys match?
				if (static::keys($from_array, $to_array))
				{
					$files['missing'][] = array(
						'location' => $bundle['name'],
						'name' => str_replace(path('bundles'), '', basename($to_file, '.php'))
					);
				}
				else
				{
					// If all our keys match we need check our values aren't empty.
					if (static::values($to_array))
					{
						$files['missing'][] = array(
							'location' => $bundle['name'],
							'name' => str_replace(path('bundles'), '', basename($to_file, '.php'))
						);
					}
				}
			}
		}
		return $files;
	}

	/**
	 * Search array keys for differences
	 *
	 * @param array $from
	 * @param array $to
	 * @param bool
	 */
	protected static function keys($from, $to)
	{
		return count(array_diff_key($from, $to)) > 0;
	}

	/**
	 * Search array values for empty strings
	 *
	 * @param array
	 * @return bool
	 */
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