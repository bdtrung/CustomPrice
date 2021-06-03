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

use Mageplaza\CustomPrice\Model\ResourceModel\Rules\CollectionFactory;
use Mageplaza\CustomPrice\Api\RulesManagementInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Class RulesRepository
 * @package Mageplaza\CustomPrice\Model
 */
class RulesRepository implements RulesManagementInterface
{
    /**
     * @var CollectionFactory
     */
    protected $rulesCollection;

    /**
     * @var TimezoneInterface
     */
    protected $timezone;

    /**
     * RulesRepository constructor.
     *
     * @param CollectionFactory $rulesCollection
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        CollectionFactory $rulesCollection,
        TimezoneInterface $timezone
    ) {
        $this->rulesCollection = $rulesCollection;
        $this->timezone        = $timezone;
    }

    /**
     * @inheritDoc
     */
    public function getRule($email, $sku)
    {
        $timeStamp   = $this->timezone->scopeTimeStamp();
        $currentDate = date('Y-m-d', $timeStamp);

        return $this->rulesCollection->create()
            ->addFieldToFilter('email', $email)
            ->addFieldToFilter('sku', $sku)
            ->addFieldToFilter('from_date', [['lteq' => $currentDate], ['null' => true]])
            ->addFieldToFilter('to_date', [['gteq' => $currentDate], ['null' => true]])
            ->getFirstItem();
    }

    /**
     * @return string
     */
    public function getCurrentDate()
    {
        $timeStamp = $this->timezone->scopeTimeStamp();

        return date('Y-m-d', $timeStamp);
    }
}
