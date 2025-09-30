<?php

namespace App\Filament\Widgets;

use App\Models\EggProduction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EggProductionChart extends ChartWidget
{
    protected ?string $heading = 'Produksi Telur Per Minggu';

    protected function getData(): array
    {
        $weeklyData = EggProduction::query()
            ->select(
                DB::raw('WEEK(date) as week'),
                DB::raw('YEAR(date) as year'),
                DB::raw('SUM(quantity) as total')
            )
            ->where('date', '>=', now()->subWeeks(12))
            ->groupBy('year', 'week')
            ->orderBy('year', 'asc')
            ->orderBy('week', 'asc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($weeklyData as $item) {
            $labels[] = "Minggu {$item->week}, {$item->year}";
            $data[] = $item->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Telur',
                    'data' => $data,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
