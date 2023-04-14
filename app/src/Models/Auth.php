<?php

namespace nasservb\AgencyAssistant\Models;
use nasservb\AgencyAssistant\Database\DB;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Abstract class Auth extends BaseEntity
{ 
    protected $email_address; 

    protected $password; 

    /**
     * @param string $name
     */
    public function __construct($name, $email='', $password='')
    {
        $this->email = $email; 
        $this->password = $password;         
        parent::__construct($name);

        @session_start(); 
    }

    public function login($email, $password):bool {
        $query = 'select * from users where email_address=\'' . 
                $email . "' and password='" . md5($password)."'";
        $items=  DB::run($query);
               
        if (is_array($items) && count($items) == 1){         
            unset($items[0]['password']);   
			$_SESSION['logged_in_user']=$items[0];
            return true;
        }
        return false;
    }

    public function logout() : bool{
        $key ='logged_in_user';
        if(isset($_SESSION[$key])==false){
            return false;
        }else{
            $_SESSION[$key]=null;
            return true;
        }			
    }

    /**
     * @return User instance
     */
    public function getCurrentUser(){
        $key ='logged_in_user';
        if(isset($_SESSION[$key])==false){
            return null;
        }else{
            return $_SESSION[$key];
        }		
    }
    
    /**
     * @return boolean is logged in or not
    */
    public function checkLogin(): bool{
        $key ='logged_in_user';
        if(isset($_SESSION[$key])==false){
            return false;
        }else{
            return true;
        }		
    }


      /**
     * @return str
     */
    public function getEmail()
    {
        return $this->email_address;
    }

    /**
     * @param str $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email_address= $email;
    } 

    /**
     * @param str $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password= $password;
    } 

    public function getToken($username)
    {
        $secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/pk7mLQyzqaS34Q4oR1ew=';
        $issuedAt   = time();
        $expire     = strtotime('now +60 minutes');      // Add 60 minutes
        $serverName = $_SERVER['SERVER_NAME'];       
        
        $data = [
            'iat'  => $issuedAt,         // Issued at: time when the token was generated
            'iss'  => $serverName,         // Issuer
            'nbf'  => $issuedAt,         // Not before
            'exp'  => $expire,                           // Expire
            'userName' => $username,                     // User name
        ];

        return JWT::encode(
            $data,
            $secretKey,
            'HS512'
        );
    }

    public function getCurrentUserType()
    {
        return isset($_SESSION['logged_in_user']) ? $_SESSION['logged_in_user']['user_type'] :'';
    }
    
}
