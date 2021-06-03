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

namespace Mageplaza\CustomPrice\Model;

use Magento\Framework\Model\AbstractModel;
use Mageplaza\CustomPrice\Api\Data\RulesInterface;
use Mageplaza\CustomPrice\Model\ResourceModel\Rules as ResourceRules;

/**
 * Class Rules
 * @package Mageplaza\CustomPrice\Model
 */
class Rules extends AbstractModel implements RulesInterface
{
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'mageplaza_customprice_rules';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceRules::class);
    }

    /**
     * @inheritDoc
     */
    public function getRuleId()
    {
        return $this->getData(self::RULE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setRuleId($value)
    {
        return $this->setData(self::RULE_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function getCustomPrice()
    {
        return $this->getData(self::CUSTOM_PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setCustomPrice($value)
    {
        return $this->setData(self::CUSTOM_PRICE, $value);
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail($value)
    {
        return $this->setData(self::EMAIL, $value);
    }

    /**
     * @inheritDoc
     */
    public function getSku()
    {
        return $this->getData(self::SKU);
    }

    /**
     * @inheritDoc
     */
    public function setSku($value)
    {
        return $this->setData(self::SKU, $value);
    }

    /**
     * @inheritDoc
     */
    public function getFromDate()
    {
        return $this->getData(self::FROM_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setFromDate($value)
    {
        return $this->setData(self::FROM_DATE, $value);
    }

    /**
     * @inheritDoc
     */
    public function getToDate()
    {
        return $this->getData(self::TO_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setToDate($value)
    {
        return $this->setData(self::TO_DATE, $value);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt($value)
    {
        return $this->setData(self::CREATED_AT, $value);
    }
}
