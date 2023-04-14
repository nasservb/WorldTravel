<?php

namespace nasservb\AgencyAssistant\Models;
use nasservb\AgencyAssistant\Database\DB;

class User extends Auth implements ISearchable
{ 
    /**
     * @var string table nem on database 
     */
    protected $_table = 'users' ;

    protected $phone_number = '';

    protected $user_type = 'user';

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
    }

    public function register($email, $password) : bool{
        $this->email_address = $email ; 
        $this->password =  md5($password);

        return $this->save();
    }

    /**
    * @return string
    */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @return string
     */
    public function geUserType()
    {
        return $this->user_type;
    }

    /**
     * @param str $phone
     * @return void
     */
    public function setPhoneNumber($phone)
    {
        $this->phone_number= $phone;
    }
 
    /**
     * @param str $type
     * @return void
     */
    public function setUserType($type)
    {
        if(!in_array($type,[])){
            throw new Exception('Invalid user type');
        }

        $this->user_type= $type;
    }

    /**
    * @param Array $filters
    * 
    * @return Array of strings 
    */
    public static function search($filters){
         $query=sprintf(
            'select * from users  
              where  
                `email`=%s', 
                $filters['email']);
         return DB::run($query);
    }

}
