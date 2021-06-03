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
use Magento\Ui\Component\MassAction\Filter;
use Mageplaza\CustomPrice\Model\RulesFactory;
use Mageplaza\CustomPrice\Model\ResourceModel\Rules\CollectionFactory;
use Mageplaza\CustomPrice\Model\ResourceModel\RulesFactory as ResourceFactory;
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
     * @var ResourceFactory
     */
    protected $_resourceFactory;

    /**
     * Mass Action Filter
     * @var Filter
     */
    public $filter;

    /**
     * @var CollectionFactory
     */
    public $collectionFactory;

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
     * @param ResourceFactory $resourceFactory
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ProductRepository $productRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        RulesFactory $rulesFactory,
        ResourceFactory $resourceFactory,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ProductRepository $productRepository
    ) {
        $this->_coreRegistry      = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_rulesFactory      = $rulesFactory;
        $this->_resourceFactory   = $resourceFactory;
        $this->filter             = $filter;
        $this->collectionFactory  = $collectionFactory;
        $this->productRepo        = $productRepository;

        parent::__construct($context);
    }

    /**
     * @return bool|\Mageplaza\CustomPrice\Model\Rules
     */
    protected function _initRule()
    {
        $ruleId = (int) $this->getRequest()->getParam('id');
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
