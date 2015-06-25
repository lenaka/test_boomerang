<?php
/* 
 * Put/get data to DB
 */
require_once 'Control.php';

class ControlUserScore extends Control
{
    protected $id;
    protected $uname;
    protected $score;
    protected $date;
    
    protected $periodType;
    protected $portion = 3;


    public function Save()
    {
        try
        {
            if (!$this->uname) { throw new Exception('Empty user name'); }
            if (is_null($this->score)) { throw new Exception('Empty score value'); }
            if (!$this->date) { throw new Exception('Empty score date'); }
            
            $this->id = $this->saveUname($this->uname);
            $this->saveScore($this->id, $this->score, $this->date);
            
            return $this->id;
        }
        catch (Exception $e)
        {
            $this->LogError($e->getMessage());
        }
    }

    public function GetSerialData($page=1)
    {
        $page = (int)$page > 0 ? $page : 1;
        $cond = is_null($this->periodType) ? '' : "WHERE score_date BETWEEN DATE_SUB(NOW(), INTERVAL 1 {$this->periodType}) AND NOW()";
        $res = $this->Db->Execute("
            SELECT SUM(s.value) sm, u.uname
            FROM score s
            JOIN users u ON s.user_id=u.id
            {$cond}
            GROUP BY user_id
            ORDER BY sm DESC
            LIMIT ".(($page-1) * $this->portion).",".($page * $this->portion)."
        ");
        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }
    
    public function GetAllCount()
    {
        $cond = is_null($this->periodType) ? '' : "WHERE score_date BETWEEN DATE_SUB(NOW(), INTERVAL 1 {$this->periodType}) AND NOW()";
        $res = current($this->Db->Execute("
            SELECT count(DISTINCT user_id) cnt
            FROM score s
            {$cond}
        "));
        return empty($res['cnt']) ? 1 : $res['cnt'];
    }

    protected function _set_periodType($val)
    {
         $this->periodType = $val == 'm' ? 'MONTH' : (
               $val == 'w' ? 'WEEK' : (
               $val ==  'd' ? 'DAY' : null));

    }
    
    private function saveUname($uname)
    {
        $this->Db->Query("
        INSERT IGNORE INTO users (uname)
        VALUES ('".$this->Db->EscapeStr($uname)."')
        ");
        if (!$id = $this->Db->LastInsertedId())
        {
            $res = current($this->Db->Execute("
            SELECT id
            FROM users
            WHERE uname='".$this->Db->EscapeStr($uname)."'
            "));
            $id = $res['id'];
        }
        
        return $this->id = $id;
    }
    
    private function saveScore($userId, $score, $date)
    {
        if ($d = DateTime::createFromFormat('d.m.Y', $date))
        {
            $this->Db->Query("
            INSERT INTO score (user_id, value, score_date)
            VALUES ({$userId}, {$score}, '".$d->format('Y-m-d')."')
            ");
        }
        else { throw new Exception("Incorrect date {$date}"); }
    }
}