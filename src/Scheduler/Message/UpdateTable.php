<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Scheduler\Message;

class UpdateTable
{
    private string $target;

    private string $function;

    public function __construct(string $target, string $function = 'process')
    {
        $this->target = $target;
        $this->function = $function;
    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function setTarget(string $target): void
    {
        $this->target = $target;
    }

    public function getFunction(): string
    {
        return $this->function;
    }

    public function setFunction(string $function): void
    {
        $this->function = $function;
    }
}
