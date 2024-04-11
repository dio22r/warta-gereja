<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Filament\Resources\MemberResource\RelationManagers;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Church Member";

    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'M' => 'info',
                        'F' => 'danger',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('family.name')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('churchGroups.name')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_place')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('blood_group')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('telp')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('marital_status')
                    ->formatStateUsing(function (string $state) {
                        return Member::ARR_MARITAL_STATUS[$state] ?? ' - ';
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        (string) Member::STATUS_UNAPPROVED => 'gray',
                        (string) Member::STATUS_ACTIVE => 'success',
                        (string) Member::STATUS_NONACTIVE => 'danger'
                    })
                    ->formatStateUsing(function (string $state) {
                        return Member::ARR_STATUS[$state] ?? ' - ';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'view' => Pages\ViewMember::route('/{record}'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
