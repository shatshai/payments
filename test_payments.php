<?php
/**
 * TestCase PaymentsTEST
 * 
 * DD Web Developer technical test.
 * 
 * TESTCASE Process and validate data unit.
 * 
 * @author Shatshai Saeaio
 */
 
if (!class_exists('PHPUnit_Framework_TestCase'))
require_once 'PHPUnit/Autoload.php';
if (!class_exists('PHPUnit_Framework_TestCase')) echo "not exitst";
require_once 'Payments.php';

class PaymentsTEST extends PHPUnit_Framework_TestCase
{
	public $payments = null;
	
	public function setUp()
	{
		$this->payments = new Payments();
	}
	
	public function tearDown()
	{
		unset($this->payments);
	}
	
	/**
	 * Test depends method
	 */
	public function testhasMethod()
	{
		$this->assertEquals(true, method_exists($this->payments, 'isValidData'));
		$this->assertEquals(true, method_exists($this->payments, 'setOrderNo'));
		$this->assertEquals(true, method_exists($this->payments, 'setAmount'));
		$this->assertEquals(true, method_exists($this->payments, 'setName'));
		$this->assertEquals(true, method_exists($this->payments, 'getOrderNo'));
		$this->assertEquals(true, method_exists($this->payments, 'getAmount'));
		$this->assertEquals(true, method_exists($this->payments, 'getName'));
		$this->assertEquals(true, method_exists($this->payments, 'getErrorStr'));
	}
	
	/**
	 * @dataProvider provider
	 * @depends testhasMethod
	 */
	public function testisValidData($order_no, $amount, $name)
	{
		$this->payments->setOrderNo($order_no);
		$this->payments->setAmount($amount);
		$this->payments->setName($name);
		
		$this->assertRegExp('/^DD\d{4}$/', $this->payments->getOrderNo());
		$this->assertGreaterThan(0, $this->payments->getAmount());
		$this->assertLessThanOrEqual(100, $this->payments->getAmount());
		$this->assertEquals($name, $this->payments->getName());
	}
	
	/**
	 * provide data for test case.
	 */
	public function provider()
	{
		return array(
				array('', '', ''), 							//Failure TEST
				array(null, null, null), 					//Failure TEST
				array(0, 0, 0), 							//Failure TEST
				array(-1, -1, -1), 							//Failure TEST			
				array(new stdClass(), new stdClass(), new stdClass()), //Error TEST			
				array('<div>DD1001</div>', '<div>99</div>', '<div>firstname lastname</div>'), //Failure TEST
				array('<div>DD1001</div>', '99', '<div>firstname lastname</div>'), 	//Failure TEST
				array('1001', '2', "firstname  lastname"), 		//Failure TEST
				array("DD'1001", '2', "firstname  lastname"), 	//Failure TEST
				array('DD"1001', '2', "firstname  lastname"), 	//Failure TEST
				array("1 or 1;", '1 or 1;', "1 or 1;"), 		//Failure TEST
				array(" or 1;", ' or 1;', " or 1;"), 			//Failure TEST
				array('DD12345', 50, "firstname lastname"), 	//Failure TEST
				array('DD1001', 200, "firstname  lastname"), 	//Failure TEST
				array('DD1001', 99, "firstnamelastname"), 		//Failure TEST
				array('DD1001', 98, "ชื่อ นามสกุล"), 					//Failure TEST
				array('DD0001', '100', "firstname  lastname"),  //valid test
				array('DD0001', '100', "firstname midname lastname"),  //valid test
				array('DD1001', 1, "firstname lastname") 		//valid test
		);
	}
}