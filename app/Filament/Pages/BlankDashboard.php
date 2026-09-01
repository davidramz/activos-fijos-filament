<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class BlankDashboard extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -2;

    protected static string $routePath = '/';

    protected static ?string $navigationLabel = 'Dashboard';

    protected string $view = 'filament.pages.blank-dashboard';

    public function getTitle(): string
    {
        return 'Dashboard';
    }
}
