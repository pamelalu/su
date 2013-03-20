<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pstone
 * Date: 3/18/13
 * Time: 7:58 PM
 * PDO database class for select, insert, ...
 */

class myPDO {

    private $pdo;

    public static $instance;


    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME."", DB_USERNAME, DB_PASSWORD);
    }

    /**
     * @return myPDO
     * singleton
     */
    public static function getInstance()
    {
        if(!isset(self::$instance)) {
            self::$instance = new myPDO();
        }
        return self::$instance;
    }

    /**
     * @param $sql
     * @return PDOStatement
     */
    public function execute($sql) {

        try{
            $rst = $this->pdo->prepare($sql);
            $rst->execute();
            return $rst;
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
        }
    }

    /**
     * @param $dataArray
     * @param $table
     * @return string
     */
    public function insert($dataArray, $table)
    {
        $fieldString =  '('.implode (', ', array_keys($dataArray)).')';
        $dataString =  '("'.implode ('", "', array_values($dataArray)).'")';

        $sql = "insert into ".$table.' '.$fieldString.' values '.$dataString;
        //print $sql;
        try{
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $lastID = $this->pdo->lastInsertId();
            $this->pdo->commit();
            return $lastID;
        }
        catch (Exception $e)
        {
            $this->pdo->rollback();
            var_dump($e->getMessage());
        }
    }

    /**
     * @param array $dataArray
     * @param $table
     * @param string $option
     * @return array
     */
    public function select($dataArray = array(), $table, $option = '')
    {
        $sql = '';
        if(count($dataArray)>0) //has where condition
        {
            $tmp= array();
            foreach ($dataArray as $field => $value)
            {
                $tmp[] = $field."='".$value."'";
            }
            $dataString = implode(' and ', $tmp);
            $sql = 'select * from `'.$table.'` where '.$dataString;
        }
        else
        {

            $sql = 'select * from `'.$table.'`';
        }
        $sql = $sql.' '.$option;
        //print $sql;

        try{
            $rst = $this->dbh->prepare($sql);
            $rst->execute();
            $results=$rst->fetchAll(PDO::FETCH_ASSOC);
            return array('count'=>count($results), 'data'=>$results);
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
        }
    }


}