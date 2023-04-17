<?php
namespace nasservb\AgencyAssistant\Controllers;

use nasservb\AgencyAssistant\Helpers\Security;
use nasservb\AgencyAssistant\Models\User;

abstract class BaseController
{
    use Security; 

    protected $user; 

    public function __construct()
    {
        $this->user = new User('');        
    }

    protected function render($output,$headerCode=200)
    {
        if ($headerCode) {
            http_response_code($headerCode);
        }
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    protected function post($key)
    {
        if (isset($_POST[$key])) {
            return $this->clean($_POST[$key]);
        }

        $data = json_decode(file_get_contents('php://input'), true);
       
        if (isset($data[$key])) {
            return $this->clean($data[$key]);
        }
        return '';
    }

    protected function get($key)
    {
        if (isset($_GET[$key])) {
            return $this->clean($_GET[$key]);
        }
        return '';
    }

    /**
     * @param  string $key
     * @return cleaned string
     */
    protected function clean($str)
    {
        return $this->xss_clean($str);
    }

    protected function checkLogin(){
        
        if (!$this->user->checkLogin()) {
            $this->render('Authentication required!', 403);
            exit(0);
        }

        return $this; 
    }

    protected function checkPostRequest(){
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->render('Bad Request', 401);
            exit(0);
        }
        return $this; 
    }

    protected function checkGetRequest(){
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->render('Bad Request', 401);
            exit(0);
        }
        return $this; 
    }

}