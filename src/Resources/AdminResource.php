<?php

namespace Fajar\Filament\Suitcms\Resources;

use Fajar\Filament\Suitcms\Models\Admin;
use Fajar\Filament\Suitcms\Resources\AdminResource\Pages\CreateAdmin;
use Fajar\Filament\Suitcms\Resources\AdminResource\Pages\EditAdmin;
use Fajar\Filament\Suitcms\Resources\AdminResource\Pages\ListAdmins;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'CMS User';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->disabled(fn (string $context): bool => $context === 'edit')
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->visible(fn (string $context): bool => $context === 'create')
                    ->confirmed()
                    ->password()
                    ->dehydrated(fn ($state) => filled($state)) //don't want to overwrite the existing password if the field is empty
                    ->required(fn (string $context): bool => $context === 'create') //require only on create
                    ->maxLength(255),
                Forms\Components\TextInput::make('password_confirmation')
                    ->visible(fn (string $context): bool => $context === 'create')
                    ->password()
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->required()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->multiple()
                    ->maxItems(1)
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name'),
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
            'index' => ListAdmins::route('/'),
            'create' => CreateAdmin::route('/create'),
            'edit' => EditAdmin::route('/{record}/edit'),
        ];
    }
}
