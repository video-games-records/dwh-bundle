<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Scheduler\Message;

class UpdateTable
{
    private string $target = '';

    private string $function = 'process';

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
