php
// app/Filament/Widgets/RevenueChart.php
<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue (Last 30 Days)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(CASE WHEN type = "commission" THEN amount ELSE 0 END) as commission'),
                DB::raw('SUM(CASE WHEN type = "subscription" THEN amount ELSE 0 END) as subscription')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Commissions',
                    'data' => $data->pluck('commission')->toArray(),
                    'borderColor' => '#4F46E5',
                    'backgroundColor' => 'rgba(79, 70, 229, 0.1)',
                ],
                [
                    'label' => 'Subscriptions',
                    'data' => $data->pluck('subscription')->toArray(),
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                ],
            ],
            'labels' => $data->pluck('date')->map(fn($d) => 
                \Carbon\Carbon::parse($d)->format('M d')
            )->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}