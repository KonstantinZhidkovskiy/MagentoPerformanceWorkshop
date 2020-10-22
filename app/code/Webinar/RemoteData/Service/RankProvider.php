<?php
declare(strict_types=1);

namespace Webinar\RemoteData\Service;

use Webinar\RemoteData\Api\Data\RankInterface;
use Webinar\RemoteData\Api\RankProviderInterface;
use Webinar\RemoteData\Model\Api\RankRetrieverInterface;
use Webinar\RemoteData\Model\RankFactory;

/**
 * Provides the ranking of companies.
 */
class RankProvider implements RankProviderInterface
{
    /**
     * @var RankRetrieverInterface
     */
    private $rankRetriever;

    /**
     * @var RankFactory
     */
    private $rankFactory;

    /**
     * RankProvider constructor.
     *
     * @param RankRetrieverInterface $rankRetriever
     * @param RankFactory            $rankFactory
     */
    public function __construct(
        RankRetrieverInterface $rankRetriever,
        RankFactory $rankFactory
    ) {
        $this->rankRetriever = $rankRetriever;
        $this->rankFactory = $rankFactory;
    }

    /**
     * @return RankInterface[]
     */
    public function getRank(): array
    {
        $data = $this->rankRetriever->retrieveRank();

        $result = [];
        foreach ($data as $datum) {
            $result[] = $this->rankFactory->create(['data' => $datum]);
        }

        return $result;
    }
}
