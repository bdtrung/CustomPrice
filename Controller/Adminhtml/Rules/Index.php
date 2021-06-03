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

use Magento\Backend\Model\View\Result\Page as ResultPage;
use Magento\Framework\View\Result\Page;
use Mageplaza\CustomPrice\Controller\Adminhtml\Rules;

/**
 * Class Index
 * @package Mageplaza\CustomPrice\Controller\Adminhtml\Rules
 */
class Index extends Rules
{
    /**
     * execute the action
     *
     * @return ResultPage|Page
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Mageplaza_CustomPrice::rules');
        $resultPage->getConfig()->getTitle()->prepend(__('Rules List'));

        return $resultPage;
    }
}
