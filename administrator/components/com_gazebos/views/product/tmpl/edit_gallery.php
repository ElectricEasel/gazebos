<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

if ($this->form->getValue('id') == 0) : ?>
<p>You can add gallery images after you save the item the first time.</p>
<?php else: ?>
<iframe width="100%" height="500px" src="index.php?option=com_gazebos&view=gallery&layout=edit&tmpl=component&product_id=<?php echo $this->form->getValue('id'); ?>"></iframe>
<?php endif; ?>
