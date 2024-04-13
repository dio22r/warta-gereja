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
            $arrStats[] = Stat::make($key, $count)
                ->description("All active member")
                ->color("success");
        }
        return [
            Stat::make("PELNAP", $memberGroup["PELNAP"])
                ->description("All children below 11 Years old")
                ->color("primary"),
            Stat::make("PELRAP", $memberGroup["PELRAP"])
                ->description("All teens between 11 to 17 Years old")
                ->color("primary"),
            Stat::make("PELPAP", $memberGroup["PELPAP"])
                ->description("All youth more than 17 Years old")
                ->color("primary"),
            Stat::make("PELPRIP", $memberGroup["PELPRIP"])
                ->description("All man that married")
                ->color("danger"),
            Stat::make("PELWAP", $memberGroup["PELWAP"])
                ->description("All woman that married")
                ->color("danger")
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
