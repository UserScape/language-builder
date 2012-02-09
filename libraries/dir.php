<?php namespace Langbuilder; defined('DS') or die('No direct script access.');

class Dir {

	/**
	 * Compare language files and creates any missing
	 *
	 * @param string $from
	 * @param string $to
	 */
	public static function create_missing($from, $to)
	{
		// First start with the application dir
		$from_files = static::read(path('app').'language/'.$from);
		foreach ($from_files as $file)
		{
			static::create(path('app').'language/'.$to.'/'.$file);
		}

		// Now any bundles
		$from_bundles = static::bundles($from);
		foreach ($from_bundles as $bundle)
		{
			$bundle_files = static::read($bundle.$from);
			foreach ($bundle_files as $file)
			{
				static::create($bundle.$to.'/'.$file);
			}
		}
	}

	/**
	 * Create an empty language file if it doesn't exist.
	 *
	 * @param string $path
	 * @return bool
	 */
	public static function create($path)
	{
		$dir = str_replace(basename($path), '', $path);

		if ( ! is_dir($dir))
		{
			static::make($dir);
		}

		if ( ! file_exists($path))
		{
			$data = '<?php ';
			\Laravel\File::put($path, $data);
		}

		return true;
	}

	/**
	 * Load all the bundles and get their paths
	 *
	 * @param string $lang
	 * @return array
	 */
	public static function bundles($lang = null)
	{
		$folders = array();

		// Get the bundle languages
		if ($bundles = \Laravel\Bundle::names())
		{
			foreach ($bundles as $bundle)
			{
				if (is_dir(\Laravel\Bundle::path($bundle).'language/'.$lang))
				{
					$folders[] = \Laravel\Bundle::path($bundle).'language/';
				}
			}
		}

		return $folders;
	}

	/**
	 * Read a directory into an array
	 *
	 * @access public
	 * @static
	 * @param  string $dir  full path to directory
	 * @param  array  $ignore files/directories to skip
	 * @return mixed  FALSE on failure, array on success
	 */
	static public function read($dir, $ignore = array())
	{
		$files = scandir($dir);
		$dir_contents = array();
		foreach ($files as $file)
		{
			if ($file == '.' OR $file == '..')
			{
				continue;
			}
			// Ignore files specified
			if ( ! in_array($file, $ignore))
			{
				$dir_contents[] = $file;
			}
		}
		return $dir_contents;
	}

	/**
	 * Make a new directory
	 *
	 * @param  string $dir
	 * @param  int $permission
	 * @param  bool $nested
	 * @return bool
	 */
	public static function make($dir, $permission = 0755, $nested = false)
	{
		// Remove links
		$dir = str_replace('../', '', $dir);
		$dir = str_replace('./', '', $dir);

		// Attempt to make the directory
		if ( ! mkdir($dir, $permission, $nested))
		{
			Log::error('Dir::make:Failed to create the directory:'.$dir);
			return false;
		}

		return true;
	}
}