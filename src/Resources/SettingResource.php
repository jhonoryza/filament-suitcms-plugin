<?php

namespace Fajar\Filament\Suitcms\Resources;

use App\Models\Setting;
use Fajar\Filament\Suitcms\Resources\SettingResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Website';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'text' => 'text',
                        'number' => 'number',
                        'textarea' => 'textarea',
                    ])->columnSpanFull()
                    ->live()
                    ->afterStateUpdated(fn(Select $component) => $component
                        ->getContainer()
                        ->getComponent('dynamicTypeFields')
                        ->getChildComponentContainer()
                        ->fill()
                    ),
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                Grid::make(1)
                    ->schema(fn(Get $get): array => match ($get('type')) {
                        'text' => [
                            Forms\Components\TextInput::make('value')
                                ->maxLength(65535)
                                ->columnSpanFull(),
                        ],
                        'number' => [
                            Forms\Components\TextInput::make('value')
                                ->numeric()
                                ->maxLength(65535)
                                ->columnSpanFull(),
                        ],
                        'textarea' => [
                            Forms\Components\Textarea::make('value')
                                ->maxLength(65535)
                                ->columnSpanFull(),
                        ],
                        default => [],
                    })
                    ->key('dynamicTypeFields'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
