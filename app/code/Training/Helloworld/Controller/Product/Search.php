<?php
/**
 * Magento 2 Training Project
 * Module Training/Helloworld
 */
namespace Training\Helloworld\Controller\Product;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;

class Search extends \Magento\Framework\App\Action\Action
{

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepositoryInterface;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * Search constructor.
     * @param Context $context
     * @param ProductRepositoryInterface $productRepositoryInterface
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepositoryInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        SortOrderBuilder $sortOrderBuilder
    )
    {
        parent::__construct($context);
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * Execute the action
     *
     * @return void
     */
    public function execute()
    {
        $this->getResponse()->appendBody($this->displayProducts($this->getProducts()));
    }

    protected function displayProducts($products) {
        $html = "<ul>";
        foreach($products as $product) {
            $html .= "<li>" . $product->getName() . "</li>";
        }
        $html .= "<ul>";
        return $html;
    }

    protected function getProducts() {
        return $this->productRepositoryInterface->getList(
            $this->searchCriteriaBuilder
            ->addFilter("description", "%comfortable%", "like")
            ->addFilter("name", "%bruno%", "like")
            ->addSortOrder($this->sortOrderBuilder->setField("name")->setDescendingDirection()->create())
            ->setPageSize(6)
            ->setCurrentPage(1)
            ->create()
        )->getItems();
    }
}
