<?php

namespace App\Exports;

use App\Models\Expense;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class ExpenseExport implements FromView
{
    protected $expenses;


    public function __construct($expenses)
    {
        $this->expenses = $expenses;
    }

    public function view(): View
    {
        return view('business.expenses.export', [
            'expenses' => $this->expenses
        ]);
    }
}
