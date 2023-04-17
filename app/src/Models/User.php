<?php

namespace nasservb\AgencyAssistant\Models;

use nasservb\AgencyAssistant\Database\DB;

class User extends Auth implements ISearchable
{
    /**
     * @var string table nem on database
     */
    protected $_table = 'users' ;

    protected $phone = '';

    protected $user_type = 'user';

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
    }

    public function register($email, $password): bool
    {
        $this->email_address = $email ;
        $this->password =  md5($password);

        return $this->save();
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @param  str $phone
     * @return void
     */
    public function setPhoneNumber($phone)
    {
        $this->phone= $phone;
    }

    /**
     * @param  str $type
     * @return void
     */
    public function setUserType($type)
    {
        if(!in_array($type, ['user','agency','admin','driver'])) {
            throw new Exception('Invalid user type');
        }

        $this->user_type= $type;
    }

    /**
     * @param Array $filters
     *
     * @return Array of strings
     */
    public static function search($filters)
    {
        $query=sprintf(
            'select * from users  
              where  
                `email`=%s',
            $filters['email']
        );
        return DB::run($query);
    }
  
    /**
     * @param  int $source
     * @param  int $destination
     * 
     * @return int driver_id
     */
    public static function getFirstDriverByPath($source, $destination) 
    {
        $query=sprintf(
            'select * from driver_preferred  
              where  
                `source_place_id`=%u and `destination_place_id`=%u',
            $source, 
            $destination
        ); 

        $data = DB::run($query);
        if (count($data)>0 ){
            return $data[0]['driver_id'];
        }

        return 0;
    }


}
