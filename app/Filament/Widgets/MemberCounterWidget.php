<?php

namespace App\Filament\Widgets;

use App\Actions\Members\CountMemberGroupActions;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MemberCounterWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $memberGroup = (new CountMemberGroupActions)->execute();

        $arrStats = [];
        foreach($memberGroup as $key => $count) {
            $arrStats[] = Stat::make($key, $count);
        }
        return $arrStats;
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
