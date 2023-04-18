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
     * @param string $email
     * @param string $password
     */
    public function __construct($name, $email='', $password='')
    {
        $this->email = $email; 
        $this->password = $password;         
        parent::__construct($name);

        @session_start(); 
    }

    /**
     * @param string $email
     * @param string $password
     * 
     * @return userId if successful and 0 if not successful login
     */
    public function login($email, $password):int
    {
        $query = 'select * from users where email_address=\'' . 
                $email . "' and password='" . md5($password)."'";
        $items=  DB::run($query);
               
        if (is_array($items) && count($items) == 1) {         
            unset($items[0]['password']);   
            $_SESSION['logged_in_user']=$items[0];
            return $items[0]['id'];
        }
        return false;
    }

    public function logout() : bool
    {
        $key ='logged_in_user';
        if(isset($_SESSION[$key])==false) {
            return false;
        }else{
            $_SESSION[$key]=null;
            return true;
        }            
    }

    /**
     * @return User instance
     */
    public function getCurrentUser()
    {         
        return (new User(''))->findById($this->readUserIdFromJwtToken());
    }    

    private function getallheaders() {
        if (!function_exists('getallheaders'))
        {
            $headers = [];
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            return $headers;   
        }
        else 
        {
            return getallheaders();
        }     
    }

    private function readUserIdFromJwtToken():int {
        $headers = $this->getallheaders();
            
        if (isset($headers['Authorization'])) {
            $token =  str_replace('Bearer ', '', $headers['Authorization']);
            $secretKey  =$this->getJwtSecretKey();

            try {
                $data = JWT::decode(
                    $token,
                    new Key($secretKey, 'HS512')
                );

                return $data->userId;
            }
            catch(\Exception $e) {
                return 0;
            }    
        }
        return 0;
    }

    /**
     * @return boolean is logged in or not
     */
    public function checkLogin()
    {
        $userId =$this->readUserIdFromJwtToken();        
       
        if(!$userId) {
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
     * @param  str $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email_address= $email;
    } 

    /**
     * @param  str $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password= $password;
    } 

    public function getToken($username,$userId )
    {
        $secretKey  =$this->getJwtSecretKey();
        $issuedAt   = time();
        $expire     = strtotime('now +60 minutes');      // Add 60 minutes
        $serverName = $_SERVER['SERVER_NAME'];       
        
        $data = [
            'iat'  => $issuedAt,         // Issued at: time when the token was generated
            'iss'  => $serverName,         // Issuer
            'nbf'  => $issuedAt,         // Not before
            'exp'  => $expire,                           // Expire
            'userName' => $username,                     // User name
            'userId' => $userId,                     // User name
        ];

        $token = JWT::encode(
            $data,
            $secretKey,
            'HS512'
        );

        return JWT::encode(
            $data,
            $secretKey,
            'HS512'
        );
    }

    private function getJwtSecretKey()
    {
        return  'bGS6lzFqvvSQ8ALbOxatm7/pk7mLQyzqaS34Q4oR1ew=';
    }

    
}
