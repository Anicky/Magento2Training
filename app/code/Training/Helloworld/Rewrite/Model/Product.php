<?php

namespace Training\Helloworld\Rewrite\Model;

class Product extends \Magento\Catalog\Model\Product {


    public function getName()
    {
        return parent::getName() . " (Hello World)";
    }


}