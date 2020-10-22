<?php
declare(strict_types=1);

namespace Webinar\RemoteData\Model\Api;

/**
 * Communicates with the API
 */
class Client implements RankRetrieverInterface
{
    /**
     * @var Server
     */
    private $server;

    /**
     * Client constructor.
     *
     * @param Server $server
     */
    public function __construct(
        Server $server
    ) {
        $this->server = $server;
    }

    /**
     * @return array[]
     */
    public function retrieveRank(): array
    {
        return $this->server->getRank();
    }
}
