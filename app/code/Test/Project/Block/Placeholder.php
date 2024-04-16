<?php

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

    public function getConfigValue($path)
    {
        return $this->scopeConfig->getValue($path);
    }

    public function isPlaceholderEnabled(){
        return $this->getConfigValue('custom_section/custom_group/enable_placeholder') ?? false;
    }

    public function getTitle()
    {
        $value = $this->getConfigValue('custom_section/custom_group/title');
        return $value !== null ? $value : '';
    }

    public function getParagraph()
    {
        $value = $this->getConfigValue('custom_section/custom_group/paragraph');
        return $value !== null ? $value : '';
    }

    public function getImageUrl()
    {
        // Retrieve the base URL for media files
        $mediaBaseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        // Retrieve the path to the uploaded image from configuration
        $imagePath = $this->scopeConfig->getValue('custom_section/custom_group/image_upload', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if($imagePath != null) {
            $imageUrl = $mediaBaseUrl . 'placeholder/image/' . $imagePath;
        }else{
            $imageUrl = 'https://placehold.co/400';
        }

        return $imageUrl;
    }
}
