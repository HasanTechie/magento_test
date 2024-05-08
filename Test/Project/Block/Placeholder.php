<?php
declare(strict_types=1);

namespace Test\Project\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Placeholder extends Template
{
    protected $scopeConfig;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function getConfigValue($path):string
    {
        return $this->scopeConfig->getValue($path) ?? '';
    }

    public function isPlaceholderEnabled(): string
    {
        return $this->getConfigValue('placeholder_section/placeholder_group/enable') ?? '';
    }

    public function getTitle():string
    {
        $value = $this->getConfigValue('placeholder_section/placeholder_group/title');
        return $value !== null ? $value : '';
    }

    public function getParagraph():string
    {
        $value = $this->getConfigValue('placeholder_section/placeholder_group/paragraph');
        return $value !== null ? $value : '';
    }

    public function getImageUrl():string
    {
        // Retrieve the base URL for media files
        $mediaBaseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        // Retrieve the path to the uploaded image from configuration
        $imagePath = $this->scopeConfig->getValue('placeholder_section/placeholder_group/image_upload', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if($imagePath != null) {
            $imageUrl = $mediaBaseUrl . 'placeholder/image/' . $imagePath;
        }else{
            $imageUrl = 'https://placehold.co/400';
        }

        return $imageUrl;
    }
}
