<?php

namespace App\Filament\Resources\ChurchGroupResource\Pages;

use App\Filament\Resources\ChurchGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewChurchGroup extends ViewRecord
{
    protected static string $resource = ChurchGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
