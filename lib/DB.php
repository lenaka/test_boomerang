<?php
/**
 * Wrapper for all DB actions.
 *
 * @author kalina
 * @final
 */
class DB
{
    private $host = "";
    private $dbName = "";
    private $user = "";
    private $password = "";
    private $connection = null;

    /**
     * @param <array> $dbParams Parameters of DB connection:
     *   "host"     => <string> Name of host phisical DB
     *   "dbName"   => <string> Name of Db for usage
     *   "user"     => <string> Login of Db user
     *   "password" => <string> PAssword of Db user
     */
    public function __construct($dbParams)
    {
        $this->host = $dbParams["host"];
        $this->dbName = $dbParams["name"];
        $this->user = $dbParams["user"];
        $this->password = $dbParams["password"];
    }

    /**
     * Create a new connection to DB
     */
    public function Connect()
    {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->dbName);
        if (!$this->connection)
        {
            throw new Exception("Can't connect to DB '{$this->dbName}' as user '{$this->user}'");
        }
        $this->connection->query('SET NAMES utf8');
    }

    /**
     * Executes a defined query in DB and returns associated array with fields name as a key.
     * Trows an exception in case of incorrect execution.
     *
     * @param <string> $query
     * @param <array> $params
     * @return <array>
     */
    public function Execute($query, $params = array())
    {
        $formatedQuery = count($params) ? vsprintf($query, $params) : $query;
        $result = $this->connection->query($formatedQuery);
        if ( $result === false )
        {
            throw new Exception("Can't execute a query '$formatedQuery'");
        }
        $return = array();
        if (is_object($result))
        {
            while ($row = $result->fetch_assoc())
            {
                $return[] = $row;
            }
        }
        return $return;
    }

    /**
     * Close current connection to DB
     */
    public function Close()
    {
        if ($this->connection) { $this->connection->close(); }
        $this->connection = null;
    }

    public function LastInsertedID()
    {
        return $this->connection->insert_id;
    }
    
    public function CountAffectedRows()
    {
        return $this->connection->affected_rows;
    }
    
    /*
     * msqli functions for transactions
     */
    public function Autocommit($flag)
    {
        return $this->connection->autocommit($flag);
    }
    public function Query($sql)
    {
        return $this->connection->query($sql);
    }
    
    public function Commit()
    {
        return $this->connection->commit();
    }
    
    public function Rollback()
    {
        return $this->connection->rollback();
    }

    /*
     * Last error
     */
    public function Error()
    {
        return $this->connection->error;
    }


    public function EscapeStr($str)
    {
        return $this->connection->real_escape_string($str);
    }
    
    public function __destruct()
    {
        $this->connection = null;
    }

}
