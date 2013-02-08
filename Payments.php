<?php
/**
 * Class Payments
 * 
 * DD Web Developer technical test.
 * Process and validate data from post value.
 * 
 * @author Shatshai Saeaio
 *
 */
Class Payments
{
	protected $order_no = '';
	protected $amount = 0.0;
	protected $name = '';
	
	public function __construct()
	{
	}
	
	public function __destruct()
	{
	}

	/**
	 * Payment Process
	 */
	public function Process()
	{
		$order_no = self::getOrderNo();
		$amount = self::getAmount();
		$name = self::getName();
		$output = '';
		$ln = "\n";
		
		//Set input data
		if (isset($_POST['order_no'])) {
			$order_no = $_POST['order_no'];
		}
		if (isset($_POST['amount'])) {
			$amount = (float)$_POST['amount'];
		}
		if (isset($_POST['name'])) {
			$name = $_POST['name'];
		}
		
		//collection and validate data
		$result = self::isValidData($order_no, $amount, $name);
		
		$output.= '<div class="content">';
		$output.= '<div class="title"><h1>Payment Result</h1></title>';
		
		if ($result == '') { //validdata case
			$output.= '<div class="entry"><div class="label">Order No:</div>';
			$output.= '<div class="value">'.self::getOrderNo().'</div></div>'.$ln;
			$output.= '<div class="entry"><div class="label">Amount:</div>';
			$output.= '<div class="value">'.self::getAmount().'</div></div>'.$ln;
			$output.= '<div class="entry"><div class="label">Order No:</div>';
			$output.= '<div class="value">'.self::getName().'</div></div>'.$ln;
				
		} else {	//invaliddata case
			$output.= $result;	
		}
		$output.= '</div>'.$ln;
		$output.= '<br />';
		$output.= '<a href="index.html">Back to Payment Form</a>'.$ln;
		
		return $output;
	}
	
	/**
	 * Set and Validate Input Data
	 * @param String $order_no
	 * @param numeric $amount
	 * @param String $name
	 * @return string
	 */
	public function isValiddata($order_no, $amount, $name)
	{
		self::setOrderNo($order_no);
		self::setAmount($amount);
		self::setName($name);
		
		$error = '';
		//Test valid Order number
		if (self::getOrderNo() == '') {
			$error.= self::getErrorStr('Invalid order number: Please field Order number in "DD0000" format Ex. DD0001');
		}
		//Test valid Amount
		if (self::getAmount() > 100.0) {
			$error.= self::getErrorStr('Invalid amount: Amount should not more than 100.');
		}
		if (self::getAmount() <= 0.0) {
			$error.= self::getErrorStr('Invalid amount: Amount should more than 0.');
		}
		//Test valid Name
		if (self::getName() == '') {
			if (strpos($name, ' ') === false) {
				$error.= self::getErrorStr('Invalid name: required first and last name.');
			} else {
				$error.= self::getErrorStr('Invalid name: please field name in english.');
			}
		}
		return $error;
	}
	/**
	 * Filter and Set Order number
	 * @param String $order_no
	 */
	public function setOrderNo($order_no)
	{
		//filter data
		$tmp_order_no = trim(strip_tags($order_no));
		if ($tmp_order_no != $order_no) return false;
		//collection data
		if (preg_match('/^DD(?P<orderid>\d{4})$/', $order_no, $matches)) {
			if (isset($matches['orderid']) && (int)$matches['orderid'] > 0) {
				$this->order_no = $order_no;
			}
		} 
	}
	/**
	 * Get order number
	 * @return string
	 */
	public function getOrderNo()
	{
		return $this->order_no;
	}
	
	/**
	 * Set total amount
	 * @param numeric $amount
	 */
	public function setAmount($amount)
	{
		if (!is_numeric($amount)) return false;
		//collection data
		if ((float)$amount > 0.0) $this->amount = $amount;
	}
	
	/**
	 * Get Total amount
	 */
	public function getAmount()
	{
		return $this->amount;
	}
	
	/**
	 * Set name
	 * @param String $name
	 */
	public function setName($name)
	{
		//filter data
		$tmp_name = trim(strip_tags($name));
		if ($tmp_name != $name) return false;
		//collection data
		if (preg_match('/^(?P<firstname>[[:alpha:]]+)([[:space:]]+)(?P<lastname>[[:alpha:]]+)/', $name, $matches)) {
			$this->name = $name;
		}
	}
	
	/**
	 * Get property name
	 */
	public function getName()
	{
		return $this->name;
	}
	/**
	 * get Error string format
	 * @param String $error
	 */
	public function getErrorStr($error)
	{
		if ($error != '') return '<div class="error">'.$error.'</div>';
	}
}