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
		$from_files = static::read(path('app').'language'.DS.$from);
		foreach ($from_files as $file)
		{
			static::create(str_replace($from, $to, $file));
		}

		// Now any bundles
		$from_bundles = static::get_bundles_with_language($from);
		foreach ($from_bundles as $bundle)
		{
			$bundle_files = static::read($bundle['language_path'].$from);
			if (!$bundle_files) continue;
			foreach ($bundle_files as $file=>$file_path)
			{
				$file_to = $bundle['language_path']. $to .DS. $file;
				static::create($file_to);
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
	public static function get_bundles_with_language($lang = null)
	{
		$folders = array();

		// Get the bundle languages
		if ($bundles = \Laravel\Bundle::all())
		{
			foreach ($bundles as $name => $bundle)
			{
				$bundle_path=\Laravel\Bundle::path($bundle['location']);
				$bundle_language_path= $bundle_path.'language'.DS;
				$has_base_language = $bundle_path.'language'.DS.$lang;
				if (is_dir($bundle_language_path) and is_dir($has_base_language))
				{
					$folders[] = array(
						'path' => $bundle_path,
						'language_path' => $bundle_language_path,
						'name' => $name
					);
				}
			}
		}

		return $folders;
	}

	/**
	 * Check if the directory exists, if not it creates it
	 *
	 * @access public
	 * @static
	 * @param  string $dir  full path to directory
	 * @return bool  FALSE on failure, TRUE on success
	 */
	static public function check_exists_or_create($dir)
	{
		if (!file_exists($dir) || !is_dir($dir))
		{
			return static::make($dir);
		}
		return true;
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
		if (!is_dir($dir))
		{
			return false;
		}

		$files = scandir($dir);
		$dir_contents = array();
		foreach ($files as $file)
		{
			if ($file == '.' OR $file == '..' OR $file == '.DS_STORE')
			{
				continue;
			}
			// Ignore files specified
			if ( ! in_array($file, $ignore))
			{
				$dir_contents[$file] = $dir.DS.$file;
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
		$dir = str_replace('..'.DS, '', $dir);
		$dir = str_replace('.'.DS, '', $dir);

		// Attempt to make the directory
		if ( ! mkdir($dir, $permission, $nested))
		{
			Log::error('Dir::make:Failed to create the directory:'.$dir);
			return false;
		}

		return true;
	}
}