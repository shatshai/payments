<?php
/**
 * PaymentsTEST
 * DD Web Developer technical test.
 * 
 * TESTCASE Process and validate data.
 * 
 * @author Shatshai Saeaio
 */
require_once 'PHPUnit/Autoload.php';
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
	 * Test method exists
	 */
	public function testhasMethod()
	{
		$this->assertEquals(true, method_exists($this->payments, 'isValidData'));
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
	
	public function provider()
	{
		return array(
				array('', '', ''), 							//Failure TEST
				array(null, null, null), 					//Failure TEST
				array(0, 0, 0), 							//Failure TEST
				array(-1, -1, -1), 							//Failure TEST			
				array(new stdClass(), new stdClass(), new stdClass()), //Error TEST			
				array('<div>DD1001</div>', '<div>99</div>', '<div>fname lastname</div>'), //Failure TEST
				array('<div>DD1001</div>', '99', '<div>fname lastname</div>'), 	//Failure TEST
				array('1001', '2', "fname  lastname"), 		//Failure TEST
				array("DD'1001", '2', "fname  lastname"), 	//Failure TEST
				array('DD"1001', '2', "fname  lastname"), 	//Failure TEST
				array("1 or 1;", '1 or 1;', "1 or 1;"), 	//Failure TEST
				array('DD1001', 200, "fname  lastname"), 	//Failure TEST
				array('DD1001', 99, "fnamelastname"), 		//Failure TEST
				array('DD0001', '100', "fname  lastname"),  //valid test
				array('DD0001', '100', "fname midname lastname"),  //valid test
				array('DD1001', 1, "fname lastname") 		//valid test
		);
	}
}