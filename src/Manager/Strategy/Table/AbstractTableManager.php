<?php
namespace VideoGamesRecords\DwhBundle\Manager\Strategy\Table;

use Doctrine\ORM\EntityManager;
use VideoGamesRecords\DwhBundle\Contracts\DataProvider\CoreProviderInterface;
use VideoGamesRecords\DwhBundle\Contracts\DwhInterface;


abstract class AbstractTableManager implements DwhInterface
{
    protected EntityManager $em;
    protected CoreProviderInterface $provider;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function setProvider(CoreProviderInterface $provider): void
    {
        $this->provider = $provider;
    }
}