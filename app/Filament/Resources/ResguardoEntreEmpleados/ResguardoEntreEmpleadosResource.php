<?php

namespace App\Filament\Resources\ResguardoEntreEmpleados;

use App\Filament\Resources\ResguardoEntreEmpleados\Pages\CreateResguardoEntreEmpleados;
use App\Filament\Resources\ResguardoEntreEmpleados\Pages\EditResguardoEntreEmpleados;
use App\Filament\Resources\ResguardoEntreEmpleados\Pages\ListResguardoEntreEmpleados;
use App\Filament\Resources\ResguardoEntreEmpleados\Pages\ViewResguardoEntreEmpleados;
use App\Filament\Resources\ResguardoEntreEmpleados\Schemas\ResguardoEntreEmpleadosForm;
use App\Filament\Resources\ResguardoEntreEmpleados\Schemas\ResguardoEntreEmpleadosInfolist;
use App\Filament\Resources\ResguardoEntreEmpleados\Tables\ResguardoEntreEmpleadosTable;
use App\Models\Resguardo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ResguardoEntreEmpleadosResource extends Resource
{
    protected static ?string $model = Resguardo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBoxArrowDown;

    protected static ?string $recordTitleAttribute = 'folio_formateado';
    protected static ?string $pluralModelLabel = 'Resg/Empleados';
    protected static ?string $singular = 'Resg.Entre Empleados';
    protected static ?string $modelLabel = 'Resguardo Entre Empleados';
    protected static string | UnitEnum | null $navigationGroup = 'Movimientos';
    protected static ?int $navigationSort = 2;

    
    public static function form(Schema $schema): Schema
    {
        return ResguardoEntreEmpleadosForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ResguardoEntreEmpleadosInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ResguardoEntreEmpleadosTable::configure($table);
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
            'index' => ListResguardoEntreEmpleados::route('/'),
            'create' => CreateResguardoEntreEmpleados::route('/create'),
            'view' => ViewResguardoEntreEmpleados::route('/{record}'),
            'edit' => EditResguardoEntreEmpleados::route('/{record}/edit'),
        ];
    }
}
