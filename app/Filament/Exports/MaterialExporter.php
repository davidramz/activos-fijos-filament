<?php

namespace App\Filament\Exports;

use App\Models\Material;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class MaterialExporter extends Exporter
{
    protected static ?string $model = Material::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('codigo')
                ->label('Código'),
            ExportColumn::make('nombre')
                ->label('Nombre'),
            ExportColumn::make('partida.codigo')
                ->label('Código de partida'),
            ExportColumn::make('partida.nombre')
                ->label('Partida'),
            ExportColumn::make('unidad.nombre')
                ->label('Unidad'),
            ExportColumn::make('marca')
                ->label('Marca'),
            ExportColumn::make('modelo')
                ->label('Modelo'),
            ExportColumn::make('tipo.nombre')
                ->label('Tipo'),
            ExportColumn::make('created_at')
                ->label('Fecha de creación'),
            ExportColumn::make('updated_at')
                ->label('Última actualización'),
        ];
    }

    public function getJobConnection(): ?string
    {
        return 'sync';
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $count = number_format($export->successful_rows);

        return "La exportación de {$count} materiales se completó correctamente.";
    }
}
