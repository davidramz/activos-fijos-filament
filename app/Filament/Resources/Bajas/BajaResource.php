<?php

namespace App\Filament\Resources\Bajas;

use App\Filament\Resources\Bajas\Pages\CreateBaja;
use App\Filament\Resources\Bajas\Pages\EditBaja;
use App\Filament\Resources\Bajas\Pages\ListBajas;
use App\Filament\Resources\Bajas\Pages\ViewBaja;
use App\Filament\Resources\Bajas\Schemas\BajaForm;
use App\Filament\Resources\Bajas\Schemas\BajaInfolist;
use App\Filament\Resources\Bajas\Tables\BajasTable;
use App\Models\Baja;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BajaResource extends Resource
{
    protected static ?string $model = Baja::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static ?string $recordTitleAttribute = 'folio_formateado';
    protected static ?string $pluralModelLabel = 'Bajas';
    protected static ?string $singular = 'Baja';
    protected static string | UnitEnum | null $navigationGroup = 'Movimientos';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return BajaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BajaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BajasTable::configure($table);
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
            'index' => ListBajas::route('/'),
            'create' => CreateBaja::route('/create'),
            'view' => ViewBaja::route('/{record}'),
            'edit' => EditBaja::route('/{record}/edit'),
        ];
    }
}
