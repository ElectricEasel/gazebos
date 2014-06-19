<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosControllerSize extends GazebosController
{
	/**
	 * Handle the form submission
	 *
	 */
	public function submit()
	{
		$app = JFactory::getApplication();
		$jform = $app->input->get('jform', array(), null);

		parent::submitForm('Size');

        $this->submitToSalesforce($jform);

		$this->setRedirect('index.php?option=com_gazebos&view=size&layout=form&tmpl=component&id=' . $jform['size_id']);
	}

    /**
     * Remote post the form data to Gazebos salesforce
     *
     * @param array $data
     *
     * @return void
     */
    public function submitToSalesforce(array $data)
    {
        // Convert the data to the properly named keys.
        if (array_key_exists('comments', $data))
        {
            $data['00NU0000004A54X'] = $data['comments'];
            unset($data['comments']);
        }

        if (array_key_exists('size_intersted_in', $data))
        {
            $data['00NU0000004AqMp'] = $data['size_intersted_in'];
            unset($data['size_intersted_in']);
        }

        if (array_key_exists('size_id', $data))
        {
            $data['00NU0000004AqMu'] = GazebosHelper::getProductForSize($data['size_id']);
            unset($data['size_id']);
        }

        $ch = curl_init('https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_exec($ch);
        curl_close($ch);
    }
}
