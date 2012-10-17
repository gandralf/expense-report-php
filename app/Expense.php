<?
class ExpenseType {
    const DINNER = 0;
    const BREAKFAST = 1;
    const CAR_RENTAL = 2;
}

class Expense {
    public $type;
    public $amount;

    public function Expense($type, $amount) {
        $this->type = $type;
        $this->amount = $amount;
    }
}