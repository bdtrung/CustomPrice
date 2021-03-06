<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_CustomPrice
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\CustomPrice\Controller\Adminhtml\Rules;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Mageplaza\CustomPrice\Controller\Adminhtml\Rules;

/**
 * Class Edit
 * @package Mageplaza\CustomPrice\Controller\Adminhtml\Rules
 */
class Edit extends Rules
{
    /**
     * @return ResponseInterface|Redirect|ResultInterface|Page
     */
    public function execute()
    {
        $rule = $this->_initRule();
        if (!$rule->getRuleId() && $this->getRequest()->getParam('rule_id')) {
            $this->messageManager->addErrorMessage(__('This Rule no longer exists.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('*/*/', [
                'id'       => $rule->getRuleId(),
                '_current' => true
            ]);

            return $resultRedirect;
        }

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Mageplaza_CustomPrice::rules');
        $resultPage->getConfig()->getTitle()
            ->set(__('Custom Price'))
            ->prepend($rule->getRuleId() ? $rule->getProductName() : __('Create Rule'));

        return $resultPage;
    }
}
