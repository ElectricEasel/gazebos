<?php defined('EE_PATH') or die;

abstract class EEHtml extends JHtml
{
	/**
	 * Includes assets from media directory, looking in the
	 * template folder for a style override to include.
	 *
	 * @param   string  $filename   Path to file.
	 * @param   string  $extension  Current extension name. Will auto detect component name if null.
	 *
	 * @return  mixed  False if asset type is unsupported, nothing if a css or js file, and a string if an image
	 */
	public static function asset($filename, $extension = null, $attributes = array())
	{
		if (is_null($extension))
		{
			$extension = array_pop(explode(DIRECTORY_SEPARATOR, JPATH_COMPONENT));
		}

		$toLoad = "$extension/$filename";

		// Discover the asset type from the file name
		$type = substr($filename, (strrpos($filename, '.') + 1));

		switch (strtoupper($type))
		{
			case 'CSS':
				self::stylesheet($toLoad, false, true, false);
				break;
			case 'JS':
				self::script($toLoad, false, true);
				break;
			case 'GIF':
			case 'JPG':
			case 'JPEG':
			case 'PNG':
			case 'BMP':
				$alt = '';

				if (isset($attributes['alt']))
				{
					$alt = $attributes['alt'];
					unset($attributes['alt']);
				}

				return self::image($toLoad, $alt, $attributes, true);
				break;
			default:
				return false;
		}
	}

	public static function extractScripts(JDocument $doc)
	{
		$buffer = '';

		// Generate script file links
		foreach ($doc->_scripts as $strSrc => $strAttr)
		{
			// Force async
			// $strAttr['async'] = true;

			$buffer .= "\t" . '<script src="' . $strSrc . '"';
			if (!is_null($strAttr['mime']))
			{
				$buffer .= ' type="' . $strAttr['mime'] . '"';
			}
			if ($strAttr['defer'])
			{
				$buffer .= ' defer="defer"';
			}
			if ($strAttr['async'])
			{
				$buffer .= ' async="async"';
			}
			$buffer .= '></script>' . PHP_EOL;
		}

		// Generate script declarations
		foreach ($doc->_script as $type => $content)
		{
			$buffer .= "\t" . '<script type="' . $type . '">' . PHP_EOL;

			// This is for full XHTML support.
			if ($doc->_mime != 'text/html')
			{
				$buffer .= "\t" . "\t" . '<![CDATA[' . PHP_EOL;
			}

			$buffer .= $content . PHP_EOL;

			// See above note
			if ($doc->_mime != 'text/html')
			{
				$buffer .= "\t" . "\t" . ']]>' . PHP_EOL;
			}
			$buffer .= "\t" . '</script>' . PHP_EOL;
		}

		$doc->_scripts = array();
		$doc->_script = array();

		return $buffer;
	}
}
