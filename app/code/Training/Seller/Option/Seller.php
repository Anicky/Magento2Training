<?php

namespace Training\Seller\Option;

use \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Training\Seller\Api\Data\SellerInterface;
use Training\Seller\Model\ResourceModel\Seller\CollectionFactory;

class Seller extends AbstractSource {

    protected $collectionFactory;

    protected $options;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function getAllOptions()
    {
        return $this->getOptions();
    }

    protected function getOptions() {
        if (is_null($this->options)) {
            $collection = $this->collectionFactory->create();
            $this->options = $collection->setOrder(SellerInterface::FIELD_NAME, $collection::SORT_ORDER_ASC)
                ->load()
                ->toOptionArray();
            array_unshift($this->options, ['value' => 0, 'label' => "---"]);
        }
        return $this->options;
    }

}