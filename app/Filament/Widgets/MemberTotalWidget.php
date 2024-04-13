<?php

namespace App\Filament\Widgets;

use App\Actions\Members\CountMemberGroupActions;
use App\Models\Family;
use App\Models\Member;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MemberTotalWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalMember = Member::query()
            ->where("status", Member::STATUS_ACTIVE)
            ->count();

        $totalFamily = Family::query()->count();

        return [
            Stat::make("Total Member", $totalMember)
                ->icon('heroicon-o-user')
                ->description("All active member")
                ->color("success"),
            Stat::make("Total Family", $totalFamily)
                ->icon('heroicon-o-home')
                ->description("All Family of the Church")
                ->color("success")
        ];
    }

    protected function getColumns(): int
    {
        return 2;
    }
}
