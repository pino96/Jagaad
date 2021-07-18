<?php

namespace Jagaad\BackendTest\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\InventoryApi\Api\SourceItemsSaveInterface;
use Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory;
use Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Jagaad\BackendTest\Model\WmsFactory;

class Sync extends Action
{

    const STATUS_MESSAGE_OK = 'The product qty was updated';
    const STATUS_MESSAGE_KO = 'Ops! There was an error during the process';

    /**
     * @var SourceItemsSaveInterface
     */
    private $sourceItemsSaveInterface;
    /**
     * @var SourceItemInterfaceFactory
     */
    private $sourceItemFactory;
    /**
     * @var DefaultSourceProviderInterface
     */
    private $defaultSourceProvider;
    /**
     * @var Context
     */
    private $context;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var WmsFactory
     */
    private $wmsFactory;


    public function __construct(
        WmsFactory $wmsFactory,
        ProductRepositoryInterface $productRepository,
        SourceItemsSaveInterface $sourceItemsSaveInterface,
        SourceItemInterfaceFactory $sourceItemFactory,
        DefaultSourceProviderInterface $defaultSourceProvider,
        Context $context
    ) {
        parent::__construct($context);
        $this->sourceItemsSaveInterface = $sourceItemsSaveInterface;
        $this->sourceItemFactory = $sourceItemFactory;
        $this->defaultSourceProvider = $defaultSourceProvider;
        $this->context = $context;
        $this->productRepository = $productRepository;
        $this->wmsFactory = $wmsFactory;
    }

    public function execute()
    {
        $wms = $this->wmsFactory->create();
        try {
            $productId = $this->getRequest()->getParam('id', false);
            $product = $this->productRepository->getById($productId);
            $random = rand(0,100);
            if ($random >= 90) {
                throw new \Exception(__(self::STATUS_MESSAGE_KO));
            }
            if (!$product) {
                throw new NoSuchEntityException(__('The requested entity does not exist.'));
            }

            // Set product qty
            /** @var \Magento\InventoryApi\Api\Data\SourceItemInterface $sourceItem */
            $sourceItem = $this->sourceItemFactory->create();
            $sourceItem->setSourceCode($this->defaultSourceProvider->getCode());
            $sourceItem->setSku($product->getSku());
            $sourceItem->setQuantity($random);
            $sourceItem->setStatus($random?1:0);

            $this->sourceItemsSaveInterface->execute([$sourceItem]);

            // record response on jagaad_wms_history table
            $wms->setSku($product->getSku())
                ->setStatus(1)
                ->setMessage(self::STATUS_MESSAGE_OK)
                ->setQty($random)
                ->save();

            $this->messageManager->addSuccessMessage(__(self::STATUS_MESSAGE_OK));
        } catch (\Exception $e) {
            $wms->setSku($product->getSku())
                ->setStatus(0)
                ->setMessage(self::STATUS_MESSAGE_KO)
                ->setQty($random)
                ->save();
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $this->_redirect('catalog/product/');
    }
}
