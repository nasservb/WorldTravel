<?php

namespace nasservb\AgencyAssistant\Models;
use nasservb\AgencyAssistant\Database\DB;

abstract class BaseEntity
{
    /** 
     * @var string 
     * name of entity 
     */
    protected $name = null;

    /** 
     * @var int id 
     */
    protected $id = null ;

    /**
     * entity constructor.
     * @param string $name
     * @param int $id
     */
    public function __construct($name=null ,$id=null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return entity object stored in the database
     */
    public function save()
    {        
        $count = 0;
        $fields = '';
        foreach(get_object_vars($this) as $col => $val) {
            if ($col == '_table' || $val == null) continue;
            if ($count++ != 0) $fields .= ', ';
            $fields .= "`$col` = '$val'";
        }

        if (intval($this->id) == 0 )//insert
        {
            $query = "INSERT INTO `$this->_table` SET $fields;";
            
            DB::run($query);
            $this->id = DB::getLastInsertedId();
            return $this; 
        }
        else //update 
        {
            $query = "update `$this->_table` SET $fields where id = $this->id;";
            DB::run($query); 
            return $this;
        }
    }

    /**
     * @return array of entity
     */
    public function getAll()
    {
        $query = "select * from `$this->_table`;";
        return DB::run($query);
    }

    /** 
     * @param int $id
     * @return entity
     */
    public function findById($id)
    {
        $query = "select * from `$this->_table` where id = $id;";
        $data= DB::run($query);
        if (is_array($data)) {
            foreach( $data[0] as $col => $val) {
                if ($col == '_table' || $val == null) continue;
                if (isset($data[0][$col])){
                    $this->{$col} = $data[0][$col];
                }
            } 
        }
        
        return $this;
    }
}