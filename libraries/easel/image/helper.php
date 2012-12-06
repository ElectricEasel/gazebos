<?php defined('EE_PATH') or die;

abstract class EEImageHelper
{
	/**
	 * Image sizes for resizing
	 *
	 * @return  array  Resize and crop sizes to use with self::resizeImages
	 *
	 */
	public static function getImageSizes()
	{
		return array(
			'resize' => array(
				array(300, null),
				array(150, null),
			),
			'crop' => array(
				array(64, 64, 270, 200),
			),
		);
	}

	/**
	 * Method to resize uploaded images
	 *
	 * @param   string  $full_dir  Directory where file is saved
	 * @param   string  $name      File name
	 * @param   array   $info      File info
	 *
	 * @return  void
	 *
	 */
	public static function resizeImage($full_dir, $name, $info)
	{
		$image = new JImage;
		$image->loadFile($full_dir.$name);

		// Check if it's wider than 600 pixels
		if ($info->width > JIMAGE_MAX_UPLOAD_WIDTH)
		{
			$image->resize(JIMAGE_MAX_UPLOAD_WIDTH, null)->toFile($full_dir.$name);
			$image = new JImage;
			$image->loadFile($full_dir.$name);
		}

		foreach (self::getImageSizes() as $type => $sizes)
		{
			foreach ($sizes as $size)
			{
				list($width, $height, $left, $top) = $size;

				if ($type = 'resize')
				{
					// fix the resize method arguments.
					// $left is actually $createNew and $top is scale method
					// check libraries/joomla/image/image.php
					$left = true;
					$top = 2;
				}
				$prefix = str_replace('__', '_', "{$width}_{$height}_");
				$image->$type($width, $height, $left, $top)->toFile($full_dir.$prefix.$name);
			}
		}
	}

	/**
	 * Method to save uploaded images
	 *
	 * @param   string  $full_dir
	 * @param   array   $files
	 * @param   array   $data
	 * @param   bool    $resize    Whether or not to resize after upload
	 *
	 * @return  void
	 */
	public static function saveImages(&$full_dir, &$files, &$data, $resize = true)
	{
		foreach
		($files['name'] as $field => $val)
		{
			if (empty($val))
			{
				continue;
			}
			$file = new stdClass;
			foreach ($files as $key => $values)
			{
				$file->$key = $values[$field];
			}
			if (!$file->error)
			{
				$parts = explode('.', $file->name);
				$file->ext = strtolower(array_pop($parts));
				$allowed_ext = explode(',', 'jpg,jpeg,png,gif,pdf');
				if (in_array($file->ext, $allowed_ext))
				{
					$file->ok = true;
				}

				$file->name = JFile::makeSafe(strtolower($file->name));

				if ($field === 'pdf')
				{
					if ($file->ok == true)
					{
						JFile::upload($file->tmp_name, $full_dir.$file->name);
						$data[$field] = $file->name;
					}
				}
				else
				{
					$file->tmp_info = JImage::getImageFileProperties($file->tmp_name);

					if (is_int($file->tmp_info->width) && is_int($file->tmp_info->height) || preg_match("/image/i", $file->tmp_info->mime))
					{
						if (is_file($full_dir.$file->name))
						{
							JFile::delete($full_dir.$file->name);
						}
						if (JFile::upload($file->tmp_name, $full_dir.$file->name))
						{
							if ($resize === true)
							{
								self::resizeImage($full_dir, $file->name, $file->tmp_info);
							}
							$data[$field] = $file->name;
						}
					}
				}
			}
		}
	}

}