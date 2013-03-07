<?php
require_once 'test_payments.php';

$suite  = new PHPUnit_Framework_TestSuite();

$suite->addTestSuite('PaymentsTest');

PHPUnit_TextUI_TestRunner::run($suite);
