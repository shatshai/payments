<?php
#require_once 'PHPUnit/Autoload.php';
require_once 'test_payments.php';
#require_once 'PHPUnit.php';


$suite  = new PHPUnit_Framework_TestSuite();

$suite->addTestSuite('PaymentsTest');
PHPUnit_TextUI_TestRunner::run($suite);