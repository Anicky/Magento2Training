<?php
/**
 * Magento 2 Training Project
 * Module Training/Helloworld
 */
namespace Training\Helloworld\Controller\Product;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Action: Index/Index
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Index extends \Magento\Framework\App\Action\Action
{

    protected $productRepository;

    public function __construct(Context $context, ProductRepository $productRepository)
    {
        parent::__construct($context);
        $this->productRepository = $productRepository;
    }

    /**
     * Execute the action
     *
     * @return void
     */
    public function execute()
    {
        $productId = (int) $this->getRequest()->getParam('id');
        if($productId) {
            try {
                $product = $this->productRepository->getById($productId);
                $this->getResponse()->appendBody("Product : " . $product->getName());
            } catch (NoSuchEntityException $e) {
                $this->_forward('noroute');
            }
        }
    }
}
