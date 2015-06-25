<?php
/* 
 * Put/get data to DB
 */
require_once 'Base.php';
class Command extends Base
{
    public function __construct($config)
    {
        parent::__construct($config);
        $this->ConnectDB();
    }
    
    public function Execute($cmd, $data)
    {
        if (in_array($cmd, get_class_methods($this)))
        {
            $input = array();
            $input[] = $data;
            return call_user_func_array(array($this, $cmd), $input);
        }
        else
        {
            throw new Exception("Unknown command '{$cmd}'");
        }
    }
    
    private function get_scores($data)
    {
        require_once $this->CorePath.'ControlUserScore.php';
        $c = new ControlUserScore($this->Db);
        $c->periodType = @$data['period'];
        return $c->GetSerialData((int)@$data['page']);
    }
    
    private function get_max_page($data)
    {
        require_once $this->CorePath.'ControlUserScore.php';
        $c = new ControlUserScore($this->Db);
        $c->periodType = @$data['period'];
        return (int)$data['portion'] ? ceil($c->GetAllCount()/$data['portion']) : 1 ;
    }
    
    private function save_scores($data)
    {
        require_once $this->CorePath.'ControlUserScore.php';
        $c = new ControlUserScore($this->Db);
        $c->uname = $data['name'];
        $c->score = $data['score'];
        $c->date = $data['date'];
        return $c->Save();
    }
}