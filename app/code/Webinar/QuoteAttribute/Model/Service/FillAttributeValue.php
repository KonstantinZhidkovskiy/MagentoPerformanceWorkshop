<?php
declare(strict_types=1);

namespace Webinar\QuoteAttribute\Model\Service;

use Exception;
use Faker\Factory;
use Magento\Catalog\Model\ResourceModel\Product\Action;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\DB\Query\Generator;
use Magento\Framework\DB\Select;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\Store;
use Webinar\QuoteAttribute\Model\Product\Attribute\QuoteAttribute;

class FillAttributeValue
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var Action
     */
    private $productAction;

    /**
     * FillAttributeValue constructor.
     *
     * @param CollectionFactory $collectionFactory
     * @param Generator         $generator
     * @param Action            $productAction
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Generator $generator,
        Action $productAction
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->generator = $generator;
        $this->productAction = $productAction;
    }

    /**
     * @throws LocalizedException
     */
    public function execute(): void
    {
        $collection = $this->collectionFactory->create();
        $collection->setOrder('entity_id', Select::SQL_ASC);

        try {
            $iterator = $this->generator->generate('entity_id', $collection->getSelect(), 100);
        } catch (LocalizedException $e) {
            throw new LocalizedException(__('Unable to fill values: %1', $e->getMessage()), $e);
        }

        $faker = Factory::create();
        $connection = $collection->getConnection();

        while ($iterator->valid()) {
            $select = $iterator->current();
            $ids = $connection->fetchCol($select);
            try {
                $connection->beginTransaction();
                foreach ($ids as $id) {
                    $this->productAction->updateAttributes(
                        [$id],
                        [
                            QuoteAttribute::CODE => $faker->company
                        ],
                        Store::DEFAULT_STORE_ID
                    );
                }
                $connection->commit();
            } catch (Exception $exception) {
                $connection->rollBack();
            }
            $iterator->next();
        }
    }
}
