<?php

namespace App\Filament\Resources\FinancialReportResource\Widgets;

use App\Models\FinancialReport;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use Livewire\Attributes\On;

class FinancialOverview extends BaseWidget
{
    // Properties to hold the current date range
    public Carbon $startDate;
    public Carbon $endDate;
    public string $currentRange = 'this_month';

    /**
     * Set a default date range when the component first loads.
     */
    public function mount(): void
    {
        $this->setDateRange('this_month');
    }

    /**
     * This method is called when the 'financialsUpdated' event is received.
     * It updates the date range based on the new selection.
     */
    #[On('financialsUpdated')]
    public function financialsUpdated(string $range): void
    {
        $this->currentRange = $range;
        $this->setDateRange($range);
    }

    /**
     * A helper method to set the start and end date properties.
     */
    protected function setDateRange(string $range): void
    {
        switch ($range) {
            case 'today':
                $this->startDate = now()->startOfDay();
                $this->endDate = now()->endOfDay();
                break;
            case 'last_7_days':
                $this->startDate = now()->subDays(6)->startOfDay();
                $this->endDate = now()->endOfDay();
                break;
            case 'last_month':
                $this->startDate = now()->subMonth()->startOfMonth();
                $this->endDate = now()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $this->startDate = now()->startOfYear();
                $this->endDate = now()->endOfYear();
                break;
            case 'this_month':
            default:
                $this->startDate = now()->startOfMonth();
                $this->endDate = now()->endOfMonth();
                break;
        }
    }

    /**
     * Get the display name for the current range
     */
    protected function getRangeDisplayName(): string
    {
        return match($this->currentRange) {
            'today' => 'Today',
            'last_7_days' => 'Last 7 Days',
            'last_month' => 'Last Month',
            'this_year' => 'This Year',
            'this_month' => 'This Month',
            default => 'Selected Period'
        };
    }

    /**
     * Calculate and return the statistics.
     */
    protected function getStats(): array
    {
        // Base query with the date range filter applied
        $query = FinancialReport::whereBetween('transaction_date', [$this->startDate, $this->endDate]);

        // Clone the query to use for separate calculations
        $incomeQuery = clone $query;
        $expenseQuery = clone $query;

        $totalIncome = $incomeQuery->where('type', 'income')->sum('amount');
        $totalExpense = $expenseQuery->where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        $rangeDisplay = $this->getRangeDisplayName();

        return [
            Stat::make('Total Income', 'Rp' . Number::format($totalIncome, locale: 'id'))
                ->description("Income for {$rangeDisplay}")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Expense', 'Rp' . Number::format($totalExpense, locale: 'id'))
                ->description("Expenses for {$rangeDisplay}")
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Net Profit', 'Rp' . Number::format($netProfit, locale: 'id'))
                ->description("Profit for {$rangeDisplay}")
                ->descriptionIcon('heroicon-m-scale')
                ->color($netProfit >= 0 ? 'success' : 'danger'),
        ];
    }
}