<?php
/*
 * @author kalina
 * (c) 2012-01
 */
require_once 'Base.php';

/*
 * The set of components for any page work (DB instance, etc)
 */
abstract class Page extends Base
{
    public function Run($tplName, $param)
    {
        include "templates/{$tplName}.tpl";
    }
}

