<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Scheduler;

use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use VideoGamesRecords\DwhBundle\Scheduler\Message\UpdateTable;

#[AsSchedule]
class InsertPlayerDataProvider implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        $message = new UpdateTable();
        $message->setTarget('player');

        return $this->schedule ??= (new Schedule())
            ->with(
                RecurringMessage::cron(
                    '5 0 * * *',
                    $message
                )
            );
    }
}
