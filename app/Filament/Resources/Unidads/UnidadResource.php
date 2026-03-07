<?php

namespace App\Filament\Resources\Unidads;

use App\Filament\Resources\Unidads\Pages\CreateUnidad;
use App\Filament\Resources\Unidads\Pages\EditUnidad;
use App\Filament\Resources\Unidads\Pages\ListUnidads;
use App\Filament\Resources\Unidads\Pages\ViewUnidad;
use App\Filament\Resources\Unidads\Schemas\UnidadForm;
use App\Filament\Resources\Unidads\Schemas\UnidadInfolist;
use App\Filament\Resources\Unidads\Tables\UnidadsTable;
use App\Models\Unidad;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UnidadResource extends Resource
{
    protected static ?string $model = Unidad::class;
    protected static ?string $pluralModelLabel  = 'Unidades';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return UnidadForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UnidadInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnidadsTable::configure($table);
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
            'index' => ListUnidads::route('/'),
            'create' => CreateUnidad::route('/create'),
            'view' => ViewUnidad::route('/{record}'),
            'edit' => EditUnidad::route('/{record}/edit'),
        ];
    }
}
