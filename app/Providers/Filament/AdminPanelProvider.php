<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Trans;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
//            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
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
//            ->navigationGroups([
//                NavigationGroup::make()
//                    ->label(Trans::get('Settings'))
//                    ->icon('heroicon-s-cog')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Trans::get('Billing'))
//                    ->icon('heroicon-o-credit-card')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Trans::get('People'))
////                    ->icon('heroicon-s-users')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Trans::get('Teams'))
//                    ->icon('fas-users')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Trans::get('Forms'))
//                    ->icon('fab-wpforms')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Trans::get('Feeds'))
//                    ->icon('fad-rss')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Trans::get('Games'))
//                    ->icon('fad-gamepad-modern')
//                    ->collapsed()
//            ]);
    }
}
