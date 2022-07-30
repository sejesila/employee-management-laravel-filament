<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Country;
use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class EmployeeStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $kenya = Country::where('country_code','KE')->withCount('employees')->first();
        $uk = Country::where('country_code','UK')->withCount('employees')->first();
        return [
            Card::make('All Employees', Employee::all()->count()),
//                ->color('success')
//                ->description('3% increase')
//                ->descriptionIcon('heroicon-s-trending-up'),

            Card::make($kenya->name . " Employees", $kenya->employees_count),
            Card::make($uk->name . " Employees", $uk->employees_count),

        ];
    }
}
