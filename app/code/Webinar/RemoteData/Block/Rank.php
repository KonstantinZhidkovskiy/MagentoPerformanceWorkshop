<?php
declare(strict_types=1);

namespace Webinar\RemoteData\Block;

use Magento\Framework\View\Element\Template;
use Webinar\RemoteData\Api\Data\RankInterface;
use Webinar\RemoteData\Api\RankProviderInterface;

/**
 * Manages output of the ranking.
 */
class Rank extends Template
{
    /**
     * @var RankInterface[]|null
     */
    private $rank;

    /**
     * @var RankProviderInterface
     */
    private $rankProvider;

    /**
     * Rank constructor.
     *
     * @param Template\Context      $context
     * @param RankProviderInterface $rankProvider
     * @param mixed[]               $data
     */
    public function __construct(
        Template\Context $context,
        RankProviderInterface $rankProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->rankProvider = $rankProvider;
    }

    /**
     * @return RankInterface[]
     */
    public function getRank(): array
    {
        if ($this->rank === null) {
            $this->rank = $this->rankProvider->getRank();
        }

        return $this->rank;
    }

    protected function _toHtml()
    {
        if (empty($this->getRank())) {
            return '';
        }

        return parent::_toHtml();
    }
}
