<?php

namespace App\Filament\Resources\MortalityResource\Pages;

use App\Filament\Resources\MortalityResource;
use App\Models\Member;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;

class ManageMortalities extends ManageRecords
{
    protected static string $resource = MortalityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function (array $data, string $model): Model {
                    $member = Member::find($data["member"]);
                    $member->status = Member::STATUS_NONACTIVE;
                    $member->save();

                    return $model::create($data);
                }),
        ];
    }

}
