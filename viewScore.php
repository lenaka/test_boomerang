<?php
require_once 'lib/Page.php';

class PageViewScore extends Page
{
    private $periodType;
    private $control;
    
    public function __construct($config)
    {
        parent::__construct($config);
        $this->ConnectDB();
        
        require_once $this->CorePath.'ControlUserScore.php';
        $this->control = new ControlUserScore($this->Db);
        
        $this->control->periodType = filter_input(INPUT_GET, 'period');
    }


    public function Display()
    {
        $scoreData = $this->control->GetSerialData($this->periodType);
        parent::Run('viewScore', array('scoreData' => $scoreData, 'portion' => 3, 'page' => 1));
    }
}

$p = new PageViewScore($config);
$p->Display();
