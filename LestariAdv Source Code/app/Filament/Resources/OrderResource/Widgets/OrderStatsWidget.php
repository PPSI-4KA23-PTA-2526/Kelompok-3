<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class OrderStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Pesanan Hari Ini
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->sum('total');

        // Pesanan Bulan Ini
        $monthOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $monthRevenue = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('payment_status', 'paid')
            ->sum('total');

        // Pesanan Pending
        $pendingOrders = Order::where('payment_status', 'pending')->count();

        // Trend - perbandingan dengan kemarin
        $yesterdayOrders = Order::whereDate('created_at', today()->subDay())->count();
        $todayTrend = $yesterdayOrders > 0
            ? round((($todayOrders - $yesterdayOrders) / $yesterdayOrders) * 100, 1)
            : 0;

        // Trend bulan - perbandingan dengan bulan lalu
        $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $monthTrend = $lastMonthOrders > 0
            ? round((($monthOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 1)
            : 0;

        return [
            Stat::make('Pesanan Hari Ini', $todayOrders)
                ->description(
                    $todayTrend >= 0
                        ? "{$todayTrend}% peningkatan dari kemarin"
                        : abs($todayTrend) . "% penurunan dari kemarin"
                )
                ->descriptionIcon($todayTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($this->getLastSevenDaysData())
                ->color($todayTrend >= 0 ? 'success' : 'danger'),

            Stat::make('Penjualan Hari Ini', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
                ->description('Total penjualan yang sudah dibayar')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Pesanan Bulan Ini', $monthOrders)
                ->description(
                    $monthTrend >= 0
                        ? "{$monthTrend}% peningkatan dari bulan lalu"
                        : abs($monthTrend) . "% penurunan dari bulan lalu"
                )
                ->descriptionIcon($monthTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($this->getLastThirtyDaysData())
                ->color($monthTrend >= 0 ? 'success' : 'danger'),

            Stat::make('Penjualan Bulan Ini', 'Rp ' . number_format($monthRevenue, 0, ',', '.'))
                ->description('Total penjualan yang sudah dibayar')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Menunggu Pembayaran', $pendingOrders)
                ->description('Pesanan yang belum dibayar')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Rata-rata Per Hari', number_format($monthOrders / now()->day, 1))
                ->description('Bulan ini')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
        ];
    }

    protected function getLastSevenDaysData(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $data[] = Order::whereDate('created_at', $date)->count();
        }
        return $data;
    }

    protected function getLastThirtyDaysData(): array
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $data[] = Order::whereDate('created_at', $date)->count();
        }
        return $data;
    }
}
