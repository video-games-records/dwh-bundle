<?php

namespace VideoGamesRecords\DwhBundle\DataProvider;

use VideoGamesRecords\DwhBundle\Contracts\Strategy\TopStrategyInterface;

class TopProvider
{
    /** @var TopStrategyInterface[] */
    private array $strategies = [];


    public function getStrategy(string $name): TopStrategyInterface
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($name)) {
                return $strategy;
            }
        }

        throw new \DomainException(sprintf('Unable to find a strategy to type [%s]', $name));
    }

    /**
     * @param TopStrategyInterface $strategy
     */
    public function addStrategy(TopStrategyInterface $strategy): void
    {
        $this->strategies[] = $strategy;
    }
}
