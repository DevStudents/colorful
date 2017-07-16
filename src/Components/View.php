<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Components;
use sintloer\COLORFUL\Core;

/**
 * View component.
 * 
 */

class View
{

	/**
	 * Data of view.
	 * @var array
	 * 
	 */

	private static $_data = [];

	/**
	 * Name of view.
	 * @var string
	 * 
	 */

	private static $_name = '';

	/**
	 * Views files directory.
	 * @var string|null
	 * 
	 */

	private static $_directory = null;

	/**
	 * Cache files directory.
	 * @var string|null
	 * 
	 */

	private static $_cacheDirectory = null;

	/**
	 * Extension of views files.
	 * @var string|null
	 * 
	 */

	private static $_extension = null;

	/**
	 * Add variables to $_data.
	 * @param array|string $name
	 * @param string|null $value
	 * @return void
	 * 
	 */

	public static function add($name, $value = null)
	{
		if(is_array($name))
		{
			foreach($name as $key => $value)
				self::$_data[$key] = $value;
		}
		else
			self::$_data[$name] = $value;
	}

	/**
	 * Load view file.
	 * @param string $name
	 * @param array $data
	 * @return void
	 * 
	 */
	
	public static function load($name, $data = [])
	{
		if($config = Core\Config::get('views'))
		{
			if(self::$_directory === null)
				self::$_directory = $config['directory'] ?? '';

			if(self::$_cacheDirectory === null)
				self::$_cacheDirectory = $config['cacheDirectory'] ?? '';

			if(self::$_extension === null)
				self::$_extension = $config['extension'] ?? '';

			self::$_name = $name;

			$content = self::_loadViewFile(str_replace('/', '.', self::$_name));
			if($content !== false)
			{
				if(is_array($data) && count($data) > 0)
					self::add($data);

				$cacheFileName = substr(md5(serialize(self::$_data) . serialize($content)), 0, 9) . '.' . substr(md5(self::$_name), 0, 4);

				$cacheFile = self::_getCacheFile($cacheFileName);
				if($cacheFile !== false)
					return $cacheFile;
				else
				{
					$content = self::_parseContent($content);
					self::_saveCacheFile($cacheFileName, $content);
					return $content;
				}
			}
			else
				Core\Error::show('View file is not found: ' . self::$_name . '.' . self::$_extension);
		}
		else
			Core\Error::show('You need to configure View System.', 1200);
	}

	/**
	 * Parsing view content.
	 * @param string $content
	 * @return string
	 * 
	 */

	private static function _parseContent($content)
	{
		$content = htmlspecialchars($content);
		$content = self::$_replaceFunctions($content);
		$content = self::$_replaceValues($content);

		return htmlspecialchars_decode($content);
	}

	/**
	 * Load view file.
	 * @param string $name
	 * @return string|boolean
	 * 
	 */

	private static function _loadViewFile($name)
	{
		$path = self::$_directory . '/' . $name . '.' . self::$_extension;
		if(is_readable($path))
		{
			ob_start();
			require $path;
			return ob_get_clean();
		}

		return false;
	}

	/**
	 * Save cache file.
	 * @param string $name
	 * @param string $content
	 * @return boolean
	 * 
	 */

	private static function _saveCacheFile($name, $content)
	{
		if(!is_dir(self::$_cacheDirectory))
			mkdir(self::$_cacheDirectory);

		foreach(glob(self::$_cacheDirectory . '/*.' . (explode('.', $name)[1])) as $file)
			unlink($file);

		if(file_put_contents(self::$_cacheDirectory . '/' . $name, $content))
			return true;

		return false;
	}

	/**
	 * Get cache file or return false if not exists.
	 * @param string $name
	 * @return string|boolean
	 * 
	 */

	private static function _getCacheFile($name)
	{
		$path = self::$_cacheDirectory . '/' . $name;
		if(is_readable($path))
			return file_get_contents($path);

		return false;
	}
}