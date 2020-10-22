<?php
declare(strict_types=1);

namespace Webinar\RemoteData\Api;

use Webinar\RemoteData\Api\Data\RankInterface;

interface RankProviderInterface
{
    /**
     * @return RankInterface[]
     */
    public function getRank(): array;
}
