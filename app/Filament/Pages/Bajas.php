<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
class Bajas extends Page
{
    protected string $view = 'filament.pages.bajas';
    protected static string | UnitEnum | null $navigationGroup = 'Movimientos';
    protected static ?int $navigationSort = 3;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBoxXMark;
    
}
