<?php
declare(strict_types=1);

namespace Webinar\ProductCounter\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Webinar\ProductCounter\Model\ResourceModel\Counter as CounterResource;

class Counter implements ArgumentInterface
{
    /**
     * @var CounterResource
     */
    private $counterResource;

    /**
     * Counter constructor.
     *
     * @param CounterResource $counterResource
     */
    public function __construct(
        CounterResource $counterResource
    ) {
        $this->counterResource = $counterResource;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->counterResource->count();
    }
}
