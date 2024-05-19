<?php

namespace App\Filament\Resources\ChurchGroupResource\RelationManagers;

use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make([
                    'sm' => 1,
                    'md' => 12,
                    'lg' => 12,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Section::make()
                                    ->columns([
                                        'sm' => 1,
                                        'md' => 12,
                                        'lg' => 12,
                                        'xl' => 12,
                                        '2xl' => 12,
                                    ])
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                        Forms\Components\Radio::make('gender')
                                            ->required()
                                            ->inline()
                                            ->options([
                                                "M" => "Male",
                                                "F" => "Female"
                                            ])
                                            ->columnSpan([
                                                'sm' => 1,
                                                'md' => 6,
                                                'lg' => 6,
                                                'xl' => 6,
                                                '2xl' => 4,
                                            ]),
                                    ]),

                                Forms\Components\Section::make()
                                    ->columns(['lg' => 2, 'xl' => 2, '2xl' => 2])
                                    ->schema([
                                        Forms\Components\DatePicker::make('birth_date'),
                                        Forms\Components\TextInput::make('birth_place')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('blood_group')
                                            ->maxLength(3),
                                    ]),

                                Forms\Components\Section::make()
                                    ->columns(['lg' => 2, 'xl' => 2, '2xl' => 2])
                                    ->schema([
                                        Forms\Components\TextInput::make('address')
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('telp')
                                            ->tel()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->maxLength(255),
                                    ])
                            ])
                            ->columnSpan(['sm' => 1, "md" => 7, "lg" => 7, "xl" => 4, '2xl' => 6]),

                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\Select::make('family')
                                            ->relationship(titleAttribute: 'name'),
                                        Forms\Components\Select::make('churchGroups')
                                            ->multiple()
                                            ->relationship(titleAttribute: 'name'),
                                    ]),
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\Select::make('marital_status')
                                            ->options([
                                                'S' => 'Single',
                                                'M' => 'Married',
                                                'J' => 'Widdow',
                                                'D' => 'Widdower'
                                            ]),
                                        Forms\Components\Select::make('status')
                                            ->required()
                                            ->options(Member::ARR_STATUS),
                                    ])
                            ])
                            ->columnSpan(['sm' => 1, "md" => 5, "lg" => 5, "xl" => 2, '2xl' => 2]),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('name', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->badge()
                    ->formatStateUsing(function (string $state) {
                        return Member::ARR_GENDER_TYPE[$state] ?? ' - ';
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'M' => 'info',
                        'F' => 'danger',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->suffix(' years'),
            ])
            ->filters([
                //
            ])
            ->headerActions([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
