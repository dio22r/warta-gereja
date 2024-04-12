<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MortalityResource\Pages;
use App\Filament\Resources\MortalityResource\RelationManagers;
use App\Models\Member;
use App\Models\Mortality;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MortalityResource extends Resource
{
    protected static ?string $model = Mortality::class;

    protected static ?string $navigationIcon = 'heroicon-o-x-circle';

    protected static ?string $navigationGroup = "Church Member";

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('member')
                            ->label('Member')
                            ->live()
                            ->relationship(titleAttribute: 'name')
                            ->afterStateUpdated(function(Set $set, ?int $state) {
                                $member = Member::find($state);

                                if (!$member) {
                                    return;
                                }

                                // $set('member_id', $member->id);
                                $set('name', $member->name);
                                $set('birth_date', $member->birth_date);
                            }),
                        Grid::make()
                            ->columns([
                                "sm" => 2
                            ])
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('birth_date')
                                    ->date()
                                    ->required(),
                            ])

                    ]),
                Forms\Components\Section::make()
                    ->schema([
                        Grid::make()
                            ->columns([
                                "sm" => 2
                            ])
                            ->schema([
                                Forms\Components\DatePicker::make('mortality_date')
                                    ->date()
                                    ->required(),
                                Forms\Components\TextInput::make('mortality_place')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Forms\Components\RichEditor::make('description')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('mortality_place')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('mortality_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMortalities::route('/'),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        dd($data);
        return static::getModel()::create($data);
    }
}
