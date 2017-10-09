<?php

/*
 * Simple class that will load the template
 * Instead of using functions to contain template data,
 * we can create dedicated php files and put them into the view folder
 * */
class Template {


    public function loadView($template, $data){

        if(function_exists($template)) {

            return $template($data);

        } else {

            return defaultTemplate($data);

        }

    }

}

function genericMessage($data){

    ?>

    <h3>Design Template Loaded</h3>
    <p>Your rolled number was <?php echo $data['number'] ?></p>
    <p>Template name <?php echo (empty(@$data['design']['design_name']) ? 'No name' : @$data['design']['design_name']) ?></p>

    <?php
}

function defaultTemplate($data) {

    genericMessage($data)

    ?>

    <p>There is no unique template for <?php echo (empty(@$data['design']['design_name']) ? 'No name' : @$data['design']['design_name']) ?></p>
    <p>Please create new function in order to display exclusive output </p>

    <?php

}

function template_one($data){

    genericMessage($data);

    ?>

    <p style="background: blue; color: #fff;">I am unique string that will only be displayed once template one is loaded</p>

    <?php

}

function template_two($data) {

    genericMessage($data);

    ?>

    <p style="background: red; color: #fff;">I am unique string that will only be displayed once template two is loaded</p>

    <?php

}

function template_three($data){

    genericMessage($data);

    ?>

    <p style="background: green; color: #fff;">I am unique string that will only be displayed once template three is loaded</p>

    <?php

}

?>