<?php
namespace nasservb\AgencyAssistant\Controllers;

use nasservb\AgencyAssistant\Models\User;

class AuthController extends BaseController {
    
    private $user ; 

    public function __construct() {
        $this->user = new User('');
    }
    
    public function login(){
        
        if ($_SERVER['REQUEST_METHOD'] != 'POST'){
            return  $this->render('Bad Request',401);
        }      

        $email =$this->post('email');
        $password=$this->post('password');

        $userId = $this->user->login($email, $password);
        if ($userId){
            
            return  $this->render([
                'token'=>$this->user->getToken($email,$userId),
                'isAgency'=> $this->user->getCurrentUserType() == 'agency' 
            ]);
        }
        else 
        {
            return  $this->render('0',401);
        }        
    }

    public function logout(){

        if ($_SERVER['REQUEST_METHOD'] != 'POST'){
            return  $this->render('Bad Request',401);
        }   

        if ($this->user->logout()){
            return  $this->render('1');
        }
        else 
        {
            return  $this->render('0',401);
        }        
    }

    
}