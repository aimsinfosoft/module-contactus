<?php
/**
 * Aimsinfosoft
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the aimsinfosoft.com license that is
 * available through the world-wide-web at this URL:
 * https://www.aimsinfosoft.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Aimsinfosoft
 * @package     Aimsinfosoft_Contactus
 * @copyright   Copyright (c) Aimsinfosoft (https://www.aimsinfosoft.com)
 * @license     https://www.aimsinfosoft.com/LICENSE.txt
 */

namespace Aimsinfosoft\Contactus\Model\ResourceModel\Contactus;

use \Aimsinfosoft\Contactus\Model\ResourceModel\AbstractCollection;

/**
 * Class Collection
 * @package Aimsinfosoft\Contactus\Model\ResourceModel\Contactus
 */

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_previewFlag;
    protected function _construct()
    {
        $this->_init(
            'Aimsinfosoft\Contactus\Model\Contactus',
            'Aimsinfosoft\Contactus\Model\ResourceModel\Contactus'
        );
        $this->_map['fields']['id'] = 'main_table.id';
    }
}
