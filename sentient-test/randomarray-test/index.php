<?php

/**
 * Function returns an array of integer numbers.  
 * @param int $howMany How many elements should we generate
 * @param int $min Set min value
 * @param int $max Set max value
 * @param int $skipDuplicates Should values be unique
 * @return array
 */
function RandomElementArray($howMany = 500, $min = 1, $max = 500, $skipDuplicates = 0){

    $array = array();

    /* Return if howMany is not an integer or it is less than 0 */
    if(!is_int($howMany) || $howMany <= 0) return array();

    for($i = 0; $i < $howMany; $i++) {

        $array[$i] = generateRandomNumbers($min, $max, $array, $skipDuplicates);

    }

    return $array;

}

/**
 * Function checks how many elements should be removed and then based on this value, it generates and stores a random array of numbers.
 * Random numbers are then compared with the original supplied array and if the match is found, it is removed from the array
 * Function returns collection of data as an array
 * @param $array
 * @param int $howMany How many elements should be removed from the array
 * @return array
 */
function randomlyRemoveArrayElement($array, $howMany = 1){

    /* Return empty array if not an array */
    if(!is_array($array)) return array();

    /* Return empty array if howMany is not integer or it is less than 0 */
    if(!is_int($howMany) || $howMany <= 0) return array();

    /* Will store the values of removed elements */
    $removedElements = array();

    /* Backup for original unedited array */
    $original = $array;

    /* Random numbers */
    $random = array();

    /* Give me minimum and maximum value stored in main array */
    $min = min($array);
    $max = max($array);

    for($i = $howMany; $i > 0; $i--) {

        /* Set skipDuplicate to 1 because we want unique values */
        $random[] = generateRandomNumbers($min, $max, $random, 1);

    }

    /*
     * Because description of desired output was not clear enough in the specification,
     * next part of code will remove any instance of integer value stored in variable $array
     * that exists in random array as well
     * */

    foreach($array AS $k => $v) {

        if(in_array($v, $random)) {
            $removedElements[$k] = $v;
            unset($array[$k]);

        }

    }
	
    return array(
        'originalArray' => $original,
        'random' => $random,
        'removedElements' => $removedElements,
        'newArray' => $array,
        'newArrayCount' => count($array),
        'removedElementsCount' => count($removedElements)
    );

}

/**
 * Function that will generate random numbers
 * @param $min Minimal number generated
 * @param $max Maximal number generated
 * @param array $rand pass by reference an array that contains other random numbers
 * @param bool $skipDuplicates Do you want to generates a unique number or duplicates can occur
 * if set to true, each number will be checked in the $rand array to see whether there is a duplicate one
 * If duplicate is found, call function again until unique number is returned
 * @return int
 */
function generateRandomNumbers($min, $max, &$rand = array(), $skipDuplicates = 0){

    $number = mt_rand($min, $max);

    if(!empty($skipDuplicates) && in_array($number, $rand)) {

        return generateRandomNumbers($min, $max, $rand, $skipDuplicates);

    }

    return $number;


}

echo "<pre>";
//$new = randomlyRemoveArrayElement(RandomElementArray($howMany = 20, $min = 1, $max = 20, $skipDuplicates = 0), 5);
$new = randomlyRemoveArrayElement(RandomElementArray());
print_r($new);
echo "</pre>";

?>