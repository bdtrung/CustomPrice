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
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect as ResultRedirect;
use Magento\Framework\Controller\ResultInterface;
use Mageplaza\CustomPrice\Controller\Adminhtml\Rules;

/**
 * Class Delete
 * @package Mageplaza\CustomPrice\Controller\Adminhtml\Rules
 */
class Delete extends Rules
{
    /**
     * @return ResponseInterface|ResultRedirect|ResultInterface
     */
    public function execute()
    {
        $ruleId = $this->getRequest()->getParam('rule_id');

        if ($ruleId) {
            $rule = $this->_initRule();
            $rule->load($ruleId);

            try {
                $rule->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the rule'));

                return $this->getResultRedirect('mpcustomprice/*/');
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $this->getResultRedirect('mpcustomprice/*/edit', ['rule_id' => $ruleId]);
            }
        }

        $this->messageManager->addErrorMessage(__('This rule no longer exists'));

        return $this->getResultRedirect('mpcustomprice/*/');
    }

    /**
     * @param $path
     * @param array $params
     *
     * @return ResultRedirect
     */
    protected function getResultRedirect($path, array $params = [])
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath($path, $params);
    }
}
