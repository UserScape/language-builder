<?php namespace Langbuilder; defined('DS') or die('No direct script access.');

class Utilities {

	/**
	 * Get files for comparision editing
	 *
	 * @param string $name
	 * @param string $location
	 * @param string $translation
	 * @return array
	 */
	public static function get_files($name, $location, $translation)
	{
		$path = \Laravel\Bundle::path($location);

		if ( ! is_file($path.'language/'.$translation.'/'.$name.'.php'))
		{
			return null;
		}

		$language['from'] = require $path.'language/'.\Laravel\Config::get('language-builder::builder.base_lang').'/'.$name.'.php';
		$language['to'] = require $path.'language/'.$translation.'/'.$name.'.php';

		return $language;
	}

	/**
	 * Generate an html link with a query string
	 *
	 * @param array $file
	 * @return string
	 */
	public static function link($file = array())
	{
		if ( ! is_array($file['location']))
		{
			$querystring = array(
				'location' => $file['location'],
				'name' => $file['name'],
				'translate' => \Laravel\Input::get('translate')
			);
			$text = $file['name'];
		}
		else
		{
			$querystring = array(
				'location' => $file['location']['name'],
				'name' => $file['name'],
				'translate' => \Laravel\Input::get('translate')
			);
			$text = $file['location']['name'].'/'.$file['name'];
		}

		$querystring = http_build_query($querystring);
		return \Laravel\HTML::link('language-builder/edit?'.$querystring, $text);
	}

	/**
	 * Make the language array string
	 *
	 * @param array $lang
	 * @return string
	 */
	public static function make_array($lang)
	{
		$out = '<?php '."\nreturn array(\n";
		$out .= static::build_array($lang);
		return $out.');';
	}

	/**
	 * Recursively build out a formated array for the language file
	 *
	 * @param array $lang
	 * @param int $depth
	 * @return string
	 */
	protected static function build_array($lang, $depth = 1)
	{
		foreach ($lang as $key => $value)
		{
			if (is_array($value))
			{
				$out .= str_repeat("\t", $depth)."'".$key."' => array(\n";
				$out .= static::build_array($value, ++$depth)."\n";
				$out .= str_repeat("\t", --$depth)."),\n";
				$depth = 1;
				continue;
			}
			$out .= str_repeat("\t", $depth)."'".$key."' => '".$value."',\n";
		}
		return $out;
	}
}