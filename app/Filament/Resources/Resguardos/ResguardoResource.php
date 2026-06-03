<?php

namespace App\Filament\Resources\Resguardos;

use App\Filament\Resources\Resguardos\Pages\CreateResguardo;
use App\Filament\Resources\Resguardos\Pages\EditResguardo;
use App\Filament\Resources\Resguardos\Pages\ListResguardos;
use App\Filament\Resources\Resguardos\Pages\ViewResguardo;
use App\Filament\Resources\Resguardos\Schemas\ResguardoForm;
use App\Filament\Resources\Resguardos\Schemas\ResguardoInfolist;
use App\Filament\Resources\Resguardos\Tables\ResguardosTable;
use App\Models\Resguardo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ResguardoResource extends Resource
{
    protected static ?string $model = Resguardo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static ?string $recordTitleAttribute = 'folio_formateado';
    protected static ?string $pluralModelLabel = 'Resguardos de Activos';
    protected static ?string $singular = 'Resguardo';
    protected static string | UnitEnum | null $navigationGroup = 'Movimientos';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ResguardoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ResguardoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ResguardosTable::configure($table);
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
            'index' => ListResguardos::route('/'),
            'create' => CreateResguardo::route('/create'),
            'view' => ViewResguardo::route('/{record}'),
            'edit' => EditResguardo::route('/{record}/edit'),
        ];
    }
}
