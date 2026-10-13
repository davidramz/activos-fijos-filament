<?php

namespace App\Filament\Exports;

use App\Models\Entrada;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EntradaExporter extends Exporter
{
    protected static ?string $model = Entrada::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('consecutivo')
                ->label('Consecutivo'),
            ExportColumn::make('factura')
                ->label('Factura'),
            ExportColumn::make('proveedor.nombre')
                ->label('Proveedor'),
            ExportColumn::make('proveedor.rfc')
                ->label('RFC del proveedor'),
            ExportColumn::make('requisicion')
                ->label('Requisición'),
            ExportColumn::make('tipoCompra.nombre')
                ->label('Tipo de compra'),
            ExportColumn::make('iva')
                ->label('Con IVA')
                ->formatStateUsing(fn ($state): string => $state ? 'Sí' : 'No'),
            ExportColumn::make('isr')
                ->label('Retiene ISR')
                ->formatStateUsing(fn ($state): string => $state ? 'Sí' : 'No'),
            ExportColumn::make('fecha_factura')
                ->label('Fecha de factura'),
            ExportColumn::make('created_at')
                ->label('Fecha de entrada'),
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

        return "La exportación de {$count} entradas se completó correctamente.";
    }
}
