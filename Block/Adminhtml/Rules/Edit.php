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

namespace Mageplaza\CustomPrice\Block\Adminhtml\Rules;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;
use Mageplaza\CustomPrice\Model\Rules;

/**
 * Class Edit
 * @package Mageplaza\CustomPrice\Block\Adminhtml\Rules
 */
class Edit extends Container
{
    /**
     * @var Registry
     */
    public $coreRegistry;

    /**
     * Edit constructor.
     *
     * @param Registry $coreRegistry
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Registry $coreRegistry,
        Context $context,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context, $data);
    }

    /**
     * Initialize Rule edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Mageplaza_CustomPrice';
        $this->_controller = 'adminhtml_rules';

        parent::_construct();

        $this->buttonList->add(
            'save_and_continue_edit',
            [
                'class'          => 'save',
                'label'          => __('Save and Continue Edit'),
                'data_attribute' => [
                    'mage-init' => ['button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form']],
                ]
            ],
            20
        );

        $ruleId = $this->getRequest()->getParam('rule_id');
        if ($ruleId !== null) {
            $this->addButton(
                'delete',
                [
                    'label'   => __('Delete'),
                    'class'   => 'delete',
                    'onclick' => 'deleteConfirm(\'' . __('Are you sure you want to delete this rule?') . '\', \'' . $this->getUrl(
                            'mpcustomprice/rules/delete',
                            ['rule_id' => $ruleId]
                        ) . '\')'
                ]
            );
        }

        $this->buttonList->update('back', 'onclick', "setLocation('" . $this->getBackUrl() . "')");

        $this->buttonList->remove('reset');
    }

    /**
     * Retrieve text for header element depending on loaded Rule
     *
     * @return string
     */
    public function getHeaderText()
    {
        /** @var Rules $rule */
        $rule = $this->coreRegistry->registry('current_rule');
        if ($rule->getId()) {
            return __("Edit Rule ID '%1'", $this->escapeHtml($rule->getId()));
        }

        return __('New Rule');
    }

    /**
     * Get form action URL
     *
     * @return string
     */
    public function getFormActionUrl()
    {
        /** @var Rules $rule */
        $rule = $this->coreRegistry->registry('current_rule');

        if ($ruleId = $rule->getId()) {
            return $this->getUrl('*/*/save', ['id' => $ruleId]);
        }

        return parent::getFormActionUrl();
    }
}
