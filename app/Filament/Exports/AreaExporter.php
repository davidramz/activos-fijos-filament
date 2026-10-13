<?php

namespace App\Filament\Exports;

use App\Models\Area;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AreaExporter extends Exporter
{
    protected static ?string $model = Area::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nombre')
                ->label('Nombre del área'),
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

        return "La exportación de {$count} áreas se completó correctamente.";
    }
}
