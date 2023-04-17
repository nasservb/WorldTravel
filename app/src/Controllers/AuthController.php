<?php
namespace nasservb\AgencyAssistant\Controllers;

class AuthController extends BaseController
{
    
    public function login()
    {        
        $this->checkPostRequest();    

        $email =$this->post('email');
        $password=$this->post('password');

        $userId = $this->user->login($email, $password);
        if ($userId) {
            
            return  $this->render(
                [
                'token'=>$this->user->getToken($email, $userId)
                ]
            );
        }
        else 
        {
            return  $this->render('0', 401);
        }        
    }

    public function logout()
    {
        $this->checkLogin()->checkGetRequest();

        if ($this->user->logout()) {
            return  $this->render('1');
        }
        else 
        {
            return  $this->render('0', 401);
        }        
    }

    
}