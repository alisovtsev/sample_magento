<?php
declare(strict_types=1);

namespace LeSite\CustomBar\Block;

use \Magento\Framework\View\Element\Template\Context;
use \Magento\Customer\Model\Session as CustomerSession;

class Bar extends \Magento\Framework\View\Element\Template
{
    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @param CustomerSession $customerSession
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        CustomerSession $customerSession,
        Context $context,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    /**
     * Additionally disable cache
     * @return null
     */
    public function getCacheLifetime()
    {
        return null;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function toHtml(): string
    {
        $availableCustomerGroups = $this->getDetails()->getCustomerGroups();//get from viewmodel
        $customerGroupId = $this->customerSession->getCustomerGroupId();
        if (!in_array($customerGroupId, $availableCustomerGroups)) {
            return '';
        }
        return parent::toHtml();
    }
}
