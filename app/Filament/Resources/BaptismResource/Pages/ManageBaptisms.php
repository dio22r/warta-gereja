<?php

namespace App\Filament\Resources\BaptismResource\Pages;

use App\Filament\Resources\BaptismResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBaptisms extends ManageRecords
{
    protected static string $resource = BaptismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
