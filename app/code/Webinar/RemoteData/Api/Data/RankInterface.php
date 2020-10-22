<?php
declare(strict_types=1);

namespace Webinar\RemoteData\Api\Data;

interface RankInterface
{
    /**@+
     * @var string
     */
    const RANK    = 'rank';
    const COMPANY = 'company';
    /**@- */

    /**
     * @return int
     */
    public function getRank(): int;

    /**
     * @return string
     */
    public function getCompany(): string;
}
