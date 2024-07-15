<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\DataProvider;

use DomainException;
use VideoGamesRecords\DwhBundle\Contracts\Strategy\CoreStrategyInterface;

class CoreProvider
{
    /** @var CoreStrategyInterface[] */
    private array $strategies = [];


    public function getStrategy(string $name): CoreStrategyInterface
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($name)) {
                return $strategy;
            }
        }

        throw new DomainException(sprintf('Unable to find a strategy to type [%s]', $name));
    }

    /**
     * @param CoreStrategyInterface $strategy
     */
    public function addStrategy(CoreStrategyInterface $strategy): void
    {
        $this->strategies[] = $strategy;
    }
}
