<?php namespace Langbuilder; defined('DS') or die('No direct script access.');

class Utilities {

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

	public static function make_array($array)
	{
		$out = '<?php '."\nreturn array(\n";
		$out .= static::build_array($array);
		return $out.');';
	}

	protected static function build_array($array, $depth = 1)
	{
		foreach ($array as $key => $value)
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