<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrderStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Total Orders
        $totalOrders = Order::count();

        // Total Revenue
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');

        // Pending Orders
        $paidOrders = Order::where('payment_status', 'paid')->count();

        // Today's Orders
        $todayOrders = Order::whereDate('created_at', today())->count();

        // This Month Revenue
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // Orders Growth (comparing this month to last month)
        $thisMonthOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $ordersGrowth = $lastMonthOrders > 0
            ? (($thisMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100
            : 0;

        return [
            Stat::make('Total Pesanan', Number::format($totalOrders))
                ->description('Semua pesanan')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary')
                ->chart($this->getTotalOrdersChart()),

            Stat::make('Total Pendapatan', Number::currency($totalRevenue, 'IDR', 'id'))
                ->description('Pendapatan yang sudah dibayar')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Pesanan Dibayar', Number::format($paidOrders))
                ->description('Sudah dibayar')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Pesanan Hari Ini', Number::format($todayOrders))
                ->description('Pesanan masuk hari ini')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info')
                ->chart($this->getLast7DaysChart()),

            Stat::make('Pendapatan Bulan Ini', Number::currency($monthlyRevenue, 'IDR', 'id'))
                ->description('Pendapatan bulan berjalan')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success')
                ->chart($this->getMonthlyRevenueChart()),

            Stat::make('Pertumbuhan Pesanan', number_format($ordersGrowth, 1) . '%')
                ->description($ordersGrowth >= 0 ? 'Naik dari bulan lalu' : 'Turun dari bulan lalu')
                ->descriptionIcon($ordersGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ordersGrowth >= 0 ? 'success' : 'danger'),
        ];
    }

    protected function getTotalOrdersChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $data[] = Order::whereDate('created_at', $date)->count();
        }
        return $data;
    }

    protected function getLast7DaysChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $data[] = Order::whereDate('created_at', $date)->count();
        }
        return $data;
    }

    protected function getMonthlyRevenueChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $revenue = Order::whereDate('created_at', $date)
                ->where('payment_status', 'paid')
                ->sum('total');
            $data[] = $revenue / 1000; // Divide by 1000 for better chart scaling
        }
        return $data;
    }
}
