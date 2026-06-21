// app/Filament/Pages/Dashboard.php
<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\DashboardStats;
use App\Filament\Widgets\RevenueChart;
use App\Filament\Widgets\KYCBacklogAlert;
use App\Filament\Widgets\PlatformHealthMonitor;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard';

    public function getWidgets(): array
    {
        return [
            DashboardStats::class,
            KYCBacklogAlert::class,
            RevenueChart::class,
            PlatformHealthMonitor::class,
        ];
    }
}