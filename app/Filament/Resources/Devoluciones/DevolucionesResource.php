<?php

namespace App\Filament\Resources\Devoluciones;

use App\Filament\Resources\Devoluciones\Pages\CreateDevolucion;
use App\Filament\Resources\Devoluciones\Pages\EditDevolucion;
use App\Filament\Resources\Devoluciones\Pages\ListDevoluciones;
use App\Filament\Resources\Devoluciones\Pages\ViewDevolucion;
use App\Filament\Resources\Devoluciones\Schemas\DevolucionForm;
use App\Filament\Resources\Devoluciones\Schemas\DevolucionInfolist;
use App\Filament\Resources\Devoluciones\Tables\DevolucionesTable;
use App\Models\Resguardo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DevolucionesResource extends Resource
{
    protected static ?string $model = Resguardo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBoxArrowDown;

    protected static ?string $recordTitleAttribute = 'folio_formateado';
    protected static ?string $pluralModelLabel = 'Devoluciones';
    protected static ?string $singular = 'Devolución';
    protected static ?string $modelLabel = 'Devolución de Activos';
    protected static string | UnitEnum | null $navigationGroup = 'Movimientos';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return DevolucionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DevolucionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DevolucionesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ActivosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDevoluciones::route('/'),
            'create' => CreateDevolucion::route('/create'),
            'view' => ViewDevolucion::route('/{record}'),
            'edit' => EditDevolucion::route('/{record}/edit'),
        ];
    }
}
