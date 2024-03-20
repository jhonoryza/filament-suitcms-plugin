<?php

namespace Fajar\Filament\Suitcms\Resources;

use App\Models\SeoMeta;
use Fajar\Filament\Suitcms\Resources\SeoMetaResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeoMetaResource extends Resource
{
    protected static ?string $model = SeoMeta::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-americas';

    protected static ?string $navigationGroup = 'Website';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('locale')
                    ->options([
                        'id' => 'Indonesia',
                        'en' => 'English',
                    ])
                    ->required(),
                Forms\Components\Select::make('open_graph_type')
                    ->options([
                        'article' => 'Article',
                        'website' => 'Website',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('seo_url')
                    ->nullable()
                    ->url()
                    ->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\TextInput::make('seo_title')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(60),
                Forms\Components\TextInput::make('seo_description')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(160),
                Forms\Components\Textarea::make('seo_content')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('seo_image')
                    ->collection(SeoMeta::IMAGE_COL),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('attachable_type')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('attachable_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('locale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('seo_url')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('seo_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('seo_description')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('open_graph_type')
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
            'index' => Pages\ListSeoMetas::route('/'),
            'create' => Pages\CreateSeoMeta::route('/create'),
            'edit' => Pages\EditSeoMeta::route('/{record}/edit'),
        ];
    }
}
