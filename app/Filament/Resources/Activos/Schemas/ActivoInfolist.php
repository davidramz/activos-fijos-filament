<?php

namespace App\Filament\Resources\Activos\Schemas;

use App\Filament\Resources\Bajas\BajaResource;
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
            ->columns(5)
            ->components([
                
                TextEntry::make('material.codigo')
                    ->label('Código')
                    ->columnSpan(1),

                TextEntry::make('material.nombre')
                    ->label('Material')
                    ->columnSpan(4),
                    
                TextEntry::make('numero_inventario')
                    ->label('Inventario'),

                TextEntry::make('numero_serie')
                    ->label('Serie'),
                TextEntry::make('material.marca')
                    ->label('Marca'),

                TextEntry::make('material.modelo')
                    ->label('Modelo'),                

                TextEntry::make('costo')
                    ->label('Costo')
                    ->money('MXN', locale: 'es_MX'),

                TextEntry::make('entrada.consecutivo')
                    ->label('Consecutivo'),

                TextEntry::make('garantia')
                    ->label('Garantía')
                    ->dateTime('d/m/Y'),               

                TextEntry::make('entrada.factura')
                    ->label('Factura'),

                TextEntry::make('created_at')
                    ->label('Fecha Factura')
                    ->dateTime('d/m/Y H:i'),
                
                TextEntry::make('status.nombre')
                    ->label('Estado')
                    ->badge()
                    ->url(function (Activo $record): ?string {
                        if ((int) $record->status_id !== 1) {
                            return null;
                        }

                        $baja = $record->bajas()->latest('bajas.created_at')->first();

                        return $baja
                            ? BajaResource::getUrl('view', ['record' => $baja])
                            : null;
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'ALMACEN' => 'almacen',
                        'RESGUARDADO' => 'success',
                        'BAJA' => 'baja',
                        'DEV.PROVEEDOR' => 'dev_proveedor',
                        'SUCEPTIBLE' => 'suceptible',
                        'CANCELADO' => 'danger',
                        'REPARACION' => 'warning',
                        default => 'gray',
                    }),

                TextEntry::make('empleadoActual.nombre')
                    ->label('Asignado a')
                    ->columnSpanFull(),

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
