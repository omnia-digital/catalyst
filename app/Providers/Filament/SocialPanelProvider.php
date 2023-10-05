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
use OmniaDigital\CatalystCore\Facades\Translate;

class SocialPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('social')
            ->path('social')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Social/Resources'), for: 'App\\Filament\\Social\\Resources')
            ->discoverPages(in: app_path('Filament/Social/Pages'), for: 'App\\Filament\\Social\\Pages')
            ->pages([
                //                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Social/Widgets'), for: 'App\\Filament\\Social\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
//            ->navigationGroups([
//                NavigationGroup::make()
//                    ->label(Translate::get('Settings'))
//                    ->icon('heroicon-s-cog')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Translate::get('Billing'))
//                    ->icon('heroicon-o-credit-card')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Translate::get('People'))
//                    //                    ->icon('heroicon-s-users')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Translate::get('Teams'))
//                    ->icon('fas-users')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Translate::get('Forms'))
//                    ->icon('fab-wpforms')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Translate::get('Feeds'))
//                    ->icon('fad-rss')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Translate::get('Games'))
//                    ->icon('fad-gamepad-modern')
//                    ->collapsed(),
//            ])
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
