<?php defined('EE_PATH') or die;

abstract class EEComponentHelper extends JComponentHelper
{
	/**
	 * Method to fetch a single component param.
	 *
	 * @param   string  $option   The component option
	 * @param   string  $param    The param to fetch
	 * @param   mixed   $default  The default value to return if param is not set.
	 *
	 * @return  mixed   Value of specified param if found, otherwise false.
	 *
	 */
	public static function getParam($option, $param, $default = null)
	{
		$component = parent::getComponent($option, true);

		if ($component->enabled !== false)
		{
			return $component->params->get($param, $default);
		}

		return false;
	}

	/**
	 * Method to load the prefix for your component into the autoloader.
	 *
	 * @param   string   $component
	 * @param   boolean  $admin
	 *
	 * @return  void
	 */
	public static function load($component, $admin = false)
	{
		$name = strtolower($component);

		if ($admin)
		{
			$path = JPATH_SITE . '/administrator/components/com_' . $name;
		}
		else
		{
			$path = JPATH_SITE . '/components/com_' . $name;
		}

		JLoader::registerPrefix($component, $path);
	}
}