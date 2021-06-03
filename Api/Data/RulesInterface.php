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

namespace Mageplaza\CustomPrice\Api\Data;

/**
 * Interface RulesInterface
 * @package Mageplaza\CustomPrice\Api\Data
 */
interface RulesInterface
{
    /**
     * Constants defined for keys of array, makes typos less likely
     */
    const RULE_ID      = 'rule_id';
    const CUSTOM_PRICE = 'custom_price';
    const EMAIL        = 'email';
    const SKU          = 'sku';
    const FROM_DATE    = 'from_date';
    const TO_DATE      = 'to_date';
    const CREATED_AT   = 'created_at';

    /**
     * @return int
     */
    public function getRuleId();

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setRuleId($value);

    /**
     * @return float
     */
    public function getCustomPrice();

    /**
     * @param float $value
     *
     * @return $this
     */
    public function setCustomPrice($value);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setEmail($value);

    /**
     * @return string
     */
    public function getSku();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setSku($value);

    /**
     * @return string
     */
    public function getFromDate();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setFromDate($value);

    /**
     * @return string
     */
    public function getToDate();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setToDate($value);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setCreatedAt($value);
}
