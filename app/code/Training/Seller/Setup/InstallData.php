<?php

namespace Training\Seller\Setup;

use Training\Seller\Model\SellerFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface {

    protected $sellerFactory;

    public function __construct(SellerFactory $sellerFactory)
    {
        $this->sellerFactory = $sellerFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $model = $this->sellerFactory->create();
        $model->setIdentifier('main')->setName('Main Seller');
        $model->getResource()->save($model);
    }


}