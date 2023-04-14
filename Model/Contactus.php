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

namespace Aimsinfosoft\Contactus\Model;

/**
 * Class Contactus
 * @package Aimsinfosoft\Contactus\Model
 */
class Contactus extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Aimsinfosoft\Contactus\Model\ResourceModel\Contactus');
    }
}