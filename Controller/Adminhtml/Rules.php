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

namespace Mageplaza\CustomPrice\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Mageplaza\CustomPrice\Model\Rules as ModelRules;
use Mageplaza\CustomPrice\Model\RulesFactory;
use Magento\Catalog\Model\ProductRepository;

/**
 * Class Rules
 * @package Mageplaza\CustomPrice\Controller\Adminhtml
 */
abstract class Rules extends Action
{
    const ADMIN_RESOURCE = 'Mageplaza_CustomPrice::rules';

    /**
     * @type PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @type Registry
     */
    protected $_coreRegistry;

    /**
     * @var RulesFactory
     */
    protected $_rulesFactory;

    /**
     * @var ProductRepository
     */
    protected $productRepo;

    /**
     * Rules constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $coreRegistry
     * @param RulesFactory $rulesFactory
     * @param ProductRepository $productRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        RulesFactory $rulesFactory,
        ProductRepository $productRepository
    ) {
        $this->_coreRegistry      = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_rulesFactory      = $rulesFactory;
        $this->productRepo        = $productRepository;

        parent::__construct($context);
    }

    /**
     * @return false|ModelRules
     */
    protected function _initRule()
    {
        $ruleId = (int) $this->getRequest()->getParam('rule_id');
        $rules  = $this->_rulesFactory->create();

        if ($ruleId) {
            $rules->load($ruleId);
            if (!$rules->getId()) {
                $this->messageManager->addErrorMessage(__('This rule no longer exists.'));

                return false;
            }
        }

        if (!$this->_coreRegistry->registry('current_rule')) {
            $this->_coreRegistry->register('current_rule', $rules);
        }

        return $rules;
    }
}
