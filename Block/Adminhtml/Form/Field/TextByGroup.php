<?php
declare(strict_types=1);

namespace LeSite\CustomBar\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Backend\Block\Template\Context;
use LeSite\CustomBar\Model\Adminhtml\System\Config\Source\Customer\Group;

class TextByGroup extends Select
{
    /**
     * @var Group
     */
    protected $groupOptions;

    /**
     * @param Context $context
     * @param Group $groupOptions
     * @param array $data
     */
    public function __construct(
        Context $context,
        Group $groupOptions,
        array $data = []
    ) {
        $this->groupOptions = $groupOptions;
        parent::__construct($context, $data);
    }

    /**
     * @param $value
     * @return TextByGroup
     */
    public function setInputName($value): TextByGroup
    {
        return $this->setName($value);
    }

    /**
     * @param $value
     * @return TextByGroup
     */
    public function setInputId($value): TextByGroup
    {
        return $this->setId($value);
    }

    /**
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    /**
     * @return array
     */
    private function getSourceOptions(): array
    {
        return $this->groupOptions->toOptionArray();
    }
}
