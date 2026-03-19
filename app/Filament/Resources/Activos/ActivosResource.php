<?php

namespace App\Filament\Resources\Activos;

use App\Filament\Resources\Activos\Pages\EditActivo;
use App\Filament\Resources\Activos\Pages\ListActivos;
use App\Filament\Resources\Activos\Pages\ViewActivo;
use App\Filament\Resources\Activos\Schemas\ActivoForm;
use App\Filament\Resources\Activos\Schemas\ActivoInfolist;
use App\Filament\Resources\Activos\Tables\ActivosTable;
use App\Models\Activo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ActivosResource extends Resource
{
    protected static ?string $model = Activo::class;
    protected static ?string $pluralModelLabel = 'Activos';
    protected static ?string $modelLabel = 'Activo';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static ?string $recordTitleAttribute = 'numero_inventario';

    public static function form(Schema $schema): Schema
    {
        return ActivoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ActivoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivosTable::configure($table);
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
            'index' => ListActivos::route('/'),
            'view' => ViewActivo::route('/{record}'),
            'edit' => EditActivo::route('/{record}/edit'),
        ];
    }
}
