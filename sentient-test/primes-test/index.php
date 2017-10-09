<?php


/**
 * Class PrimeNumbers
 * Detects whether supplied numbers are prime
 */
class PrimeNumbers{
	
	private $numbers = array();
	
	private $primes = array();
	
	public function __construct($numbers){
		/* Allow to supply a single number without defining an array. Conversion will happen here */
		$this->numbers = is_array($numbers) ? $numbers : (array) $numbers;
		$this->detectPrimeNumbers();
		
	}
	
	public function detectPrimeNumbers(){
		
		foreach($this->numbers AS $v) {
			
			/* Skip if supplied number is 0 or 1 or if the number is not 2 and is divisible by 2 */
			if($v == 0 || $v == 1 || ($v !== 2 && $v % 2 == 0)) continue;
			
			if($this->isPrime($v)) $this->addToPrime($v);
		
		}
		
	}
	
	public function getPrimes(){
		
		return $this->primes;
		
	}
	
	public function addToPrime($prime){
		
		$this->primes[] = $prime;
		
	}

    /**
     * Function that will detect whether number is a prime and return true or false
     * Counter will be set to two only if number is dividable by itself and 1
     * @param $number Number to check
     * @return bool
     */
    public function isPrime($number){
		
		$counter = 0;

		for($i = 1; $i <= $number; $i++) {
		
			if($number % $i == 0) {
				
				$counter++;
				
			}
		
		}
		
		return ($counter == 2) ? true : false;
		
	}
	
}

$primes = new PrimeNumbers(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 149, 291, 293));

var_dump($primes->getPrimes());

?>