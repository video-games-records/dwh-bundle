<?php

namespace VideoGamesRecords\DwhBundle\Manager;

use VideoGamesRecords\DwhBundle\Contracts\Strategy\TableStrategyInterface;

class TableManager
{
    /** @var TableStrategyInterface[] */
    private array $strategies = [];


    public function getStrategy(string $name): TableStrategyInterface
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($name)) {
                return $strategy;
            }
        }

        throw new \DomainException(sprintf('Unable to find a strategy to type [%s]', $name));
    }

    /**
     * @param TableStrategyInterface $strategy
     */
    public function addStrategy(TableStrategyInterface $strategy): void
    {
        $this->strategies[] = $strategy;
    }
}
