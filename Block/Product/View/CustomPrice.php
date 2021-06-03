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

namespace Mageplaza\CustomPrice\Block\Product\View;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Context;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Mageplaza\CustomPrice\Model\RulesRepository;

/**
 * Class CustomPrice
 * @package Mageplaza\CustomPrice\Block
 */
class CustomPrice extends AbstractProduct
{
    /**
     * @var SessionFactory
     */
    protected $customerSession;

    /**
     * @var RulesRepository
     */
    protected $rulesRepo;

    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * CustomPrice constructor.
     *
     * @param Context $context
     * @param SessionFactory $customerSession
     * @param RulesRepository $rulesRepo
     * @param PriceCurrencyInterface $priceCurrency
     * @param array $data
     */
    public function __construct(
        Context $context,
        SessionFactory $customerSession,
        RulesRepository $rulesRepo,
        PriceCurrencyInterface $priceCurrency,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        $this->rulesRepo       = $rulesRepo;
        $this->priceCurrency   = $priceCurrency;
        parent::__construct($context, $data);
    }

    /**
     * @param $sku
     *
     * @return bool|DataObject
     */
    public function getRule($sku)
    {
        $customerEmail = $this->customerSession->create()->getCustomer()->getEmail();

        if (!$customerEmail) {
            return false;
        }

        $rule = $this->rulesRepo->getRule($customerEmail, $sku);

        return $rule->getId() ? $rule : false;
    }

    /**
     * @param $amount
     * @param bool $includeContainer
     * @param null $scope
     * @param null $currency
     * @param int $precision
     *
     * @return string
     */
    public function formatPrice(
        $amount,
        $includeContainer = true,
        $scope = null,
        $currency = null,
        $precision = PriceCurrencyInterface::DEFAULT_PRECISION
    ) {
        return $this->priceCurrency->format($amount, $includeContainer, $precision, $scope, $currency);
    }
}
