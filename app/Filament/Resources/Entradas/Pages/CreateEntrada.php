<?php

namespace App\Filament\Resources\Entradas\Pages;

use App\Filament\Resources\Entradas\EntradaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateEntrada extends CreateRecord
{
    protected static string $resource = EntradaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }
}
