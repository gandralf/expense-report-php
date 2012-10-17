<?php

class ExpenseReport {
    private $expenses = array();

    /**
     * @param $printer ReportPrinter
     */
    public function printReport($printer) {
        $total = 0;
        $mealExpenses = 0;

        $printer->printText("Expenses " . $this->getDate() . "\n");

        foreach ($this->expenses as $expense) {
            if ($expense->type == ExpenseType::BREAKFAST || $expense->type == ExpenseType::DINNER)
                $mealExpenses += $expense->amount;

            $name = "TILT";
            switch ($expense->type) {
                case ExpenseType::DINNER: $name = "Dinner"; break;
                case ExpenseType::BREAKFAST: $name = "Breakfast"; break;
                case ExpenseType::CAR_RENTAL: $name = "Car Rental"; break;
            }
            $printer->printText(sprintf("%s\t%s\t$%.02f\n",
                (  ($expense->type == ExpenseType::DINNER && $expense->amount > 5000)
                    || ($expense->type == ExpenseType::BREAKFAST && $expense->amount > 1000)) ? "X" : " ",
                $name, $expense->amount / 100.0));

            $total += $expense->amount;
        }

        $printer->printText(sprintf("\nMeal expenses $%.02f",$mealExpenses / 100.0 ));
        $printer->printText(sprintf("\nTotal $%.02f", $total / 100.0));
    }

    /**
     * @param $expense Expense
     */
    public function addExpense($expense) {
        array_push($this->expenses, $expense);
    }

    public function getDate() {
        return "9/12/2002";
    }
}
