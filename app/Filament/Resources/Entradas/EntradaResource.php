<?php

namespace App\Filament\Resources\Entradas;

use App\Filament\Resources\Entradas\Pages\CreateEntrada;
use App\Filament\Resources\Entradas\Pages\EditEntrada;
use App\Filament\Resources\Entradas\Pages\ListEntradas;
use App\Filament\Resources\Entradas\Pages\ViewEntrada;
use App\Filament\Resources\Entradas\RelationManagers\ActivosRelationManager;
use App\Filament\Resources\Entradas\Schemas\EntradaForm;
use App\Filament\Resources\Entradas\Schemas\EntradaInfolist;
use App\Filament\Resources\Entradas\Tables\EntradasTable;
use App\Models\Entrada;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EntradaResource extends Resource
{
    protected static ?string $model = Entrada::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    protected static ?string $pluralModelLabel = 'Entradas';
    protected static ?string $recordTitleAttribute = 'folio';

    public static function form(Schema $schema): Schema
    {
        return EntradaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EntradaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EntradasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ActivosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEntradas::route('/'),
            'create' => CreateEntrada::route('/create'),
            'view' => ViewEntrada::route('/{record}'),
            'edit' => EditEntrada::route('/{record}/edit'),
        ];
    }
}
