<?php

namespace App\Filament\Resources\Areas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;


class AreaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del área')
                    ->required()
                    ->afterStateUpdated(function ($state, $set) {
                        $set('nombre', preg_replace('/\s+/', ' ', trim($state)));
                    })
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Esta área ya se encuentra registrada.',
                    ])
            ]);
    }
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data['nombre'] = mb_strtolower(trim($data['nombre']));
    //     return $data;
    // }
}
