<?php

/**
 * FizzBuzz outputs integers from 1 to 100
 * However,
 * if an integer is a modulus of 3 and 5 it will output FizzBuzz
 * if an integer is a modulus of 3 it will output Fizz
 * if an integer is a modulus of 5 it will output Buzz
 */
function FizzBuzz(){

    $start = 1;
    $end = 100;
    $multipleOfThree = 'Fizz';
    $multipleOfFive = 'Buzz';
    $multipleofThreeAndFive = 'FizzBuzz';

    $values = array();

    for($i = $start; $i <= $end; $i++) {

        if($i % 3 == 0 && $i % 5 == 0) {
            $values[] = $multipleofThreeAndFive;
            continue;
        }

        if($i % 3 == 0) {
            $values[] = $multipleOfThree;
            continue;
        }

        if($i % 5 == 0) {
            $values[] = $multipleOfFive;
            continue;
        }

        $values[] = $i;

    }
	
	return $values;

}

echo "<pre>";
echo join("\n\r", FizzBuzz());
echo "</pre>";

?>