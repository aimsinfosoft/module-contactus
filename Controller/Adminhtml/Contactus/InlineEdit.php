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

namespace Aimsinfosoft\Contactus\Controller\Adminhtml\Contactus;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Cms\Api\Data\PageInterface;
use Aimsinfosoft\Contactus\Model\Contactus as ModelContactus;

/**
 * Class InlineEdit
 * @package Aimsinfosoft\Contactus\Controller\Adminhtml\Contactus
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    protected $dataProcessor;
    protected $jsonFactory;
    protected $ContactusModel;
    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param ModelContactus $ContactusModel
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        PostDataProcessor $dataProcessor,
        ModelContactus $ContactusModel,
        JsonFactory $jsonFactory
    )
    {
        parent::__construct($context);
        $this->dataProcessor = $dataProcessor;
        $this->jsonFactory = $jsonFactory;
        $this->ContactusModel = $ContactusModel;
    }

    /**
     * Inline edit contact record
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $Id) {
            $Contactus = $this->ContactusModel->load($Id);

            try {
                $Data = $this->filterPost($postItems[$Id]);
                $this->validatePost($Data, $Contactus, $error, $messages);
                $extendedPageData = $Contactus->getData();
                $this->setContactusTableData($Contactus, $extendedPageData, $Data);
                $this->ContactusModel->save($Contactus);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithPageId($Contactus, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithPageId($Contactus, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithPageId(
                    $Contactus,
                    __('Something went wrong while saving the item.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

      /**
     * filter contact record
     * @param $postData
     */
    protected function filterPost($postData = [])
    {
        $pageData = $this->dataProcessor->filter($postData);
        $pageData['custom_theme'] = isset($pageData['custom_theme']) ? $pageData['custom_theme'] : null;
        $pageData['custom_root_template'] = isset($pageData['custom_root_template'])
            ? $pageData['custom_root_template']
            : null;
        return $pageData;
    }

     /**
     * Validate  post request
     * @param $pageData
     * @param \Aimsinfosoft\Contactus\Model\Contactus $page
     * @param $error
     * @param $messages
     */
    protected function validatePost(
        array $pageData,
        \Aimsinfosoft\Contactus\Model\Contactus $page,
        &$error,
        array &$messages
    )
    {
        if (!($this->dataProcessor->validate($pageData) && $this->dataProcessor->validateRequireEntry($pageData))) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithPageId($page, $error->getText());
            }
        }
    }

    /** 
     * check if error in Page ID
     * @param ModelContactus $page
     * @param $errorText
     * */
    protected function getErrorWithPageId(ModelContactus $page, $errorText)
    {
        return '[Page ID: ' . $page->getId() . '] ' . $errorText;
    }

    /** 
     * check if error in Page ID
     * @param ModelContactus $page
     * @param $extendedPageData
     * @param $pageData
     * */
    public function setContactusTableData(
        ModelContactus $page,
        array $extendedPageData,
        array $pageData
    )
    {
        $page->setData(array_merge($page->getData(), $extendedPageData, $pageData));
        return $this;
    }
}
