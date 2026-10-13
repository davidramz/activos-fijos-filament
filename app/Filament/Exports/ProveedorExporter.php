<?php

namespace App\Filament\Exports;

use App\Models\Proveedor;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProveedorExporter extends Exporter
{
    protected static ?string $model = Proveedor::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('codigo')
                ->label('Código'),
            ExportColumn::make('nombre')
                ->label('Nombre'),
            ExportColumn::make('rfc')
                ->label('RFC'),
            ExportColumn::make('calle')
                ->label('Calle'),
            ExportColumn::make('colonia')
                ->label('Colonia'),
            ExportColumn::make('cp')
                ->label('Código postal'),
            ExportColumn::make('ciudad')
                ->label('Ciudad'),
            ExportColumn::make('estado')
                ->label('Estado'),
            ExportColumn::make('telefono')
                ->label('Teléfono'),
            ExportColumn::make('giro')
                ->label('Giro'),
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

        return "La exportación de {$count} proveedores se completó correctamente.";
    }
}
