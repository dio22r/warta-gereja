<?php

namespace App\Filament\Resources\BaptismResource\Pages;

use App\Filament\Resources\BaptismResource;
use App\Models\Member;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;

class ManageBaptisms extends ManageRecords
{
    protected static string $resource = BaptismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function (array $data, string $model): Model {
                    $member = Member::find($data["member_id"]);
                    $member->is_baptized = true;
                    $member->save();

                    return $model::create($data);
                })
        ];
    }
}
