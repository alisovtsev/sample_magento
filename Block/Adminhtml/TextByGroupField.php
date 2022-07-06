<?php
declare(strict_types=1);

namespace LeSite\CustomBar\Block\Adminhtml;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use LeSite\CustomBar\Block\Adminhtml\Form\Field\TextByGroup;
use Magento\Framework\Exception\LocalizedException;

class TextByGroupField extends AbstractFieldArray
{
    /**
     * @var TextByGroup
     */
    private $dropdownRenderer;

    /**
     * @return void
     * @throws LocalizedException
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'group_id',
            [
                'label' => __('Customer Group'),
                'renderer' => $this->getDropdownRenderer(),
            ]
        );
        $this->addColumn(
            'text',
            [
                'label' => __('Text'),
                'class' => 'required-entry',
            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * @param DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $row->setData('option_extra_attrs', []);
    }

    /**
     * @return TextByGroup
     * @throws LocalizedException
     */
    private function getDropdownRenderer(): TextByGroup
    {
        if (!$this->dropdownRenderer) {
            $this->dropdownRenderer = $this->getLayout()->createBlock(
                TextByGroup::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->dropdownRenderer;
    }
}
