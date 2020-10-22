<?php
declare(strict_types=1);

namespace Webinar\RemoteData\Model;

use Magento\Framework\Api\AbstractSimpleObject;
use Webinar\RemoteData\Api\Data\RankInterface;

/**
 * Represents the rank.
 */
class Rank extends AbstractSimpleObject implements RankInterface
{

    /**
     * @return int
     */
    public function getRank(): int
    {
        return (int)$this->_get(self::RANK);
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return (string)$this->_get(self::COMPANY);
    }
}
