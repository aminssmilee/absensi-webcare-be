<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\RecentAbsensi;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('paneladmin')
            ->brandName('Sistem Presensi WebCare')
            ->authGuard('web')

            /* === Custom CSS === */
            ->renderHook(
                'panels::head.end',
                fn() => '
                    <style>
                        /* === SIDEBAR === */
                        .fi-sidebar { 
                            background: #1e3a8a !important; /* biru tua */
                            color: #fff !important;
                            display: flex;
                            flex-direction: column;
                        }

                        /* Sidebar header (brand) */
                        .fi-sidebar-header { 
                            background: #1e3a8a !important;
                            color: #fff !important;
                        }
                        .fi-sidebar-header h1,
                        .fi-sidebar-header .fi-brand {
                            color: #ffffff !important; /* brand putih */
                            font-weight: 600 !important;
                        }

                        /* Menu default */
                        .fi-sidebar a { 
                            color: #d1d5db !important;
                            font-weight: 500;
                        }

                        /* Menu aktif */
                        .fi-sidebar a.fi-active { 
                            background: #ffffff !important;  /* putih */
                            color: #000000 !important;        /* teks hitam */
                            font-weight: 600 !important;
                        }
                        .fi-sidebar a.fi-active svg {
                            color: #000000 !important;        /* icon hitam */
                            fill: #000000 !important;
                        }

                        /* Hover menu */
                        .fi-sidebar a:hover { 
                            background: #2563eb !important;   /* biru terang */
                            color: #000000 !important;        /* teks hitam */
                        }
                        .fi-sidebar a:hover svg {
                            color: #000000 !important;        /* icon putih */
                            fill: #ffffff !important;
                        }
                    </style>
                '
            )

            ->login()
            ->colors([
                'primary' => Color::Blue,
                'danger'  => Color::Rose,
                'gray'    => Color::Gray,
                'info'    => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])

            /* === Widgets Dashboard === */
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->widgets([
                StatsOverview::class,
                RecentAbsensi::class,
            ])

            /* === Middleware === */
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
