<?php

require 'Expense.php';
require 'ExpenseReport.php';
require 'MockReportPrinter.php';

class ExpenseReportTest extends PHPUnit_Framework_TestCase {
    /**
     * @var $report ExpenseReport
     */
    private $report;
    /**
     * @var $printer MockReportPrinter
     */
    private $printer;

    public function setUp() {
        $this->report = new ExpenseReport();
        $this->printer = new MockReportPrinter();
    }

  
    public function testPrintEmpty() {
        $this->report->printReport($this->printer);
        
        $this->assertEquals(
            "Expenses 9/12/2002\n" .
                "\n" .
                "Meal expenses $0.00\n" .
                "Total $0.00",
            $this->printer->getText());
    }

  
  public function testPrintOneDinner() {
    $this->report->addExpense(new Expense(ExpenseType::DINNER, 1678));
    $this->report->printReport($this->printer);

    $this->assertEquals(
        "Expenses 9/12/2002\n" .
            " \tDinner\t$16.78\n" .
            "\n" .
            "Meal expenses $16.78\n" .
            "Total $16.78",
        $this->printer->getText());
  }

  
  public function testTwoMeals() {
    $this->report->addExpense(new Expense(ExpenseType::DINNER, 1000));
    $this->report->addExpense(new Expense(ExpenseType::BREAKFAST, 500));
    $this->report->printReport($this->printer);

    $this->assertEquals(
        "Expenses 9/12/2002\n" .
            " \tDinner\t$10.00\n" .
            " \tBreakfast\t$5.00\n" .

            "\n" .
            "Meal expenses $15.00\n" .
            "Total $15.00",
        $this->printer->getText());
}

  
  public function testTwoMealsAndCarRental() {
    $this->report->addExpense(new Expense(ExpenseType::DINNER, 1000));
    $this->report->addExpense(new Expense(ExpenseType::BREAKFAST, 500));
    $this->report->addExpense(new Expense(ExpenseType::CAR_RENTAL, 50000));
    $this->report->printReport($this->printer);

    $this->assertEquals(
        "Expenses 9/12/2002\n" .
            " \tDinner\t$10.00\n" .
            " \tBreakfast\t$5.00\n" .
            " \tCar Rental\t$500.00\n" .
            "\n" .
            "Meal expenses $15.00\n" .
            "Total $515.00",
        $this->printer->getText());
}

  
  public function testOverages() {
    $this->report->addExpense(new Expense(ExpenseType::BREAKFAST, 1000));
    $this->report->addExpense(new Expense(ExpenseType::BREAKFAST, 1001));
    $this->report->addExpense(new Expense(ExpenseType::DINNER, 5000));
    $this->report->addExpense(new Expense(ExpenseType::DINNER, 5001));
    $this->report->printReport($this->printer);

    $this->assertEquals(
        "Expenses 9/12/2002\n" .
            " \tBreakfast\t$10.00\n" .
            "X\tBreakfast\t$10.01\n" .
            " \tDinner\t$50.00\n" .
            "X\tDinner\t$50.01\n" .
            "\n" .
            "Meal expenses $120.02\n" .
            "Total $120.02",
        $this->printer->getText());
}
}
