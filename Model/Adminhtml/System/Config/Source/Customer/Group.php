<?php
declare(strict_types=1);

namespace LeSite\CustomBar\Model\Adminhtml\System\Config\Source\Customer;

use \Magento\Customer\Model\ResourceModel\Group\CollectionFactory;

class Group implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * array of customer group options
     * @var array
     */
    private $options = [];

    /**
     * @var CollectionFactory
     */
    private $groupCollectionFactory;

    /**
     * @param CollectionFactory $groupCollectionFactory
     */
    public function __construct(
        CollectionFactory $groupCollectionFactory
    ) {
        $this->groupCollectionFactory = $groupCollectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        if (!$this->options) {
            $this->options = $this->groupCollectionFactory->create()->loadData()->toOptionArray();
        }
        return $this->options;
    }
}
