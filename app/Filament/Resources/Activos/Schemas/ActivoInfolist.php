<?php

namespace App\Filament\Resources\Activos\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\ViewEntry;
use Filament\Actions\Action;
use App\Models\Activo;

class ActivoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                TextEntry::make('material.nombre')
                    ->label('Material')
                    ->columnSpanFull(),
                TextEntry::make('numero_inventario')
                    ->label('Número de Inventario'),

                TextEntry::make('numero_serie')
                    ->label('Número de Serie'),
                TextEntry::make('material.marca')
                    ->label('Marca'),

                TextEntry::make('material.modelo')
                    ->label('Modelo'),

                TextEntry::make('material.codigo')
                    ->label('Código del Material'),

                TextEntry::make('costo')
                    ->label('Costo')
                    ->money('MXN'),

                TextEntry::make('garantia')
                    ->label('Garantía')
                    ->dateTime('d/m/Y'),

                TextEntry::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'RESGUARDADO' => 'success',
                        'En uso' => 'info',
                        'Dañado' => 'danger',
                        'Fuera de servicio' => 'warning',
                        default => 'gray',
                    }),

                TextEntry::make('empleadoActual.nombre')
                    ->label('Asignado a'),

                TextEntry::make('entrada.folio')
                    ->label('Entrada (Folio)'),

                TextEntry::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i'),

                TextEntry::make('detalles')
                    ->label('Detalles')
                    ->columnSpanFull(),

                ViewEntry::make('imagenes')
                    ->label('Imágenes')
                    ->columnSpanFull()
                    ->view('filament.infolists.components.image-gallery', [
                        // Images will be passed via the record
                    ]),
                // Action::make('imagenes')
                //     ->label('Ver imágenes')
                //     ->action(fn() => null) // opcional
                //     ->modalContent(function (Activo $record) {
                //         return view('filament.infolists.components.galeria-lightbox', [
                //             'img' => collect($record->imagenes ?? [])
                //                 ->map(fn($path) => [
                //                     'url' => asset('storage/' . $path),
                //                     'thumbnailUrl' => asset('storage/' . $path),
                //                 ])
                //                 ->values()
                //                 ->toArray(),
                //         ]);
                //     })
                //     ->modalCancelAction(fn(Action $action) => $action->label('Cerrar'))
                //     ->modalSubmitAction(false),
            ]);
    }
}
