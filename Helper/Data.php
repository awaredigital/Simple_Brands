<?php

namespace Simple\Brands\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Amasty\ShopbyBase\Model\ResourceModel\OptionSetting\CollectionFactory as Collection;
use Amasty\ShopbyBase\Model\OptionSetting;
use \Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper{

	private $optionSetting;
    private $storeManager;
    private $brands;

	public function __construct(
		Context $context,
		Collection $optionSetting,
		StoreManagerInterface $storeManager
	)
	{
		parent::__construct($context);
		$this->optionSetting = $optionSetting;
        $this->storeManager = $storeManager;
	}

	/**
	 * @param $product
	 * @return \Amasty\ShopbyBase\Model\ResourceModel\OptionSetting\Collection|bool
	 */
	public function getBrandImage($product){

		$optionId = $product->getData('brands');
		$imageCollection = $this->optionSetting->create();

		if($optionId){
			$imageCollection->addFieldToFilter('value',array('eq'=>$optionId))
                ->addFieldtoFilter('filter_code', array('eq' => 'attr_brands'))->getFirstItem();
                $this->brands = $imageCollection->getData();
        }
	}

	/**
	 * @param $image
	 * @return string
	 * @throws \Magento\Framework\Exception\NoSuchEntityException
	 */
	public function getImageUrl()
	{
        if($this->brands){
            $image = $this->brands;
            $url = OptionSetting::IMAGES_DIR . $image[0]['image'];

            $url = rtrim($this->storeManager->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA), '/')
                . $url; //IMAGES_DIR already has delimiter

            return $url;
        }
       
    }
    
    public function getTitle(){
        if($this->brands){
            return $this->brands[0]['title'];
        }
    }

}