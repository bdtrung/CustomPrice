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

use Exception;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Mageplaza\CustomPrice\Controller\Adminhtml\Rules;

/**
 * Class Save
 * @package Mageplaza\CustomPrice\Controller\Adminhtml\Rules
 */
class Save extends Rules
{
    /**
     * @return Redirect|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data           = $this->getRequest()->getPost('rule');
        $redirectBack   = $this->getRequest()->getParam('back', false);

        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }

        /** @var \Mageplaza\CustomPrice\Model\Rules $rule */
        $rule = $this->_initRule();

        try {
            $this->productRepo->get($data['sku']);
            $rule->addData($data)->save();
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
            $resultRedirect->setPath('*/*/edit', ['rule_id' => $rule->getId(), '_current' => true]);
        }

        $this->messageManager->addSuccessMessage(__('The Rule has been saved'));

        return $redirectBack
            ? $resultRedirect->setPath('*/*/edit', ['rule_id' => $rule->getRuleId()])
            : $resultRedirect->setPath('*/*/');
    }
}
