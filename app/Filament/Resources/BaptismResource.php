<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BaptismResource\Pages;
use App\Models\Baptism;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BaptismResource extends Resource
{
    protected static ?string $model = Baptism::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = "Church Member";

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('member_id')
                            ->live()
                            ->searchable()
                            ->relationship(name: 'member', titleAttribute: 'name')
                            ->afterStateUpdated(function (Set $set, ?int $state) {
                                $member = Member::find($state);

                                if (!$member) {
                                    return;
                                }

                                $set('member', $member->id);
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
                                Forms\Components\DatePicker::make('baptism_date')
                                    ->date()
                                    ->required(),
                                Forms\Components\TextInput::make('baptism_place')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('baptised_by')
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
                Tables\Columns\TextColumn::make('baptised_by')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('baptism_place')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('baptism_date')
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
            'index' => Pages\ManageBaptisms::route('/'),
        ];
    }
}
