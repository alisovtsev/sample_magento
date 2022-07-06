<?php
declare(strict_types=1);

namespace LeSite\CustomBar\ViewModel;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Notification implements ArgumentInterface
{
    const XML_CONFIG_PATH = 'custom_notification/%s/%s';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Json
     */
    private $jsonHelper;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @param CustomerSession $customerSession
     * @param ScopeConfigInterface $scopeConfig
     * @param Json $jsonHelper
     * @param SerializerInterface $serializer
     */
    public function __construct(
        CustomerSession $customerSession,
        ScopeConfigInterface $scopeConfig,
        Json $jsonHelper,
        SerializerInterface $serializer
    ) {
        $this->customerSession = $customerSession;
        $this->scopeConfig    = $scopeConfig;
        $this->jsonHelper     = $jsonHelper;
        $this->serializer     = $serializer;
    }

    /**
     * Is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool)$this->getConfigValue('general', 'enabled');
    }

    /**
     * Get text content.
     *
     * @return string
     */
    public function getText(): string
    {
        $customerGroupId = $this->customerSession->getCustomerGroupId();
        try {
            $textByGroups = $this->serializer->unserialize($this->getConfigValue('content', 'text_by_group'));
            foreach ($textByGroups as $textByGroup) {
                if ($textByGroup['group_id'] == $customerGroupId) {
                    return $textByGroup['text'];
                }
            }
            //phpcs:ignore Magento2.CodeAnalysis.EmptyBlock.DetectedCatch
        } catch (\Exception $e) {
            //textByGroup not configured yet, so just skip in this case
        }
        //by default return default text
        return $this->getConfigValue('design', 'text') ?? '';
    }

    /**
     * Get font size.
     *
     * @return string
     */
    public function getFontSize(): string
    {
        $value = 'auto';
        $confValue = (string)$this->getConfigValue('design', 'font_size');
        if (null !== $confValue) {
            $value = $confValue . 'px';
        }

        return $value;
    }

    /**
     * Get background color.
     *
     * @return string
     */
    public function getBackgroundColor(): string
    {
        return $this->getConfigValue('design', 'bg_color') ?? 'auto';
    }

    /**
     * Get text color.
     *
     * @return string
     */
    public function getTextColor(): string
    {
        return $this->getConfigValue('design', 'text_color') ?? 'auto';
    }

    /**
     * Get config data.
     *
     * @return string
     */
    public function getConfigData(): string
    {
        return $this->jsonHelper->serialize([
            'notification' => [
                'text' => $this->getText(),
                'fontSize' => $this->getFontSize(),
                'textColor' => $this->getTextColor(),
                'backgroundColor' => $this->getBackgroundColor()
            ]
        ]);
    }

    /**
     * Get config value
     *
     * @param string $group
     * @param string $field
     * @return string
     */
    private function getConfigValue(string $group, string $field): string
    {
        $path = sprintf(self::XML_CONFIG_PATH, $group, $field);
        return $this->scopeConfig->getValue($path);
    }

    /**
     * Get list of customer groups for show bar
     * @return array
     */
    public function getCustomerGroups(): array
    {
        $customerGroupsIds = $this->getConfigValue('general', 'customer_group_list') ?? '';
        return explode(',', $customerGroupsIds);
    }
}
