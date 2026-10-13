<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Pages\BlankDashboard;
use App\Filament\Pages\Auth\Login;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Enums\Width;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Navigation\NavigationGroup;
use Filament\Support\Icons\Heroicon;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/')
            ->globalSearch(false)
            ->databaseNotifications()
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login(Login::class)
            ->colors([
                //'primary' => Color::Emerald,
                'primary' => '#539b7a',
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
                'suceptible' => Color::Amber,
                'baja' => Color::Red,
                'dev_proveedor' => Color::Sky,
                'almacen' => Color::Lime,
            ])
            ->font('Poppins')
            //->font('Roboto Mono', provider: GoogleFontProvider::class)
            //->font('Azeret Mono', provider: GoogleFontProvider::class)
            //->font('Roboto', provider: GoogleFontProvider::class)
            ->maxContentWidth(Width::Full)
            ->subNavigationPosition(SubNavigationPosition::End)
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('14rem')
            ->brandLogo(asset('images/logo.png'))
            ->brandLogoHeight('3rem')
            ->brandName('Activos Fijos')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                BlankDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            // ->widgets([
            //     AccountWidget::class,
            //     FilamentInfoWidget::class,
            // ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
