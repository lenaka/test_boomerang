<?php
/* 
 * Put/get data to DB
 */
class Control extends Base
{
    public function __construct($Db)
    {
        $this->Db = $Db;
    }
}