<?php

/*
 * This class will handle several functions
 * Generating random number
 * Inserting new design and rescaling
 * Deleting existing design and rescaling
 * Initializing the template
 * */
class Design_Gamble{

    private $number = 0;
    private $designModel = array();
    private $design = array();

    public function __construct(Design_Model $model)
    {
        $this->designModel = $model;
        $this->roleDice();
        $this->loadDesign();
    }

    public function roleDice(){

        $this->number = mt_rand(1, 100);

    }

    public function loadDesign(){

        $rs = $this->percentageToNumbers($this->designModel->getAll());

        foreach($rs AS $k => $v) {

            $start = $v['start'];
            $end = $v['end'];

            if($this->number >= $start && $this->number <= $end ) {

                $this->design = $v;

            }

        }

    }

    public function percentageToNumbers($rs){

        $start = 1;

        $tableAlias = $this->designModel->getColumnNames();
        $alias = $tableAlias['percentage'];

        foreach($rs AS $k => $v) {

            $rs[$k]['start'] = round($start);
            $rs[$k]['end'] = round($start + $v[ $alias ] - 1);
            $start = round($start + $v[ $alias ]);

        }

        return $rs;

    }

    public function addToDesign($item, $rescale = 1) {

        $model = $this->designModel;

        $tableAlias = $this->designModel->getColumnNames();
        $alias = $tableAlias['percentage'];

        $model->dm_insert($item);
        $id = $model->lastId();

        if(!empty($rescale)) $this->rescalePercentage($item[$alias], $id);

    }

    public function deleteFromDesign($id) {

        $tableAlias = $this->designModel->getColumnNames();
        $alias_i = $tableAlias['id'];
        $alias_p = $tableAlias['percentage'];

        $rs = $this->designModel->getPercentageById($id);
        $rs = @$rs[0];

        $this->designModel->dm_delete(array($alias_i => $id));

        $this->rescalePercentage(@$rs[ $alias_p ], 0, 1);
    }

    public function rescalePercentage($percent = 1, $exclude = 0, $scale = 0){

        $tableAlias = $this->designModel->getColumnNames();
        $alias_i = $tableAlias['id'];
        $alias_p = $tableAlias['percentage'];

        foreach($this->designModel->getAll() AS $k => $v) {

            if($v[ $alias_i ] == $exclude) continue;

            if(!empty($scale)) {
                /* This needs to be better because there is a calculation bug when you delete a record */
                $newPercentage = round($v[ $alias_p ] + ( ($v[ $alias_p ] * $percent) / 100));
            } else {
                $newPercentage = round($v[ $alias_p ] - ( ($v[ $alias_p ] * $percent) / 100));
            }

            $this->designModel->dm_update(array($alias_p => $newPercentage), $alias_i . ' = ' . $v[ $alias_i ]);

        }

    }


    public function viewDesign(){

        $design = $this->design;

        $tableAlias = $this->designModel->getColumnNames();
        $alias_t = $tableAlias['template'];

        require_once 'view/design/template.php';

        $template = new Template();

        $data = array('number' => $this->number, 'design' => $design);

        return $template->loadView(@$design[ $alias_t ], $data);


    }

    public function getDesign(){

        return $this->design;

    }

    public function getDesignModel(){

        return $this->designModel;

    }

}



?>