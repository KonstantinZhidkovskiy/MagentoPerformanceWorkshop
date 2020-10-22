<?php

namespace Webinar\ProductCounter\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Counts values according to some fixed criteria
 */
class Counter extends AbstractDb
{
    // phpcs:ignore
    protected function _construct()
    {
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $connection = $this->getConnection();
        //phpcs:ignore
        $sql = "select count(*) as ctmip
                    from catalog_product_entity
                    inner join catalog_product_entity_int cpei on catalog_product_entity.entity_id = cpei.entity_id
                    inner join catalog_product_entity_varchar cpev on catalog_product_entity.entity_id = cpev.entity_id
                    where cpev.value like '%2%';";

        return (int)$connection->fetchOne($sql);
    }
}
