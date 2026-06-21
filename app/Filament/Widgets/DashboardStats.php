php
// app/Filament/Widgets/DashboardStats.php
<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Deal;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue = Transaction::where('type', 'commission')->sum('amount');
        $activeUsers = User::where('status', 'active')->count();
        $pendingKYC = User::whereHas('kycVerification', fn($q) => 
            $q->where('status', 'pending')
        )->count();
        $activeDeals = Deal::where('status', 'active')->count();
        $premiumUsers = User::whereHas('activeSubscription')->count();
        
        return [
            Stat::make('Total Revenue', 'KES ' . Number::abbreviate($totalRevenue))
                ->description('12% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
                
            Stat::make('Active Users', Number::abbreviate($activeUsers))
                ->description('4,821 total')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
                
            Stat::make('Pending KYC', $pendingKYC)
                ->description($pendingKYC > 50 ? '⚠ Requires attention' : '✅ Normal')
                ->descriptionIcon($pendingKYC > 50 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($pendingKYC > 50 ? 'warning' : 'success'),
                
            Stat::make('Active Deals', $activeDeals)
                ->description('342 this month')
                ->color('primary'),
                
            Stat::make('Premium Users', $premiumUsers)
                ->description('891 subscribed')
                ->descriptionIcon('heroicon-m-star')
                ->color('success'),
                
            Stat::make('Wallet Balance', 'KES ' . Number::abbreviate(
                Transaction::where('type', 'deposit')->sum('amount') - 
                Transaction::where('type', 'withdrawal')->sum('amount')
            ))
                ->description('Platform escrow')
                ->color('primary'),
        ];
    }
}