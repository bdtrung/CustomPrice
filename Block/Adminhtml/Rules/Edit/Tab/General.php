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

namespace Mageplaza\CustomPrice\Block\Adminhtml\Rules\Edit\Tab;

use IntlDateFormatter;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Exception\LocalizedException;
use Mageplaza\CustomPrice\Model\Rules;

/**
 * Class General
 * @package Mageplaza\CustomPrice\Block\Adminhtml\Rules\Edit\Tab
 */
class General extends Generic implements TabInterface
{
    /**
     * @return Generic
     * @throws LocalizedException
     */
    protected function _prepareForm()
    {
        /** @var Rules $rule */
        $rule = $this->_coreRegistry->registry('current_rule');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('rule_');
        $form->setFieldNameSuffix('rule');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => __('General'),
            'class'  => 'fieldset-wide'
        ]);

        if ($rule->getId()) {
            $fieldset->addField('rule_id', 'hidden', [
                'name' => 'rule_id'
            ]);
        }

        $fieldset->addField('custom_price', 'text', [
            'name'     => 'custom_price',
            'label'    => __('Custom Price'),
            'required' => true,
            'class'    => 'validate-greater-than-zero validate-number-range'
        ]);

        $fieldset->addField('email', 'text', [
            'name'     => 'email',
            'label'    => __('Customer Email'),
            'title'    => __('Customer Email'),
            'text'     => $this->escapeHtml($rule->getEmail()),
            'required' => true,
            'class'    => 'validate-email'
        ]);

        $fieldset->addField('sku', 'text', [
            'name'     => 'sku',
            'label'    => __('Product SKU'),
            'title'    => __('Product SKU'),
            'text'     => $this->escapeHtml($rule->getSku()),
            'required' => true
        ]);

        $fieldset->addField('from_date', 'date', [
            'name'        => 'from_date',
            'label'       => __('Active From'),
            'title'       => __('Active From'),
            'date_format' => $this->_localeDate->getDateFormat(IntlDateFormatter::MEDIUM),
            'class'       => 'validate-date validate-date-range date-range-task_data-from',
            'timezone'    => false,
        ]);

        $fieldset->addField('to_date', 'date', [
            'name'        => 'to_date',
            'label'       => __('Active To'),
            'title'       => __('Active To'),
            'date_format' => $this->_localeDate->getDateFormat(IntlDateFormatter::MEDIUM),
            'class'       => 'validate-date validate-date-range date-range-task_data-to',
            'timezone'    => false,
        ]);


        $form->addValues($rule->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Custom Price');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}
