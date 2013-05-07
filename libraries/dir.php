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
			static::create(preg_replace('|([\/])'.$from.'([\/])|', "$1$to$2", $file));
		}

		// Now any bundles
		$from_bundles = static::bundles($from);
		foreach ($from_bundles as $bundle)
		{
			$bundle_files = static::read($bundle['path'].$from);
			foreach ($bundle_files as $file)
			{
				static::create(preg_replace('|([\/])'.$from.'([\/])|', "$1$to$2", $file));
			}
		}
	}

	/**
	 * Create an empty language file if it doesn't exist.
	 *
	 * @param string $path
	 * @return bool
	 */
	public static function create($full_path)
	{
		$dir = str_replace(basename($full_path), '', $full_path);

		if ( ! is_dir($dir))
		{
			static::make($dir);
		}

		if ( ! file_exists($full_path))
		{
			$data = '<?php return array();';
			\Laravel\File::put($full_path, $data);
		}

		return true;
	}

	/**
	 * Load all the bundles with language files and get their paths
	 *
	 * @param string $lang
	 * @return array
	 */
	public static function bundles($lang = null)
	{
		$folders = array();

		// Get the bundle languages
		if ($bundles = \Laravel\Bundle::all())
		{
			foreach ($bundles as $bundle)
			{
				if (is_dir(\Laravel\Bundle::path($bundle['location']).'/language/'.$lang))
				{
					$folders[] = array(
						'path' => \Laravel\Bundle::path($bundle['location']).'language/',
						'name' => $bundle
					);
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
				$dir_contents[] = $dir.'/'.$file;
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