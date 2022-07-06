<?php
declare(strict_types=1);

namespace LeSite\CustomBar\Block\Adminhtml\Config\Backend;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value as ConfigValue;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\SerializerInterface;

class ArraySerialized extends ConfigValue
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @param ManagerInterface $messageManager
     * @param SerializerInterface $serializer
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        ManagerInterface $messageManager,
        SerializerInterface $serializer,
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->messageManager = $messageManager;
        $this->serializer = $serializer;
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * @return void
     */
    public function beforeSave()
    {
        $value = $this->getValue();
        unset($value['__empty']);
        $this->checkDuplicates($value);
        $encodedValue = $this->serializer->serialize($value);
        $this->setValue($encodedValue);
    }

    /**
     * @param $value
     * @return void
     */
    protected function checkDuplicates($value)
    {
        $groups = [];
        foreach ($value as $val) {
            if (in_array($val['group_id'], $groups)) {
                $this->messageManager->addWarning(
                    __('Text by customer has duplicate groups. Please remove duplicates')
                );
                break;
            }
            $groups[] = $val['group_id'];
        }
    }

    /**
     * @return void
     */
    protected function _afterLoad()
    {
        $value = $this->getValue();
        if ($value) {
            $decodedValue = $this->serializer->unserialize($value);
            $this->setValue($decodedValue);
        }
    }
}
