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
 * @package     Aimsinfosoft_Imageclean
 * @copyright   Copyright (c) Aimsinfosoft (https://www.aimsinfosoft.com)
 * @license     https://www.aimsinfosoft.com/LICENSE.txt
 */

namespace Aimsinfosoft\Contactus\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
   
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
		$installer = $setup;
        $installer->startSetup();

        /**
         * Create table 'orderstatus'
         */
		if(version_compare($context->getVersion(), '1.0.1', '<')) {
		$table = $setup->getTable('aimsinfosoft_contactus');

        $setup->getConnection()
            ->addIndex(
                $table,
                $setup->getIdxName(
                    $table,
                    ['name', 'email', 'telephone', 'comment'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name', 'email', 'telephone', 'comment'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
		}
	}
}