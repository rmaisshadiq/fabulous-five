<?php

namespace App\Filament\Resources\FinancialReportResource\Widgets;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Widgets\Widget;

class FinancialFilterWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.resources.financial-report-resource.widgets.financial-filter-widget';

    public ?array $data = []; // Store form data

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Date Filter')
                    ->schema([
                        Select::make('filter')
                            ->label('Select Date Range')
                            ->options([
                                'today' => 'Today',
                                'last_7_days' => 'Last 7 Days',
                                'this_month' => 'This Month',
                                'last_month' => 'Last Month',
                                'this_year' => 'This Year',
                            ])
                            ->default('this_month')
                            ->live() // Trigger update on change
                            ->afterStateUpdated(fn () => $this->dispatchFilterUpdate()),
                    ])
            ])
            ->statePath('data'); // Bind to data property
    }

    public function mount(): void
    {
        // Initialize form with default values
        $this->form->fill(['filter' => 'this_month']);
        
        // Dispatch the initial filter state when the widget loads
        $this->dispatchFilterUpdate();
    }

    public function dispatchFilterUpdate(): void
    {
        $filterValue = $this->data['filter'] ?? 'this_month';
        $this->dispatch('financialsUpdated', range: $filterValue);
    }

    protected function getForms(): array
    {
        return [
            'form',
        ];
    }
}