<?php
/*
 * Initialize data for all components
 * @author kalina
 * (c) 2015-06
 */

$cfgFile = __DIR__."/../config/phpconfig.ini";
$config = parse_ini_file($cfgFile, true);

/*
 * The set of components for any page work (DB instance, etc)
 */
abstract class Base
{
    public $CorePath = "";
    protected $Db;
    protected $AbsPath;
    
    
    public function __construct($config)
    {
        // Web site dir path
        $this->AbsPath = $config["ABS_PATH"] or die("ABS_PATH shall be set up in config");

        $dbParameters = $config["DB"] or die("DB section shall be set up in config");
        $this->CorePath = $this->AbsPath.$config["System"]["lib"] or die("System section shall be set up in config");

        require_once($this->CorePath."DB.php");
        $this->Db = new DB($dbParameters);
    }
    
    public function __get($name)
    {
        $meth = "_get_{$name}";
        if (method_exists($this, $meth))
        {
            $ret = call_user_func(array($this, $meth), $value);
        }
        else
        {
            $vars = get_class_vars(get_class($this));
            $ret = array_key_exists($name, $vars)
                ? $this->$name
                : $this->LogError("Can't find '{$name}'");
        }
        return $ret;
    }
    
    public function __set($name, $value)
    {
        $meth = "_set_{$name}";
        if (method_exists($this, $meth))
        {
            call_user_func(array($this, $meth), $value);
        }
        else
        {
            $this->$name = $value;
        }
    }

    public function GetDB()
    { return $this->Db; }

    public function ConnectDB()
    {
        try { $this->Db->Connect(); }
        catch (Exception $e)
        {
            $this->LogError($e->getMessage());
            exit();
        }
    }

    public function Finalize()
    {
        $this->Db->Close();
    }
    
    public function __destruct()
    {
        $this->Db = null;
    }
    
    /*
     * Test realization.
     * Just write to IO.
     * 
     * @param <string> Error message
     */
    protected function LogError($eMes)
    {
        echo $eMes;
        return;
    }
}

