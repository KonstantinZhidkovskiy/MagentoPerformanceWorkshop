<?php

namespace Webinar\RemoteData\Model\Api;

interface RankRetrieverInterface
{
    /**
     * @return array[]
     */
    public function retrieveRank(): array;
}
