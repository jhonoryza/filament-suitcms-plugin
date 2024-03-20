<?php

namespace Fajar\Filament\Suitcms\Resources;

use App\Models\Role;
use Fajar\Filament\Suitcms\Forms\Components\CheckboxPermissionRole;
use Fajar\Filament\Suitcms\Resources\RoleResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup = 'CMS User';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $forms = [
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\Section::make('CMS Permissions')
                ->schema([
                    CheckboxPermissionRole::make('permissions')
                        ->label('')
                        ->relationshipWithGroup(
                            'perm_name',
                            'permissions',
                            'perm_act',
                            function (Builder $query) {
                                $query
                                    ->addSelect([
                                        DB::raw('SUBSTRING_INDEX(name, " ", -1) as perm_name'),
                                        DB::raw('SUBSTRING_INDEX(name, " ", 1) as perm_act'),
                                    ])
                                    ->where('guard_name', 'cms');
                            })
                        ->bulkToggleable()
                        ->gridDirection('row'),
                ]),
        ];

        return $form
            ->columns(1)
            ->schema($forms);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                // Tables\Columns\TextColumn::make('guard_name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('{record}/edit'),
        ];
    }
}
