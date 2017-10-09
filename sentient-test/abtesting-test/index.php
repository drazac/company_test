<?php

/*
 * Specification is not clear
 *
 * If I understand this correctly, by default there are 3 designs
 * Design number 1 will see 50% of people.
 * Design number 2 will se 25% of people, same as design number 3
 *
 * Adding more designs. I presume when you add new design you specify the percentage for it, however total percentage can not go beyond 100%, so that means, whenever
 * new design gets added, all other designs (their percentages) will be scaled down dynamically, e.g we are adding design 4 with 15 chance to be viewed:
 *
 * Design number 1 - scaled from 50% to 42.5
 * Design number 2 - scaled from 25% to 21.25
 * Design number 3 - scaled from 25% to 21.25
 * Design number 4 - set to 15%
 *
 * Total is 100%
 *
 *
 * */

require_once 'database.php';
require_once 'abtesting.php';

$dm = new Design_Gamble(new Design_Model());

/* Initial design values */

//$dm->addToDesign(array('design_name'=>'Design 1', 'split_percent'=>50, 'design_template'=>'template_one'), 0);
//$dm->addToDesign(array('design_name'=>'Design 2', 'split_percent'=>25, 'design_template'=>'template_two'), 0);
//$dm->addToDesign(array('design_name'=>'Design 3', 'split_percent'=>25, 'design_template'=>'template_three'), 0);


/* Adding new values */
//$dm->addToDesign(array('design_name'=>'Design 4', 'split_percent'=>15));

/*Deleting values - provide a correct ID */
//$dm->deleteFromDesign(1);
//$dm->deleteFromDesign(2);
//$dm->deleteFromDesign(3);


echo $dm->viewDesign();

?>