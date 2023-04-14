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

namespace Aimsinfosoft\Contactus\Plugin;

/**
 * Class ContactusPlugin
 * @package Aimsinfosoft\Contactus\Plugin
 */
class ContactusPlugin
{
    /**
     * @var \Aimsinfosoft\Contactus\Model\Contactus
     */
    protected $contactus;

    /**
     * Plugin constructor.
     *
     * @param \Aimsinfosoft\Contactus\Model\Contactus $contactus
     */
    public function __construct(
        \Aimsinfosoft\Contactus\Model\Contactus $contactus
    )
    {
        $this->contactus = $contactus;
    }

    /**
     * Save the contact info
     * @param \Magento\Contact\Controller\Index\Post $subject
     * @param \Closure $proceed
     * */
    public function aroundExecute(\Magento\Contact\Controller\Index\Post $subject, \Closure $proceed)
    {
        $request = $subject->getRequest()->getPostValue();
        if ($this->validatedParams($request)) {
            $this->contactus->setData($request);
            $this->contactus->save();
        }
        $returnValue = $proceed();
        return $returnValue;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\Exception
     */
    private function validatedParams($request)
    {   
        if (trim($request['name']) === '') {
            throw new LocalizedException(__('Enter the Name and try again.'));
        }
        if (trim($request['comment']) ==' ') {
            throw new LocalizedException(__('Enter the comment and try again.'));
        }
        if (false === \strpos($request['email'], '@')) {
            throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
        }
        if (trim($request['hideit']) !== '') {
            throw new \Exception();
        }
        return $request;
    }
}