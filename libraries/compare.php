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
		$files['app'] = static::get_files($from, $to);
		$files['bundles'] = array();

		$bundle_dirs = Dir::get_bundles_with_language($from);
		foreach ($bundle_dirs as $bundle)
		{
			$files['bundles'] = array_merge_recursive($files['bundles'], static::get_files($from, $to, $bundle));
		}
		
		return $files;
	}

	/**
	 * Generate a list of language files
	 *
	 * @param array $from
	 * @param array $to
	 * @return array
	 */
	protected static function get_files($from, $to, $bundle = null)
	{
		$base_path = ($bundle) ? $bundle['path'] : path('app');
		$path = $base_path . 'language' . DS;
		$app_name= ($bundle) ? $bundle['name'] : 'application';

		$from_files = Dir::read($path.$from);
		$translated = (Dir::check_exists_or_create($path.$to)) ? Dir::read($path.$to) : array();

		foreach ($from_files as $key => $file)
		{
			$from_array = require $file;
			if (!array_key_exists($key, $translated))
			{
				$file_to = $path.$to.DS.$key;
				if (!is_file($file_to))
				{
					if (!Dir::create($file_to))
					{
						throw new Exception("Error creating file ".$file_to, 1);
					}
					$translated[$key]=$file_to;
				}
			}

			$to_array =  require $translated[$key];
			$to_name = str_replace($base_path, '', basename($translated[$key], '.php'));
			$from_health = static::lang_rows($from_array);
			$to_health = static::lang_rows($to_array);
			$files['all'][] = array(
				'location' => $app_name,
				'name' => $to_name,
			);
			if ($from_health != $to_health)
			{
				$files['missing'][] = array(
					'location' => $app_name,
					'name' => $to_name,
					'status' => static::lang_health($from_health,$to_health)
				);
			}
		}

		return $files;
	}

	/**
	 * Search array values for empty strings
	 *
	 * @param array
	 * @return int
	 */
	protected static function lang_rows($array)
	{
		$rows = 0;
		foreach ($array as $item)
		{
			if (is_array($item))
			{
				$rows += static::lang_rows($item);
			}
			else
			{
				$rows += empty($item)? 0 : 1;
			}
		}
		return $rows;
	}

	/**
	 * Search array values for empty strings
	 *
	 * @param int $from
	 * @param int $to
	 * @return int
	 */
	protected static function lang_health($from, $to)
	{
		if ($from < 1) return 0;
		return round(($to*100/$from), 1, PHP_ROUND_HALF_DOWN);
	}
}