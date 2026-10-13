<?php

namespace App\Filament\Exports;

use App\Models\Activo;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ActivoExporter extends Exporter
{
    protected static ?string $model = Activo::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('numero_inventario')
                ->label('Inventario'),
            ExportColumn::make('status.nombre')
                ->label('Estado'),
            ExportColumn::make('material.codigo')
                ->label('Código'),
            ExportColumn::make('material.nombre')
                ->label('Material'),
            ExportColumn::make('material.marca')
                ->label('Marca'),
            ExportColumn::make('material.modelo')
                ->label('Modelo'),
            ExportColumn::make('numero_serie')
                ->label('Serie'),
            ExportColumn::make('costo')
                ->label('Costo'),
            ExportColumn::make('garantia')
                ->label('Garantía'),
            ExportColumn::make('empleadoActual.nombre')
                ->label('Asignado a'),
            ExportColumn::make('detalles')
                ->label('Detalles'),
        ];
    }

    public function getJobConnection(): ?string
    {
        return 'sync';
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $count = number_format($export->successful_rows);

        return "La exportación de {$count} activos se completó correctamente.";
    }
}
