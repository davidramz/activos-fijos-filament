<?php

namespace App\Filament\Exports;

use App\Models\Empleado;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EmpleadoExporter extends Exporter
{
    protected static ?string $model = Empleado::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('numero')
                ->label('Número'),
            ExportColumn::make('nombre')
                ->label('Nombre'),
            ExportColumn::make('puesto.nombre')
                ->label('Puesto'),
            ExportColumn::make('campus.nombre')
                ->label('Campus'),
        ];
    }

    public function getJobConnection(): ?string
    {
        return 'sync';
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $count = number_format($export->successful_rows);

        return "La exportación de {$count} empleados se completó correctamente.";
    }
}
