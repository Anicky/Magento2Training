<?php
/**
 * Magento 2 Training Project
 * Module Training/Helloworld
 */
namespace Training\Helloworld\Controller\Product;
use Magento\Framework\App\Action\Context;
use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

/**
 * Action: Index/Index
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Categories extends \Magento\Framework\App\Action\Action
{

    protected $productCollectionFactory;

    protected $categoryCollectionFactory;

    public function __construct(
        Context $context,
        ProductCollectionFactory $productCollectionFactory,
        CategoryCollectionFactory $categoryCollectionFactory
    )
    {
        parent::__construct($context);
        $this->productCollectionFactory = $productCollectionFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * Execute the action
     *
     * @return void
     */
    public function execute()
    {
        $categoryIds = [];
        $products = $this->getProductsWhereNameContains("bag");
        foreach($products as $product) {
            $categoryIds = array_merge($categoryIds, $product->getCategoryIds());
        }
        $categoryIds = array_unique($categoryIds);
        $categories = $this->getCategoriesInIds($categoryIds);
        $html = "<ul>";
        foreach($products->getItems() as $product) {
            $html .= "<li>";
            $html .= $product->getName();
            $html .= "<ul>";
            foreach($product->getCategoryIds() as $categoryId) {
                $html .= "<li>";
                $html .= $categories->getItemById($categoryId)->getName();
                $html .= "</li>";
            }
            $html .= "</ul>";
            $html .= "</li>";
        }
        $html .= "</ul>";
        $this->getResponse()->appendBody($html);
    }

    protected function getProductsWhereNameContains($name) {
        return $this->productCollectionFactory
            ->create()
            ->addAttributeToFilter("name", ["like" => "%" . $name ."%"])
            ->addCategoryIds()
            ->load();
    }

    protected function getCategoriesInIds(array $ids) {
        return $this->categoryCollectionFactory
            ->create()
            ->addAttributeToFilter("entity_id", ["in" => $ids])
            ->addAttributeToSelect("name")
            ->load();
    }

}
