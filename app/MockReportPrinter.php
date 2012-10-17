<?php

require 'ReportPrinter.php';

class MockReportPrinter implements ReportPrinter {
    private $printedText = "";

    public function printText($text) {
        $this->printedText .= $text;
    }

    public function getText() {
        return $this->printedText;
    }
}
