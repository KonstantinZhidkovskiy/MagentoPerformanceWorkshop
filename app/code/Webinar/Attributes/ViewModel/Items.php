<?php
declare(strict_types=1);

namespace Webinar\Attributes\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

class Items implements ArgumentInterface
{

    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

    /**
     * Items constructor.
     * @param ProductCollectionFactory $productCollectionFactory
     */
    public function __construct(
        ProductCollectionFactory $productCollectionFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * @return ProductCollection
     */
    public function getItems()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->setPageSize(100)
            ->setCurPage(1);
        return $collection;
    }
}
