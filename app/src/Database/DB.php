<?php 
namespace nasservb\AgencyAssistant\Database;

use nasservb\AgencyAssistant\Database\Migrations\Migrations;
use nasservb\AgencyAssistant\Database\Seeders\Seeders;

use nasservb\AgencyAssistant\Database\Drivers\Mysql;

class DB
{

    private static $driver = null; 

    private function __construct()
    {
    }  

    /**
     * @var DatabaseInterface $driver
     */
    public static function connect($driver = null ) 
    {
        if (!$driver ) {
            static::$driver = new Mysql(); 
            static::$driver->connect('db', 'world_travel', 'root', '12345678'); 
        } else {
            static::$driver = $driver;
        }
    }

    /**
     * @param string                      $query
     * @param array by reference          $rows
     * @param int by reference rows count 
     */
    public static function run($query,&$row='',&$count=0)
    {
        if (!static::$driver) {
            static::connect(); 
        }
        
        try {
            return static::$driver->run($query, $row, $count);
        }catch (\Exception $e){
            return null;
        }
    } 
    
    /**
     * @return int Last Inserted Id 
     */
    public static function getLastInsertedId()
    {
        if (!static::$driver) {
            static::connect(); 
        }

        return static::$driver->getLastInsertedId(); 
    } 

    public static function init()
    {
        if (!static::$driver) {
            static::connect(); 
        }

        /**
         * migrate database
         */
        (new Migrations)->run(); 

        /**
         * seeds
         */
        (new Seeders)->run();           
    } 
} 
