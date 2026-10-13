<?php

namespace App\Filament\Exports;

use App\Models\Partida;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PartidaExporter extends Exporter
{
    protected static ?string $model = Partida::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('tipo.nombre')
                ->label('Tipo'),
            ExportColumn::make('codigo')
                ->label('Código'),
            ExportColumn::make('nombre')
                ->label('Nombre'),
            ExportColumn::make('detalle')
                ->label('Detalle'),
        ];
    }

    public function getJobConnection(): ?string
    {
        return 'sync';
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $count = number_format($export->successful_rows);

        return "La exportación de {$count} partidas se completó correctamente.";
    }
}
